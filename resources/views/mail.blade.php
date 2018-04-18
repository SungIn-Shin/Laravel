<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1> 반려 안내 </h1>
    문서명 : {{ $document->document_name }} <br/>
    요청자 : {{ $document->user->name }} <br/>
    문서종류 : {{ $document->document_type }} <br/>

    반려내용
    <table style="border:1px solid black;">
        <thead>
            <tr>
                <th>반려자</th>
                <th>제목</th>
                <th>반려내용</th>
                <th>작성일시</th>
            </tr>
        </thead>

        <tbody>
            @foreach($document->comments as $comment)
            <tr>
                <td>{{$comment->writer}}</td>
                <td>{{$comment->title}}</td>
                <td>{{$comment->content}}</td>
                <td>{{$comment->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>