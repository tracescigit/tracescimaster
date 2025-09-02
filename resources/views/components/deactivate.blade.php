<div id="deactivate-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body p-0">
				<div class="p-5 text-center">
					<i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
					<input type="hidden" name="id" value="" id="target">
					<div class="text-3xl mt-5">Are you sure?</div>

					<div class="text-gray-600 mt-2">Do you really want to confirm action ?</div>
				</div>
				<div class="px-5 pb-8 text-center">
					<button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1" id="dismiss-modal">Cancel</button>
					<button type="button" class="btn btn-danger w-auto" id="deact-button">Confirm</button>
				</div>
			</div>
		</div>
	</div>
</div>