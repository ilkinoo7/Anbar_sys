@extends('layout.app')

@section('products')



<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Məhsul</h4>

            <form method="post" action="{{route('productForm')}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    Brend:<br>

                    <select name="brand_id">
                        <option value="">Brendi secin</option>

                        @foreach($bdata as $binfo)
                        <option value="{{$binfo->id}}">{{$binfo->ad}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Ad</label>
                    <input type="text" class="form-control" name="ad">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Alis</label>
                    <input type="text" class="form-control" name="alis">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Satis</label>
                    <input type="text" class="form-control" name="satis">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Miqdar</label>
                    <input type="text" class="form-control" name="miqdar">
                </div>


                <button type="submit" class="btn btn-primary mr-2">Daxil et</button>

            </form>


        </div>
    </div>
</div>













<div class="card">
    <div class="card-body">
        <h4 class="card-title">Cədvəl</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Brend </th>
                    <th> Ad </th>
                    <th> Alis </th>
                    <th> Satis </th>
                    <th> Miqdar </th>
                    <th> Yaradildi </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>

                @foreach($data as $i=>$info)
                <tr>

                    <td> {{$info->brend}} </td>
                    <td> {{$info->mehsul}} </td>
                    <td> {{$info->alis}} </td>
                    <td> {{$info->satis}} </td>
                    <td> {{$info->miqdar}} </td>
                    <td> {{$info->created_at}} </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

</div>
@endsection
