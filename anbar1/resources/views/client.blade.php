@extends('layout.app')



@section('clients')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Müştəri</h4>

            <form method="post" action="{{route('clientForm')}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="exampleInputName1">Ad</label>
                    <input type="text" class="form-control" name="ad">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Soyad</label>
                    <input type="text" class="form-control" name="soyad">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Telefon</label>
                    <input type="text" class="form-control" name="tel">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Email</label>
                    <input type="text" class="form-control" name="email">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Şirkət</label>
                    <input type="text" class="form-control" name="shirket">
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
                    <th> Ad </th>
                    <th> Soyad </th>
                    <th> Tel </th>
                    <th> Email </th>
                    <th> Shirket </th>
                    <th> Yaradildi </th>
                </tr>
            </thead>
            <tbody>

                @foreach($data as $i=>$info)
                <tr>

                    <td> {{$info->ad}} </td>
                    <td> {{$info->soyad}} </td>
                    <td> {{$info->tel}} </td>
                    <td> {{$info->email}} </td>
                    <td> {{$info->shirket}} </td>
                    <td> {{$info->created_at}} </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

</div>


@endsection
