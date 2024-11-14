<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categoryController extends Controller
{
    //
    public function index(){
        $categories = Category::get();

        if($categories->count() > 0){
            return CategoryResource::collection($categories);
        }

        return response()->json([
            "message"=>"No Categories Found!!"
        ]);
    }
    public function store(Request $request){
        $isValide = Validator::make($request->all(), [
            "name"=> "required|unique:categories",
            "description"=>"required"
        ]);

        if($isValide->fails()){
            return response()->json([
                "error"=> $isValide->messages(),
            ]);
        }

        Category::create([
            "name"=> $request->name,
            "description"=> $request->description
        ]);

        return response()->json([
            "message"=> "Category added Successfully"
        ]);
    }
    public function show(category $category){
        return [
            "Category"=>new CategoryResource($category)
        ];
    }
    public function update(Request $request, category $category){
        $isValide = Validator::make($request->all(), [
            "name"=> "required",
            "description"=> "required"
        ]);

        if($isValide->fails()){
            return response()->json([
                "error"=> $isValide->messages(),
            ]);
        }

        $category->update([
            "name"=> $request->name,
            "description"=> $request->description
        ]);

        return response()->json([
            "message"=> "Category Updated Successfully"
        ]);
    }
    public function destroy(category $category){
        $category->delete();
        return response()->json([
            "message"=> "Category Deleted Successfully"
        ]);
    }
    public function getAllPaginate(Request $request){
        $category = category::paginate(5);

        if($request->paginate){
            $category = category::orderBy("created_at","desc")->paginate($request->paginate);
        }
        else{
            $category = category::orderBy("created_at","desc")->paginate(5);
        }
        
        if($category->count() > 0){
            return CategoryResource::collection($category);
        }
        else{
            return response()->json([
                "message"=> "No category found"
            ]);
        }
    }
}
