<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class taskController extends Controller
{
    public function index(){
        $tasks = task::get();
        if($tasks->count() > 0){
            return TaskResource::collection($tasks);
        }
        else{
            return response()->json([
                "message"=> "No Task found"
            ]);
        }
    }

    public function store(Request $request){
        $isValide = Validator::make($request->all(),[
            "name"=>"required",
            "archived"=>"required|boolean"
        ]);

        if($isValide->fails()){
            return response()->json([
                "error"=>$isValide->messages()
            ]);
        }

        task::create([
            "name"=>$request->name,
            "archived"=>$request->archived
        ]);

        return response()->json([
            "message"=>"Task Added"
        ]);
    }

    public function show(task $Task){
        return new TaskResource($Task);
    }
    public function update(Request $request,task $Task){
        $isValide = Validator::make($request->all(),[
            "name"=>"required",
            "archived"=>"required|boolean"
        ]);

        if($isValide->fails()){
            return response()->json([
                "error"=>$isValide->messages()
            ]);
        }

        $Task->update([
            "name"=>$request->name,
            "archived"=>$request->archived
        ]);

        return [
            "message"=>"Task Updated"
        ];
    }
    public function destroy(task $Task){
        $Task->delete();
        return [
            "message"=>"Task Deleted"
        ];
    }
    public function getAllPaginate(Request $request){
        $task = task::paginate(5);

        if($request->paginate){
            $task = task::orderBy("created_at","desc")->paginate($request->paginate);
        }
        else{
            $task = task::orderBy("created_at","desc")->paginate(5);
        }
        
        if($task->count() > 0){
            return TaskResource::collection($task);
        }
        else{
            return response()->json([
                "message"=> "No task found"
            ]);
        }
    }
}
