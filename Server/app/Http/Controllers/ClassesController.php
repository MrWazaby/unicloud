<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Login;
use App\Classe;
use App\Course;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Responses
     */
     public function index(Request $request)
     {
       $user = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();
       if(isset($user) and !empty($user)) {
         $data["classes"] = Classe::where('promo', $user->promo)->get();
         foreach($data["classes"] as $classe) {
             $data["courses"][$classe->id] = Course::where('id_classe', $classe->id)->get();
         }
         $data["valid"] = true;
       } else {
         $data["valid"] = false;
       }
       return $data;
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
        //
    }

    /**
     * Display the specified resource.
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
