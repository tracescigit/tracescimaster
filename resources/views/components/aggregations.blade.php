<div id="action-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3 px-5">
                <h3 class="text-xl font-normal">Add Aggregation</h3>
            </div>
            <div class="modal-body p-5">
                <div class="grid grid-cols-12">
                    <h6 class="col-span-12 mb-4">Please fill the form below for creation.</h6>
                    <form id="action-form" class="col-span-12">
                        <div class="col-span-12 mb-4">
                            <label for="from_serial_no">From serial number</label>
                            <input type="text" placeholder="Enter serial number" min="1" class="form-control form__input" name="from_serial_no" id="from_serial_no">
                            <div id="error-from_serial_no" class="login__input-error w-auto text-theme-6"></div>
                        </div>
                        <div class="col-span-12 mb-4">
                            <label for="to_serial_no">To serial number</label>
                            <input type="text" placeholder="Enter serial number" min="1" class="form-control form__input" name="to_serial_no" id="to_serial_no">
                            <div id="error-to_serial_no" class="login__input-error w-auto text-theme-6"></div>
                        </div>
                        <input type="hidden" name="level" id="level" value="{{$_GET['level']}}">                        
                        <div class="col-span-12 mb-4">
                            <label for="quantity">Quantity</label>
                            <input type="number" placeholder="Enter quantity" min="1" step="1" class="form-control form__input" name="quantity" id="quantity">
                            <div id="error-quantity" class="login__input-error w-auto text-theme-6"></div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="px-5 py-3 modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-auto float-left">Cancel</button>
                <button type="button" class="btn btn-primary w-24 ml-auto" id="action-button">Submit</button>
            </div>
        </div>
    </div>
</div>