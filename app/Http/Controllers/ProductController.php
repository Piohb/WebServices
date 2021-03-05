<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     tags={"Product"},
     *     summary="Return a product",
     *     security={{"jwt":{}}},
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
    public function show(Product $product)
    {
        return response()->json(new ProductCollection($product));
    }

    /**
     * Add a new Product
     *
     * @OA\Post(
     *     path="/products",
     *     tags={"Product"},
     *     summary="Add a new product",
     *     security={{"jwt":{}}},
     *     @OA\RequestBody(
     *          description= "Provide product informations",
     *          required=true,
     *          @OA\JsonContent(
     *                required={"name", "description", "category_id"},
     *              type="object",
     *     			@OA\Property(property="name", type="string", example="product_name"),
     *     			@OA\Property(property="description", type="text", example="product_description"),
     *              @OA\Property(property="category_id", type="integer", example="product_category_id"),
     *          )
     *      ),
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
        $this->validate(request(), [
            'name' => ['required', 'string'],
            'description' => ['required', 'text'],
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
     *     security={{"jwt":{}}},
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
     *     			@OA\Property(property="description", type="text", example="product_description"),
     *              @OA\Property(property="category_id", type="integer", example="product_category_id")
     *          )
     *      ),
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

    public function update(Product $product)
    {
        $this->validate(request(), [
            'name' => ['string'],
            'description' => ['text'],
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
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         description="product id",
     *         in="path",
     *         name="id",
     *     ),
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
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(array('message' => 'Product deleted'));
    }
}
