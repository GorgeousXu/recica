<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
</head>
<body>

<table>
    <tr>
        @foreach($books as $book)
            <td>{{$book->v_book}}</td>
        @endforeach
    </tr>
</table>

</body>
</html>
