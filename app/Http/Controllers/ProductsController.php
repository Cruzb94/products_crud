<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Products;
use Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

    public function getProducts(){
        $products = Products::all();
        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('products.register_product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Products::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'id_user' => Auth::user()->id
        ]);

        if($request->file('imagen')){
            $imagename = $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->storeAs('public/image', $imagename);
            // $path = Storage::disk('public')->put('image', $request->file('imagen')->getClientOriginalName());
            $product->fill(['imagen' => 'storage/image/'.$imagename])->save();
        }

         return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::find($id);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $product = Products::find($request->id);

        $product->update([
            'name' => $request->name,
            'stock' => $request->stock,
            'id_user' => Auth::user()->id
        ]);

        if($request->file('imagen')){
            $imagename = $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->storeAs('public/image', $imagename);
            // $path = Storage::disk('public')->put('image', $request->file('imagen')->getClientOriginalName());
            $product->fill(['imagen' => 'storage/image/'.$imagename])->save();
        }

         return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Products::where('id',$id)->delete();
        return $result;
    }
}
