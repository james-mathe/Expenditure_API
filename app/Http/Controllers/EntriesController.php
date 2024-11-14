<?php

namespace App\Http\Controllers;

use App\Http\Resources\EntriesResource;
use App\Models\Entries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntriesController extends Controller
{
    public function index()
    {
        $entrie = Entries::get();
        
        if($entrie->count() > 0){
            return EntriesResource::collection($entrie);
        }
        else{
            return response()->json([
                "message"=> "No Entries found"
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isValide = Validator::make($request->all(),[
            "name"=> "required",
            "amount"=> "required|decimal:0,5",
            "category_id"=> "required|integer",
        ]);

        if($isValide->fails()){
            return response()->json([
                "error"=> $isValide->messages()
            ]);
        }

        Entries::create([
            "name"=> $request->name,
            "amount"=> $request->amount,
            "category_id"=> $request->category_id
        ]);
        return response()->json([
            "message"=> "You're adding monney"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entries $entrie)
    {
       
        return new EntriesResource($entrie);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entries $entrie)
    {
        $isValide = Validator::make($request->all(),[
            "name"=> "required",
            "amount"=> "required|decimal:0,5",
            "category_id"=> "required|integer",
        ]);
        if($isValide->fails()){
            return response()->json([
                "error"=> $isValide->messages()
            ]);
        }
        $entrie->update([
            "name"=> $request->name,
            "amount"=> $request->amount,
            "category_id"=> $request->category_id
        ]);
        return response()->json([
            "message"=> "Entries Updated Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entries $entrie)
    {
        $entrie->delete();
        return response()->json([
            "message"=> "Entries Deleted"
        ]);
    }

    public function getAllPaginate(Request $request){
        $entrie = Entries::paginate(5);

        if($request->paginate){
            $entrie = Entries::orderBy("created_at","desc")->paginate($request->paginate);
        }
        else{
            $entrie = Entries::orderBy("created_at","desc")->paginate(5);
        }
        
        if($entrie->count() > 0){
            return EntriesResource::collection($entrie);
        }
        else{
            return response()->json([
                "message"=> "No Entries found"
            ]);
        }
    }
}
