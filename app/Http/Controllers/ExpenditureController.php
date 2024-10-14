<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenditureResource;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $Expenditure = Expenditure::paginate(5);

        if($request->paginate){
            $expenditure = Expenditure::with("category")->orderBy("created_at","desc")->paginate($request->paginate);
        }
        else{
            $expenditure = Expenditure::with("category")->orderBy("created_at","desc")->paginate(5);
        }
        
        if($expenditure->count() > 0){
            return ExpenditureResource::collection($expenditure);
        }
        else{
            return response()->json([
                "message"=> "No Expenditure found"
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

        $expenditure = Expenditure::create([
            "name"=> $request->name,
            "amount"=> $request->amount,
            "category_id"=> $request->category_id
        ]);
        return response()->json([
            "message"=> "You're Spending monney"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expenditure $expenditure)
    {
       
        return new ExpenditureResource($expenditure);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expenditure $expenditure)
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
        $expenditure->update([
            "name"=> $request->name,
            "amount"=> $request->amount,
            "category_id"=> $request->category_id
        ]);
        return response()->json([
            "message"=> "Expenditure Updated Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenditure $expenditure)
    {
        $expenditure->delete();
        return response()->json([
            "message"=> "Expenditure Deleted"
        ]);
    }

    
}
