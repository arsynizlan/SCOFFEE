<form id="editForm">
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Role</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-select" name="role" id="role-edit">
                            <option value="" disabled>Pilih</option>
                            <option value="SuperAdmin">SuperAdmin</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
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
