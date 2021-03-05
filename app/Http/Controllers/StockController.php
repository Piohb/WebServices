<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockCollection;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{

    /**
     * @OA\Get(
     *     path="/stocks/{id}",
     *     tags={"Stock"},
     *     summary="Return a stock",
     *     @OA\Parameter(
     *         description="stock id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get stock",
     *     	   @OA\JsonContent(ref="#/components/schemas/Stock")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws
     */
    public function show($id)
    {
        $stock = Stock::findOrFail($id);
        return response()->json(new StockCollection($stock));
    }
    

    /**
     * Add a new stock
     *
     * @OA\Post(
     *     path="/stocks",
     *     tags={"Stock"},
     *     summary="Add a new stock",
     *     security={{"jwt":{}}},
     *     @OA\RequestBody(
     *          description= "Provide stock informations",
     *          required=true,
     *          @OA\JsonContent(
     *                required={"product_id", "shop_id", "price", "stock"},
     *              type="object",
     *              @OA\Property(property="product_id", type="integer", example="1"),
     *              @OA\Property(property="shop_id", type="integer", example="1"),
     *              @OA\Property(property="price", type="float", example="5"),
     *              @OA\Property(property="stock", type="integer", example="13"),
     *              @OA\Property(property="sales", type="integer", example="10"),
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="stock created",
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *      )
     *    )
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store()
    {
        $this->validate(request(), [
            'product_id' => ['required', 'exists:products,id'],
            'shop_id' => ['required', 'exists:shops,id'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
            'sales' => ['nullable|integer|between:0,100']
        ]);

        $stock = new Stock();
        $stock->product_id = request('product_id');
        $stock->shop_id = request('shop_id');
        $stock->price = request('price');
        $stock->stock = request('stock');
        request()->has('sales') ? $stock->sales = request('sales') : false;
        $stock->save();

        return response()->json(new StockCollection($stock));
    }


    /**
     * Update a stock
     *
     * @OA\Patch(
     *     path="/stocks/{id}",
     *     tags={"Stock"},
     *     summary="Update a stock",
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         description="stock id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\RequestBody(
     *          description= "Provide stock informations",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="price", type="float", example="5"),
     *              @OA\Property(property="stock", type="integer", example="13"),
     *              @OA\Property(property="sales", type="integer", example="10"),
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="stock updated",
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *      )
     *    )
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function update($id)
    {
        $stock = Stock::findOrFail($id);

        $this->validate(request(), [
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
            'sales' => ['nullable|integer|between:0,100']
        ]);

        request()->has('price') ? $stock->price = request('price') : false;
        request()->has('stock') ? $stock->stock = request('stock') : false;
        request()->has('sales') ? $stock->sales = request('sales') : false;
        $stock->save();

        return response()->json(new StockCollection($stock));
    }


    /**
     * @OA\Delete(
     *     path="/stocks/{id}",
     *     tags={"Stock"},
     *     summary="Delete a stock",
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         description="stock id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="stock deleted",
     *            @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="OK"),
     *         )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return response()->json(array('message' => 'Stock deleted'));
    }

}
