<form id="infoForm">
    <div class="modal fade text-left w-100" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edukasi</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" name="title" id="title-info" class="form-control">
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-select" name="category" id="category-info">
                            <option value="" selected disabled>Pilih</option>
                            <option value="Kopi Asik">Kopi Asik</option>
                            <option value="Sumedang Kopi">Sumedang Kopi</option>
                            <option value="Pejuang Coffee">Pejuang Coffee</option>
                            <option value="Benih Coffee">Benih Coffee</option>
                        </select>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="body">Deskripsi</label>
                        <textarea name="body" id="body-info" class="form-control"></textarea>
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
