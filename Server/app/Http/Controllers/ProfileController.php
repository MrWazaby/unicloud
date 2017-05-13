<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Login;
use App\Stats;
use App\SheetQuizz;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();

        if(isset($user) and !empty($user)) {
          $data = $user;
          unset($data["password"]);
          unset($data["token"]);
          unset($data["ip"]);

          $data["revisionsPrct"] = Stats::where([['idUSer', $user->id], ['sheets', '!=', 0]])->count();
          $data["quizzCreated"] = SheetQuizz::where([['author', $user->id], ['quizz', 1]])->count();
          $data["methodCreated"] = SheetQuizz::where([['author', $user->id], ['quizz', 0]])->count();

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
    public function show(Request $request, $id)
    {
      $userA = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();

      if(isset($userA) and !empty($userA)) {
        $user = Login::where('id', $id)->first();
        $data = $user;
        unset($data["password"]);
        unset($data["token"]);
        unset($data["ip"]);

        $data["revisionsPrct"] = Stats::where([['idUSer', $id], ['sheets', '!=', 0]])->count();
        $data["quizzCreated"] = SheetQuizz::where([['author', $id], ['quizz', 1]])->count();
        $data["methodCreated"] = SheetQuizz::where([['author', $id], ['quizz', 0]])->count();

        $data["valid"] = true;
      } else {
        $data["valid"] = false;
      }

      return $data;
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
