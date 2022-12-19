@extends('layout.app')

@section('brands')

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Brend</h4>

            <form method="post" action="{{route('brandForm')}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="exampleInputName1">Brend</label>
                    <input type="text" class="form-control" name="ad">
                </div>

                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Foto URL">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Yukle</button>
                        </span>
                    </div>
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
                    <th> Foto </th>
                    <th> Brend </th>
                    <th> Yaradildi </th>
                </tr>
            </thead>
            <tbody>

                @foreach($data as $i=>$info)
                <tr>
                    <td class="py-1">
                        <img src="{{url($info->image)}}" alt="image">
                    </td>
                    <td> {{$info->ad}} </td>

                    <td> {{$info->created_at}} </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

</div>
@endsection
