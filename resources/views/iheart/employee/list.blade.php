@extends('layouts.adminlte2')
@section('content')

<script type="text/javascript">
    // $(document).ready(function() {
    //     //
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
        
    //     $.get("/iheart/organizationchart/show")
    //     .done(function(response){
    //         // alert(response);
    //         $('#tree').treeview({
    //             data: response, 
    //             showCheckbox : true,
    //         });
    //     })
    //     .fail(function(xhr, textStatus, errorThrown) {
    //         alert("XHR : "+xhr.responseText + "\r\n TEXTSTATUS : " + textStatus + "\r\n errorThrown : " + errorThrown);
    //     });

        
    //     $('#tree').on('nodeChecked', function(event, data) {
    //         // Your logic goes here
    //         alert('data : ' + data);
    //         $('#tree').treeview('removeNode', [ nodes, { silent: true } ]);
    //     }); 
    // });

</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        전자결재 
        <small>리스트-일반사용자</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">

    {{-- <div class="row col-lg-3">
        <div id="tree"></div>
    </div> --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">                   
                <div class="box-body">
                    <div class="row">                            
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">문서명</th>
                                    <th class="text-center">문서분류</th>
                                    <th class="text-center">등록일시</th>
                                    <th class="text-center">팀장 승인</th>
                                    <th class="text-center">지원팀장 승인</th>
                                    <th class="text-center">반려내역</th>
                                </tr>                                    
                            </thead>
                            <tbody>
                                    @foreach($documents as $document)
                                    @if($document->tl_inspection_status == "APR" && ($document->sl_inspection_status == "APR" || $document->sl_inspection_status == null))
                                    <tr class="success">
                                    @elseif($document->tl_inspection_status == "REJ" || $document->sl_inspection_status == "REJ")
                                    <tr class="danger">
                                    @else  
                                    <tr>
                                    @endif
                                        <td class="text-center"><a href="{{ route('iheart.employee.detail', $document->id) }}">  {{ $document->document_name }} </a></td> 
                                        <td class="text-center">{{ $document->document_type }}</td>
                                        <td class="text-center">{{ $document->created_at }}</td>
                                        <td class="text-center">
                                        
                                            {{ $document->changeInspectionStatus($document->tl_inspection_status)}}
                                        </td>
                                        <td class="text-center">
                                            {{$document->changeInspectionStatus($document->sl_inspection_status)}}
                                        </td>
                                        <td class="text-center">
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
                                                        <th class="text-center">작성자</th>
                                                        <th class="text-center">제목</th>
                                                        <th class="text-center">내용</th>
                                                        <th class="text-center">작성일시</th>                                    
                                                    </tr>  
                                                </thead>
                                                <tbody class="bg-warning">
                                                    <tr>
                                                        <td class="text-center">{{$comment->writer}}</td>
                                                        <td class="text-center">{{$comment->title}}</td>
                                                        <td class="text-center">{{$comment->content}}</td>
                                                        <td class="text-center">{{$comment->created_at}}</td>
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


  