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
        <small>REQUEST로그</small>
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
                <form action="{{route('iheart.admin.log.requestList')}}" action="GET">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            
                            <div class="col-lg-4">
                                <input id="created_at_start" name="created_at_start" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="{{ request()->created_at_start }}">~
                                <input id="created_at_end" name="created_at_end" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="{{ request()->created_at_end }}">
                            </div>
                            <div class="col-lg-5">
                                <label for="user_name">검색조건</label>
                                <select id="condition" name="condition" class="form-control">
                                    <option value="useremail">계정</option>
                                    <option value="ip">IP</option>
                                    <option value="url">URL</option>
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <tr>
                                        <th class="col-lg-1">번호</th>
                                        <th class="col-lg-1">계정</th>
                                        <th class="col-lg-1">IP</th>
                                        <th class="col-lg-5">URL</th>
                                        <th class="col-lg-1">METHOD</th>
                                        <th class="col-lg-2">AGENT</th>
                                        <th class="col-lg-1">날짜</th>
                                    </tr>       
                                </tr>                                    
                            </thead>
                            <tbody>
                                @foreach ($log_requests as $log_request)
                                <tr>
                                    <td>{{ $log_request->id }}</td>
                                    <td>{{ $log_request->useremail }}</td>
                                    <td>{{ $log_request->ip }}</td>
                                    <td style="table-layout:fixed; word-break:break-all;">{{ $log_request->url }}</td>
                                    <td>{{ $log_request->method }}</td>
                                    <td style="table-layout:fixed; word-break:break-all;">{{ $log_request->agent }}</td>
                                    <td>{{ $log_request->created_at}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- /.row -->                
                    <div class="text-center">{{ $log_requests->appends(request()->query())->links() }}</div>                        
                </div>
            </div>          
        </div>                   
    </div>
</section>
<!-- /.content -->
</div>
@endsection


  