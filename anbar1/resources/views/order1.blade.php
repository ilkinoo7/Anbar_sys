@extends('layout.app')

@section('title')
Orders
@endsection


@section('main')
{{$user_id}}
<h1>Sifariş</h1>

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
<form method="post" action="{{route('orderForm')}}">
	@csrf

    Müştəri:<br>

	<select name="client_id">
		<option value="">Müştəri seçin</option>

		@foreach($cdata as $cinfo)
			<option value="{{$cinfo->id}}">{{$cinfo->ad}} {{$cinfo->soyad}}</option>
		@endforeach
	</select>
	<br>

    Mehsul:<br>

	<select name="product_id">
		<option value="">Məhsul seçin</option>

		@foreach($pdata as $pinfo)
			<option value="{{$pinfo->id}}">{{$pinfo->brend}} - {{$pinfo->mehsul}} [ {{$pinfo->miqdar}} ]</option>
		@endforeach
	</select>
	<br>

    Miqdar:<br>
		<input type="text" name="pmiqdar"><br><br>
        <button type="submit">Daxil et</button>
	
</form>

@endisset

@isset($editdata)

<form method="post" action="{{route('oupdate')}}">
	@csrf

    Müştəri:<br>

	<select name="client_id">
		<option value="">Müştəri seçin</option>

		@foreach($cdata as $cinfo)

			@if($editdata->client_id==$cinfo->id)
				<option selected value="{{$cinfo->id}}">{{$cinfo->ad}} {{$cinfo->soyad}}</option>
			@else
				<option value="{{$cinfo->id}}">{{$cinfo->ad}} {{$cinfo->soyad}}</option>
			@endif

		@endforeach
	</select>
	<br>

    Mehsul:<br>

	<select name="product_id">
		<option value="">Məhsul seçin</option>

		@foreach($pdata as $pinfo)

			@if($editdata->product_id==$pinfo->id)
				<option selected value="{{$pinfo->id}}">{{$pinfo->brend}} - {{$pinfo->mehsul}} [ {{$pinfo->miqdar}} ]</option>
			@else
				<option value="{{$pinfo->id}}">{{$pinfo->brend}} - {{$pinfo->mehsul}} [ {{$pinfo->miqdar}} ]</option>
			@endif

		@endforeach
	</select>
	<br>

    Miqdar:<br>
	<input type="text" name="pmiqdar" value="{{$editdata->pmiqdar}}"><br><br>
		<input type="hidden" name="id" value="{{$editdata->id}}">
        <button type="submit">Daxil et</button>
	
</form>

@endisset

@isset($deletedataorder)

Siz bu brendi silmeye eminsiniz?<br><br>

        <a href="{{route('odelete',$deletedataorder->id)}}"><button>He</button></a>
		<a href="{{route('olist')}}"><button>Yox</button></a>
		<br><br>
@endisset

<b>Mushteri: </b>{{$csay}} | <b>Brend: </b>{{$bsay}} | <b>Ceshid: </b>{{$psay}} | <b>Mehsul: </b>{{$tmehsul}} | <b>Alis: </b>{{$talis}} | <b>Satis: </b>{{$tsatis}} | <b>Qazanc: </b>{{$qazanc}} | <b>Cari qazanc: </b>{{$cqazanc}}

<br><br>
Bazada {{$data->count()}} sifaris var<br><br>
@foreach($data as $i=>$info)
    #{{$i+=1}}<br>
	<b>Klient: </b>{{$info->klient}}<br>
    <b>Mehsul: </b>{{$info->produkt}}<br>
	<b>Stok: </b>{{$info->stok}}<br>
    <b>Sifarish: </b>{{$info->pmiqdar}}<br>
	<b>Alis: </b>{{$info->alis}}<br>
	<b>Satis: </b>{{$info->satis}}<br>

	@if($info->tesdiq==0)
		<a href="{{route('osil',$info->id)}}"><button>Sil</button></a>
		<a href="{{route('oedit',$info->id)}}"><button>Redakte</button></a>
		<a href="{{route('otesdiq',$info->id)}}"><button>Tesdiq</button></a><br><br>
	@else
		<a href="{{route('olegvet',$info->id)}}"><button>legv et</button></a><br><br>
	@endif
	
@endforeach


@endsection