<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\FoodCategory;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\FoodCategory as FoodCategoryResource;
use App\Http\Resources\FoodCategoryCollection as FoodCategoriesResource;

class FoodCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = FoodCategory::all();
        return $this->sendResponse(new FoodCategoriesResource($categories), 'categories retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:App\FoodCategory|max:250'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $category = FoodCategory::create($input);

        return $this->sendResponse(new FoodCategoryResource($category), 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FoodCategory $category)
    {
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }

        return $this->sendResponse(new FoodCategoryResource($category), 'Category retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodCategory $category)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:App\FoodCategory|max:250'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $category->save($input);

        return $this->sendResponse(new FoodCategoryResource($category), 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodCategory $category)
    {
        $category->delete();

        return $this->sendResponse([], 'Category deleted successfully.');
    }
}
