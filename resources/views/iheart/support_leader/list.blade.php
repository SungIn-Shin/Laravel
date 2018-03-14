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
                    <div class="box-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="document_name">반려내역</label>
                            <input type="text" id="document_name" name="document_name" class="form-group">
                            <label for="document_type">문서분류</label>
                            <input type="text" id="document_type" name="document_type" class="form-group">
                            <button type="submit" class="btn btn-default pull-right" id="aprBtn">검색</button> 
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
                                    <th>문서명</th>
                                    <th>문서분류</th>
                                    <th>등록일시</th>
                                    <th>팀장 승인</th>
                                    <th>지원팀장 승인</th>
                                    <th>최종승인</th>
                                </tr>                                    
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                @if( $document->tl_inspection_status == "REJ")
                                    <tr>
                                        <td><a href="{{ route('iheart.support_leader.detail', $document->id) }}">  {{ $document->document_name }} </a></td> 
                                        <td>{{ $document->document_type }}</td>
                                        <td>{{ $document->created_at }}</td>
                                        <td>
                                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
                                                {{ $document->tl_inspection_status}}
                                            </a>
                                        </td>
                                        <td>
                                            @isset($document->sl_inspection_status)
                                            {{$document->sl_inspection_status}}
                                            @endisset
                                            @empty($document->sl_inspection_status)
                                            미승인
                                            @endempty                                                
                                        </td>
                                        <td>
                                            @isset($document->sl_inspection_status)
                                            {{$document->sl_inspection_status}}
                                            @endisset
                                            @empty($document->sl_inspection_status)
                                            미승인
                                            @endempty
                                        </td>
                                    </tr>
                                    @foreach($document->comments as $comment)
                                    <tr class="collapse" id="collapseExample">
                                        <td colspan="6">
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
                                @else
                                    <tr>
                                        <td><a href="{{ route('iheart.support_leader.detail', $document->id) }}">  {{ $document->document_name }} </a></td> 
                                        <td>{{ $document->document_type }}</td>
                                        <td>{{ $document->created_at }}</td>
                                        <td>
                                            @isset($document->tl_inspection_status)
                                            {{$document->tl_inspection_status}}
                                            @endisset
                                            @empty($document->tl_inspection_status)
                                            미승인
                                            @endempty
                                        </td>
                                        <td>
                                            @isset($document->sl_inspection_status)
                                            {{$document->sl_inspection_status}}
                                            @endisset
                                            @empty($document->sl_inspection_status)
                                            미승인
                                            @endempty                                                
                                        </td>
                                        <td>
                                            @isset($document->status)
                                            {{$document->status}}
                                            @endisset
                                            @empty($document->status)
                                            미승인
                                            @endempty
                                        </td>
                                    </tr>
                                @endif
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


  