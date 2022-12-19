@extends('layout.app')

@section('orders')


<div class="container mt-4">

    <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>

    <div class="card">

        <div class="card-header text-center font-weight-bold">
            <h2>Orders</h2>
        </div>

        <div class="card-body">

            <table class="table table-bordered" id="datatable-ajax-crud">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Musteri</th>
                        <th>Mehsul</th>
                        <th>Stok</th>
                        <th>Miqdar</th>
                        <th>Tarix</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

        </div>

    </div>
    <!-- boostrap add and edit book model -->
    <div class="modal fade" id="ajax-book-model" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ajaxBookModel"></h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm"
                        class="form-horizontal" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">

                        @csrf
                        <div class="form-group">
                            Müştəri:<br>

                            <select name="client_id" id="client">
                                <option value="">Müştəri seçin</option>

                                @foreach($cdata as $cinfo)
                                <option value="{{$cinfo->id}}">{{$cinfo->ad}} {{$cinfo->soyad}}</option>
                                @endforeach
                            </select>
                            <br>
                        </div>

                        <div class="form-group">
                            Mehsul:<br>

                            <select name="product_id" id="product">
                                <option value="">Məhsul seçin</option>

                                @foreach($pdata as $pinfo)
                                <option value="{{$pinfo->id}}">{{$pinfo->brend}} - {{$pinfo->mehsul}} [
                                    {{$pinfo->miqdar}} ]
                                </option>
                                @endforeach
                            </select>
                            <br>
                        </div>


                        <div class="form-group">
                            <label for="exampleInputName1">Miqdar</label>
                            <input type="text" class="form-control" name="pmiqdar" id="pmiqdar">
                        </div>



                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save changes
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->

    <script type="text/javascript">
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $('#datatable-ajax-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('orders_data') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'klient',
                        name: 'klient'
                    },
                    {
                        data: 'produkt',
                        name: 'produkt'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'pmiqdar',
                        name: 'pmiqdar'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });


            $('#addNewBook').click(function () {
                $('#addEditBookForm').trigger("reset");
                $('#ajaxBookModel').html("Add Book");
                $('#ajax-book-model').modal('show');

                $('#id').val('');



            });

            $('body').on('click', '.edit', function () {

                var id = $(this).data('id');

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('edit-order') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#ajaxBookModel').html("Edit Book");
                        $('#ajax-book-model').modal('show');
                        $('#id').val(res.id);
                        $('#title').val(res.title);


                    }
                });

            });

            $('body').on('click', '.delete', function () {

                if (confirm("Delete Record?") == true) {
                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('delete-order') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {

                            var oTable = $('#datatable-ajax-crud').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                }

            });



            $('body').on('click', '.tesdiq', function () {

                if (confirm("Confirm Record?") == true) {
                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ route('otesdiq') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {

                            var oTable = $('#datatable-ajax-crud').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                }

            });

            $('body').on('click', '.legv', function () {

                
                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('olegvet') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {

                            var oTable = $('#datatable-ajax-crud').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                

            });

            $('#addEditBookForm').submit(function (e) {

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ url('add-update-order')}}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#ajax-book-model").modal('hide');
                        var oTable = $('#datatable-ajax-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        });

    </script>
</div>

@endsection
