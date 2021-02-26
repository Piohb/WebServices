<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopCollection;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    /**
     * @OA\Get(
     *     path="/shops",
     *     tags={"Shop"},
     *     summary="Return all shops",
     *     security={{"jwt":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="get shops",
     *     	   @OA\JsonContent(
     *     	   		@OA\Items(ref="#/components/schemas/Shop")
     * 		   )
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

    public function index()
    {
        $shops = Shop::get();
        return response()->json(ShopCollection::collection($shops));
    }


    /**
     * @OA\Get(
     *     path="/shops/{id}",
     *     tags={"Shop"},
     *     summary="Return a shop",
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         description="shop id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get shop",
     *     	   @OA\JsonContent(ref="#/components/schemas/Shop")
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

    public function show(Shop $shop)
    {
        return response()->json(new ShopCollection($shop));
    }


    /**
     * Add a new shop
     *
     * @OA\Post(
     *     path="/shops",
     *     tags={"Shop"},
     *     summary="Add a new shop",
     *     security={{"jwt":{}}},
     *     @OA\RequestBody(
     *          description= "Provide shop informations",
     *          required=true,
     *          @OA\JsonContent(
     *                required={"name", "address_line", "zipcode", "city", "country"},
     *              type="object",
     *     			@OA\Property(property="name", type="string", example="shop_name"),
     *     			@OA\Property(property="address_line", type="string", example="shop_address_line"),
     *              @OA\Property(property="zipcode", type="string", example="shop_zipcode"),
     *              @OA\Property(property="city", type="string", example="shop_city"),
     *     			@OA\Property(property="country", type="string", example="shop_country"),
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="shop created",
     *         @OA\JsonContent(ref="#/components/schemas/Shop")
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
            'address_line' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string']
        ]);

        $shop = new Shop();
        $shop->name = request('name');
        $shop->address_line = request('address_line');
        $shop->zipcode = request('zipcode');
        $shop->city = request('city');
        $shop->country = request('country');
        $shop->save();

        return response()->json(new ShopCollection($shop));
    }


    /**
     * Update a shop
     *
     * @OA\Patch(
     *     path="/shops/{id}",
     *     tags={"Shop"},
     *     summary="Update a shop",
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         description="shop id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\RequestBody(
     *          description= "Provide shop informations",
     *          @OA\JsonContent(
     *              type="object",
     *     			@OA\Property(property="name", type="string", example="shop_name"),
     *     			@OA\Property(property="address_line", type="string", example="shop_address_line"),
     *              @OA\Property(property="zipcode", type="string", example="shop_zipcode"),
     *              @OA\Property(property="city", type="string", example="shop_city"),
     *     			@OA\Property(property="country", type="string", example="shop_country"),
     *
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="shop updated",
     *         @OA\JsonContent(ref="#/components/schemas/Shop")
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

    public function update(Shop $shop)
    {
        $this->validate(request(), [
            'name' => ['string'],
            'address_line' => ['string'],
            'zipcode' => ['string'],
            'city' => ['string'],
            'country' => ['string']
        ]);

        request()->has('name') ? $shop->name = request('name') : false;
        request()->has('address_line') ?  $shop->address_line = request('address_line') : false;
        request()->has('zipcode')  ? $shop->zipcode = request('zipcode') : false;
        request()->has('city') ? $shop->city = request('city') : false;
        request()->has('country') ? $shop->country = request('country') : false;
        $shop->save();

        return response()->json(new ShopCollection($shop));
    }


    /**
     * @OA\Delete(
     *     path="/shops/{id}",
     *     tags={"Shop"},
     *     summary="Delete a shop",
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         description="shop id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="shop deleted",
     *     	   @OA\JsonContent(
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

    public function destroy(Shop $shop)
    {
        $shop->delete();
        return response()->json(array('message' => 'Shop deleted'));
    }

}