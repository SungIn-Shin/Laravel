<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Log_request extends Model
{
    public function store($request)
    {
        $data = new Log_request;
        $data->url = $request->fullUrl();
        $data->method = $request->getMethod();
        $data->ip = $request->getClientIp();
        $data->agent = $request->header('User-Agent');
        $data->useremail = Auth::check() ? Auth::user()->email : null;
        
        $result = $data->save();
    }
}
