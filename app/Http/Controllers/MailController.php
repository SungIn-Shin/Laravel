<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;
use App\Mail\RejectMailer;
class MailController extends Controller
{
    //
    public function send(Request $request) 
    {
        Mail::to('tlstjddls123@naver.com')
            ->queue(new RejectMailer);
        //Mail::send(new SendMail);
        // Mail::send(['test' => 'mail'], ['name', 'SungIn'], function($message){
        //     $message->to('tlstjddls123@naver.com', 'To SungIn')->subject('TestMail');
        //     $message->from('tlstjddls123@gmail.com', 'SUngIn');
        // });
    }
}
