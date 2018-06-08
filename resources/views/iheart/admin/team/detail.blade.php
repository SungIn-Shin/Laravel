@extends('layouts.adminlte2')


@section('content')


<script type="text/javascript">

</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        팀 관리 
        <small>팀 정보 상세 - 관리자</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<form action="{{ route('iheart.admin.teams.update') }}" method="post" id="updateForm">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$team->id}}">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    {{--  <div class="box-header with-border">
                        <h3 class="box-title">전자결재 - 지출품의서</h3>
                    </div>  --}}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        사용자 정보 수정을 성공했습니다.
                                    </div>
                                    <a href="/">Return to homepage</a>
                                {{-- @elseif (session('current_password'))
                                    <div class="alert alert-danger">
                                        {{session('current_password')}}
                                    </div> --}}
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">팀 이름</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="이메일을 입력하세요" value="{{ $team->name }}">

                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                    <label for="location">지역</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="이름을 입력하세요" value="{{ $team->location }}" required>

                                    @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-default pull-right">수정</button> 
                                    {{--  <button id="ajaxBtn" class="btn btn-default pull-right">ajax수정</button>   --}}
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>          
            </div>                    
        </div>
    </form>

</section>
<!-- /.content -->
</div>
@endsection


  