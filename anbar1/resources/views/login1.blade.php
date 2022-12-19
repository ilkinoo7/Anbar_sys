<center>
@if($errors->any())
	@foreach($errors->all() as $sehv)
	{{$sehv}}<br>
	@endforeach
@endif

<br><br>

@if(session('success'))
    {{session('success')}}
@endif

<br><br>


<form method="post" action="{{route('signin')}}">
	@csrf
	
    Email:<br>
        <input type="text" name="email"><br>
    Parol:<br>
        <input type="password" name="password"><br><br>
		<button type="submit">Daxil ol</button>
</form>

</center>
