<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\Document;
use App\Comment;
use App\Attachment;
use App\ExpenditureHistory;
use App\ApprovalLine;
use App\ExpenditureItem;

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
        // 결재라인
        $document_name = date('Ym') . '_' . $user->name . '_지출품의서';
        // 지출 항목 List
        $items = ExpenditureItem::all(); 

        if($user->hasRole('employee')) {
            return view('iheart.employee.regist')->with(['document_name' => $document_name, 'items' => $items]);
        } else if ($user->hasRole('team_leader')) {
            return view('iheart.team_leader.regist')->with(['document_name' => $document_name, 'items' => $items]);
        } else if ($user->hasRole('support_leader')) {
            return view('iheart.support_leader.document.regist')->with(['document_name' => $document_name, 'items' => $items]);
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
        $user_id = Auth::user()->id;
        $documents = new Document;
        $documents = Document::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(5);
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

    // 경영지원팀장 지출품의 리스트 조회
    public function selectSupportLeaderDocumentsList(Request $request) 
    { 
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
        
        return view('iheart.support_leader.document.list')->with(['documents' => $documents]);        
    }


    public function selectTeamLeaderDocumentsList(Request $request) 
    {
        $team_id = Auth::user()->team_id;
        $documents = new Document;
        $documents = Document::where('team_id', $team_id)->orderBy('created_at', 'desc')->paginate(5);
        
        return view('iheart.team_leader.list')->with(['documents' => $documents]);        
    }

    public function documentDetail($document_id) 
    {
        // 세션 유저 정보 획득
        $user = Auth::user();
        // 모델에서 데이터 획득
        $document = new Document;

        $document = Document::find($document_id);

        $expenditure_historys = json_decode($document->expenditure_historys, true);
        // dd($expenditure_historys);
        // 권한별 페이지 변경
        if($user->hasRole('employee')) {
            return view('iheart.employee.detail')->with(['document' => $document, 'expenditure_historys' => $expenditure_historys]);
        } else if ($user->hasRole('team_leader')) {
            return view('iheart.team_leader.detail')->with(['document' => $document, 'expenditure_historys' => $expenditure_historys]);
        } else if ($user->hasRole('support_leader')) {
            return view('iheart.support_leader.document.detail')->with(['document' => $document, 'expenditure_historys' => $expenditure_historys]);
        } else if ($user->hasRole('admin')) {
            return view('iheart.admin.detail')->with(['document' => $document, 'expenditure_historys' => $expenditure_historys]);
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

        return redirect()->route('iheart.support_leader.documents.list');        
    }
    // 경영지원 팀장 승인처리 
    public function supportLeaderApr(Request $request) 
    {
        $document_id = $request->document_id;
        $document = Document::find($document_id);
        $document->sl_inspection_status = "APR";
        $document->save();
        
        return redirect()->route('iheart.support_leader.documents.list');        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insertDocument(Request $request)
    {   
        // 1. 사용자 계정 획득
        $user = Auth::user();
        // 2. Document 테이블 Insert
        $document = new Document;
        $document->user_id = $user->id;
        $document->team_id = $user->team_id;
        $document->document_name = $request->document_name;
        $document->document_type = $request->document_type;
        $document->document_comment = $request->document_comment;
        $expenditureArr = array();
        // 기존 -> [{"item":"811","content":null,"price":"1234"}]
        // 변경 후 -> [{"item":"811","item_name":"복리후생비","content":null,"price":"1234"}]
        foreach($request->expenditure as $expenditure) {
            if(!empty($expenditure['item'])) {
                $dataArr = array();
                $exItem = ExpenditureItem::where('code', $expenditure['item'])->first();;
                $dataArr['item'] = $expenditure['item'];
                $dataArr['item_name'] = $exItem->name;
                $dataArr['content'] = $expenditure['content'];
                $dataArr['price'] = $expenditure['price'];
                array_push($expenditureArr, $dataArr);
            }
        }
        $document->expenditure_historys = json_encode($expenditureArr);
        // print_r($document->expenditure_historys);
        // die();
        $document->save();

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

    public function accountingList(Request $request) 
    {
        // dd(date('m'));
        $query = Document::query();

        if($request->has('year')) {
            $year = $request->year;
            $query->whereYear('created_at', $year);
        } else {
            $year = intval(date('Y'));
            $query->whereYear('created_at', $year);
            $request->year = $year;
        }

        if($request->has('month')) {
            $month = $request->month;
            $query->whereMonth('created_at', $month);
        } else {
            $month = intval(date('m'));
            $query->whereMonth('created_at', $month);
            $request->month = $month;
        }

        $documents = $query->orderBy('created_at', 'desc')->get();
        
        return view('iheart.support_leader.document.accountinglist')->with(['documents' => $documents, 'request' => $request]);
    }
}
