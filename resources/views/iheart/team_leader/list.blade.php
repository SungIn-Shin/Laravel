@extends('layouts.adminlte2')
@section('content')
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
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">                   
                <div class="box-body">
                    <div class="row">                            
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>문서명</th>
                                    <th>문서분류</th>
                                    <th>등록일시</th>
                                    <th>상태</th>                                    
                                </tr>                                    
                            </thead>
                            <tbody>
                                @foreach($users as $user)                                    
                                    @foreach($user->documents as $document)    
                                    <tr>
                                        <td><a href="{{ route('iheart.team_leader.detail', $document->id) }}">  {{ $document->document_name }} </a></td> 
                                        <td>{{ $document->document_type }}</td>
                                        <td>{{ $document->created_at }}</td>
                                        <td>{{ $document->tl_inspection_status}}</td>
                                    </tr>
                                    @endforeach   
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


  