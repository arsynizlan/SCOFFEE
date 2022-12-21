<form id="editForm">
    <div class="modal fade text-left w-100" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Event</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" name="title" id="title-edit" class="form-control" >
                    </label>
                    <label for="title">Image</label>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- imgBB file uploader -->
                                <input type="file" name="image" id="title-edit" class="imgbb-filepond">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea name="body" id="body-edit" class="form-control"></textarea>
                        </label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary" id="editSubmit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
