<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenditureResource;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenditureController extends Controller
{
    /**
     * 
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenditure = Expenditure::get();
        
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
    public function show(Expenditure $Expenditure)
    {
       
        return new ExpenditureResource($Expenditure);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expenditure $Expenditure)
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
        $Expenditure->update([
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
    public function destroy(Expenditure $Expenditure)
    {
        $Expenditure->delete();
        return response()->json([
            "message"=> "Expenditure Deleted"
        ]);
    }

    public function getAllPaginate(Request $request){
        $expenditure = Expenditure::paginate(5);

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

    public function getExpenditureByCategory(Request $request){
        $expense = Expenditure::select(Expenditure::raw("id"),Expenditure::raw("category_id"),Expenditure::raw("name"),Expenditure::raw("amount"),Expenditure::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as Created_at"))
        ->where("category_id","=",$request->cat)
        ->get();

        if($expense->count() > 0){
            return $expense;
        }
        else{
            return[
                "message"=>"No Expense For this Category"
            ];
        }
    }
    
}
