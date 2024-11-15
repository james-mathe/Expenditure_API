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

    public function show(login $login){
        return new loginResource($login);
    }
}
