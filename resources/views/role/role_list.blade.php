@extends('layouts.admin_app')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Role 역할 관리</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">
                        역할 리스트
                    </div>
                    <div class="pull-right">                        
                        <a class="btn btn-default" href="{{route('role.store')}}" role="button">역할등록</a>
                    </div>
                </div>                                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>권한</th>
                                    <th>권한이름</th>
                                    <th>설명</th>                                    
                                    <th>생성일자</th>      
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)                                
                                <tr>
                                    <th scope="row">   <a  href="{{ route('role.attachRole', $role->id) }}"> {{ $role->id }}  </a> </th>
                                    <td>                {{ $role->name }}  </td>
                                    <td>                {{ $role->display_name }}   </td>
                                    <td>                {{ $role->description }} </td>
                                    <td>                {{ $role->created_at }}</td>                         
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>    
    <!-- pagenation -->
    <div class="text-center">{{ $roles->links() }}</div>

</div>
<!-- /#page-wrapper -->
 
@endsection



