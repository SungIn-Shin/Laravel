@extends('layouts.adminlte2')
@section('content')

<script type="text/javascript">
    $( document ).ready(function() {
     
    });
</script>

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
                <form action="{{ route('iheart.support_leader.documents.accountinglist') }}" action="GET">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            
                            <div class="col-lg-3 col-md-12">
                                <select id="year" name="year" class="form-control">
                                    <option value="">연도 선택</option>
                                    @for($i = intval(date('Y')); $i >= 2016 ; $i--) 
                                        @if ($request->year == $i) 
                                            <option value="{{$i}}" selected>{{$i}}년</option>
                                        @else 
                                            <option value="{{$i}}">{{$i}}년</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <select id="month" name="month" class="form-control">
                                    <option value="">월 선택</option>
                                    @for($i = 1; $i <= 12 ; $i++) 
                                    @if ($request->month == $i) 
                                        @if($i < 10)
                                            <option value="0{{$i}}" selected>0{{$i}}월</option>
                                        @else
                                        <option value="{{$i}}" selected>{{$i}}월</option>
                                        @endif
                                    @else 
                                        @if($i < 10)
                                            <option value="0{{$i}}">0{{$i}}월</option>
                                        @else
                                        <option value="{{$i}}">{{$i}}월</option>
                                        @endif
                                    @endif
                                    @endfor
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
        <div class="col-lg-12 pull-right">
            <form action="{{ route('iheart.support_leader.documents.excelDown') }}" method="get">
                <input type="hidden" name="year" value="{{$request->year}}">
                <input type="hidden" name="month" value="{{$request->month}}">
                <button type="submit" class="btn btn-default pull-right" id="aprBtn">엑셀다운</button> 
            </form>
           
        </div>
    </div>

    <br>

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
                                    @foreach ( json_decode($document->expenditure_historys, true) as $expenditure)
                                    <tr>
                                        <td class="text-center">{{$document->user->name}}</td>    
                                        <td class="text-center">{{$expenditure['item_name'] . '(' . $expenditure['item'] . ')'}}</td>
                                        <td class="text-center">{{$expenditure['content']}}</td>
                                        <td class="text-center">{{number_format($expenditure['price'])}} 원</td>
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


  