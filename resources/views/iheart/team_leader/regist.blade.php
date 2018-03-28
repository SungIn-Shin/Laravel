@extends('layouts.adminlte2')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        전자결재 
        <small>지출품의서(등록)-팀장</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <form action="{{ route('iheart.team_leader.regist') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    {{--  <div class="box-header with-border">
                        <h3 class="box-title">전자결재 - 지출품의서</h3>
                    </div>  --}}
                    <div class="box-body">
                        <!-- 문서번호, 문서분류, 문서명, 문서설명 row -->
                        <div class="row">                            
                            <div class="form-group col-lg-12">
                                <label for="document_type">문서분류</label>
                                <select class="form-control" name="document_type" id="document_type" >                
                                    <option value="지출품의서">지출품의서</option>
                                </select>            
                            </div>          
                            {{--  <div class="form-group col-lg-4 col-md-6">
                                <label for="document_name">문서명</label>
                                <input type="text" class="form-control" name="document_name" id="document_name" placeholder="문서명">
                            </div>
                            <div class="form-group col-lg-4 col-md-6">
                                <label for="document_comment">문서설명</label>
                                <input type="text" class="form-control" name="document_comment" id="document_comment" placeholder="문서 설명">
                            </div>  --}}
                        </div> <!-- /.row -->              
                        <!-- 지출내역, 증빙서류첨부 row -->
                        <div class="row">
                            <!-- 지출내역 -->
                            <div class="form-group col-lg-12 col-md-12">                  
                                <label for="exTable">지출내역</label>
                                <table id="exTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th>항목</th>
                                    <th>내용</th>
                                    <th>금액</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 10; $i++)
                                    <tr>
                                        <td>
                                            <select class="form-control" name="expenditure[{{ $i }}][item]" id="expenditure[{{ $i }}][item]" >                
                                                <option value="">선택</option>
                                                <option value="811">복리후생비</option>
                                                <option value="812">여비교통비</option>
                                                <option value="814">통신비</option>
                                                <option value="824">운반비</option>
                                                <option value="826">도서인쇄비</option>
                                                <option value="830">소모품비</option>
                                                <option value="831">지급수수료(기타)</option>
                                            </select> 
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="content1" name="expenditure[{{ $i }}][content]" placeholder="내용{{ $i }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="price1" name="expenditure[{{ $i }}][price]" placeholder="금액{{ $i }}">
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                                </table>
                            </div>
                            <!-- 증빙서류 -->
                            <div class="form-group col-lg-12 col-md-12">
                                <label for="exTable">증빙서류</label>
                                <input id="multiple" multiple="multiple" class="form-control"  type="file" name="files[]"/>
                                <textarea id="attachList" class="form-control" rows="3" placeholder="첨부파일 리스트"></textarea>
                                <br>
                                <button type="submit" class="btn btn-default pull-right">제출</button>  
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


  