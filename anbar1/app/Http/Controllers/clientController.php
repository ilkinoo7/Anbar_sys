<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\clientRequest;

use App\Models\clients;

use Illuminate\Support\Facades\Auth;

class clientController extends Controller
{
    public function clientForm(clientRequest $post){
  
        $con = new clients();
        $con->ad = $post->ad;
        $con->soyad = $post->soyad;
        $con->tel = $post->tel;
        $con->email = $post->email;
        $con->user_id = auth::id();
        $con->shirket = $post->shirket;

        $con -> save();

        return redirect()->route('clist')->with('success','Melumat ugurla elave edildi!');
    }

    public function clist(){
        $con = clients::orderBy('id','desc')->where('clients.user_id','=',auth::id())->get();
        return view('client',['data'=>$con]);
    }

    public function csil($id){
        $con = clients::orderBy('id','desc')->where('clients.user_id','=',auth::id())->get();
        $deletecon = clients::find($id);
        return view('client',[
            'deletedata'=>$deletecon,
            'data'=>$con
        ]);
    }

    public function cdelete($id){    
        
        
        $deletecon = clients::find($id)->delete();
        return redirect()->route('clist')->with('success','Melumat ugurla silindi!');
        
    }

    public function cedit($id){
        $con = clients::orderBy('id','desc')->where('clients.user_id','=',auth::id())->get();
        $editcon = clients::find($id);
        return view('client',[
            'editdata'=>$editcon,
            'data'=>$con
        ]);
    }


    public function cupdate(clientRequest $post){
  
        $con = clients::find($post->id);
        $con->ad = $post->ad;
        $con->soyad = $post->soyad;
        $con->tel = $post->tel;
        $con->email = $post->email;
        $con->shirket = $post->shirket;

        $con -> save();

        return redirect()->route('clist')->with('success','Melumat ugurla yenilendi!');

    }
}
