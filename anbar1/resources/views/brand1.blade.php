@extends('layout.app')

@section('title')
Brand
@endsection


@section('main')

<h1>Brand</h1>


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

@isset($editdata)
<form method="post" action="{{route('bupdate')}}" enctype="multipart/form-data">
	@csrf
	Brend:<br>
	    <input type="text" name="ad" value="{{$editdata->ad}}">
	Foto:<br>
		<input type="file" name="foto"><br><br>

		<input type="hidden" name="id" value="{{$editdata->id}}">
		<input type="hidden" name="hazirki_foto" value="{{$editdata->foto}}">
		<button type="submit">Yenile</button>
		<a href="{{route('blist')}}"><button type="button">Imtina</button></a>
</form>
@endisset

@isset($deletedata)
	Siz bu brendi silmeye eminsiniz?:<br>
	<a href="{{route('bdelete',$deletedata->id)}}"><button>He</button></a>
	<a href="{{route('blist')}}"><button>Yox</button></a>
	<br><br>
@endisset



@empty($editdata)
<form method="post" action="{{route('brandForm')}}" enctype="multipart/form-data">
	@csrf
	Brend:<br>
	    <input type="text" name="ad"><br>
	Foto:<br>
		<input type="file" name="foto"><br><br>
		<button type="submit">Daxil et</button>
</form>
@endempty


<br><br>
@foreach($data as $i=>$info)
    #{{$i+=1}}<br>
    <b>Brend: </b>{{$info->ad}}<br>
	<image style="width:75px; height:65px;" src="{{url($info->image)}}"><br>
    <b>Tarix: </b>{{$info->created_at}}<br><br>
	<a href="{{route('bsil',$info->id)}}"><button>Sil</button></a>
	<a href="{{route('bedit',$info->id)}}"><button>Redakte</button></a><br><br>
@endforeach

@endsection
