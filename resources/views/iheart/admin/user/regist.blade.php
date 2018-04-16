@extends('layouts.adminlte2')


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        사용자 관리 
        <small>사용자 등록 - 관리자</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<form action="{{route('iheart.admin.users.regist')}}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    {{--  <div class="box-header with-border">
                        <h3 class="box-title">전자결재 - 지출품의서</h3>
                    </div>  --}}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">이메일 주소</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="이메일을 입력하세요" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">이름</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="이름을 입력하세요" value="{{ old('name') }}" required>

                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="name">패스워드</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="패스워드를 입력하세요." value="{{ old('password') }}" required>
                                    <br/>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="패스워드를 다시 입력하세요." required>

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('team') ? ' has-error' : '' }}">
                                    <label for="team">소속 팀</label>
                                    <select id="team" name="team" class="form-control">
                                        <option value="">팀 선택</option>
                                        @foreach ($teams as $team)
                                            <option value="{{$team->id}}"  {{ old('team') == $team->id ? 'selected' : '' }}>
                                                {{$team->name}}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('team'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('team') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('rank') ? ' has-error' : '' }}">
                                    <label for="rank">직급</label>
                                    <select id="rank" name="rank" class="form-control">
                                        <option value="">직급 선택</option>
                                        @foreach ($ranks as $rank)
                                            <option value="{{$rank->id}}" {{ old('rank') == $rank->id ? 'selected' : '' }}>
                                                {{$rank->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('rank'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rank') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="position">직책</label>
                                    <select id="position" name="position" class="form-control">
                                        <option value="">직책 선택</option>
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}" {{ old('position') == $position->id ? 'selected' : '' }}>
                                                {{$position->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                    <label for="role">권한</label>
                                    <select id="role" name="role" class="form-control">
                                        <option value="">권한 선택</option>
                                        @foreach ($roles as $role)
                                            <option value="{{$role->id}}" {{  old('role') == $role->id ? 'selected' : '' }}>
                                                {{$role->description}}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <!-- otp key (2018.04.09) -->
                                <div class="form-group{{ $errors->has('otpkey') ? ' has-error' : '' }}">
                                    <label for="name">OTP KEY</label>
                                    <input type="text" class="form-control" id="otpkey" name="otpkey" value="{{ old('otpkey') }}" onclick="javascript:alert('OTP생성버튼을 클릭하세요.');">
                                    <input type="button" value="OTP생성" onclick="javascript:genOtpSecretString();">
                                    <input type="button" value="클립보드복사" onclick="javascript:copyOtpSecretString();">
                                    <br>현재 표시된 OTP 코드로 QR이미지 보기<input type="checkbox" name="chkOtpQr" id="chkOtpQr" onclick="javascript:dispOtpQr();">
                                    <br>
                                    <img id="qrImg" src="" />

                                    @if ($errors->has('otpkey'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('otpkey') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <!-- otp key -->

                                <div class="form-group">
                                    <button type="submit" class="btn btn-default pull-right">제출</button> 
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


  