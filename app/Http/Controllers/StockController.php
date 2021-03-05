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
     *     security={{"jwt":{}}},
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
    public function show(Stock $stock)
    {
        return response()->json(new StockCollection($stock));
    }
}
