@extends('layout.app')

@section('title')
Clients
@endsection


@section('main')

<h1>Client</h1>

@if($errors->any())
	@foreach($errors->all() as $sehv)
	{{$sehv}}<br>
	@endforeach
@endif

<br><br>

@if(session('success'))
    {{session('success')}}
@endif

@empty($editdata)
<form method="post" action="{{route('clientForm')}}">
	@csrf
	Klientin adi:<br>
		<input type="text" name="ad"><br>
	Klientin soyadi:<br>
		<input type="text" name="soyad"><br>

	Telefon:<br>
		<input type="text" name="tel"><br>

	EMail:<br>
		<input type="text" name="email"><br>

	Shirket:<br>
		<input type="text" name="shirket"><br><br>
        		
		<button type="submit">Daxil et</button>

</form>
@endempty

@isset($editdata)

<form method="post" action="{{route('cupdate')}}">
	@csrf
	Klientin adi:<br>
		<input type="text" name="ad" value="{{$editdata->ad}}"><br>
	Klientin soyadi:<br>
		<input type="text" name="soyad" value="{{$editdata->soyad}}"><br>

	Telefon:<br>
		<input type="text" name="tel" value="{{$editdata->tel}}"><br>

	EMail:<br>
		<input type="text" name="email" value="{{$editdata->email}}"><br>

	Shirket:<br>
		<input type="text" name="shirket" value="{{$editdata->shirket}}"><br><br>
        		
		<input type="hidden" name="id" value="{{$editdata->id}}">
		<button type="submit">Yenile</button>


@endisset

@isset($deletedata)
	Siz bu klienti silmeye eminsiniz?:<br>
	<a href="{{route('cdelete',$deletedata->id)}}"><button>He</button></a>
	<a href="{{route('clist')}}"><button>Yox</button></a>
	<br><br>
@endisset



<br><br>
@foreach($data as $i=>$info)
    #{{$i+=1}}<br>
    <b>Ad: </b>{{$info->ad}}<br>
    <b>Soyad: </b>{{$info->soyad}}<br>
	<b>Tel: </b>{{$info->tel}}<br>
    <b>Email: </b>{{$info->email}}<br>
	<b>Shirket: </b>{{$info->shirket}}<br><br>
	<a href="{{route('csil',$info->id)}}"><button>Sil</button></a>
	<a href="{{route('cedit',$info->id)}}"><button>Redakte</button></a><br><br>
@endforeach

@endsection
