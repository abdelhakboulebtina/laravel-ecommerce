<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Cart.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $duplicata=Cart::search(function ($cartItem,$rowId)use($request){
        return $cartItem->id==$request->product_id;
    });
    if($duplicata->isNotEmpty())
    {
        return redirect()->route('products.index')->with('success','le product à déja été ajouté');
    }
        $product= Product::find($request->product_id) ;
        Cart::add($product->id,$product->title,1,$product->price)
        ->associate('App\Product');
        return redirect()->route('products.index')->with('success','le produit à bien été ajouté');
    }

    /**
     * Display the speced resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId)
    {
        $data=$request->json()->all();
        Cart::update($rowId,$data['qty']);
        $validtor=Validtor::make($request->all(),['qty'=>'required|numeric|between:1,6']);
       if ($validtor->fails()) {
           # code...
           Session::flash('danger','la quantite de produit estne doit pas  depasse 6');
           return response()->json(['danger'=>'Cart quantity has not been updated']);
       }
        Session::flash('success','la quantite de produit est passe a '.$data['qty']);
        return response()->json(['success'=>'Cart quantity has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowid)
    {
       Cart::remove($rowid);
       return back()->with('success','le produit a été supprimé');
    }
}
