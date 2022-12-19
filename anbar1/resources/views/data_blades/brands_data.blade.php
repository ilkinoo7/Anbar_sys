@extends('layout.app')

@section('brands')




<div class="container mt-4">

    <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button>
    </div>

    <div class="card">

        <div class="card-header text-center font-weight-bold">
            <h2>Brands</h2>
        </div>

        <div class="card-body">

            <table class="table table-bordered" id="datatable-ajax-crud">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Brand</th>
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
                            <label for="exampleInputName1">Brend</label>
                            <input type="text" class="form-control" name="ad" id="title">
                        </div>

                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Foto URL">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Yukle</button>
                                </span>
                            </div>
                            <div class="col-sm-6 pull-right">
                                <img id="preview-image"
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSM4sEG5g9GFcy4SUxbzWNzUTf1jMISTDZrTw&usqp=CAU"
                                    alt="preview image" style="max-height: 250px;">
                            </div>
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

            $('#image').change(function () {

                let reader = new FileReader();

                reader.onload = (e) => {

                    $('#preview-image').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);

            });

            $('#datatable-ajax-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('brands_data') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'image',
                        render: function (data, type, full, meta) {
                            return '<img style="width:50px; height:50px; " src="' + data + '">'
                        },
                        orderable: false
                    },
                    {
                        data: 'ad',
                        name: 'ad'
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
                $("#image").attr("required", "true");
                $('#id').val('');
                $('#preview-image').attr('src',
                    'https://www.riobeauty.co.uk/images/product_image_not_found.gif');


            });

            $('body').on('click', '.edit', function () {

                var id = $(this).data('id');

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('edit-brand') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#ajaxBookModel').html("Edit Book");
                        $('#ajax-book-model').modal('show');
                        $('#id').val(res.id);
                        $('#title').val(res.ad);
                        document.getElementById('preview-image').src = res.image

                    }
                });

            });

            $('body').on('click', '.delete', function () {

                if (confirm("Delete Record?") == true) {
                    var id = $(this).data('id');

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('brands_delete') }}",
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
                    url: "{{ url('add-update-brand')}}",
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
