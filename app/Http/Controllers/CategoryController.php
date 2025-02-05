<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return $this->Ok($categories);
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            "name" => "required|max:255|unique:categories|string"
        ]);

        if ($validator->fails()){
            return $this->BadRequest($validator);
        }

        $category = Category::create($validator->validated());

        return $this->Created($category);
    }
    public function update(Request $request, Category $category){
        $validator = validator()->make($request->all(), [
            "name" => "required|max:255|unique:categories,name,$category->id|string"
        ]);

        if ($validator->fails()){
            return $this->BadRequest($validator);
        }

        $category->update($validator->validated());

        return $this->Ok($category, "Updated!");
    }
    public function destroy(Category $category){

        $category->delete();

        return $this->Ok(null, "Deleted!");
    }

    public function show(Category $category){
        $category->products;

        return $this->Ok($category,"Retrieved!");
    }
}
