@extends('layouts.adminlte2')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        전자결재 
        <small>리스트-경영지원팀장</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">  
                <form action="{{ route('iheart.support_leader.list') }}" action="GET">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            
                            <div class="col-lg-3">
                                <select id="year" name="year" class="form-control">
                                    <option value="2018">연도 선택</option>
                                    <option value="2018">2018년</option>
                                    <option value="2017">2017년</option>
                                    <option value="2016">2016년</option>
                                    <option value="2015">2015년</option>
                                    <option value="2014">2014년</option>
                                    <option value="2013">2013년</option>
                                    <option value="2012">2012년</option>
                                    <option value="2011">2011년</option>
                                    <option value="2010">2010년</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <select id="month" name="month" class="form-control">
                                    <option value="">월 선택</option>
                                    <option value="1">1월</option>
                                    <option value="2">2월</option>
                                    <option value="3">3월</option>
                                    <option value="4">4월</option>
                                    <option value="5">5월</option>
                                    <option value="6">6월</option>
                                    <option value="7">7월</option>
                                    <option value="8">8월</option>
                                    <option value="9">9월</option>
                                    <option value="10">10월</option>
                                    <option value="11">11월</option>
                                    <option value="12">12월</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <select id="team_id" name="team_id" class="form-control">
                                    <option value="">팀선택</option>
                                    <option value="2">경영지원팀</option>
                                    <option value="3">영업팀</option>
                                    <option value="4">개발팀</option>
                                    <option value="5">IDC운영팀</option>
                                    <option value="6">기술운영팀</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label for="user_name">작성자</label>
                                <input type="text" id="user_name" name="user_name" class="form-group">
                                <button type="submit" class="btn btn-default pull-right" id="aprBtn">검색</button> 
                            </div>
                        </div>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">                   
                <div class="box-body">
                    <div class="row">               
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>팀</th>
                                    <th>작성자</th>
                                    <th>문서명</th>
                                    <th>문서분류</th>
                                    <th>등록일시</th>
                                    <th>팀장 승인</th>
                                    <th>지원팀장 승인</th>
                                    <th>최종승인</th>
                                    <th>반려사유</th>
                                </tr>                                    
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                @if($document->tl_inspection_status == "APR" && ($document->sl_inspection_status == "APR" || $document->sl_inspection_status == null))
                                <tr class="success">
                                @elseif($document->tl_inspection_status == "REJ" || $document->sl_inspection_status == "REJ")
                                <tr class="danger">
                                @else  
                                <tr class="warning">
                                @endif
                                    <td>{{$document->team->name}}</td>
                                    <td>{{$document->user->name}}</td>
                                    <td><a href="{{ route('iheart.support_leader.detail', $document->id) }}">  {{ $document->document_name }} </a></td> 
                                    <td>{{ $document->document_type }}</td>
                                    <td>{{ $document->created_at }}</td>
                                    <td>
                                        {{ $document->changeInspectionStatus($document->tl_inspection_status)}}
                                    </td>
                                    <td>
                                        {{$document->changeInspectionStatus($document->sl_inspection_status)}}
                                    </td>
                                    <td>
                                        {{$document->changeStatus($document->status)}}
                                    </td>
                                    <td>
                                        @if($document->tl_inspection_status == "REJ" || $document->sl_inspection_status == "REJ" )
                                            <a data-toggle="collapse" href="#{{$document->id}}" aria-expanded="true" aria-controls="{{$document->id}}">
                                                보기
                                            </a>
                                        @else
                                            내역없음
                                        @endif
                                    </td>
                                </tr>
                                @foreach($document->comments as $comment)
                                <tr class="collapse" id="{{$document->id}}">
                                    <td colspan="7">
                                        <label for="rej_data">반려내역</label>
                                        <table class="table" id="rej_data">
                                            <thead class="bg-danger">
                                                <tr>
                                                    <th>작성자</th>
                                                    <th>제목</th>
                                                    <th>내용</th>
                                                    <th>작성일시</th>                                    
                                                </tr>  
                                            </thead>
                                            <tbody class="bg-warning">
                                                <tr>
                                                    <td>{{$comment->writer}}</td>
                                                    <td>{{$comment->title}}</td>
                                                    <td>{{$comment->content}}</td>
                                                    <td>{{$comment->created_at}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @endforeach

                                @endforeach         
                            </tbody>
                        </table>
                    </div> <!-- /.row -->                
                    <div class="text-center">{{ $documents->links() }}</div>                        
                </div>
            </div>          
        </div>                    
    </div>
</section>
<!-- /.content -->
</div>
@endsection


  