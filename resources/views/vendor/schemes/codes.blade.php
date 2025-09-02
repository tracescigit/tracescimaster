<div class="grid grid-cols-12 code-wrapper">
	<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
		<label class="form-label w-full flex flex-col sm:flex-row">
			From Code
		</label>
		<input type="text" name="from_codes[]" value="{{$code['from']}}" class="form-control form__input" required>
	</div>
	<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
		<label class="form-label w-full flex flex-col sm:flex-row">
			To Code
		</label>
		<input type="text" name="to_codes[]" value="{{$code['to']}}" class="form-control form__input" required>
	</div>
</div>