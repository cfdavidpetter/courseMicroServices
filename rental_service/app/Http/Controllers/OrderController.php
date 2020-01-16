<?php

namespace App\Http\Controllers;


use Validator;
use App\Order;
use App\OrderItem;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Order::with('items')->paginate(15), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Order::with('items')->findOrFail($id), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $Order = Order::create(array_merge($request->all(), ['id' => Uuid::uuid4()]));
            foreach ($request->items as $Item) {
                OrderItem::create(array_merge($Item, [
                    'id'        => Uuid::uuid4(),
                    'order_id'  => $Order->id,
                ]));
            }

            DB::commit();
            return response()->json(Order::with('items')->findOrFail($Order->id), 201);
        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $Order = Order::findOrFail($id);
            $Order->fill($request->all());
            $Order->save();

            //Itens
            $Order->items()->delete();
            foreach ($request->items as $Item) {
                OrderItem::create(array_merge($Item, [
                    'id'        => Uuid::uuid4(),
                    'order_id'  => $Order->id,
                ]));
            }
            
            DB::commit();
            return response()->json(Order::with('items')->findOrFail($Order->id), 200);
        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(Order::destroy($id), 200);
    }
}
