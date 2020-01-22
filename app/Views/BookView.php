<?= $this->extend('partials/main') ?>

<?= $this->section('content') ?>
    <?= $this->include('parts/modals')?>
    <div class="row">
        <div class="col-12 mbl">
            <span class="btn-group float-right pb-3">
                <button type="button" class="btn btn-block btn-primary" id="create-book" data-toggle="modal" data-target="#modal-create-book">Create Book</button>
            </span>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable ajax crud CodeIgniter4</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data-table-book" class="table table-striped dataTable">
                                    <thead>
                                        <tr role="row">
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
<!-- /.row -->
<?= $this->endSection() ?>


<?= $this->section('extra-js') ?>
<script>
$(document).ready(function () {

    $.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf_token_name"]').attr('content')
	    }
	});

    var dataTableBook = $('#data-table-book').DataTable({
        serverSide : true,
        processing: true,
        ordering : true,
        ajax : {
            url: "<?= base_url('book/show') ?>",
            method : 'post'
        },
        "columns": [
            {
                "data": "id"
            },
            {
                "data": "title"
            },
            {
                "data": "author"
            },
            {
                "data": "description"
            },
            {
                "data": "status"
            },
            {
                "data": "action"
            }
        ],
        "columnDefs": [{
            width : '80px',
            targets : 5,
            orderable : false
        }, ]
    });

    $(document).on('click', '#btn-save-book', function () {
        $('.text-danger').remove();
        var createForm = $("#form-create-book");
        ajaxRequest(
            "<?= base_url('book/store') ?>",
            'POST',
            createForm.serializeArray(),
            function (response) {
                if (response.errors) {
                    $.each(response.errors, function (elem, messages) {
                        createForm.find('input[name="' + elem + '"]').after('<p class="text-danger">' + messages + '</p>');
                        createForm.find('textarea[name="' + elem + '"]').after('<p class="text-danger">' + messages + '</p>');
                    });
                } else {
                    Toast.fire({
                        icon: 'success',
                        title: response.messages
                    })
                    dataTableBook.ajax.reload();
                    $("#form-create-book").trigger("reset");
                    $("#modal-create-book").modal('hide');
                }
            }
        )
    })

    $(document).on('click', '.btn-edit', function (e) {
        $('.text-danger').remove();
        e.preventDefault();
        var url = "<?= base_url('book/edit')?>" + "/" + ":id";
        url = url.replace(':id', $(this).attr('data-id'));
        ajaxRequest(
            url, 'GET', [],
            function (response) {
                if (response.data) {
                    var editForm = $('#form-edit-book');
                    editForm.find('input[name="title"]').val(response.data.title);
                    editForm.find('input[name="author"]').val(response.data.author);
                    editForm.find('textarea[name="description"]').val(response.data.description);
                    editForm.find('select[name="status"]').val(response.data.status);
                    $("#book_id").val(response.data.id);
                    $("#modal-edit-book").modal('show');
                }
            }
        )
    });

    $(document).on('click', '#btn-update-book', function (e) {
        var url = "<?= base_url('book/update')?>" + "/" + ":id";
        url = url.replace(':id', $("#book_id").val());
        var editForm = $("#form-edit-book");
        ajaxRequest(
            url,
            'PUT',
            editForm.serializeArray(),
            function (response) {
                if (response.errors) {
                    $.each(response.errors, function (elem, messages) {
                        editForm.find('input[name="' + elem + '"]').after('<p class="text-danger">' + messages + '</p>');
                        editForm.find('textarea[name="' + elem + '"]').after('<p class="text-danger">' + messages + '</p>');
                        Toast.fire({
                            icon: 'error',
                            title: messages
                        })
                    });
                } else {
                    Toast.fire({
                        icon: 'success',
                        title: response.messages
                    })
                    dataTableBook.ajax.reload();
                    $("#form-edit-book").trigger("reset");
                    $("#modal-edit-book").modal('hide');
                }
            });
    });

    $(document).on('click', '.btn-delete', function (e) {
        var url = "<?= base_url('book/destroy')?>" + "/" + ":id";
        url = url.replace(':id', $(this).attr('data-id'));
        Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.value) {
                    ajaxRequest(
                        url,
                        'DELETE',
                        [],
                        function (response) {
                            if (response.errors) {
                                Toast.fire({
                                    icon: 'error',
                                    title: response.messages
                                })
                            } else {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.messages
                                })
                                dataTableBook.ajax.reload();
                            }
                        }
                    )
                }
            })
    });

    $('#modal-create-book').on('hidden.bs.modal', function (e) {
        $("#form-create-book").trigger("reset");
    });

    function ajaxRequest(url, type, data, successFunction) {
        $.ajax({
            url: url,
            method: type,
            data: data,
            success: successFunction
        });
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
});
</script>
<?= $this->endSection() ?>