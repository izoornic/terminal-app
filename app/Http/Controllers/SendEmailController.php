<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
//use Illuminate\Support\Facades\Mail;
//use Illuminate\Mail;
use App\Mail\NotyfyMail;


class SendEmailController extends Controller
{
     //
     public function index()
     {

          Mail::to('izornic@gmail.com')->send(new NotyfyMail());

          /* if (Mail::failures()) {
           return response()->Fail('Sorry! Please try again latter');
      }else{
           return response()->success('Great! Successfully send in your mail');
         } */
     }

     public static function sendMail()
     {

          Mail::to('izornic@gmail.com')->send(new NotyfyMail());

          if (Mail::failures()) {
               return response()->Fail('Sorry! Please try again latter');
          } else {
               return response()->success('Great! Successfully send in your mail');
          }
     }
}
