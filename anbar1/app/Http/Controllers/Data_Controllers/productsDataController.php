<?php
namespace App\Http\Controllers\Data_Controllers;

use App\Http\Controllers\Controller;

use App\Models\products;

use App\Models\brands;

use Illuminate\Support\Facades\Auth;

class productsDataController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(products::join('brands','brands.id','=','products.brand_id')
            ->select('products.id','products.ad AS mehsul','products.alis','products.alis','products.satis','products.miqdar','products.created_at','brands.ad AS brend')->where('products.user_id','=',auth::id())
            ->orderBy('id','desc')->get())
            ->addColumn('action', 'product-action')
            ->addColumn('created_at',function($row){
                return date('Y-m-d H:i:s',strtotime($row->created_at));
            })
            ->rawColumns(['action','image'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('products_data',[
            'bdata'=>brands::orderBy('ad','asc')->where('brands.user_id','=',auth::id())->get()
        ]
        );
    }
     
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $post)
    {  
        
        $con = new products();
        $con->user_id = auth::id();
        $con->brand_id = $post->brand_id;
        $con->ad = $post->ad;
        $con->alis = $post->alis;
        $con->satis = $post->satis;
        $con->miqdar = $post->miqdar;

        $con->user_id = auth::id();
       
        $con->save();
     
        return Response()->json($con);
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
        $book  = products::where($where)->first();
     
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
        $book = products::where('id',$request->id)->delete();
     
        return Response()->json($book);
    }
}
