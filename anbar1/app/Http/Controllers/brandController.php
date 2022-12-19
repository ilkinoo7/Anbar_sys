<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\brandRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\brands;
use App\Models\products;

class brandController extends Controller
{
    public function brandForm(brandRequest $post){

        $con = new brands();

        $post->validate([
            'foto'=>'required|image|mimes:jpg,jpeg,png,gif,svg|max:10485760'
        ]);

        if($post->file('foto')){
            $file = time().'.'.$post->foto->extension();
            $post->foto->storeAs('public/uploads/brands/',$file);
            $con->image = 'storage/uploads/brands/'.$file;
        }

        $con->ad = $post->ad;
        $con->user_id = auth::id();

        $con -> save();

        return redirect()->route('blist')->with('success','Melumat ugurla elave edildi!');
    }

    public function blist(){
        $con = brands::orderBy('id','desc')->where('brands.user_id','=',auth::id())->get();
        return view('brand',['data'=>$con]);
    }

    public function bsil(){
        $con = brands::oredrBy('id','desc')->where('brands.user_id','=',auth::id())->get();
        $deletecon = brands::find($id);
        return view('brand',[
            'deletedata'=>$deletecon,
            'data'=>$con
        ]);

    }

    public function bdelete(){

        $con1 = brands::find($id);
        $brand_id = $con1->id;

        $con2 = products::where('brand_id','=',$id)->count();

        if($con2>0)
        {
            return redirect()->route('blist')->with('success','Bu brend aktiv mehsula malikdir!');
            
           
        }
        else{
            $deletecon = brands::find($id)->delete();
            return redirect()->route('blist')->with('success','Melumat ugurla silindi!');
        }
    }

    public function bedit($id){
        $con = brands::orderBy('id','desc')->where('brands.user_id','=',auth::id())->get();
        $editcon = brands::find($id);
        return view('brand',[
            'editdata'=>$editcon,
            'data'=>$con
        ]);
    }

    public function bupdate(brandRequest $post){
  
        $con = brands::find($post->id);

        $post->validate([
            'foto'=>'required|image|mimes:jpg,jpeg,png,gif,svg|max:10485760'
        ]);

        if($post->file('foto')){

            $file = time().'.'.$post->foto->extension();
            $post->foto->storeAs('public/uploads/brands/',$file);
            $con->image = 'storage/uploads/brands/'.$file;

        }

        $con->ad = $post->ad;

        $con -> save();

        return redirect()->route('blist')->with('success','Melumat ugurla yenilendi!');

    }
}
