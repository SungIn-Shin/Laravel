@extends('layouts.adminlte2')

<link rel="stylesheet" href="{{ asset('css/jquery-plugin/eazyzoom/css/example.css') }}" />
<link rel="stylesheet" href="{{ asset('css/jquery-plugin/eazyzoom/css/pygments.css') }}" />
<link rel="stylesheet" href="{{ asset('css/jquery-plugin/eazyzoom/css/easyzoom.css') }}" />

<!-- Google Analytics tracking code -->
<script>
    var _gaq=[['_setAccount','UA-2508361-9'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{ asset('css/jquery-plugin/eazyzoom/dist/easyzoom.js') }}"></script>
<script>
    // Instantiate EasyZoom instances
    var $easyzoom = $('.easyzoom').easyZoom();

    // Setup thumbnails example
    var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

    $('.thumbnails').on('click', 'a', function(e) {
        var $this = $(this);

        e.preventDefault();

        // Use EasyZoom's `swap` method
        api1.swap($this.data('standard'), $this.attr('href'));
    });

    {{--  // Setup toggles example
    var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

    $('.toggle').on('click', function() {
        var $this = $(this);
        if ($this.data("active") === true) {
            $this.text("Switch on").data("active", false);
            api2.teardown();
        } else {
            $this.text("Switch off").data("active", true);
            api2._init();
        }
    });  --}}
</script>

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        전자결재 
        <small>지출품의서(상세보기)-경영지원팀장</small>
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
                <div class="box-body">
                    <!-- 문서번호, 문서분류, 문서명, 문서설명 row -->
                    <div class="row">                            
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="document_type">문서분류</label>
                            <select class="form-control" name="document_type" id="document_type" >                
                            <option value="지출품의서">지출품의서</option>
                            </select>            
                        </div>          
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="document_name">문서명</label>
                            <input type="text" class="form-control" name="document_name" id="document_name" placeholder="문서명" value="{{ $document->document_name }}">
                        </div>
                        <div class="form-group col-lg-4 col-md-6">
                            <label for="document_comment">문서설명</label>
                            <input type="text" class="form-control" name="document_comment" id="document_comment" placeholder="문서 설명" value="{{ $document->document_comment }}">
                        </div>
                    </div> <!-- /.row -->              
                    <!-- 지출내역, 증빙서류첨부 row -->
                    <div class="row">
                        <!-- 지출내역 -->
                        <div class="form-group col-lg-6 col-md-12">        
                            <label for="exTable">지출내역</label>
                            <table id="exTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th>항목</th>
                                <th>내용</th>
                                <th>금액</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($document->expenditureHistorys as $expens)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="item1" name="item1" placeholder="항목1" value="{{ $expens->item }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="content1" name="content1" placeholder="내용1" value="{{ $expens->content }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="price1" name="price1" placeholder="금액1" value="{{ $expens->price }}">
                                    </td>
                                </tr>
                                @endforeach                                   
                            </tbody>
                            </table>
                            <label for="" class="pull-right">합계 : {{$document->expenditureHistorys[0]->price + $document->expenditureHistorys[1]->price + $document->expenditureHistorys[2]->price}} 원</label>
                        </div>
                        <!-- 증빙서류 -->
                        <div class="form-group col-lg-6 col-md-12">
                            <label for="exTable">증빙서류</label>
                            {{--  <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#imgReviewModal" >첨부서류 상세보기</button>  --}}
                            @if($document->attachments->count() > 0)
                            <ul class="list-group">
                                @foreach($document->attachments as $attachment)                                
                                <li class="list-group-item" data-toggle="modal" data-target="#imgReviewModal">
                                    {{$attachment->origin_name}}
                                </li>                                                                            
                                @endforeach
                            </ul>
                            @else
                            <ul class="list-group">
                                <li class="list-group-item">증빙서류 없음</li>                                        
                            </ul>
                            @endif

                            @if($document->sl_inspection_status === "APR")
                            승인됨
                            @elseif($document->sl_inspection_status === "REJ")                            
                                @foreach($document->comments as $comment)
                                <tr class="collapse" id="collapseExample">
                                    <label for="rej_data">반려내역</label>
                                    <table class="table" id="rej_data">
                                        <thead class="bg-danger">
                                            <tr>
                                                <th>작성자</th>
                                                <th>제목</th>
                                                <th>내용</th>
                                                <th>작성자</th>
                                                <th>작성일시</th>                                    
                                            </tr>  
                                        </thead>
                                        <tbody class="bg-warning">
                                            <tr>
                                                <td>{{$comment->writer}}</td>
                                                <td>{{$comment->title}}</td>
                                                <td>{{$comment->content}}</td>
                                                <td>{{$comment->writer}}</td>
                                                <td>{{$comment->created_at}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </tr>
                                @endforeach
                            @else
                            <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#rejFormModal" >반려</button>
                            <form action="{{ route('iheart.support_leader.apr') }}" method="post" id="aprForm">  
                                {{ csrf_field() }}
                                <input type="hidden" name="document_id" value="{{$document->id}}">
                                <button type="submit" class="btn btn-default pull-right" id="aprBtn">승인</button>  
                            </form>
                            @endif
                            
                        </div>
                    </div>
                    <div class="row">
                        @if($document->attachments->count() > 0)
                        @foreach($document->attachments as $attachment)                                    
                        <div class="col-xs-6 col-md-3">
                            <label for="{{ $attachment->origin_name }}">{{ $attachment->origin_name }}</label>
                            <a id="{{$attachment->origin_name}}" href="{{ Storage::url($attachment->path) }}" class="thumbnail" style="cursor:pointer" onclick="javascript:window.open(this.href);">
                                <input class="img-thumbnail" type="image" src="{{ Storage::url($attachment->path) }}">
                            </a>
                        </div>
                        @endforeach
                        @else 
                        <div class="col-xs-6 col-md-3">
                            <a href="" class="thumbnail">
                                <input class="img-thumbnail" type="image" src="">
                            </a>
                        </div>
                        @endif
                    </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejFormModal" tabindex="-1" role="dialog" aria-labelledby="rejModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="rejModalLabel">전자결재 반려</h4>
            </div>
            <form action="{{ route('iheart.support_leader.reject') }}" method="post" id="rejectForm">  
                {{ csrf_field() }}
                <input type="hidden" name="document_id" value="{{$document->id}}">
                <div class="modal-body">      
                    <div class="row">
                        <label for="title">제목</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="제목을 입력하세요." >
                    </div>
                    <div class="row">
                    <label for="exTable">반려사유</label>
                    <textarea id="content" name="content" class="form-control" rows="3" placeholder="반려사유를 작성하세요."></textarea>
                    </div>
                </div>
                <div class="modal-footer">                
                    <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>                
                    <button type="button" class="btn btn-primary" id="rejBtn">반려</button> {{-- 반려 -> submit button  --}}       
                </div>
            </form>
            </div>
        </div>
    </div>


</section>
<!-- /.content -->
</div>
<script type="text/javascript">
    $("#aprBtn").click(function () {
        if(confirm("팀장 승인을 진행하시겠습니까?")) {
            alert('승인!');            
            $("#aprForm").submit();
        } else {
            alert('취소!');
        }        
    });

    $("#rejBtn").click(function () {
        if(confirm("최종 반려 등록을 진행하시겠습니까?")) {                        
            $("#rejectForm").submit();
        } else {
            alert('취소!');
        }
    });
</script>
@endsection


  