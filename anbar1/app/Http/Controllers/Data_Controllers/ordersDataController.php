<?php
namespace App\Http\Controllers\Data_Controllers;

use App\Http\Controllers\Controller;

use App\Models\orders;

use App\Models\clients;

use App\Models\products;

use App\Models\brands;

use Illuminate\Support\Facades\Auth;

class ordersDataController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(orders::join('clients','clients.id','=','orders.client_id')
            ->join('products','products.id','=','orders.product_id')
            ->select('orders.created_at','orders.id','orders.tesdiq','clients.ad AS klient','products.alis','products.satis','products.miqdar AS stok','orders.pmiqdar','products.ad AS produkt')->where('orders.user_id','=',auth::id())
            ->orderBy('id','desc')->get())

            ->addColumn('created_at',function($row){
                return date('Y-m-d H:i:s',strtotime($row->created_at));
            })

            ->addColumn('action',function($row){

                if($row->tesdiq==0){
                    return '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success edit">
                    Edit
                    </a>
                    <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" data-original-title="Delete" data-id="'.$row->id.'" class="delete btn btn-danger">
                        Delete
                    </a>
                    
                    
                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Tesdiq" class="tesdiq btn btn-success">
                        Tesdiq et
                    </a>';
                }
                else{
                    return'<a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" data-original-title="Delete" data-id="'.$row->id.'" class="legv btn btn-danger">
                    Legv et
                </a>';
                }

                               
            })


            ->rawColumns(['action','image'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('data_blades.orders_data',[
            'cdata'=>clients::orderBy('ad','asc')->where('clients.user_id','=',auth::id())->get(),
            'pdata'=> products::join('brands','brands.id','=','products.brand_id')
            ->select('products.id','products.ad AS mehsul','products.miqdar','brands.ad AS brend')
            ->orderBy('id','desc')->get(),
        ]);
    }
   
    
     
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        
         
        // $book->ad = $request->title;
        $book = new orders();
        $book->user_id = auth::id();
        $book->client_id = $request->client_id;
        $book->product_id = $request->product_id;
        $book->pmiqdar = $request->pmiqdar;
        $book->tesdiq = 0;
        
       
        $book->save();
     
        return Response()->json($book);
    }
     
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $book  = orders::where($where)->first();
     
        return Response()->json($book);
    }
     
     
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $book = orders::where('id',$request->id)->delete();
     
        return Response()->json($book);
    }

    public function otesdiq(Request $request){

        $book1 = orders::find($request->id);
        $product_id = $book1->product_id;
        $order_miqdar = $book1->pmiqdar;

        $book2 = products::find($product_id);
        $product_miqdar = $book2->miqdar;

        if($order_miqdar<=$product_miqdar){

            $netice = $product_miqdar - $order_miqdar;

            $book2->miqdar = $netice;
            $book2->save();

            $book1->tesdiq = 1;
            $book1->save();

            

        }
            return Response()->json($book1);
        
        
    }

    public function olegvet(Request $request){

        $book1 = orders::find($request->id);
        $product_id = $book1->product_id;
        $order_miqdar = $book1->pmiqdar;

        $book2 = products::find($product_id);
        $product_miqdar = $book2->miqdar;

        

            $netice = $product_miqdar + $order_miqdar;

            $book2->miqdar = $netice;
            $book2->save();

            $book1->tesdiq = 0;
            $book1->save();

            //return redirect()->route('olist')->with('success','Melumat ugurla legv olundu!');
            return Response()->json($book1);
        
    }
}
