@extends('layouts.adminlte2')
@section('content')

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
        <div class="col-lg-12">
            <div class="box box-primary">                   
                <div class="box-body">
                    <div class="row">                            
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>소속</th>
                                        <th>이름</th>
                                        <th>직급</th>
                                        <th>직책</th>
                                        <th>이메일</th>
                                        <th>등록일시</th>
                                        <th>최근로그인일자</th>
                                        <th>최근7일로그인수</th>
                                        <th>사용여부</th>
                                    </tr>       
                                </tr>                                    
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr id="tr{{$user->id}}" style="cursor:pointer;" onclick="location.href='{{url('/iheart/admin/users/detail', $user->id)}}'"
                                    @if ($user->useyn == 'N')
                                        class="danger"
                                    @endif
                                    >
                                    <td>{{ $user->team->name }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->rank_name}}</td>
                                    <td>{{ $user->position_name}}</td>
                                    <td>{{ $user->email}}</td>
                                    <td>{{ $user->created_at}}</td>
                                    <td>
                                        {{ $user->lastdate}}
                                        @if (!empty($user->counter30) && $user->counter30 == 0)
                                        <br><span class="text-danger">(최근30일이내로그인없음)</span>
                                        @endif
                                    </td>
                                    @if (empty($user->counter7))
                                        <td>0</td>
                                    @else
                                        <td>{{ $user->counter7 }}</td>
                                    @endif
                                    {{-- @if (empty($user->deleted_at))
                                        <td>사용중</td>
                                    @else
                                        <td>미사용</td>
                                    @endif --}}
                                    @if ($user->useyn == 'N')
                                        <td><span class='text-danger'>미사용</span></td>
                                    @else
                                        <td><span class='text-success'>사용중</span></td>
                                    @endif
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- /.row -->                
                    <div class="text-center">{{ $users->links() }}</div>                        
                </div>
            </div>          
        </div>                    
    </div>
</section>
<!-- /.content -->
</div>
@endsection


  