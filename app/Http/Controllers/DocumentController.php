<?php

namespace App\Http\Controllers;

use App\Document;
use App\Attachment;
use App\ExpenditureHistory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::paginate(2);        
        // dump($documents);
        return view('iheart.list')->with(['documents' => $documents]);
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
        $user_id = Auth::id();
        // 2. Document 테이블 Insert
        $document = new Document;
        $document->user_id = $user_id;
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
        foreach($request->file('files') as $file) {
            // dump($file);
            $originName = $file->getClientOriginalName();            
            $path = $file->store('files');            
            // dump($originName);
            // dump($path);
            $attach = new Attachment;
            $attach->path = $path;
            $attach->origin_name = $originName;
            $document->attachments()->save($attach);
        }

        return view('iheart.list');
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
