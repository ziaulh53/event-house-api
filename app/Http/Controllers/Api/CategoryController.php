<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::query()->orderBy('id', 'desc')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request['image'];
        $data['description'] = $request['description'];
        Category::create($data);
        return response(['success' => true, 'msg' => 'New Category created!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $data = $request->validated();
        $category = Category::find($id);
        if(isset($request['image'])){
            $data['image'] = $request['image'];
        }
        $category->update($data);
        return response(['success' => true, 'msg' => 'Category updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $id = $request->route('id');
        $category = Category::find($id);
        $category->delete();
        return response(['msg' => 'Deleted successfully', 'success' => true], 201);
    }
}
