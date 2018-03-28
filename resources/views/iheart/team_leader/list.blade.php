@extends('layouts.adminlte2')
@section('content')

<script type="text/javascript">

    $(document).ready(function() {
        $('#tree').treeview({
            data: getTree(), 
            showCheckbox : true,
        });
        
        $('#tree').on('nodeChecked', function(event, data) {
            // Your logic goes here
            alert('data : ' + data);
            $('#tree').treeview('removeNode', [ nodes, { silent: true } ]);
        });

        
    })

    function getTree() {
        var tree = [
                    {
                        text: "Parent 1",
                        nodes: [
                        {
                            text: "Child 1",
                            nodes: [
                            {
                                text: "Grandchild 1", 
                            },
                            {
                                text: "Grandchild 2"
                            }
                            ]
                        },
                        {
                            text: "Child 2"
                        }
                        ]
                    },
                    {
                        text: "Parent 2"
                    },
                    {
                        text: "Parent 3"
                    },
                    {
                        text: "Parent 4"
                    },
                    {
                        text: "Parent 5"
                    }
                    ];
        // Some logic to retrieve, or generate tree structure
        return tree;
    }
      
    
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        전자결재 
        <small>리스트-팀장</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">

    <div class="row col-lg-3">
        <div id="tree"></div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">                   
                <div class="box-body">
                    <div class="row">                            
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>작성자</th>
                                    <th>문서명</th>
                                    <th>문서분류</th>
                                    <th>등록일시</th>
                                    <th>팀장 승인</th>
                                    <th>지원팀장 승인</th>
                                    <th>최종승인</th>
                                    <th>반려내역</th>
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
                                        <td>{{ $document->user->name}}</td>
                                        <td><a href="{{ route('iheart.team_leader.detail', $document->id) }}">  {{ $document->document_name }} </a></td> 
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


  