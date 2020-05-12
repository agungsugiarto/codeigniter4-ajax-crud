<?= $this->extend('partials/main') ?>

<?= $this->section('content') ?>
    <?= $this->include('parts/modals')?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> CodeIgniter4 - DataTable Serverside with ajax crud</h3>
                    <div class="float-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-block btn-primary" id="create-book" data-toggle="modal" data-target="#modal-create-book"><i class="fa fa-plus"></i> Create Book</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="data-table-book" class="table table-striped dataTable">
                                        <thead>
                                            <tr role="row">
                                                <th>No</th>
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
        autoWidth: false,
        serverSide : true,
        processing: true,
        order: [[1, 'asc']],
        columnDefs: [{
            orderable: false,
            targets: [0,4,5]
        }],

        ajax : {
            url: "<?= route_to('datatable') ?>",
            method : 'POST'
        },

        columns: [
            {
                "data": null
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
                "data": function(data) {
                    switch(data.status) {
                        case 'Publish':
                        return `<span class="right badge badge-success">${data.status}</span>`
                        break;
                        case 'Pending':
                        return `<span class="right badge badge-info">${data.status}</span>`
                        break;
                        case 'Draft':
                        return `<span class="right badge badge-warning">${data.status}</span>`
                        break;
                    }
                }
            },
            {
                "data": function(data) {
                    return `<td class="text-right py-0 align-middle">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-primary btn-edit" data-id="${data.id}"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-danger btn-delete" data-id="${data.id}"><i class="fas fa-trash"></i></button>
                            </div>
                            </td>`
                }
            }
        ]
    });

    dataTableBook.on('draw.dt', function() {
        var PageInfo = $('#data-table-book').DataTable().page.info();
        dataTableBook.column(0, {
            page: 'current'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    $(document).on('click', '#btn-save-book', function () {
        $('.text-danger').remove();
        $('.is-invalid').removeClass('is-invalid');
        var createForm = $('#form-create-book');
        
        $.ajax({
            url: '<?= route_to('resource') ?>',
            method: 'POST',
            data: createForm.serialize()
        }).done((data, textStatus) => {
            Toast.fire({
                icon: 'success',
                title: textStatus
            })
            dataTableBook.ajax.reload();
            $("#form-create-book").trigger("reset");
            $("#modal-create-book").modal('hide');

        }).fail((xhr, status, error) => {
            if (xhr.responseJSON.message) {
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON.message,
                });
            }

            $.each(xhr.responseJSON.messages, (elem, messages) => {
                createForm.find('select[name="' + elem + '"]').after('<p class="text-danger">' + messages + '</p>');
                createForm.find('input[name="' + elem + '"]').addClass('is-invalid').after('<p class="text-danger">' + messages + '</p>');
                createForm.find('textarea[name="' + elem + '"]').addClass('is-invalid').after('<p class="text-danger">' + messages + '</p>');
            });
        })
    })

    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault();
        $.ajax({
            url: `<?= route_to('book/resource') ?>/${$(this).attr('data-id')}/edit`,
            method: 'GET',
            
        }).done((response) => {
            var editForm = $('#form-edit-book');
            editForm.find('input[name="title"]').val(response.data.title);
            editForm.find('input[name="author"]').val(response.data.author);
            editForm.find('textarea[name="description"]').val(response.data.description);
            editForm.find('select[name="status_id"]').val(response.data.status_id);
            $("#book_id").val(response.data.id);
            $("#modal-edit-book").modal('show');
        }).fail((error) => {
            Toast.fire({
                icon: 'error',
                title: error.responseJSON.messages.error,
            });
        })
    });

    $(document).on('click', '#btn-update-book', function (e) {
        e.preventDefault();
        $('.text-danger').remove();
        var editForm = $('#form-edit-book');

        $.ajax({
            url: `<?= route_to('book/resource') ?>/${$('#book_id').val()}`,
            method: 'PUT',
            data: editForm.serialize()
            
        }).done((data, textStatus) => {
            Toast.fire({
                icon: 'success',
                title: textStatus
            })
            dataTableBook.ajax.reload();
            $("#form-edit-book").trigger("reset");
            $("#modal-edit-book").modal('hide');

        }).fail((xhr, status, error) => {
            $.each(xhr.responseJSON.messages, (elem, messages) => {
                editForm.find('select[name="' + elem + '"]').after('<p class="text-danger">' + messages + '</p>');
                editForm.find('input[name="' + elem + '"]').addClass('is-invalid').after('<p class="text-danger">' + messages + '</p>');
                editForm.find('textarea[name="' + elem + '"]').addClass('is-invalid').after('<p class="text-danger">' + messages + '</p>');
            });
        })
    });

    $(document).on('click', '.btn-delete', function (e) {
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
                $.ajax({
                    url: `<?= route_to('book/resource') ?>/${$(this).attr('data-id')}`,
                    method: 'DELETE',
                }).done((data, textStatus) => {
                    Toast.fire({
                        icon: 'success',
                        title: textStatus,
                    });
                    dataTableBook.ajax.reload();
                }).fail((error) => {
                    Toast.fire({
                        icon: 'error',
                        title: error.responseJSON.messages.error,
                    });
                })
            }
        })
    });

    $('#modal-create-book').on('hidden.bs.modal', function() {
        $(this).find('#form-create-book')[0].reset();
        $('.text-danger').remove();
        $('.is-invalid').removeClass('is-invalid');
    });

    $('#modal-edit-book').on('hidden.bs.modal', function() {
        $(this).find('#form-edit-permission')[0].reset();
        $('.text-danger').remove();
        $('.is-invalid').removeClass('is-invalid');
    });

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