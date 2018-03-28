<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Document extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;
    // Documents(1) : Expenditure_historys(N) 관계 지정
    public function expenditureHistorys() {
        return $this->hasMany('App\ExpenditureHistory');
    }
    
    // Documents(1) : attachments(N) 관계 지정
    public function attachments() {
        return $this->hasMany('App\Attachment');
    }

    // Documents(1) : attachments(N) 관계 지정
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    // Documents(N) : users(1) 역관계 지정
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function team() {
        return $this->belongsToThrough(Team::class, User::class);
    }


    


    // 일반 사용자 문서 리스트 조회
    public function selectNomalUserDocumentsList(Request $request) {
        //  
        $user_id = Auth::user()->id;
        $documents = Document::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(5);
        return $documents;
    }

    // 팀장 문서 리스트 조회
    public function selectTeamLeaderDocumentsList(Request $request) {
        //
        $team_id = Auth::user()->team_id;
        $documents = Document::where('team_id', $team_id)->orderBy('created_at', 'desc')->paginate(5);
        return $documents;
    }

    // 경영지원 팀장 등급 문서 리스트 조회
    public function selectSupportLeaderDocumentsList(Request $request) {
        $query = Document::query();
        
        if($request->has('team_id')){ 
            $team_id = $request->team_id;
            $query->where('team_id', $team_id);
        }

        if($request->has('user_name')){
            $user_name = $request->user_name;
            $users = User::where('name', 'like', '%'.$user_name.'%')->pluck('id'); // id만 array로 반환해줌.
            $query->whereIn('user_id', $users);
        }

        if($request->has('year')) {
            $year = $request->year;
            $query->whereYear('created_at', $year);
        }

        if($request->has('month')) {
            $month = $request->month;
            $query->whereMonth('created_at', $month);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(5);

        return $documents;
    }

    // 문서정보 상세보기
    public function selectDocumentDetail($document_id) {
        return Document::find($document_id);
    }

















    public function changeInspectionStatus($status) {
        switch ($status) {
            case "REJ" : 
                return "반려";
                break;
            case "APR":
                return "승인";
                break;            
            default:
                return "검토중";
                break;                                                                          
        }
    }

    public function changeStatus($status) {
        switch ($status) {
            case "REG" : 
                return "검토대기";
                break;
            case "APR":
                return "승인";
                break;            
            default:
                return "검토중";
                break;                                                                          
        }
    }

   
}
