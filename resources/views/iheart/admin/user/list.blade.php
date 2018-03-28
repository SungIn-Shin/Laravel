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
                        <table class="table">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>직급</th>
                                        <th>직책</th>
                                        <th>이름</th>
                                        <th>이메일</th>
                                        <th>등록일시</th>
                                        <th>수정일시</th>
                                        <th>사용여부</th>
                                    </tr>       
                                </tr>                                    
                            </thead>
                            <tbody>
                                    <tr>
                                        
                                    </tr>
                            </tbody>
                        </table>
                    </div> <!-- /.row -->                
                    {{--  <div class="text-center">{{ $documents->links() }}</div>                          --}}
                </div>
            </div>          
        </div>                    
    </div>
</section>
<!-- /.content -->
</div>
@endsection


  