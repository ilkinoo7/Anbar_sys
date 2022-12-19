@extends('layout.app')



@section('orders')


<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Sifariş</h4>

            <form method="post" action="{{route('orderForm')}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    Müştəri:<br>

                    <select name="client_id">
                        <option value="">Müştəri seçin</option>

                        @foreach($cdata as $cinfo)
                        <option value="{{$cinfo->id}}">{{$cinfo->ad}} {{$cinfo->soyad}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>

                <div class="form-group">
                    Mehsul:<br>

                    <select name="product_id">
                        <option value="">Məhsul seçin</option>

                        @foreach($pdata as $pinfo)
                        <option value="{{$pinfo->id}}">{{$pinfo->brend}} - {{$pinfo->mehsul}} [ {{$pinfo->miqdar}} ]
                        </option>
                        @endforeach
                    </select>
                    <br>
                </div>


                <div class="form-group">
                    <label for="exampleInputName1">Miqdar</label>
                    <input type="text" class="form-control" name="pmiqdar">
                </div>


                <button type="submit" class="btn btn-primary mr-2">Daxil et</button>

            </form>


        </div>
    </div>
</div>














<div class="card">
    <div class="card-body">
        <h4 class="card-title">Cədvəl</h4>

        <p class="card-description"> Bazada <code>{{$data->count()}}</code> sifaris var

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th> Klient </th>
                        <th> Mehsul </th>
                        <th> Stok </th>
                        <th> Sifarish </th>
                        <th> Alis </th>
                        <th> Satis </th>
                        <th> Yaradildi </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($data as $i=>$info)
                    <tr>

                        <td> {{$info->klient}} </td>
                        <td> {{$info->produkt}} </td>
                        <td> {{$info->stok}} </td>
                        <td> {{$info->pmiqdar}} </td>
                        <td> {{$info->alis}} </td>
                        <td> {{$info->satis}} </td>
                        <td> {{$info->created_at}} </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
    </div>
</div>

</div>
@endsection
