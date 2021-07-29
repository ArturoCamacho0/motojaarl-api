<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        if(count($categories) === 0){
            return response(array(
                "message" => "No categories",
            ), 404);
        }
        return response(array(
            "categories" => $categories
        ), 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|unique:categories,name"
        ]);
        if(!$validation->fails() && Category::create($request->all())) {
            return response(array(
                "message" => "The category has been created",
                "status" => "success"
            ), 201);
        }else{
            return response(array(
                "message" => "The category hasn't been created",
                "status" => "error",
                "errors" => $validation->errors()
            ), 500);
        }
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|unique:categories,name,".$id
        ]);

        $category = Category::findOrFail($id);

        if(!$validation->fails() && $category) {
            $category->update($request->all());
            return response(array(
                "message" => "The category has been updated",
                "status" => "success"
            ), 201);
        }else{
            return response(array(
                "message" => "The category hasn't been updated",
                "status" => "error",
                "errors" => $validation->errors()
            ), 500);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if(!isset($category))
            return response(array(
                "message" => "The category don't exists",
                "status" => "error"
            ), 404);

        if($category->delete()) {
            return response(array(
                "message" => "The category has been deleted",
                "status" => "success"
            ), 200);
        }else {
            return response(array(
                "message" => "The category hasn't been deleted",
                "status" => "error"
            ), 500);
        }
    }
}
