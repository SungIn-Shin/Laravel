<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Loginhistory extends Model
{
    public function index($request)
    {
        $loginhistories = Loginhistory::query(); // 아래쪽에서 쿼리를 합침
        
        // 날짜
        if ( !empty($request->created_at_start) && !empty($request->created_at_end) ) {
            $loginhistories = $loginhistories->whereBetween('created_at', array($request->created_at_start." 00:00:00", $request->created_at_end." 23:59:59"));
        }
        // 성공실패여부
        if ( !empty($request->successyn) ) {
            $loginhistories = $loginhistories->where('successyn','=',$request->successyn);
        }

        // 검색조건
        $condition = $request->condition;
        $search = $request->search;

        // 요청된 검색조건인 $condition 값은 컬럼 조작 방지를 위해 미리 고정된 값이 맞는지 확인했음 -> 나중에 다른 방법 찾을것
        if ( !empty($condition) && !empty($search) && ($condition == 'useremail' || $condition == 'ip') ) {
            $loginhistories = $loginhistories->where($condition,'LIKE',"%{$search}%");
        }

        $loginhistories = $loginhistories->orderBy('id', 'desc')
            ->getQuery()
            ->paginate(10);

        return $loginhistories;
    }

    public function store($request, $loginhistory)
    {
        DB::beginTransaction();

        $data = new Loginhistory;
        $data->useremail = $request->email;  //입력된 user의 email
        $data->ip = $request->ip();
        $data->gubun = $loginhistory->gubun;
        $data->successyn = $loginhistory->successyn;
        
        $result = $data->save();
        
        if (!$result) {
            DB::rollback();
        } else {
            DB::commit();
        }
    }
}
