@if (!empty($product))
<style>
	:root {
		--primary: #111111;
		--primary-light: #333333;
		--bg: #f4f6f9;
		--white: #ffffff;
		--text: #222222;
		--muted: #777777;
		--success: #0f8a43;
		--danger: #dc3545;
		--accent: #7a0d7d;
	}

	/* =========================
   GLOBAL
========================= */

	body {
		background: var(--bg);
		font-family: 'Poppins', sans-serif;
	}

	#main {
		background: linear-gradient(180deg, #f4f6f9 0%, #eef0f5 100%);
		min-height: 100vh;
		padding-bottom: 40px;
	}

	/* =========================
   HEADER
========================= */

	.pd-header {
		display: flex;
		align-items: center;
		padding: 18px 20px;
		background: linear-gradient(135deg, #000, #2a2a2a);
		position: sticky;
		top: 0;
		z-index: 999;
		box-shadow: 0 5px 20px rgba(0, 0, 0, .15);
	}

	.pd-back {
		color: #fff;
		font-size: 20px;
		margin-right: 15px;
		width: 36px;
		height: 36px;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 50%;
		background: rgba(255, 255, 255, .08);
		transition: .25s;
	}

	.pd-back:hover {
		background: rgba(255, 255, 255, .18);
		transform: translateX(-2px);
	}

	.pd-header-title {
		color: #fff;
		margin: 0;
		font-size: 22px;
		font-weight: 700;
	}

	/* =========================
   CAROUSEL
========================= */

	.pd-carousel {
		padding: 20px;
	}

	.pd-carousel .carousel-inner {
		background: #fff;
		border-radius: 22px;
		overflow: hidden;
		height: 340px;

		box-shadow:
			0 12px 35px rgba(0, 0, 0, .10);
	}

	.pd-carousel .item {
		height: 340px;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.pd-carousel-image {
		max-width: 100%;
		max-height: 100%;
		object-fit: contain;
		transition: .4s;
	}

	.pd-carousel-image:hover {
		transform: scale(1.05);
	}

	.pd-carousel .carousel-control {
		width: 44px;
		height: 44px;
		border-radius: 50%;
		background: rgba(0, 0, 0, .65);
		top: 50%;
		transform: translateY(-50%);
	}

	.pd-carousel .carousel-control.left {
		left: 12px;
	}

	.pd-carousel .carousel-control.right {
		right: 12px;
	}

	/* =========================
   PRODUCT HERO
========================= */

	.pd-product-hero {
		text-align: center;
		padding: 10px 20px 20px;
	}

	.pd-product-hero h2 {
		font-size: 28px;
		font-weight: 700;
		color: var(--text);
		margin-bottom: 5px;
	}

	.pd-product-hero p {
		color: var(--muted);
	}

	/* =========================
   STATUS
========================= */

	.pd-status-wrap {
		text-align: center;
		margin-bottom: 22px;
	}

	.pd-status {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		padding: 10px 28px;
		border-radius: 50px;
		font-size: 14px;
		font-weight: 700;
	}

	.pd-status-genuine {
		background: #e8f8ef;
		color: var(--success);
		border: 1px solid #cbeed8;
	}

	.pd-status-suspicious {
		background: #fff0f0;
		color: var(--danger);
		border: 1px solid #ffd0d5;
	}

	/* =========================
   TABS
========================= */

	.pd-tabs {
		display: flex;
		justify-content: center;
		gap: 12px;
		border: none;
		margin: 20px;
	}

	.pd-tabs>li {
		float: none;
	}

	.pd-tabs>li>a {
		border: none !important;
		border-radius: 50px;
		padding: 12px 26px;
		background: #fff;
		color: #555;
		font-weight: 600;
		transition: .3s;
		box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
	}

	.pd-tabs>li.active>a {
		background: linear-gradient(135deg, #000, #2e2e2e) !important;
		color: #fff !important;
	}

	.pd-tabs>li>a:hover {
		background: #f1f1f1;
	}

	/* =========================
   PRODUCT INFORMATION CARD
========================= */

	.pd-list {
		padding: 0 15px 20px;
	}

	.pd-info-card {
		background: #fff;
		border-radius: 20px;
		overflow: hidden;

		box-shadow:
			0 12px 35px rgba(0, 0, 0, .08);

		border: 1px solid rgba(0, 0, 0, .05);

		margin-bottom: 25px;
	}

	/* Card Header */

	.pd-card-header {
		padding: 18px 24px;
		background: linear-gradient(135deg, #000, #2a2a2a);
		color: #fff;
	}

	.pd-card-header h3 {
		margin: 0;
		font-size: 18px;
		font-weight: 700;
	}

	.pd-card-header i {
		margin-right: 10px;
	}

	/* Rows */

	.pd-row {
		display: flex;
		justify-content: space-between;
		align-items: center;

		padding: 18px 24px;

		border-bottom: 1px solid #ececec;

		transition: .25s ease;
	}

	.pd-row:last-child {
		border-bottom: none;
	}

	.pd-row:nth-child(even) {
		background: #fafafa;
	}

	.pd-row:hover {
		background: #f7f7f7;
	}

	.pd-row-label {
		width: 40%;
		color: #666;
		font-size: 14px;
		font-weight: 600;
		display: flex;
		align-items: center;
	}

	.pd-row-label i {
		width: 38px;
		height: 38px;
		line-height: 38px;
		text-align: center;

		border-radius: 10px;

		background: #f3f3f3;
		color: var(--accent);

		margin-right: 12px;
		transition: .25s;
	}

	.pd-row:hover .pd-row-label i {
		background: var(--accent);
		color: #fff;
	}

	.pd-row-value {
		width: 60%;
		text-align: right;
		color: #222;
		font-weight: 700;
		font-size: 15px;
	}

	.pd-row-price {
		color: var(--accent);
		font-size: 20px;
		font-weight: 800;
	}

	/* =========================
   BADGES
========================= */

	.pd-badge-success {
		background: #e8f8ef;
		color: var(--success);
		border: 1px solid #cbeed8;
		padding: 6px 14px;
		border-radius: 30px;
		font-size: 13px;
		font-weight: 700;
	}

	.pd-badge-danger {
		background: #fff0f0;
		color: var(--danger);
		border: 1px solid #ffd0d5;
		padding: 6px 14px;
		border-radius: 30px;
		font-size: 13px;
		font-weight: 700;
	}

	/* =========================
   TIMELINE
========================= */

	.pd-timeline {
		padding: 20px;
	}

	.pd-timeline-item {
		display: flex;
		margin-bottom: 20px;
		position: relative;
	}

	.pd-timeline-dot {
		width: 14px;
		height: 14px;
		background: #000;
		border-radius: 50%;
		margin-top: 12px;
		flex-shrink: 0;
	}

	.pd-timeline-content {
		margin-left: 15px;
		padding: 15px;
		background: #fff;
		border-radius: 14px;
		width: 100%;

		border-left: 4px solid var(--accent);

		box-shadow:
			0 4px 14px rgba(0, 0, 0, .05);
	}

	.pd-timeline-action {
		font-weight: 700;
		color: #111;
	}

	.pd-timeline-meta {
		color: #777;
		font-size: 12px;
		margin-top: 5px;
	}

	/* =========================
   VIDEO
========================= */

	video {
		width: 100%;
		border-radius: 15px;
	}

	/* =========================
   MOBILE
========================= */

	@media(max-width:768px) {

		.pd-header-title {
			font-size: 18px;
		}

		.pd-carousel .carousel-inner,
		.pd-carousel .item {
			height: 260px;
		}

		.pd-tabs {
			gap: 8px;
			overflow: auto;
			white-space: nowrap;
		}

		.pd-tabs>li>a {
			padding: 10px 16px;
			font-size: 13px;
		}

		.pd-row {
			flex-direction: column;
			align-items: flex-start;
			padding: 15px;
		}

		.pd-row-label {
			width: 100%;
			margin-bottom: 8px;
		}

		.pd-row-value {
			width: 100%;
			text-align: left;
		}

		.pd-product-hero h2 {
			font-size: 22px;
		}
	}
</style>
@php
$fieldPermissions = json_decode($permissions['field_name']) ?? [];
@endphp

<!-- TOP BAR -->
<div class="pd-header">
	<a href="javascript:history.back()" class="pd-back"><i class="fa fa-arrow-left"></i></a>
	<h2 class="pd-header-title">Product Details</h2>
</div>

<!-- IMAGE CAROUSEL -->
@php
$carouselImages = [];

if(!empty($fieldPermissions) && in_array('Product Image', $fieldPermissions) && !empty($product['image'])) {
$carouselImages[] = $product['image'];
}

if(!empty($fieldPermissions) && in_array('Label Image', $fieldPermissions) && !empty($product['label_image'])) {
$carouselImages[] = $product['label_image'];
}

if(!empty($product['gallery']) && is_array($product['gallery'])) {
foreach($product['gallery'] as $img) {
if(!empty($img)) {
$carouselImages[] = $img;
}
}
}
@endphp

@if(!empty($carouselImages))
<div id="pd-carousel" class="carousel slide pd-carousel" data-ride="carousel">
	<div class="carousel-inner">
		@foreach($carouselImages as $index => $img)
		<div class="item @if($index == 0) active @endif">
			<a href="javascript:void(0)" class="image-link" data-src="{{ $img }}">
				<img
					src="{{ $img }}"
					class="pd-carousel-image"
					onerror="this.onerror=null;this.src='{{ asset('web/images/no-image.png') }}';">
			</a>
		</div>
		@endforeach
	</div>

	@if(count($carouselImages) > 1)
	<a class="left carousel-control" href="#pd-carousel" data-slide="prev">
		<i class="fa fa-chevron-left"></i>
	</a>
	<a class="right carousel-control" href="#pd-carousel" data-slide="next">
		<i class="fa fa-chevron-right"></i>
	</a>

	<ol class="carousel-indicators">
		@foreach($carouselImages as $index => $img)
		<li data-target="#pd-carousel" data-slide-to="{{ $index }}" @if($index==0) class="active" @endif></li>
		@endforeach
	</ol>
	@endif
</div>
@endif

<!-- STATUS BADGE -->
<div class="pd-status-wrap">
	<span class="pd-status @if($product['genuine_product'] == true) pd-status-genuine @else pd-status-suspicious @endif">
		@if ($product['genuine_product'] == true)
		Genuine
		@else
		Suspicious
		@endif
	</span>
</div>

<!-- TABS -->
<ul class="nav nav-tabs pd-tabs">
	<li class="active"><a data-toggle="tab" href="#details">Details</a></li>
	<li><a data-toggle="tab" href="#description">Description</a></li>
	<li><a data-toggle="tab" href="#wallet">Wallet</a></li>
</ul>

<div class="tab-content">

	<!-- DETAILS TAB -->
	<div id="details" class="tab-pane fade in active">
		<div class="pd-list">
			<div class="pd-info-card">

				<div class="pd-card-header">
					<h3>
						<i class="fa fa-cube"></i>
						Product Information
					</h3>
				</div>
				@if(!empty($fieldPermissions) && in_array('Product Name', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-tag"></i> Product Name</div>
					<div class="pd-row-value">{{ $product['name'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Brand', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-building"></i> Brand</div>
					<div class="pd-row-value">{{ $product['brand'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Manufacturer', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-briefcase"></i> Manufacturer</div>
					<div class="pd-row-value">{{ $product['manufacturer'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Price', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-dollar"></i> Price</div>
					<div class="pd-row-value pd-row-price">{{ $product['price'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Tax Class', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-credit-card"></i> Tax Class</div>
					<div class="pd-row-value">{{ $product['tax_class'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Batch Code', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-barcode"></i> Batch Code</div>
					<div class="pd-row-value">{{ $product['batch_code'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Manufactured on', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-calendar"></i> Manufactured on</div>
					<div class="pd-row-value">{{ $product['manufactured_on'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Expiry on', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-calendar-times-o"></i> Expiry on</div>
					<div class="pd-row-value">{{ $product['expiry_on'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Genuine Product', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-check-circle"></i> Genuine Product</div>
					<div class="pd-row-value">{{ $product['genuine_product'] ? 'Yes' : 'No' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Scan Counts', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-qrcode"></i> Scan Counts</div>
					<div class="pd-row-value">{{ $product['scan_count'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Last Scanned', $fieldPermissions))
				<div class="pd-row">
					<div class="pd-row-label"><i class="fa fa-clock-o"></i> Last Scanned</div>
					<div class="pd-row-value">{{ $product['last_scanned'] ?? '' }}</div>
				</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Product Journey', $fieldPermissions))
				@if(!empty($journey))
				<div class="pd-row pd-row-block">
					<div class="pd-row-label"><i class="fa fa-history"></i> Product Journey</div>
					<div class="pd-row-value-block">
						<div class="pd-timeline">
							@foreach($journey as $detail)
							<div class="pd-timeline-item">
								<div class="pd-timeline-dot"></div>
								<div class="pd-timeline-content">
									<div class="pd-timeline-action">{{ ucfirst($detail['action'] ?? '-') }}</div>
									<div class="pd-timeline-meta">Scanned at: {{ $detail['scanned_at'] ?? '' }}</div>
									<div class="pd-timeline-meta">Scanned by: {{ $detail['scanned_by'] ?? '' }}</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				@endif
				@endif

			</div>
		</div>
	</div>

	<!-- DESCRIPTION TAB -->
	<div id="description" class="tab-pane fade">
		<div class="pd-list">

			@if(!empty($fieldPermissions) && in_array('Description', $fieldPermissions))
			<div class="pd-row pd-row-block">
				<div class="pd-row-label"><i class="fa fa-align-left"></i> Description</div>
				<div class="pd-row-value-block">{!! $product['html_description'] ?? '' !!}</div>
			</div>
			@endif

			@if(!empty($fieldPermissions) && in_array('Media', $fieldPermissions))
			<div class="pd-row pd-row-block">
				<div class="pd-row-label"><i class="fa fa-video-camera"></i> Media</div>
				<div class="pd-row-value-block">
					@if ($product['media'])
					<video width="100%" height="200" controls style="max-width:300px; border-radius:8px;">
						<source src="{{ $product['media'] }}" type="video/mp4">
					</video>
					@else
					NA
					@endif
				</div>
			</div>
			@endif

			@if(empty($fieldPermissions) || (!in_array('Description', $fieldPermissions) && !in_array('Media', $fieldPermissions)))
			<div class="pd-row">
				<div class="pd-row-value">NA</div>
			</div>
			@endif

		</div>
	</div>

	<!-- WALLET TAB -->
	<div id="wallet" class="tab-pane fade">
		<div class="pd-list">
			<div class="pd-row">
				<div class="pd-row-label"><i class="fa fa-wallet"></i> Wallet Balance</div>
				<div class="pd-row-value">{{ $wallet_balance ?? '0' }}</div>
			</div>
		</div>
	</div>

</div>

@endif