<?php

namespace App\Http\Controllers\Data_Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\clients;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

class clientsDataController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(clients::select('*'))
            ->addColumn('action', 'data_blades.book-action')
            #->addColumn('image', 'image')
            ->addColumn('created_at', function($row){
                return date('d-m-Y H:i:s', strtotime($row->created_at) );
            })
            ->rawColumns(['action','image'])
            ->addIndexColumn()
            ->make(true);

            
        }
        return view('data_blades.clients_data');
    }
     
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        date_default_timezone_set('Asia/Baku');

        $bookId = $request->id;
        if($bookId){
             
            $book = clients::find($bookId);
            $path = $book->image;
            File::delete($path);
               
            if($request->hasFile('image')){
                $file = time().'.'.$request->image->extension();
                $request->image->storeAS('public/uploads/images/',$file);
                $book->image = 'storage/uploads/images/'.$file;
                   
             
            }  
         }else{
               
            $book = new clients();
            if($request->hasFile('image')){
                $file = time().'.'.$request->image->extension();
                $request->image->storeAS('public/uploads/images/',$file);
                $book->image = 'storage/uploads/images/'.$file;
                
            }
               
         }
        
        
        $book->ad = $request->ad;
        $book->user_id = auth::id();
        $book->soyad = $request->soyad;
        $book->tel = $request->tel;
        $book->email = $request->email;
        $book->shirket = $request->shirket;
       
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
        $book  = clients::where($where)->first();
     
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
        $book = clients::find($request->id);
        $path = $book->image;

        File::delete($path);
        $book->delete();
     
        return Response()->json($book);
    }
}

