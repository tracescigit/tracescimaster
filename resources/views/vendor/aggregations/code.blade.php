<div class="col-span-12 bg-gray-200 p-3">

	<table class="table">
		<tbody>
			<tr>
				<td>Batch</td>
				<td>{{$code->batch}}</td>
			</tr>

			<tr>
				<td>Product Name</td>
				<td>{{$code->getProduct->name}}</td>
			</tr>

			@if ($code->getProduct->image_url)
				<tr>
					<td colspan="2">
						<img src="{{asset($code->getProduct->image_url)}}" class="w-full">
					</td>
				</tr>
			@endif

		</tbody>
	</table>

</div>