<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories",
     *     tags={"Category"},
     *     summary="Return all categories",
     *     @OA\Response(
     *         response=200,
     *         description="get categories",
     *         @OA\JsonContent(
     *              @OA\Items(ref="#/components/schemas/Category")
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
    public function index()
    {
        $category = Category::get();
        return response()->json(CategoryCollection::collection($category));
    }


    /**
     * @OA\Get(
     *     path="/categories/{id}",
     *     tags={"Category"},
     *     summary="Return a category",
     *     @OA\Parameter(
     *         description="category id",
     *         in="path",
     *         name="id",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get category",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
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
        $category = Category::findOrFail($id);

        return response()->json(new CategoryCollection($category));
    }

    /**
     * Add a new category
     *
     * @OA\Post(
     *     path="/categories",
     *     tags={"Category"},
     *     summary="Add a new category",
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

    public function update($id)
    {
        $category = Category::findOrFail($id);

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
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(array('message' => 'Category deleted'));
    }
}

