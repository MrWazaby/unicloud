<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Login;
use App\Course;
use App\Classe;
use App\SheetQuizz;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
       $user = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();
       $course = Course::where('id', $request->id)->first();
       $classe = Classe::where('id', $course->id_classe)->first();

       if(isset($user) and !empty($user) and $classe->promo == $user->promo) {
         $data["course"] = $course;

         $data["sheets"] = SheetQuizz::select('id', 'title', 'author', 'quizz')->where('course', $course->id)->get();
         foreach ($data["sheets"] as $key => $value) {
           $author = Login::where('id', $value->author)->first();
           $data["sheets"][$key]->certified = $author->certified;
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
