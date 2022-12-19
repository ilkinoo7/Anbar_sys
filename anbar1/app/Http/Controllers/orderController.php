<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\orderRequest;

use Illuminate\Support\Facades\Auth;

use App\Models\orders;
use App\Models\clients;
use App\Models\products;
use App\Models\brands;

class orderController extends Controller
{
    public function orderForm(orderRequest $post){
  
        $con = new orders();
        $con->user_id = auth::id();
        $con->client_id = $post->client_id;
        $con->product_id = $post->product_id;
        $con->pmiqdar = $post->pmiqdar;
        $con->tesdiq=0;

        $con -> save();

        return redirect()->route('olist')->with('success','Melumat ugurla elave edildi!');

    }

    public function olist(){

        $user_id = auth::id();

        $con = orders::join('clients','clients.id','=','orders.client_id')
        ->join('products','products.id','=','orders.product_id')
        ->select('orders.created_at','orders.id','orders.tesdiq','clients.ad AS klient','products.alis','products.satis','products.miqdar AS stok','orders.pmiqdar','products.ad AS produkt')->where('orders.user_id','=',auth::id())
        ->orderBy('id','desc')->get();



        $p = products::get();

        $qazanc = 0;

        $cqazanc = 0;

        foreach($p as $m){
            $miq = $m->miqdar;
            $al = $m->alis;
            $sat = $m->satis;

            $qazanc = $sat - $al;
            $cazanc = (($sat - $al) * $miq) + $qazanc;
        }


        return view('order',[
            'bsay'=>brands::count(),
            'csay'=>clients::count(),
            'psay'=>products::count(),
            'tmehsul'=>products::sum('miqdar'),
            'talis'=>products::sum('alis'),
            'tsatis'=>products::sum('satis'),
            'user_id'=>$user_id,
            'qazanc'=>$qazanc,
            'cqazanc'=>$cqazanc,
            'data'=>$con,            
            'cdata'=>clients::orderBy('ad','asc')->where('clients.user_id','=',auth::id())->get(),
            'pdata'=> products::join('brands','brands.id','=','products.brand_id')
            ->select('products.id','products.ad AS mehsul','products.miqdar','brands.ad AS brend')
            ->orderBy('id','desc')->get(),
        ]);
    }

    public function osil($id){
        $con = orders::join('clients','clients.id','=','orders.client_id')
        ->join('products','products.id','=','orders.product_id')->select('orders.id','clients.ad AS klient','products.alis','products.satis','products.miqdar AS stok','orders.pmiqdar','products.ad AS produkt')->where('orders.user_id','=',auth::id())
        ->orderBy('id','desc')->get();

        $deletecon = orders::find($id);

        return view('order',[
            'deletedataorder'=>$deletecon,
            'cdata'=>clients::orderBy('ad','asc')->where('clients.user_id','=',auth::id())->get(),
            'pdata'=> products::join('brands','brands.id','=','products.brand_id')
            ->select('products.id','products.ad AS mehsul','products.alis','products.alis','products.satis','products.miqdar','brands.ad AS brend')
            ->orderBy('id','desc')->get(),
            'data'=>$con,
        ]);  
    }

    public function odelete($id){
        $deletecon = orders::find($id)->delete();
        return redirect()->route('olist')->with('success','Melumat ugurla silindi!');
    }

    public function oedit($id){
        $con = orders::join('clients','clients.id','=','orders.client_id')
        ->join('products','products.id','=','orders.product_id')->select('orders.id','clients.ad AS klient','orders.pmiqdar','products.ad AS produkt')->where('orders.user_id','=',auth::id())
        ->orderBy('id','desc')->get();

        $editcon = orders::find($id);
        return view('order',[
            'editdata'=>$editcon,
            'data'=>$con,            
            'cdata'=>clients::orderBy('ad','asc')->where('clients.user_id','=',auth::id())->get(),
            'pdata'=> products::join('brands','brands.id','=','products.brand_id')
            ->select('products.id','products.ad AS mehsul','products.alis','products.alis','products.satis','products.miqdar','brands.ad AS brend')
            ->orderBy('id','desc')->get(),
        ]);
    }



    public function otesdiq($id){

        $con1 = orders::find($id);
        $product_id = $con1->product_id;
        $order_miqdar = $con1->pmiqdar;

        $con2 = products::find($product_id);
        $product_miqdar = $con2->miqdar;

        if($order_miqdar<=$product_miqdar){

            $netice = $product_miqdar - $order_miqdar;

            $con2->miqdar = $netice;
            $con2->save();

            $con1->tesdiq = 1;
            $con1->save();

            return redirect()->route('olist')->with('success','Melumat ugurla tesdiq olundu!');


        }
        else{
            return redirect()->route('olist')->with('success','Kifayet qeder mehsul yoxdu!');
        }
        
    }

    public function olegvet($id){

        $con1 = orders::find($id);
        $product_id = $con1->product_id;
        $order_miqdar = $con1->pmiqdar;

        $con2 = products::find($product_id);
        $product_miqdar = $con2->miqdar;

        

            $netice = $product_miqdar + $order_miqdar;

            $con2->miqdar = $netice;
            $con2->save();

            $con1->tesdiq = 0;
            $con1->save();

            return redirect()->route('olist')->with('success','Melumat ugurla legv olundu!');
        
    }


    public function oupdate(orderRequest $post){
  
        $con = new orders();
        $con->client_id = $post->client_id;
        $con->product_id = $post->product_id;
        $con->pmiqdar = $post->pmiqdar;

        $con -> save();

        return redirect()->route('olist')->with('success','Melumat ugurla yenilendi!');

    }
}
