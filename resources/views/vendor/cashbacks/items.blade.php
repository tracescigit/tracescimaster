<div class="grid grid-cols-12 prize-wrapper">
	<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
		<label class="form-label w-full flex flex-col sm:flex-row">
			Amount
		</label>
		<input type="number" min="1" name="items[]" value="{{$item['item']}}" class="form-control form__input" required>
	</div>
	<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
		<label class="form-label w-full flex flex-col sm:flex-row">
			Quantity
		</label>
		<input type="number" min="1" step="1" name="quantity[]" value="{{$item['quantity']}}" class="form-control form__input" required>
	</div>
</div>