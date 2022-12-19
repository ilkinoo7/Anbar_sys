<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\productRequest;

use Illuminate\Support\Facades\Auth;

use App\Models\products;
use App\Models\brands;

class productController extends Controller
{
    public function productForm(productRequest $post){
  
        $con = new products();
        $con->user_id = auth::id();
        $con->brand_id = $post->brand_id;
        $con->ad = $post->ad;
        $con->alis = $post->alis;
        $con->satis = $post->satis;
        $con->miqdar = $post->miqdar;

        $con -> save();

        return redirect()->route('plist')->with('success','Melumat ugurla elave edildi!');

    }

    public function plist(){

        $con = products::join('brands','brands.id','=','products.brand_id')
        ->select('products.id','products.ad AS mehsul','products.alis','products.alis','products.satis','products.miqdar','brands.ad AS brend')->where('products.user_id','=',auth::id())
        ->orderBy('id','desc')->get();

        return view('product',[
            'data'=>$con,
            'bdata'=>brands::orderBy('ad','asc')->where('brands.user_id','=',auth::id())->get(),
        ]);
    }

    public function psil($id){

        $con = products::join('brands','brands.id','=','products.brand_id')
        ->select('products.id','products.ad AS mehsul','products.alis','products.alis','products.satis','products.miqdar','brands.ad AS brend')->where('products.user_id','=',auth::id())
        ->orderBy('id','desc')->get();

        $deletecon = products::find($id);
        return view('product',[
            'bdata'=>brands::orderBy('ad','asc')->where('brands.user_id','=',auth::id())->get(),
            'deletedata'=>$deletecon,
            'data'=>$con
        ]);
       
    }

    public function pdelete($id){

        $con = products::find($id)->delete();
        return redirect()->route('plist')->with('success','Melumat ugurla silindi!');
    }

    public function pedit($id){
        $con = products::join('brands','brands.id','=','products.brand_id')
        ->select('products.id','products.ad AS mehsul','products.alis','products.alis','products.satis','products.miqdar','brands.ad AS brend')->where('products.user_id','=',auth::id())
        ->orderBy('id','desc')->get();

        $editcon = products::find($id);
        return view('product',[
            'editdata'=>$editcon,
            'data'=>$con,
            'bdata'=>brands::orderBy('ad','asc')->where('brands.user_id','=',auth::id())->get(),
        ]);
    }


    public function pupdate(productRequest $post){
  
        $con = products::find($post->id);
        $con->brand_id = $post->brand_id;
        $con->ad = $post->ad;
        $con->alis = $post->alis;
        $con->satis = $post->satis;
        $con->miqdar = $post->miqdar;

        $con -> save();

        return redirect()->route('plist')->with('success','Melumat ugurla yenilendi!');

    }
}
