<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;
class MailController extends Controller
{
    //
    public function send() 
    {
        Mail::send(new SendMail);
        // Mail::send(['test' => 'mail'], ['name', 'SungIn'], function($message){
        //     $message->to('tlstjddls123@naver.com', 'To SungIn')->subject('TestMail');
        //     $message->from('tlstjddls123@gmail.com', 'SUngIn');
        // });
    }
}
