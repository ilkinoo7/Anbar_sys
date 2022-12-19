<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UserRequest;

use App\Models\User;

class UserController extends Controller
{
    public function userForm(UserRequest $post){

        $con = new User();
        
        
        $con->name = $post->ad;
        $con->email = $post->email;
        $con->password = Hash::make($post->parol);

        $con -> save();

        return redirect()->back()->with('success','Melumat ugurla elave edildi!');

    }

    public function ulist(){
        $con = User::orderBy('id','desc')->get();
        return view('user',['data'=>$con]);
    }


    public function login(Request $post){

        if(!Auth::attempt(['email'=>$post->email,'password'=>$post->password])){

            return redirect()->back()->with('success','Login ve ya parol yanlishdir!');
        }

        return redirect()->route('olist');

    }

    public function logout(){

        auth()->logout();
        return redirect()->route('login');
    }   

}
