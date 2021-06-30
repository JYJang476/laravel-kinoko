<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="post" action="{{ Route('tt') }}">
        <input name="table" type="text">
        <textarea name="req" id="req" cols="30" rows="10"></textarea>
        <input name="sm" type="submit">
    </form>
</body>
</html>
