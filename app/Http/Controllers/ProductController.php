<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     tags={"Product"},
     *     summary="Return a product",
     *     @OA\Parameter(
     *         description="product id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get product",
     *     	   @OA\JsonContent(ref="#/components/schemas/Product")
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
        $product = Product::findOrFail($id);
        return response()->json(new ProductCollection($product));
    }


    /**
     * Add a new Product
     *
     * @OA\Post(
     *     path="/products",
     *     tags={"Product"},
     *     summary="Add a new product",
     *     @OA\RequestBody(
     *          description= "Provide product informations",
     *          required=true,
     *          @OA\JsonContent(
     *                required={"name", "description", "category_id"},
     *              type="object",
     *     			@OA\Property(property="name", type="string", example="product_name"),
     *     			@OA\Property(property="description", type="string", example="product_description"),
     *              @OA\Property(property="category_id", type="integer", example="product_category_id"),
     *          )
     *      ),
     *     security={{"jwt":{}}},
     *      @OA\Response(
     *         response=200,
     *         description="product created",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
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
        if(auth()->user()->role != 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $this->validate(request(), [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'integer']
        ]);

        $product = new Product();
        $product->name = request('name');
        $product->description = request('description');
        $product->category_id = request('category_id');
        $product->save();

        return response()->json(new ProductCollection($product));
    }

    /**
     * Update a product
     *
     * @OA\Patch(
     *     path="/products/{id}",
     *     tags={"Product"},
     *     summary="Update a product",
     *     @OA\Parameter(
     *         description="product id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\RequestBody(
     *          description= "Provide product informations",
     *          @OA\JsonContent(
     *              type="object",
     *     			@OA\Property(property="name", type="string", example="product_name"),
     *     			@OA\Property(property="description", type="string", example="product_description"),
     *              @OA\Property(property="category_id", type="integer", example="product_category_id")
     *          )
     *      ),
     *     security={{"jwt":{}}},
     *      @OA\Response(
     *         response=200,
     *         description="product updated",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
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
        if(auth()->user()->role != 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $product = Product::findOrFail($id);
        
        $this->validate(request(), [
            'name' => ['string'],
            'description' => ['string'],
            'category_id' => ['integer']
        ]);

        request()->has('name') ? $product->name = request('name') : false ;
        request()->has('description') ?  $product->description = request('description') : false ;
        request()->has('category_id')  ? $product->category_id = request('category_id') : false ;
        $product->save();

        return response()->json(new ProductCollection($product));
    }


    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     tags={"Product"},
     *     summary="Delete a product",
     *     @OA\Parameter(
     *         description="product id",
     *         in="path",
     *         name="id",
     *     ),
     *     security={{"jwt":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="product deleted",
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
        if(auth()->user()->role != 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(array('message' => 'Product deleted'));
    }


    /**
     * @OA\Get(
     *     path="/shop_products/{id}",
     *     tags={"Product"},
     *     summary="Return all products from a specific shop",
     *     @OA\Parameter(
     *         description="shop id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get product",
     *     	   @OA\JsonContent(ref="#/components/schemas/Product")
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
    public function fromShop($id)
    {
        $stocks = Stock::findOrFail($id);
        return response()->json(new ProductCollection($stocks));
    }
}
