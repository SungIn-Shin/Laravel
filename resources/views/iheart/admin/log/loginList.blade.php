@extends('layouts.adminlte2')
@section('content')

<script type="text/javascript">
    $( document ).ready(function() {
        var condition = "{{ request()->condition }}";
        var successyn = "{{ request()->successyn }}";
        for (var l_i=0; l_i<document.getElementById("condition").options.length; l_i++) {
            if (document.getElementById("condition")[l_i].value == condition) {
                document.getElementById("condition")[l_i].selected = true;
                break;
            }
        }
        for (var l_i=0; l_i<document.getElementById("successyn").options.length; l_i++) {
            if (document.getElementById("successyn")[l_i].value == successyn) {
                document.getElementById("successyn")[l_i].selected = true;
                break;
            }
        }
    });
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        로그
        <small>로그인로그</small>
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
                <form action="{{route('iheart.admin.log.loginList')}}" action="GET">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            
                            <div class="col-lg-4">
                                <input id="created_at_start" name="created_at_start" type="date" value="{{ request()->created_at_start }}">~
                                <input id="created_at_end" name="created_at_end" type="date" value="{{ request()->created_at_end }}">
                            </div>
                            <div class="col-lg-3">
                                <label for="user_name">성공실패</label>
                                <select id="successyn" name="successyn" class="form-control">
                                    <option value="">전체</option>
                                    <option value="Y">성공</option>
                                    <option value="N">실패</option>
                                </select>
                            </div>
                            <div class="col-lg-5">
                                <label for="user_name">검색조건</label>
                                <select id="condition" name="condition" class="form-control">
                                    <option value="useremail">계정</option>
                                    <option value="ip">IP</option>
                                </select>
                                <input type="text" id="search" name="search" class="form-group" value="{{ request()->search }}">
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
                                    <tr>
                                        <th>계정</th>
                                        <th>IP</th>
                                        <th>구분</th>
                                        <th>성공실패</th>
                                        <th>날짜</th>
                                    </tr>       
                                </tr>                                    
                            </thead>
                            <tbody>
                                @foreach ($loginhistories as $loginhistory)
                                <tr>
                                    <td>{{ $loginhistory->useremail }}</td>
                                    <td>{{ $loginhistory->ip }}</td>
                                    @if ($loginhistory->gubun == "U")
                                        <td>사원</td>
                                    @else
                                        <td>Unknown</td>
                                    @endif
                                    @if ($loginhistory->successyn == "Y")
                                        <td>성공</td>
                                    @else
                                        <td>실패</td>
                                    @endif
                                    <td>{{ $loginhistory->created_at}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- /.row -->                
                    <div class="text-center">{{ $loginhistories->appends(request()->query())->links() }}</div>                        
                </div>
            </div>          
        </div>                   
    </div>
</section>
<!-- /.content -->
</div>
@endsection


  