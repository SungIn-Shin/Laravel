@extends('layouts.adminlte2')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        전자결재 
        <small>리스트-경영지원팀장</small>
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
                <form action="{{ route('iheart.support_leader.documents.list') }}" action="GET">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            
                            <div class="col-lg-3 col-md-12">
                                <select id="year" name="year" class="form-control">
                                    <option value="2018">연도 선택</option>
                                    <option value="2018">2018년</option>
                                    <option value="2017">2017년</option>
                                    <option value="2016">2016년</option>
                                    <option value="2015">2015년</option>
                                    <option value="2014">2014년</option>
                                    <option value="2013">2013년</option>
                                    <option value="2012">2012년</option>
                                    <option value="2011">2011년</option>
                                    <option value="2010">2010년</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <select id="month" name="month" class="form-control">
                                    <option value="">월 선택</option>
                                    <option value="1">1월</option>
                                    <option value="2">2월</option>
                                    <option value="3">3월</option>
                                    <option value="4">4월</option>
                                    <option value="5">5월</option>
                                    <option value="6">6월</option>
                                    <option value="7">7월</option>
                                    <option value="8">8월</option>
                                    <option value="9">9월</option>
                                    <option value="10">10월</option>
                                    <option value="11">11월</option>
                                    <option value="12">12월</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-12">
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
                                    <th class="text-center">직원명</th>
                                    <th class="text-center">항목명</th>
                                    <th class="text-center">내용</th>
                                    <th class="text-center">금액</th>
                                </tr>                                    
                            </thead>
                            <tbody>
                                @foreach ($documents as $document)
                                    @foreach ($documents->expenditure_historys as $expenditure)
                                    <tr>
                                        <td>{{$document->user->name}}</td>    
                                        <td>{{$expenditure['item_name']}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr> 
                                    @endforeach
                                @endforeach
                                      
                            </tbody>
                        </table>
                    </div> <!-- /.row -->                
                    {{-- <div class="text-center">{{ $documents->links() }}</div>                         --}}
                </div>
            </div>          
        </div>                    
    </div>
</section>
<!-- /.content -->
</div>
@endsection


  