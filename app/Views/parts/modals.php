<!-- Create Modal -->
<div class="modal fade" id="modal-create-book" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create a Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-create-book" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="Title of book">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="author" placeholder="Author for book">
                    </div>
                    <div class="form-group">
                        <select class="form-control select2" id="status-save" name="status_id">
                            <option value="" disabled selected>=PILIH STATUS=</option>
                            <option id="publish" value="1">Publish</option>
                            <option id="pending" value="2">Pending</option>
                            <option id="draft" value="3">Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="description" placeholder="Enter ..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn-save-book">Save Book</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="modal-edit-book" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit a Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-book" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="book_id">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="Title of book">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="author" placeholder="Author for book">
                    </div>
                    <div class="form-group">
                        <select class="form-control select2" id="status" name="status_id">
                            <option id="publish" value="1">Publish</option>
                            <option id="pending" value="2">Pending</option>
                            <option id="draft" value="3">Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="description" placeholder="Enter ..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn-update-book">Update Book</button>
            </div>
        </div>
    </div>
</div>
