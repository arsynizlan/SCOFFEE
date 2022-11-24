<form id="editForm">
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Category</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name-edit" class="form-control">
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="editImage">Gambar</label>
                        <input type="file" id="editImage" name="image" data-show-loader="false"
                            class="form-control" required data-allowed-file-extensions="jpg png"
                            data-max-file-size-preview="3M" data-max-file-size="3M">
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
