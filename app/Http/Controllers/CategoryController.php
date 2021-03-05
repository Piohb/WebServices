<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Add a new category
     *
     * @OA\Post(
     *     path="/categories",
     *     tags={"Category"},
     *     summary="Add a new category",
     *     security={{"jwt":{}}},
     *     @OA\RequestBody(
     *          description= "Provide category informations",
     *          required=true,
     *          @OA\JsonContent(
     *                required={"name"},
     *              type="object",
     *     			@OA\Property(property="name", type="string", example="category_name"),
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="category created",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
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
        ]);

        $category = new Category();
        $category->name = request('name');
        $category->save();

        return response()->json(new CategoryCollection($category));
    }

    /**
     * Update a category
     *
     * @OA\Patch(
     *     path="/categories/{id}",
     *     tags={"Category"},
     *     summary="Update a category",
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         description="category id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\RequestBody(
     *          description= "Provide category informations",
     *          @OA\JsonContent(
     *              type="object",
     *     			@OA\Property(property="name", type="string", example="category_name")
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="category updated",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
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

    public function update(Category $category)
    {
        $this->validate(request(), [
            'name' => ['string']
        ]);

        request()->has('name') ? $category->name = request('name') : false ;
        $category->save();

        return response()->json(new CategoryCollection($category));
    }


    /**
     * @OA\Delete(
     *     path="/categories/{id}",
     *     tags={"Category"},
     *     summary="Delete a category",
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         description="category id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="category deleted",
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
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(array('message' => 'Category deleted'));
    }
}

