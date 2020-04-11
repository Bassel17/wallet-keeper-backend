<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

use Exception;

class CategoryController extends Controller
{

    public function getUserIncomeCategories($id){
        try{
            $categories = Category::where('user_id',$id)->where('type','income')->get();
            if($categories === 0)return response()->json(['error'=>'user not found'],404);
            return response()->json($categories,200);
        }catch(Exception $e){
            return response()->json(["error"=>"server error","status"=>500],500);
        }
    }

    public function getUserExpenseCategories($id){
        try{
            $categories = Category::where('user_id',$id)->where('type','expense')->get();
            if($categories === 0)return response()->json(['error'=>'user not found'],404);
            return response()->json($categories,200);
        }catch(Exception $e){
            return response()->json(["error"=>"server error","status"=>500],500);
        }
    }

    public function getUserCategoryWithID($id,$category_id){
        $category = Category::where('user_id',$id)->where('category_id',$category_id)->get();
        if($category == 0) return response()->json(['error'=>'category not found',"status"=>404],404);
        return response()->json($category,200); 
    }

    public function updateCategory(Request $request){
        $id = $request->category_id;
        $name = $request->name;
        $category = Category::where('category_id',$id)->update(['name' => $name]);
        if($category == 0) return response()->json(['error'=>'category not found'],404);
        return response()->json(['message'=>'category updated', "status"=>201],201);
    }

    public function addCategory(Request $request){
        $category = new Category;
        $category->name = $request->name;
        $category->type = $request->type;
        $category->user_id = $request->user_id;
        $result = $category->save();
        if($result == 0){
            if($category == 0) return response()->json(['error'=>'category not added',"status"=>400],400);
        }
        return response()->json(['message'=>'category added', "status"=>201],201);
    }

    public function deleteCategory(Request $request){
        $id = $request->category_id;
        $category = Category::where('category_id',$id)->delete();
        if($category == 0) return response()->json(['error'=>'category not found',"status"=>404],404);
        return response()->json(['message'=>'category deleted'],200);
    }
}
