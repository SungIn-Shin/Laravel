<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Log_request extends Model
{
    public function index($request)
    {
        $log_requests = Log_request::query(); // 아래쪽에서 쿼리를 합침
        
        // 날짜
        if ( !empty($request->created_at_start) && !empty($request->created_at_end) ) {
            $log_requests = $log_requests->whereBetween('created_at', array($request->created_at_start." 00:00:00", $request->created_at_end." 23:59:59"));
        }

        // 검색조건
        $condition = $request->condition;
        $search = $request->search;

        // 요청된 검색조건인 $condition 값은 컬럼 조작 방지를 위해 미리 고정된 값이 맞는지 확인했음 -> 나중에 다른 방법 찾을것
        if ( !empty($condition) && !empty($search) && ($condition == 'useremail' || $condition == 'ip' || $condition == 'url') ) {
            $log_requests = $log_requests->where($condition,'LIKE',"%{$search}%");
        }

        $log_requests = $log_requests->orderBy('id', 'desc')
            ->getQuery()
            ->paginate(10);

        return $log_requests;
    }

    public function store($request)
    {
        if ( config('app.log_request') ) {
            if ( config('app.log_request_anonymous') == true || (config('app.log_request_anonymous') == false && Auth::check()) ) {
                $data = new Log_request;
                $data->url = $request->fullUrl();
                $data->method = $request->getMethod();
                $data->ip = $request->getClientIp();
                $data->agent = $request->header('User-Agent');
                $data->useremail = Auth::check() ? Auth::user()->email : null;
                
                $result = $data->save();
            }
        }
    }
}
