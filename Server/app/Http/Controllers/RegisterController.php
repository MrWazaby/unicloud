<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Login;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      $valid = true;
      $users = Login::all();

      foreach($users as $user) {
        if(strtoupper($user->mail) == strtoupper($request->mail)) $valid = false;
      }

      if($valid) {
        if(filter_var($request->mail, FILTER_VALIDATE_EMAIL)) {
            if($request->mail == $request->mail2) {
              if(strlen($request->pass) >= 6 && $request->pass == $request->pass2) {
                if(!empty($request->firstName) && !empty($request->lastName)) {
                  if(!empty($request->promo) && !empty($request->studentId)) {
                    $error = 0;
                    $user = new Login;
                    $user->mail = $request->mail;
                    $user->password = Hash::make($request->pass);
                    $user->firstName = $request->firstName;
                    $user->lastName = $request->lastName;
                    $user->avatar = "";
                    $user->promo = $request->promo;
                    $user->idUser = $request->studentId;
                    $user->registerDate = date("Y-m-d H:i:s");
                    $user->lastLogin = date("Y-m-d H:i:s");
                    $user->certified = 0;
                    $user->ip = $request->ip();
                    $user->token = "";
                    $user->score = 0;
                    $user->save();
                  } else {
                    $error = 6;
                  }
                } else {
                  $error = 5;
                }
              } else {
                $error = 4;
              }
            } else {
              $error = 3;
            }
        } else {
          $error = 2;
        }
      } else {
        $error = 1;
      }

      return $error;
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
        $error = 404;

        if($request->action == "pass") {
          if(isset($request->pass) && isset($request->pass2) && isset($request->oldpass)) {
            if(strlen($request->pass) >= 6 && $request->pass == $request->pass2) {
              $user = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();
              if(Hash::check($request->oldpass, $user->password)) {
                $user->password = Hash::make($request->pass);
                $user->save();
                $error = 7;
              } else {
                $error = 11;
              }
            } else {
              $error = 4;
            }
          }
        }

        if($request->action == "data") {
          if(!empty($request->firstName) && !empty($request->lastName)) {
            if(!empty($request->promo) && !empty($request->studentId)) {
              $user = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();
              $user->firstName = $request->firstName;
              $user->lastName = $request->lastName;
              $user->promo = $request->promo;
              $user->idUser = $request->studentId;
              $user->save();
              $error = 8;
            } else {
              $error = 6;
            }
          } else {
            $error = 5;
          }
        }

        if($request->action == "avatar") {
          $error = 10;
          $allowedExt = ["jpeg", "png", "jpg", "gif", "svg"];
          $allowedMime = ["image/jpeg", "image/png", "image/jpg", "image/gif", "image/svg+xml"];

          if($request->file('avatar') !== null && $request->file('avatar')->isValid()) {
            if($request->file('avatar')->getSize() < 1048576) {
              if(in_array($request->file('avatar')->getClientOriginalExtension(), $allowedExt)) {
                if(in_array($request->file('avatar')->getMimeType(), $allowedMime)) {
                  $size = getimagesize($request->file('avatar'));
                  if($size[0] <= 600 && $size[1] < 600) {
                    $user = Login::where([['token', $request->token], ['ip', $request->ip()]])->first();
                    $imageName = $user->id.'-'.time().'.'.$request->file('avatar')->getClientOriginalExtension();
                    $request->file('avatar')->move(public_path('avatars/upload'), $imageName);
                    if($user->avatar != "") unlink(public_path('avatars/upload').'/'.$user->avatar);
                    $user->avatar = $imageName;
                    $user->save();
                    $error = 9;
                  }
                }
              }
            }
          }
        }

        return $error;
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
