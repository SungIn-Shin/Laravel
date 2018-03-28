<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\Document;
use App\Comment;
use App\Attachment;
use App\ExpenditureHistory;
use App\ApprovalLine;

use DB;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    // 로그찍기ㅣㅣㅣㅣㅣㅣㅣㅣㅣㅣㅣㅣㅣㅣㅣㅣㅣ
    // var_dump($documents);
    // die();
    // print_r($documents);
    // die();
    // dump($documents);

    public function registForm()
    {
        $user = Auth::user();
        if($user->hasRole('employee')) {
            return view('iheart.employee.regist');
        } else if ($user->hasRole('team_leader')) {
            return view('iheart.team_leader.regist');
        } else {
            abort(400);
        }
    }
    /**
     * Display a listing of the resource. * * 
     * @return \Illuminate\Http\Response
     */
    public function selectNomalUserDocumentsList(Request $request)
    {
        // dd(ApprovalLine::all()); 
        $documents = new Document;
        $documents = $documents->selectNomalUserDocumentsList($request);
        return view('iheart.employee.list')->with(['documents' => $documents]);
    }

    private function switchInspectionStatus(String $inspecStatus) 
    {
        switch ($inspecStatus) {
            case 'APR':
                return "승인";
                break;
            
            default:
                return "반려";
                break;
        }
    }

    // 경영지원팀장 문서 리스트 조회
    public function selectSupportLeaderDocumentsList(Request $request) 
    { 
        $documents = new Document;
        $documents = $documents->selectSupportLeaderDocumentsList($request);
        return view('iheart.support_leader.list')->with(['documents' => $documents]);        
    }

    public function selectTeamLeaderDocumentsList(Request $request) 
    {
        $documents = new Document;
        $documents = $documents->selectTeamLeaderDocumentsList($request);
       
        return view('iheart.team_leader.list')->with(['documents' => $documents]);        
    }

    public function documentDetail($document_id) 
    {
        // 세션 유저 정보 획득
        $user = Auth::user();
        // 모델에서 데이터 획득
        $document = new Document;
        $document = $document->selectDocumentDetail($document_id);

        // 권한별 페이지 변경
        if($user->hasRole('employee')) {
            return view('iheart.employee.detail')->with('document', $document);
        } else if ($user->hasRole('team_leader')) {
            return view('iheart.team_leader.detail')->with('document', $document);
        } else if ($user->hasRole('support_leader')) {
            return view('iheart.support_leader.detail')->with('document', $document);
        } else if ($user->hasRole('admin')) {
            return view('iheart.admin.detail')->with('document', $document);
        } else {
            abort(403);
        }
    }

    // 팀장 반려처리
    public function teamLeaderReject(Request $request) 
    {
        $document_id = $request->document_id;
        $document = Document::find($document_id);
        $document->tl_inspection_status = "REJ";
        $document->save();

        $comment = new Comment;
        $comment->writer    = Auth::user()->name;
        $comment->title     = $request->title;
        $comment->content   = $request->content;
        $document->comments()->save($comment);

        return redirect()->route('iheart.team_leader.list');        
    }

    // 팀장 승인처리
    public function teamLeaderApr(Request $request) 
    {
        $document_id = $request->document_id;
        $document = Document::find($document_id);
        $document->tl_inspection_status = "APR";
        $document->save();
        
        return redirect()->route('iheart.team_leader.list');        
    }

    // 경영지원 팀장 반려처리 
    public function supportLeaderReject(Request $request) 
    {
        $document_id = $request->document_id;
        $document = Document::find($document_id);
        $document->sl_inspection_status = "REJ";
        $document->save();

        $comment = new Comment;
        $comment->writer    = Auth::user()->name;
        $comment->title     = $request->title;
        $comment->content   = $request->content;
        $document->comments()->save($comment);

        return redirect()->route('iheart.support_leader.list');        
    }
    // 경영지원 팀장 승인처리 
    public function supportLeaderApr(Request $request) 
    {
        $document_id = $request->document_id;
        $document = Document::find($document_id);
        $document->sl_inspection_status = "APR";
        $document->save();
        
        return redirect()->route('iheart.support_leader.list');        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insertDocument(Request $request)
    {   
        // dd(sizeof($request->expenditure));
        // print_r($request->expenditure);
        // print_r(array_values($request->expenditure));
        // $temp = array();
        // for ($i=0; $i < sizeof($request->expenditure); $i++) { 
        //     # code...

        // }

        // print_r(json_encode(array_values($request->expenditure)));
        // die();
        //
        // 1. 사용자 아이디 획득
        $user = Auth::user();
        // 2. Document 테이블 Insert
        $document = new Document;
        $document->user_id = $user->id;
        $document->team_id = $user->team_id;
        $document->document_name = $request->document_name;
        $document->document_type = $request->document_type;
        $document->document_comment = $request->document_comment;
        $document->save();

        // 2. expenditure_historys table insert - 지출내역 테이블      
        $history1 = new ExpenditureHistory;        
        $history1->item = $request->item1;
        $history1->content = $request->content1;
        $history1->price = $request->price1;
        $history1->order = 1;
        $document->expenditureHistorys()->save($history1); 
        
        $history2 = new ExpenditureHistory;        
        $history2->item = $request->item2;
        $history2->content = $request->content2;
        $history2->price = $request->price2;
        $history2->order = 2;
        $document->expenditureHistorys()->save($history2); 

        $history3 = new ExpenditureHistory;        
        $history3->item = $request->item3;
        $history3->content = $request->content3;
        $history3->price = $request->price3;
        $history3->order = 3;
        $document->expenditureHistorys()->save($history3);      

        // 첨부파일 추가
        
        if ($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                // dump($file);
                $originName = $file->getClientOriginalName();            
                // // store('save path');  save path = 지정하지 않을 시 storage 폴더 하위에 생성됨.
                // // 기본 upload 파일 저장
                $path = $file->store('public/upload');                
                $attach = new Attachment;
                $attach->path = $path;
                $attach->origin_name = $originName;
                $document->attachments()->save($attach);
            }
        }
        if ($user->hasRole('employee')) {
            return redirect()->route('iheart.employee.list');        
        } elseif($user->hasRole('team_leader')) {
            return redirect()->route('iheart.team_leader.list');        
        }        
    }
}
