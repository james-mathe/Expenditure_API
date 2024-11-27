<?php

namespace App\Http\Controllers;

use App\Http\Resources\loginResource;
use App\Models\login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class loginController extends Controller
{
    public function index(){
        $user = login::get();
        if($user->count() > 0){
            return loginResource::collection($user);
        }
        return [
            "message"=> "No login user found"
        ];
    }

    public function store(Request $request){
        $isValid = Validator::make($request->all(),[
            "uid_user"=>"required",
            "email"=>"required|email"
        ]);

        if($isValid->fails()){
            return [
                "error"=>$isValid->messages()
            ];
        }

        login::create([
            "uid_user"=>$request->uid_user,
            "email"=>$request->email
        ]);

        return [
            "message"=>"login"
        ];
    }

    public function show(login $Log){
        return new loginResource($Log);
    }

    public function update(Request $request, login $log){
        $isValid = Validator::make($request->all(),[
            "role"=>"required"
        ]);

        if($isValid->fails()){
            return [
                "error"=>$isValid->messages()
            ];
        }

        $log->update([
            "role"=>$request->role
        ]);
        
        return [
            "message"=>"your Role is changed"
        ];
    }
    public function getElementByuid(Request $request){

        $user = login::select(login::raw("id"),login::raw("uid_user"),login::raw("email"),login::raw("role"),login::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as Created_at"))
        ->where("uid_user","=",$request->uid)
        ->get();

        if($user->count() > 0){
            return $user;
        }
        else{
            return [
                "message"=>"No User Find with This UID!!"
            ];
        }
       
    }
}
