<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Client;
use App\Document;
use Auth;
use DB;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('documents.index');
    }

    public function getDocuments(){
        echo "<pre>";
        $documents = Document::with('client')->get();

        print_r($documents);
        die();
        return $documents;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('documents.register_document');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $document = Document::create([
            'name' => $request->name,
            'description' => $request->description,
            'client_id' => $request->client_id,
            'expiration_date' => $request->expiration_date,
            'reminder_date' => $request->reminder_date,
            'user_id' => Auth::user()->id
        ]);

        if($request->file('file')){
            $filename = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/documents', $filename);
            // $path = Storage::disk('public')->put('image', $request->file('imagen')->getClientOriginalName());
            $document->fill(['file' => 'storage/documents/'.$filename])->save();
        }
        // if($request->type_person == 'Fisica'){
        //     $cliente = Client::create([
        //         'name' => $request->name,
        //         'phone' => $request->phone,
        //         'email' => $request->email,
        //         'rfc' => $request->rfc,
        //         'curp' => $request->curp,
        //         'address' => $request->address,
        //         'type_person' => $request->type_person,
        //         'user_id' => Auth::user()->id
        //     ]);

        //     if (!$cliente) {
        //         return array('status' => 'error', 'msg' => 'Error al crear cliente');
        //     }

        //     return array('status' => 'success', 'msg' => 'Cliente creado exitosamente');
        // }

        // if($request->type_person == 'Moral'){
        //      $cliente = Client::create([
        //         'name' => $request->name,
        //         'phone' => $request->phone,
        //         'email' => $request->email,
        //         'rfc' => $request->rfc,
        //         'business_name' => $request->business_name,
        //         'address' => $request->address,
        //         'turn' => $request->turn,
        //         'type_person' => $request->type_person,
        //         'user_id' => Auth::user()->id
        //     ]);

             if (!$document) {
                return array('status' => 'error', 'msg' => 'Error al crear documento');
            }

            return array('status' => 'success', 'msg' => 'Documento creado exitosamente');
        // }
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
        $client = Client::find($id);
        return $client;
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

        $client = Client::find($request->id);

        $client_exists_email = DB::table('clients')->where('email','=', $request->email)->where('id', '<>', $request->id)->first(); //validar si el email ya esta registrado


        $client_exists_rfc = DB::table('clients')->where('rfc','=',$request->rfc)->where('id', '<>', $request->id)->first(); //validar si el rfc ya esta registrado

        if(!empty($client_exists_email)){
            return array('status' => 'error', 'msg' => 'Email ya se encuentra registrado');
        }

        if(!empty($client_exists_rfc)){
            return array('status' => 'error', 'msg' => 'RFC ya se encuentra registrado');
        }

        if($request->type_person == 'Fisica'){
            $client->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'rfc' => $request->rfc,
                'curp' => $request->curp,
                'address' => $request->address,
                'type_person' => $request->type_person,
                'user_id' => Auth::user()->id
            ]);

            if (!$client) {
                return array('status' => 'error', 'msg' => 'Error al actualizar cliente');
            }

            return array('status' => 'success', 'msg' => 'Cliente actualizado exitosamente');
        }


        if($request->type_person == 'Moral'){
             $client->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'rfc' => $request->rfc,
                'business_name' => $request->business_name,
                'address' => $request->address,
                'turn' => $request->turn,
                'type_person' => $request->type_person,
                'user_id' => Auth::user()->id
            ]);

             if (!$client) {
                return array('status' => 'error', 'msg' => 'Error al actualizar cliente');
            }

            return array('status' => 'success', 'msg' => 'Cliente actualizado exitosamente');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Client::where('id',$id)->delete();
        return $result;
    }
}
