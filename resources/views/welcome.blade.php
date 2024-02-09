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
<pre>
    {{$tenant}}
</pre>

@if(!$tenant)

<form method="post" action="{{route('create')}}">
    @csrf
    <input type="text" placeholder="Name" name="name"/> <br/>
    <input type="text" placeholder="Domain" name="domain"/> <br/>
    <input type="text" placeholder="database" name="database"/> <br/>
    <button type="submit" >Create</button>
</form>
@endif

@if($user)
    <h1>User : {{$user->email}}</h1>
@else
    no user
@endif
</body>
</html>
