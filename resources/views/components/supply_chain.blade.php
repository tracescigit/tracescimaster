<div id="add-new-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3 px-5">
                <h3 class="text-xl font-normal">Add New</h3>
            </div>
            <div class="modal-body p-5">
                <div class="grid grid-cols-12">
                    <h6 class="col-span-12 mb-4">Please fill the form below for creation.</h6>
                    <form id="add-new-form" class="col-span-12">
                        <div class="col-span-12 mb-4">
                            <label for="user">Select User</label>
                            <select name="user" id="user" class="form-select" required></select>
                            <div id="error-user" class="login__input-error w-auto text-theme-6"></div>
                        </div>
                        <input type="hidden" id="parent_id" name="parent_id">
                    </form>
                </div>
            </div>
            <div class="px-5 py-3 modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-auto float-left">Cancel</button>
                <button type="button" class="btn btn-primary w-24 ml-auto" id="add-new-button">Submit</button>
            </div>
        </div>
    </div>
</div>