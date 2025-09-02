<div class="grid grid-cols-12 reward-wrapper">
	<div class="input-form col-span-12 lg:col-span-4 px-2 py-1 mt-2">
		<label class="form-label w-full flex flex-col sm:flex-row">
			Type
		</label>
		<select name="types[]" class="form-control form__input" required>
			<option value="amount" {{(isset($item['type']) && $item['type']=='amount')?'selected':''}}>Amount</option>
			<option value="product" {{(isset($item['type']) && $item['type']=='product')?'selected':''}}>Product</option>
		</select>
	</div>
	<div class="input-form col-span-12 lg:col-span-4 px-2 py-1 mt-2">
		<label class="form-label w-full flex flex-col sm:flex-row">
			Points
		</label>
		<input type="text" name="points[]" value="{{$item['points']}}" class="form-control form__input" required>
	</div>
	<div class="input-form col-span-12 lg:col-span-4 px-2 py-1 mt-2">
		<label class="form-label w-full flex flex-col sm:flex-row">
			Value/Item
		</label>
		<input type="text" name="items[]" value="{{$item['item']??''}}" class="form-control form__input" required>
	</div>
</div>