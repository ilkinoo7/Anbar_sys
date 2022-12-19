@extends('layout.app')

@section('title')
Products
@endsection


@section('main')

<h1>Produkt</h1>

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
<form method="post" action="{{route('productForm')}}">
	@csrf
	Brend:<br>

	<select name="brand_id">
		<option value="">Brendi secin</option>

		@foreach($bdata as $binfo)
			<option value="{{$binfo->id}}">{{$binfo->ad}}</option>
		@endforeach
	</select>
	<br>
	Ad:<br>
		<input type="text" name="ad"><br>
	Aliş:<br>
		<input type="text" name="alis"><br>
	Satış:<br>
		<input type="text" name="satis"><br>
	Miqdar:<br>
		<input type="text" name="miqdar"><br><br>
		<button type="submit">Daxil et</button>
</form>

@endempty

@isset($editdata)

<form method="post" action="{{route('pupdate')}}">
	@csrf
	Brend:<br>
	<select name="brand_id">
		<option value="">Brendi secin</option>

		@foreach($bdata as $binfo)
			@if($editdata->brand_id==$binfo->id)
				<option selected value="{{$binfo->id}}">{{$binfo->ad}}</option>
			@else:
				<option value="{{$binfo->id}}">{{$binfo->ad}}</option>
			@endif
		@endforeach
	</select>
	<br>
	Ad:<br>
		<input type="text" name="ad" value="{{$editdata->ad}}"><br>
	Aliş:<br>
		<input type="text" name="alis" value="{{$editdata->alis}}"><br>
	Satış:<br>
		<input type="text" name="satis" value="{{$editdata->satis}}"><br>
	Miqdar:<br>
		<input type="text" name="miqdar" value="{{$editdata->miqdar}}"><br><br>
		<input type="hidden" name="id" value="{{$editdata->id}}">
		<button type="submit">Yenile</button>
</form>

@endisset

@isset($deletedata)
	Siz bu mehsulu silmeye eminsiniz?:<br>
	<a href="{{route('pdelete',$deletedata->id)}}"><button>He</button></a>
	<a href="{{route('plist')}}"><button>Yox</button></a>
	<br><br>
@endisset

<br><br>
@foreach($data as $i=>$info)
    #{{$i+=1}}<br>
	<b>Brend: </b>{{$info->brend}}<br>
    <b>Ad: </b>{{$info->mehsul}}<br>
    <b>Alis: </b>{{$info->alis}}<br>
	<b>Satis: </b>{{$info->satis}}<br>
    <b>Miqdar: </b>{{$info->miqdar}}<br>
	<a href="{{route('psil',$info->id)}}"><button>Sil</button></a>
	<a href="{{route('pedit',$info->id)}}"><button>Redakte</button></a><br><br>
@endforeach

@endsection