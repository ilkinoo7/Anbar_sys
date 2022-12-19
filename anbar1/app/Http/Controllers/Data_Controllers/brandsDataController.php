<?php
namespace App\Http\Controllers\Data_Controllers;

use App\Http\Controllers\Controller;
use App\Models\brands;

use Illuminate\Http\Request;

use App\Models\products;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

class brandsDataController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(brands::select('*'))
            ->addColumn('action', 'data_blades.book-action')
            #->addColumn('image', 'image')
            ->addColumn('created_at', function($row){
                return date('d-m-Y H:i:s', strtotime($row->created_at) );
            })
            ->rawColumns(['action','image'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('data_blades.brands_data');
    }
     
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        #Update
        date_default_timezone_set('Asia/Baku');
        $bookId = $request->id;
        if($bookId){
             
            $book = brands::find($bookId);
            $path = $book->image;
            File::delete($path);
                
            if($request->hasFile('image')){
                $file = time().'.'.$request->image->extension();
                $request->image->storeAS('public/uploads/images/',$file);
                $book->image = 'storage/uploads/images/'.$file;
                
                
                
             
            }
               
         }
         #Insert
         else{
            $book = new brands;               
            if($request->hasFile('image')){
                $file = time().'.'.$request->image->extension();
                $request->image->storeAS('public/uploads/images/',$file);
                $book->image = 'storage/uploads/images/'.$file;
                
            }
               
         }
         
        $book->ad = $request->ad;
        $book->user_id = auth::id();
       
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
        $book  = brands::where($where)->first();
     
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
        #$book = brands::where('id',$request->id)->delete();
     
        

        $book = brands::find($request->id);
        $path = $book->image;

        File::delete($path);
        $book->delete();

        return Response()->json($book);

        /*$con1 = brands::find($id);
        $brand_id = $con1->id;

        $con2 = products::where('brand_id','=',$id)->count();

        if($con2>0)
        {
            return redirect()->route('blist')->with('success','Bu brend aktiv mehsula malikdir!');
            
           
        }
        else{
            $deletecon = brands::find($id)->delete();
            return redirect()->route('blist')->with('success','Melumat ugurla silindi!');
        }*/
    }
}
