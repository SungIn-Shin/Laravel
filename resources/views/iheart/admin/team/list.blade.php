@extends('layouts.adminlte2')
@section('content')

<script type="text/javascript">
    $( document ).ready(function() {
{{-- 
        if (typeof jQuery != 'undefined') {  
            // jQuery is loaded => print the version
            alert(jQuery.fn.jquery);
        } --}}
        // ajax setup 
        // 홀수번째 버튼에 클릭시 moveUp 함수 호출 하기 (올리기 버튼에 클릭이벤트 생성)
        $('#teamTable button:even').bind('click', function(){ moveUp(this) });

        // 짝수번째 버튼에 클릭시 moveUp 함수 호출 하기 (내리기 버튼에 클릭이벤트 생성)
        $('#teamTable button:odd').bind('click', function(){ moveDown(this) });

        $('#saveBtn').on('click', function(){ 

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var tr = $('#teamTable tbody tr');
            
            var jsonArray = new Array();
            
            //  tr.id = Teams Table의 Team ID (고유키)
            //  tr.eq(idx).index() + 1(기본값 1부터 시작하기위해 +1 시킴.) = 정렬 순서. 웹에서 보여지는 tr의 순서대로 
            tr.each(function(index, Element) {
                var teamInfo = new Object();
                teamInfo.teamId = tr.eq(index).attr('id');
                teamInfo.sortKey = (tr.eq(index).index() + 1);
                jsonArray.push(teamInfo);
            });

            $.post("/iheart/admin/teams/update/sort", JSON.stringify(jsonArray))
            .done(function(msg){
                var res = $.parseJSON(msg);
                var code = res.CODE;
                if(code === 200) {
                    alert('팀 정렬 수정 성공');
                    location.reload();
                } else {
                    var error = res.ERROR;
                    alert('팀 정렬 수정 실패');
                }
            })
            .fail(function(xhr, textStatus, errorThrown) {
                alert("XHR : "+xhr.responseText + "\r\n TEXTSTATUS : " + textStatus + "\r\n errorThrown : " + errorThrown);
            });
        });
    });

    function moveUp(el){
        var $tr = $(el).closest('tr'); // 클릭한 버튼이 속한 tr 요소
        // alert($tr.index()); // 해당 tr index 가져오기. 0부터 시작. 이걸로 순서 지정.
        $tr.prev().before($tr); // 선택한 tr 의 이전 tr 앞에 선택한 tr 넣기
    }

    function moveDown(el){
        var $tr = $(el).closest('tr'); // 클릭한 버튼이 속한 tr 요소
        $tr.next().after($tr); // 선택한 tr 의 다음 tr 뒤에 선택한 tr 넣기
    }



</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        사용자 관리
        <small>사용자 리스트 - 관리자</small>
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
        <div class="col-lg-6 col-md-12">
            <div class="box box-primary">                   
                <div class="box-body">
                        <div class="row">                            
                            <table class="table" id="teamTable">
                                <thead>
                                    <tr>
                                        <tr>
                                            <th>순서</th>
                                            <th>팀명</th>
                                            <th>생성일자</th>
                                            <th>순서변경</th>
                                        </tr>       
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    @foreach ($teams as $team)
                                        <tr id="{{$team->id}}">
                                            <td>{{ $team->sortkey}}</td>
                                            <td>{{ $team->name }}</td>
                                            <td>{{ $team->created_at }}</td>
                                            {{--  <td>{{ $team->sortkey}}</td>  --}}
                                            <td>
                                                <button type="button" class="btn btn-success">올리기</button>
                                                <button type="button" class="btn btn-danger">내리기</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div> <!-- /.row --> 
                        
                        <div class="text-center">
                            <input class="btn btn-default" type="button" id="saveBtn" value="변경내용 저장">
                        </div>       
                </div>
            </div>          
        </div>                    
    </div>
</section>
<!-- /.content -->
</div>
@endsection


  