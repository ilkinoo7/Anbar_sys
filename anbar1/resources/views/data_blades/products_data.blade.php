@extends('layout.app')

@section('products')

<div class="container mt-4">

    <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>

    <div class="card">

        <div class="card-header text-center font-weight-bold">
            <h2>Products</h2>
        </div>

        <div class="card-body">

            <table class="table table-bordered" id="datatable-ajax-crud">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Brend</th>
                        <th>Ad</th>
                        <th>Alis</th>
                        <th>Satis</th>
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


                        @csrf

                        <div class="form-group">
                            Brend:<br>

                            <select name="brand_id" id="brand">
                                <option value="">Brendi secin</option>

                                @foreach($bdata as $binfo)
                                <option value="{{$binfo->id}}">{{$binfo->ad}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName1">Ad</label>
                            <input type="text" class="form-control" name="ad" id="ad">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName1">Alis</label>
                            <input type="text" class="form-control" name="alis" id="alis">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName1">Satis</label>
                            <input type="text" class="form-control" name="satis" id="satis">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName1">Miqdar</label>
                            <input type="text" class="form-control" name="miqdar" id="miqdar">
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
                ajax: "{{ url('products_data') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'brend',
                        name: 'brend'
                    },
                    {
                        data: 'mehsul',
                        name: 'ad'
                    },

                    {
                        data: 'alis',
                        name: 'alis'
                    },
                    {
                        data: 'satis',
                        name: 'satis'
                    },
                    {
                        data: 'miqdar',
                        name: 'miqdar'
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
                    url: "{{ url('edit-product') }}",
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
                        url: "{{ url('delete-product') }}",
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

            $('#addEditBookForm').submit(function (e) {

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ url('add-update-product')}}",
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
