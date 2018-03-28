@extends('layouts.adminlte2')


@section('content')

<script type="text/javascript">

    var treeObject = new Map();

    
    $(document).ready(function() {
         

        var tree = $('#tree').treeview({
                                data: getTree(), 
                                showCheckbox : true,
                                state : {
                                    selected : true, 
                                }
                            });

        $('#removeNodeBtn').on('click', function(){
            // alert($('#tree').treeview('getParent', this));
            // $('#tree').treeview('removeNode', [ $('#tree').treeview('getChecked')[0] , { silent: false} ]);
            
            // alert($('#tree').treeview('getNodes', $('#tree').treeview('getChecked')));

            // 선택한 노드 삭제. 부모 노드 선택시 자식노드들 같이 삭제
            $('#tree').treeview('removeNode', [ $('#tree').treeview('getChecked') , { silent: true } ]);

        });
        // $('#tree').on('nodeChecked', function(event, data) {
        //     // Your logic goes here
        //     treeObject.set(data.key, data.text);
        //     var tmp = "";

        //     treeObject.forEach(function(item, key, mapObj) {
        //         tmp += key + ", " + item + "\r\n";
        //     });
        //     alert(tmp);
            
        // });

        // $('#tree').on('nodeUnchecked', function(event, data) {
        //     // Your logic goes here
        //     treeObject.delete(data.key);
            
        // });
    });


    function setSelectBox() {
        $("#apr_line")
    }

    function getTree() {
        var tree = [
                    {
                        text: "일반사용자1",
                        user_id: 1,
                        {{--  icon: "glyphicon glyphicon-stop", // 기본 아이콘 설정 : default : null  --}}
                        {{--  selectedIcon: "glyphicon glyphicon-stop", // 선택했을 때 생성되는 아이콘  default : null  --}}
                        selectable: true, // 선택 가능여부 설정 default : true
                        color: "#ff0000", // 폰트 색상
                        backColor: "#000000", // 배경색 default "#ffffff" 흰색
                        href: "#node-1", // 링크...
                        key : "2222",
                        zzzz : "3333", 
                        내맘대로 : "ㅋㅋㅋ",  // 이런거 다 위에서 data.key 이름으로 받아올 수 있음. custom이 가능하군!?
                        
                        nodes: [
                        {
                            text: "Child 1",
                            nodes: [
                            {
                                text: "Grandchild 1"
                            },
                            {
                                text: "Grandchild 2"
                            }
                            ]
                        },
                        {
                            text: "Child 2"
                        }
                        ]
                    },
                    {
                        text: "Parent 2"
                    },
                    {
                        text: "Parent 3"
                    },
                    {
                        text: "Parent 4"
                    },
                    {
                        text: "Parent 5"
                    }
                    ];
        // Some logic to retrieve, or generate tree structure
        return tree;
    }
      
    
</script>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        전자결재 
        <small>지출품의서(등록)-일반사용자</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <form action="{{ route('iheart.employee.regist') }}" method="post" enctype="multipart/form-data">
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
                            <div class="form-group col-lg-4 col-md-6">
                                <label for="document_type">문서분류</label>
                                <select class="form-control" name="document_type" id="document_type" >                
                                <option value="지출품의서">지출품의서</option>
                                </select>            
                            </div>          
                            <div class="form-group col-lg-4 col-md-6">
                                <label for="document_name">문서명</label>
                                <input type="text" class="form-control" name="document_name" id="document_name" placeholder="문서명">
                            </div>
                            <div class="form-group col-lg-4 col-md-6">
                                <label for="document_comment">문서설명</label>
                                <input type="text" class="form-control" name="document_comment" id="document_comment" placeholder="문서 설명">
                            </div>
                        </div> <!-- /.row -->          
                        
                        <div class="row col-lg-12">
                            <div class="col-lg-6">
                                <label>결재라인 선택</label>
                                <div id="tree"></div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Select Multiple Disabled</label>
                                    <select id="apr_line" name="apr_line" multiple="" class="form-control" >

                                    </select>
                                    <a id="removeNodeBtn" href="#" class="glyphicon glyphicon-arrow-up pull-right"></a>
                                    
                                    <a href="#" class="glyphicon glyphicon-arrow-down pull-right"></a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 지출내역, 증빙서류첨부 row -->
                        <div class="row">
                            <!-- 지출내역 -->
                            <div class="form-group col-lg-6 col-md-12">                  
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
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="item1" name="item1" placeholder="항목1">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="content1" name="content1" placeholder="내용1">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="price1" name="price1" placeholder="금액1">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="item2" name="item2" placeholder="항목2">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="content2" name="content2" placeholder="내용2">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="price2" name="price2" placeholder="금액2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="item3" name="item3" placeholder="항목3">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="content3" name="content3" placeholder="내용3">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="price3" name="price3" placeholder="금액3">
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <!-- 증빙서류 -->
                            <div class="form-group col-lg-6 col-md-12">
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


  