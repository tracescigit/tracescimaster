@if (!empty($product))
<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#product" class="btn btn-primary">Product</a></li>
	<li><a data-toggle="tab" href="#wallet" class="btn btn-primary">Wallet</a></li>
</ul>

@php
$fieldPermissions = json_decode($permissions['field_name']) ?? [];
@endphp
<div class="tab-content mt-4">
	<div id="product" class="tab-pane fade in active">

		<h3 class="w-full my-4 text-2xl px-2" style="margin:25px 0;">
			@if ($product['genuine_product'] == true)
			This product is genuine :
			@else
			Suspicious product
			@endif
		</h3>

		<table class="table w-full border">

			@if(!empty($fieldPermissions) && in_array('Product Name', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Product Name</strong></th>
				<th class="px-2">{{ $product['name'] ?? '' }}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Brand', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Brand</strong></th>
				<th class="px-2">{{ $product['brand'] ?? '' }}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Price', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Price</strong></th>
				<th class="px-2">{{ $product['price'] ?? '' }}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Scan Counts', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Scan Counts</strong></th>
				<th class="px-2">{{ $product['scan_count'] ?? '' }}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Last Scanned', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Last Scanned</strong></th>
				<th class="px-2">{{ $product['last_scanned'] ?? '' }}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Batch Code', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Batch Code</strong></th>
				<th class="px-2">{{ $product['batch_code'] ?? '' }}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Manufactured on', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Manufactured on</strong></th>
				<th class="px-2">{{ $product['manufactured_on'] ?? '' }}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Expiry on', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Expiry on</strong></th>
				<th class="px-2">{{ $product['expiry_on'] ?? '' }}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Genuine Product', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Genuine Product</strong></th>
				<th class="px-2">{{ $product['genuine_product'] ? 'Yes' : 'No' }}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Product Image', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Product Image</strong></th>
				<th class="px-2">
					@if ($product['image'])
					<a href="javascript:void(0)" class="image-link" data-toggle="modal" data-target="#image-modal" data-src="{{ $product['image'] }}">
						<img src="{{ $product['image'] }}" class="img-thumbnail" style="max-height:100px;">
					</a>
					@else
					NA
					@endif
				</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Label Image', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Label Image</strong></th>
				<th class="px-2">
					@if ($product['label_image'])
					<img src="{{ $product['label_image'] }}" class="img-thumbnail" style="max-height:100px;">
					@else
					NA
					@endif
				</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Media', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Media</strong></th>
				<th class="px-2">
					@if ($product['media'])
					<video width="200" height="150" controls>
						<source src="{{ $product['media'] }}" type="video/mp4">
					</video>
					@else
					NA
					@endif
				</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Description', $fieldPermissions))
			<tr>
				<th class="px-2"><strong>Description</strong></th>
				<th class="px-2">{!! $product['html_description'] ?? '' !!}</th>
			</tr>
			@endif

			@if(!empty($fieldPermissions) && in_array('Product Journey', $fieldPermissions))
			<tr>
				<th class="px-2">Product Journey</th>
				<th class="px-2">
					@if(!empty($journey))
					@foreach($journey as $detail)
					<div>
						ACTION: <strong>{{ ucfirst($detail['action'] ?? '-') }}</strong><br>
						SCANNED AT: {{ $detail['scanned_at'] ?? '' }}<br>
						SCANNED BY: {{ $detail['scanned_by'] ?? '' }}
						<hr>
					</div>
					@endforeach
					@else
					NA
					@endif
				</th>
			</tr>
			@endif

		</table>

	</div>
</div>
@endif