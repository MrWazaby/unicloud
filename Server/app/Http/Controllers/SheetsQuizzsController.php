<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Login;
use App\Course;
use App\Classe;
use App\SheetQuizz;
use App\Quizz;
use App\Stats;

class SheetsQuizzsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
       $user = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();
       $sheetsquizzs = SheetQuizz::where('id', $request->id)->first();
       $course = Course::where('id', $sheetsquizzs->course)->first();
       $classe = Classe::where('id', $course->id_classe)->first();


       if(isset($user) and !empty($user) and $classe->promo == $user->promo) {
         $data["course"] = $course;

         $data["sheets"] = $sheetsquizzs;

         if($sheetsquizzs->quizz == 1) {
           $questions = Quizz::where('quizz', $sheetsquizzs->id)->get();
           foreach($questions as $question) {
               $data["questions"][$question->id] = $question->question;
               $data["answers"][$question->id] = explode("\n", $question->answers);
               $data["answers"][$question->id] = array_merge($data["answers"][$question->id], explode("\n", $question->goodAnswers));
               shuffle($data["answers"][$question->id]);
           }
         } else {
           if(empty(Stats::where([['idUser', $user->id], ['sheets', $request->id]])->first())) {
             $stats = new Stats;
             $stats->idUSer = $user->id;
             $stats->sheets = $request->id;
             $stats->quizz = 0;
             $stats->save();
           }
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
      $user = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();
      $course = Course::where('id', $request->id_course)->first();
      $classe = Classe::where('id', $course->id_classe)->first();

      $data = 0;

      if(isset($user) and !empty($user) and $classe->promo == $user->promo) {
        if(isset($request->title) && !empty($request->title) && isset($request->content) && !empty($request->content) && is_numeric($request->score) && $request->score <= 10) {
          $sheet = new SheetQuizz;

          $sheet->author = $user->id;
          $sheet->course = $request->id_course;
          $sheet->title = $request->title;
          $sheet->content = $request->content;
          $sheet->score = $request->score;
          if($request->isQuizz) $sheet->quizz = 1;
          else $sheet->quizz = 0;

          $sheet->save();
          $data = SheetQuizz::orderBy('id', 'desc')->first()->id;

          if($request->isQuizz) {
            if(count($request->questions) > 0) {
              foreach ($request->questions as $key => $value) {
                if(isset($request->badAnswers[$key]) && isset($request->goodAnswer[$key]) && isset($value) && !empty($request->badAnswers[$key]) && !empty($request->goodAnswer[$key]) && !empty($value)) {
                  $quizz = new Quizz;
                  $quizz->quizz = $data;
                  $quizz->question = $value;
                  $quizz->answers = $request->badAnswers[$key];
                  $quizz->goodAnswers = $request->goodAnswer[$key];
                  $quizz->save();
                } else {
                  SheetQuizz::where('id', $data)->first()->delete();
                  $remanents = Quizz::where('quizz', $data)->get();
                  foreach ($remanents as $remanent) {
                    $remanent->delete();
                  }
                  $data = 0;
                }
              }
            } else {
              SheetQuizz::where('id', $data)->first()->delete();
              $data = 0;
            }
          }
        }
      }

      return $data;
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
      $user = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();
      $sheetsquizzs = SheetQuizz::where('id', $id)->first();
      $course = Course::where('id', $sheetsquizzs->course)->first();
      $classe = Classe::where('id', $course->id_classe)->first();


      if(isset($user) and !empty($user) and $classe->promo == $user->promo) {
        $data["course"] = $course;

        $data["sheets"] = $sheetsquizzs;

        $score = 0;

        if($sheetsquizzs->quizz == 1) {
          $questions = Quizz::where('quizz', $sheetsquizzs->id)->get();
          foreach($questions as $question) {
              $answers = explode("\n", $question->goodAnswers);
              if(!empty($request->answers[$question->id]) && in_array($request->answers[$question->id], $answers)) $score++;
          }
        }
      }

      if($score == count($questions)) {
        if(empty(Stats::where([['idUser', $user->id], ['quizz', $id]])->first())) {
          $stats = new Stats;
          $stats->idUSer = $user->id;
          $stats->sheets = 0;
          $stats->quizz = $id;
          $stats->save();
          $user->score += $sheetsquizzs->score;
          $user->save();
        }
      }

      return $score;
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
