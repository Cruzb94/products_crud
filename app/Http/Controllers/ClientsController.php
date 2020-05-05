<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Client;
use Auth;
use DB;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clients.index');
    }

    public function getClients(){
        $clients = Client::all();
        return $clients;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('clients.register_client');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client_exists_email = DB::table('clients')->where('email', $request->email)->first(); //validar si el email ya esta registrado

        $client_exists_rfc = DB::table('clients')->where('rfc', $request->rfc)->first(); //validar si el rfc ya esta registrado

        if($client_exists_email){
            return array('status' => 'error', 'msg' => 'Email ya se encuentra registrado');
        }

        if($client_exists_rfc){
            return array('status' => 'error', 'msg' => 'RFC ya se encuentra registrado');
        }

        if($request->type_person == 'Fisica'){
            $cliente = Client::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'rfc' => $request->rfc,
                'curp' => $request->curp,
                'address' => $request->address,
                'type_person' => $request->type_person,
                'user_id' => Auth::user()->id
            ]);

            if (!$cliente) {
                return array('status' => 'error', 'msg' => 'Error al crear cliente');
            }

            return array('status' => 'success', 'msg' => 'Cliente creado exitosamente');
        }

        if($request->type_person == 'Moral'){
             $cliente = Client::create([
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

             if (!$cliente) {
                return array('status' => 'error', 'msg' => 'Error al crear cliente');
            }

            return array('status' => 'success', 'msg' => 'Cliente creado exitosamente');
        }
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
