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
@if(!$tenant)

<form method="post" action="{{route('landlord.create')}}">
    @csrf
    <label>
        <input type="text" placeholder="Name" name="name"/>
    </label> <br/>
    <label>
        <input type="text" placeholder="Domain" name="domain"/>
    </label> <br/>
    <label>
        <input type="text" placeholder="database" name="database"/>
    </label> <br/>
    <button type="submit" >Create</button>
</form>
@else

@if($user)
    <h1>User : {{$user->email}}</h1> <a href="/home">Home</a>
@else
    no user,
    <a href="/login">Login</a>
@endif
@endif


</body>
</html>
