<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Login;
use App\Course;
use App\Classe;
use App\SheetQuizz;


class SheetsQuizzsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
       $user = Login::where('token', $request->token)->first();
       $sheetsquizzs = SheetQuizz::where('id', $request->id)->first();
       $course = Course::where('id', $sheetsquizzs->course)->first();
       $classe = Classe::where('id', $course->id_classe)->first();


       if(isset($user) and !empty($user) and $classe->promo == $user->promo) {
         $data["course"] = $course;

         $data["sheets"] = $sheetsquizzs;

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
