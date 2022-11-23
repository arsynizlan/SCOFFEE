<form id="createForm" enctype="multipart/form-data">
    <div class="modal fade text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Education</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" name="title" id="title-edit" class="form-control">
                        </label>
                        <label for="image">Image</label>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- imgBB file uploader -->
                                <input type="file" name="image" id="createImage" class="imgbb-filepond">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-select" name="category" id="category-edit">
                            'Kopi Asik', 'Sumedang Kopi', 'Pejuang Coffee', 'Benih Coffee'
                            <option value="" disabled>Pilih</option>
                            <option value="Kopi Asik">Kopi Asik</option>
                            <option value="Sumedang Kopi">Sumedang Kopi</option>
                            <option value="Pejuang Coffee">Pejuang Coffee</option>
                            <option value="Benih Coffee">Benih Coffee</option>
                        </select>
                        </label>
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
                    <button type="button" class="btn btn-primary" id="createSubmit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
