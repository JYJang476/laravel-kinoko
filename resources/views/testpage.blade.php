@include("layouts.master")
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</body>

</html>
