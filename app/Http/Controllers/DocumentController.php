<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\Document;
use App\Comment;
use App\Attachment;
use App\ExpenditureHistory;

use DB;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource. * * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $documents = Document::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(5);
        // var_dump($documents);
        // die();
        // print_r($documents);
        // die();
        // dump($documents);
        
        return view('iheart.employee.list')->with(['documents' => $documents]);
    }

    private function switchInspectionStatus(String $inspecStatus) {
        switch ($inspecStatus) {
            case 'APR':
                return "승인";
                break;
            
            default:
                return "반려";
                break;
        }
        
    }
    
    public function supportLeaderIndex(Request $request) { 
        // 조건 검색 추가
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

        return view('iheart.support_leader.list')->with(['documents' => $documents]);        
    }

    public function teamLeaderIndex() {
        
        // 1. 접속 유저의 team_id 획득 $team_id = Auth::user()->team_id;        
        $team_id = Auth::user()->team_id;
        $documents = Document::where('team_id', $team_id)->orderBy('created_at', 'desc')->paginate(5);
        return view('iheart.team_leader.list')->with(['documents' => $documents]);        
    }

   

    public function teamLeaderDetail($document_id) {
        $document = Document::find($document_id);
        return view('iheart.team_leader.detail')->with('document', $document);
    }

    public function supportLeaderDetail($document_id) {

        $document = Document::find($document_id);
        return view('iheart.support_leader.detail')->with('document', $document);
    }

    // 팀장 반려처리
    public function teamLeaderReject(Request $request) {
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
    public function teamLeaderApr(Request $request) {
        $document_id = $request->document_id;
        $document = Document::find($document_id);
        $document->tl_inspection_status = "APR";
        $document->save();
        
        return redirect()->route('iheart.team_leader.list');        
    }

    // 경영지원 팀장 반려처리 
    public function supportLeaderReject(Request $request) {
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
    public function supportLeaderApr(Request $request) {
        $document_id = $request->document_id;
        $document = Document::find($document_id);
        $document->sl_inspection_status = "APR";
        $document->save();
        
        return redirect()->route('iheart.support_leader.list');        
    }


    public function detail($document_id) {
        
        $document = Document::find($document_id);       
        
        
        // dump($document);
        return view('iheart.employee.detail')->with(['document' => $document]);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
