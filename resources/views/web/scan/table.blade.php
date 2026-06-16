@if (!empty($product))
@php
$fieldPermissions = json_decode($permissions['field_name']) ?? [];
$isGenuine = !empty($product['genuine_product']);

$carouselImages = [];
if (!empty($fieldPermissions) && in_array('Product Image', $fieldPermissions) && !empty($product['image']))
$carouselImages[] = $product['image'];
if (!empty($fieldPermissions) && in_array('Label Image', $fieldPermissions) && !empty($product['label_image']))
$carouselImages[] = $product['label_image'];
if (!empty($product['gallery']) && is_array($product['gallery']))
foreach ($product['gallery'] as $img)
if (!empty($img)) $carouselImages[] = $img;

$hasJourney = !empty($fieldPermissions) && in_array('Product Journey', $fieldPermissions) && !empty($journey);
$hasDescription = !empty($fieldPermissions) && in_array('Description', $fieldPermissions);
$hasMedia = !empty($fieldPermissions) && in_array('Media', $fieldPermissions);
@endphp

<style>
	/* ── Reset inherited scan-minimal constraints ── */
	.scan-minimal {
		align-items: flex-start !important;
		padding: 0 !important;
		background: #f4f5f7 !important
	}

	.scan-minimal::before,
	.scan-minimal::after {
		display: none !important
	}

	.scan-minimal-box {
		max-width: 100% !important;
		width: 100% !important;
		border: none !important;
		border-radius: 0 !important;
		padding: 0 !important;
		box-shadow: none !important;
		background: transparent !important
	}

	.scan-minimal-icon,
	.scan-minimal-sub,
	.scan-minimal-hint,
	.scan-eyebrow,
	.text-bg {
		display: none !important
	}

	/* ── Tokens ── */
	:root {
		--p: #7a0d7d;
		--p-bg: #f5edf5;
		--p-bdr: rgba(122, 13, 125, .20);
		--ok: #1a7a4a;
		--ok-bg: #eaf6f0;
		--ok-bdr: rgba(26, 122, 74, .22);
		--err: #c0392b;
		--err-bg: #fdecea;
		--err-bdr: rgba(192, 57, 43, .22);
		--bg: #f4f5f7;
		--surf: #ffffff;
		--bdr: rgba(0, 0, 0, .07);
		--bdr2: rgba(0, 0, 0, .13);
		--tx: #111;
		--tx2: #555;
		--tx3: #999;
	}

	/* ── Page ── */
	.pd-page {
		font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
		background: var(--bg);
		min-height: 100vh;
		color: var(--tx)
	}

	/* ── Topbar ── */
	.pd-topbar {
		display: flex;
		align-items: center;
		gap: 14px;
		padding: 0 32px;
		height: 56px;
		background: var(--surf);
		border-bottom: 1px solid var(--bdr);
		position: sticky;
		top: 0;
		z-index: 200
	}

	.pd-back-btn {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 13px;
		font-weight: 500;
		color: var(--tx2);
		text-decoration: none;
		padding: 6px 12px;
		border-radius: 7px;
		border: 1px solid var(--bdr2);
		background: var(--surf);
		cursor: pointer;
		transition: background .15s
	}

	.pd-back-btn:hover {
		background: var(--bg)
	}

	.pd-topbar-title {
		font-size: 15px;
		font-weight: 600;
		color: var(--tx);
		flex: 1
	}

	.pd-topbar-pill {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 12px;
		font-weight: 600;
		padding: 5px 14px;
		border-radius: 20px
	}

	.pd-topbar-pill.genuine {
		background: var(--ok-bg);
		color: var(--ok);
		border: 1px solid var(--ok-bdr)
	}

	.pd-topbar-pill.suspect {
		background: var(--err-bg);
		color: var(--err);
		border: 1px solid var(--err-bdr)
	}

	/* ── Wrap ── */
	.pd-wrap {
		max-width: 1100px;
		margin: 0 auto;
		padding: 28px 32px 60px
	}

	/* ── Hero ── */
	.pd-hero {
		display: grid;
		grid-template-columns: 340px 1fr;
		background: var(--surf);
		border: 1px solid var(--bdr);
		border-radius: 14px;
		overflow: hidden;
		margin-bottom: 24px
	}

	.pd-hero-img {
		background: var(--p-bg);
		border-right: 1px solid var(--bdr);
		min-height: 300px;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		position: relative
	}

	.pd-hero-info {
		padding: 28px 32px;
		display: flex;
		flex-direction: column
	}

	.pd-hero-mfr {
		font-size: 12px;
		color: var(--tx3);
		margin-bottom: 4px
	}

	.pd-hero-name {
		font-size: 22px;
		font-weight: 700;
		color: var(--tx);
		line-height: 1.3;
		margin-bottom: 16px
	}

	.pd-hero-price-row {
		display: flex;
		align-items: baseline;
		gap: 8px;
		margin-bottom: 4px
	}

	.pd-hero-price {
		font-size: 30px;
		font-weight: 700;
		color: var(--p)
	}

	.pd-hero-price-note {
		font-size: 12px;
		color: var(--tx3)
	}

	.pd-hero-div {
		height: 1px;
		background: var(--bdr);
		margin: 20px 0
	}

	.pd-quick-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 10px;
		margin-bottom: 20px
	}

	.pd-qcell {
		background: var(--bg);
		border-radius: 8px;
		padding: 10px 14px;
		border: 1px solid var(--bdr)
	}

	.pd-qlbl {
		font-size: 11px;
		color: var(--tx3);
		margin-bottom: 3px
	}

	.pd-qval {
		font-size: 13px;
		font-weight: 600;
		color: var(--tx)
	}

	.pd-status-row {
		display: flex;
		align-items: center;
		gap: 8px;
		padding: 12px 16px;
		border-radius: 9px;
		font-size: 13px;
		font-weight: 600
	}

	.pd-status-row.genuine {
		background: var(--ok-bg);
		color: var(--ok);
		border: 1px solid var(--ok-bdr)
	}

	.pd-status-row.suspect {
		background: var(--err-bg);
		color: var(--err);
		border: 1px solid var(--err-bdr)
	}

	/* ── Carousel ── */
	.pd-car-inner {
		width: 100%;
		height: 300px;
		position: relative;
		overflow: hidden
	}

	.pd-slide {
		position: absolute;
		inset: 0;
		display: flex;
		align-items: center;
		justify-content: center;
		opacity: 0;
		transition: opacity .3s;
		pointer-events: none
	}

	.pd-slide.pd-on {
		opacity: 1;
		pointer-events: auto
	}

	.pd-slide img {
		max-width: 100%;
		max-height: 100%;
		object-fit: contain
	}

	.pd-no-img {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 8px;
		color: var(--p);
		opacity: .25
	}

	.pd-no-img i {
		font-size: 56px
	}

	.pd-no-img span {
		font-size: 12px
	}

	.pd-car-nav {
		position: absolute;
		bottom: 12px;
		left: 0;
		right: 0;
		display: flex;
		justify-content: center;
		gap: 6px;
		z-index: 2
	}

	.pd-car-dot {
		width: 7px;
		height: 7px;
		border-radius: 50%;
		background: rgba(122, 13, 125, .25);
		border: none;
		cursor: pointer;
		padding: 0;
		transition: background .2s
	}

	.pd-claim-btn {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		font-size: 14px;
		font-weight: 600;
		padding: 10px 20px;
		border-radius: 9px;
		border: 1px solid var(--p-bdr);
		background: var(--p-bg);
		color: var(--p);
		cursor: pointer;
		font-family: inherit;
		transition: opacity .15s;
	}

	.pd-claim-btn:hover {
		opacity: .8
	}
					
	.pd-car-dot.pd-on {
		background: var(--p)
	}

	.pd-car-arr {
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		width: 30px;
		height: 30px;
		border-radius: 50%;
		background: rgba(255, 255, 255, .9);
		border: 1px solid var(--bdr2);
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 13px;
		color: var(--tx2);
		cursor: pointer;
		z-index: 2
	}

	.pd-car-arr.prev {
		left: 10px
	}

	.pd-car-arr.next {
		right: 10px
	}

	/* ── Stat bar ── */
	.pd-statbar {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		background: var(--surf);
		border: 1px solid var(--bdr);
		border-radius: 14px;
		overflow: hidden;
		margin-bottom: 24px
	}

	.pd-topbar-title {
		display: flex;
		align-items: center;
		gap: 10px;
		font-size: 20px;
		font-weight: 700;
		color: #111;
	}

	.pd-brand-logo {
		height: 40px;
		width: auto;
		max-width: 120px;
		object-fit: contain;
	}

	.pd-statcell {
		padding: 20px 24px;
		text-align: center;
		border-right: 1px solid var(--bdr)
	}

	.pd-statcell:last-child {
		border-right: none
	}

	.pd-stat-num {
		font-size: 26px;
		font-weight: 700;
		color: var(--p);
		line-height: 1;
		margin-bottom: 4px
	}

	.pd-stat-lbl {
		font-size: 12px;
		color: var(--tx3)
	}

	/* ── Tabs ── */
	.pd-tabs-nav {
		display: flex;
		gap: 2px;
		border-bottom: 1px solid var(--bdr);
		margin-bottom: 24px;
		background: var(--surf);
		border-radius: 14px 14px 0 0;
		padding: 0 8px;
		overflow-x: auto
	}

	.pd-tabs-nav::-webkit-scrollbar {
		display: none
	}

	.pd-tab-link {
		padding: 14px 22px;
		font-size: 14px;
		font-weight: 500;
		color: var(--tx3);
		border: none;
		background: none;
		cursor: pointer;
		border-bottom: 2.5px solid transparent;
		white-space: nowrap;
		font-family: inherit;
		transition: color .15s, border-color .15s;
		margin-bottom: -1px
	}

	.pd-tab-link:focus {
		outline: none
	}

	.pd-tab-link:hover {
		color: var(--tx2)
	}

	.pd-tab-link.pd-on {
		color: var(--p);
		border-bottom-color: var(--p);
		font-weight: 600
	}

	.pd-tab-panel {
		display: none
	}

	.pd-tab-panel.pd-on {
		display: block
	}

	/* ── Section title ── */
	.pd-sec-title {
		font-size: 11px;
		font-weight: 600;
		letter-spacing: .08em;
		text-transform: uppercase;
		color: var(--tx3);
		margin-bottom: 12px;
		padding-bottom: 10px;
		border-bottom: 1px solid var(--bdr)
	}

	/* ── Field grid ── */
	.pd-field-grid {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 1px;
		background: var(--bdr);
		border: 1px solid var(--bdr);
		border-radius: 12px;
		overflow: hidden;
		margin-bottom: 24px
	}

	.pd-fcell {
		background: var(--surf);
		padding: 16px 20px
	}

	.pd-flbl {
		display: flex;
		align-items: center;
		gap: 6px;
		font-size: 11px;
		color: var(--tx3);
		margin-bottom: 5px
	}

	.pd-flbl i {
		font-size: 13px;
		color: var(--p);
		opacity: .65
	}

	.pd-fval {
		font-size: 14px;
		font-weight: 600;
		color: var(--tx)
	}

	.pd-fval.price {
		font-size: 17px;
		color: var(--p)
	}

	.pd-fval.ok {
		color: var(--ok)
	}

	.pd-fval.err {
		color: var(--err)
	}

	/* ── Journey ── */
	.pd-journey-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
		gap: 14px;
		margin-bottom: 24px
	}

	.pd-jcard {
		background: var(--surf);
		border: 1px solid var(--bdr);
		border-radius: 12px;
		padding: 18px 20px;
		border-left: 3px solid var(--p)
	}

	.pd-jstep {
		display: inline-block;
		font-size: 10px;
		font-weight: 700;
		letter-spacing: .06em;
		color: var(--p);
		background: var(--p-bg);
		border-radius: 20px;
		padding: 3px 10px;
		margin-bottom: 10px
	}

	.pd-jaction {
		font-size: 14px;
		font-weight: 700;
		color: var(--tx);
		margin-bottom: 8px
	}

	.pd-jmeta {
		font-size: 12px;
		color: var(--tx3);
		line-height: 1.75
	}

	/* ── Description ── */
	.pd-desc-card {
		background: var(--surf);
		border: 1px solid var(--bdr);
		border-radius: 12px;
		padding: 24px;
		font-size: 14px;
		color: var(--tx2);
		line-height: 1.85;
		margin-bottom: 20px
	}

	.pd-media-wrap {
		background: var(--p-bg);
		border: 1px solid var(--p-bdr);
		border-radius: 12px;
		overflow: hidden;
		margin-bottom: 20px
	}

	.pd-media-wrap video {
		width: 100%;
		display: block
	}

	.pd-media-empty {
		height: 90px;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		font-size: 13px;
		color: var(--p);
		opacity: .5
	}

	/* ── Wallet ── */
	.pd-wallet-card {
		background: var(--surf);
		border: 1px solid var(--bdr);
		border-radius: 14px;
		padding: 26px 30px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		max-width: 520px
	}

	.pd-wallet-lbl {
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 1.2px;
		color: var(--tx3);
		margin-bottom: 10px
	}

	.pd-wallet-amt {
		font-size: 42px;
		font-weight: 800;
		line-height: 1;
		letter-spacing: -1px;
		color: var(--tx)
	}

	/* ── Footer ── */
	.pd-foot-hint {
		text-align: center;
		font-size: 12px;
		color: var(--tx3);
		margin-top: 40px;
		padding-top: 20px;
		border-top: 1px solid var(--bdr);
		line-height: 1.7
	}

	/* ── Responsive ── */
	@media(max-width:900px) {
		.pd-hero {
			grid-template-columns: 1fr
		}

		.pd-hero-img {
			border-right: none;
			border-bottom: 1px solid var(--bdr)
		}

		.pd-hero-info {
			padding: 20px
		}

		.pd-field-grid {
			grid-template-columns: repeat(2, 1fr)
		}

		.pd-wrap {
			padding: 20px 20px 40px
		}

		.pd-topbar {
			padding: 0 20px
		}
	}

	@media(max-width:600px) {
		.pd-field-grid {
			grid-template-columns: 1fr
		}

		.pd-statbar {
			grid-template-columns: 1fr
		}

		.pd-statcell {
			border-right: none;
			border-bottom: 1px solid var(--bdr)
		}

		.pd-statcell:last-child {
			border-bottom: none
		}

		.pd-wallet-card {
			padding: 22px 20px;
			max-width: 100%
		}

		.pd-wallet-amt {
			font-size: 34px
		}

		.pd-tabs-nav {
			border-radius: 0
		}
	}
</style>

<div class="pd-page" id="pd-page-root">

	{{-- TOPBAR --}}
	<div class="pd-topbar">

		<div class="pd-topbar-title">
			@if(!empty($product['logo']))
			<img src="{{ $product['logo'] }}" alt="" class="pd-brand-logo">
			@endif

			<span>{{ $product['brand'] ?? '--' }}</span>
		</div>
		<div class="pd-topbar-pill {{ $isGenuine ? 'genuine' : 'suspect' }}">
			<i class="fa fa-{{ $isGenuine ? 'shield' : 'exclamation-triangle' }}"></i>
			{{ $isGenuine ? 'Genuine Product' : 'Suspicious' }}
		</div>
	</div>

	<div class="pd-wrap">

		{{-- ═══ HERO ═══ --}}
		<div class="pd-hero">

			{{-- Image / Carousel --}}
			<div class="pd-hero-img">
				@if(count($carouselImages) > 0)
				<div class="pd-car-inner" id="pd-car">
					@foreach($carouselImages as $i => $img)
					<div class="pd-slide {{ $i === 0 ? 'pd-on' : '' }}">
						<img src="{{ $img }}"
							alt="Product image {{ $i + 1 }}"
							onerror="this.onerror=null;this.src='{{ asset('web/images/no-image.png') }}';">
					</div>
					@endforeach
				</div>
				@if(count($carouselImages) > 1)
				<button class="pd-car-arr prev" onclick="pdCarMove(-1)" aria-label="Previous">
					<i class="fa fa-chevron-left"></i>
				</button>
				<button class="pd-car-arr next" onclick="pdCarMove(1)" aria-label="Next">
					<i class="fa fa-chevron-right"></i>
				</button>
				<div class="pd-car-nav">
					@foreach($carouselImages as $i => $img)
					<button class="pd-car-dot {{ $i === 0 ? 'pd-on' : '' }}"
						onclick="pdCarGo({{ $i }})"
						aria-label="Image {{ $i + 1 }}"></button>
					@endforeach
				</div>
				@endif
				@else
				<div class="pd-no-img">
					<i class="fa fa-image"></i>
					<span>No image</span>
				</div>
				@endif
			</div>

			{{-- Info --}}
			<div class="pd-hero-info">
				@if(!empty($fieldPermissions) && in_array('Manufacturer', $fieldPermissions) && !empty($product['manufacturer']))
				<div class="pd-hero-mfr">{{ $product['manufacturer'] }}</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Product Name', $fieldPermissions) && !empty($product['name']))
				<div class="pd-hero-name">{{ $product['name'] }}</div>
				@endif

				@if(!empty($fieldPermissions) && in_array('Price', $fieldPermissions) && !empty($product['price']))
				<div class="pd-hero-price-row">
					<div class="pd-hero-price">{{ $product['price'] }}</div>
					<div class="pd-hero-price-note">MRP incl. taxes</div>
				</div>
				@endif

				<div class="pd-hero-div"></div>

				<div class="pd-quick-grid">
					@if(!empty($fieldPermissions) && in_array('Brand', $fieldPermissions))
					<div class="pd-qcell">
						<div class="pd-qlbl">Brand</div>
						<div class="pd-qval">{{ $product['brand'] ?? '—' }}</div>
					</div>
					@endif
					@if(!empty($fieldPermissions) && in_array('Batch Code', $fieldPermissions))
					<div class="pd-qcell">
						<div class="pd-qlbl">Batch Code</div>
						<div class="pd-qval">{{ $product['batch_code'] ?? '—' }}</div>
					</div>
					@endif
					@if(!empty($fieldPermissions) && in_array('Manufactured on', $fieldPermissions))
					<div class="pd-qcell">
						<div class="pd-qlbl">Manufactured</div>
						<div class="pd-qval">{{ $product['manufactured_on'] ?? '—' }}</div>
					</div>
					@endif
					@if(!empty($fieldPermissions) && in_array('Expiry on', $fieldPermissions))
					<div class="pd-qcell">
						<div class="pd-qlbl">Expires</div>
						<div class="pd-qval">{{ $product['expiry_on'] ?? '—' }}</div>
					</div>
					@endif
				</div>

				<div class="pd-status-row {{ $isGenuine ? 'genuine' : 'suspect' }}">
					<i class="fa fa-{{ $isGenuine ? 'check-circle' : 'times-circle' }}"></i>
					{{ $isGenuine ? 'This product is verified genuine.' : 'This product appears suspicious. Please report it.' }}
				</div>
			</div>
		</div>

		{{-- ═══ STAT BAR ═══ --}}
		@php
		$showStatBar = !empty($fieldPermissions) && (
		in_array('Scan Counts', $fieldPermissions) ||
		in_array('Last Scanned', $fieldPermissions) ||
		in_array('Genuine Product', $fieldPermissions)
		);
		@endphp
		@if($showStatBar)
		<div class="pd-statbar">
			@if(in_array('Scan Counts', $fieldPermissions))
			<div class="pd-statcell">
				<div class="pd-stat-num">{{ $product['scan_count'] ?? '0' }}</div>
				<div class="pd-stat-lbl">Total Scans</div>
			</div>
			@endif
			@if(in_array('Last Scanned', $fieldPermissions))
			<div class="pd-statcell">
				<div class="pd-stat-num" style="font-size:15px;padding-top:6px">{{ $product['last_scanned'] ?? '—' }}</div>
				<div class="pd-stat-lbl">Last Scanned</div>
			</div>
			@endif
			@if(in_array('Genuine Product', $fieldPermissions))
			<div class="pd-statcell">
				<div class="pd-stat-num" style="font-size:15px;padding-top:6px;color:{{ $isGenuine ? 'var(--ok)' : 'var(--err)' }}">
					{{ $isGenuine ? 'Genuine' : 'Suspicious' }}
				</div>
				<div class="pd-stat-lbl">Authenticity</div>
			</div>
			@endif
		</div>
		@endif
		{{-- ═══ TABS NAV ═══ --}}
		<div class="pd-tabs-nav" id="pd-tabs-nav">
			<button class="pd-tab-link pd-on" data-pd-tab="details">
				<i class="fa fa-cube"></i> Details
			</button>
			@if($hasJourney)
			<button class="pd-tab-link" data-pd-tab="journey">
				<i class="fa fa-history"></i> Journey
			</button>
			@endif
			<button class="pd-tab-link" data-pd-tab="description">
				<i class="fa fa-align-left"></i> Description
			</button>
			<button class="pd-tab-link" data-pd-tab="wallet">
				<i class="fa fa-wallet"></i> Wallet
			</button>

			{{-- Report button sits at the end of the tab bar --}}
			<button class="pd-tab-link pd-report-btn" style="margin-left:auto;color:var(--err);"
				data-product="{{ $product['id'] ?? '' }}"
				data-batch="{{ $product['batch_code'] ?? '' }}">
				<i class="fa fa-flag"></i> Report
			</button>
		</div>

		{{-- ═══ DETAILS PANEL ═══ --}}
		<div id="pd-tab-details" class="pd-tab-panel pd-on">
			<div class="pd-sec-title">Product Information</div>
			<div class="pd-field-grid">
				@if(!empty($fieldPermissions) && in_array('Product Name', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-tag"></i> Product Name</div>
					<div class="pd-fval">{{ $product['name'] ?? '—' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Brand', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-building"></i> Brand</div>
					<div class="pd-fval">{{ $product['brand'] ?? '—' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Manufacturer', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-briefcase"></i> Manufacturer</div>
					<div class="pd-fval">{{ $product['manufacturer'] ?? '—' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Price', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-dollar"></i> Price</div>
					<div class="pd-fval price">{{ $product['price'] ?? '—' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Tax Class', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-credit-card"></i> Tax Class</div>
					<div class="pd-fval">{{ $product['tax_class'] ?? '—' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Batch Code', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-barcode"></i> Batch Code</div>
					<div class="pd-fval">{{ $product['batch_code'] ?? '—' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Manufactured on', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-calendar"></i> Manufactured On</div>
					<div class="pd-fval">{{ $product['manufactured_on'] ?? '—' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Expiry on', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-calendar-times-o"></i> Expiry On</div>
					<div class="pd-fval">{{ $product['expiry_on'] ?? '—' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Genuine Product', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-check-circle"></i> Genuine Product</div>
					<div class="pd-fval {{ $isGenuine ? 'ok' : 'err' }}">{{ $isGenuine ? 'Yes' : 'No' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Scan Counts', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-qrcode"></i> Scan Count</div>
					<div class="pd-fval">{{ $product['scan_count'] ?? '—' }}</div>
				</div>
				@endif
				@if(!empty($fieldPermissions) && in_array('Last Scanned', $fieldPermissions))
				<div class="pd-fcell">
					<div class="pd-flbl"><i class="fa fa-clock-o"></i> Last Scanned</div>
					<div class="pd-fval">{{ $product['last_scanned'] ?? '—' }}</div>
				</div>
				@endif
			</div>
		</div>

		{{-- ═══ JOURNEY PANEL ═══ --}}
		@if($hasJourney)
		<div id="pd-tab-journey" class="pd-tab-panel">
			<div class="pd-sec-title">Product Journey</div>
			<div class="pd-journey-grid">
				@foreach($journey as $idx => $detail)
				<div class="pd-jcard">
					<div class="pd-jstep">Step {{ $idx + 1 }}</div>
					<div class="pd-jaction">{{ ucfirst($detail['action'] ?? '—') }}</div>
					<div class="pd-jmeta">
						<i class="fa fa-clock-o"></i> {{ $detail['scanned_at'] ?? '—' }}<br>
						<i class="fa fa-user"></i> {{ $detail['scanned_by'] ?? '—' }}
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif

		{{-- ═══ DESCRIPTION PANEL ═══ --}}
		<div id="pd-tab-description" class="pd-tab-panel">
			@if($hasDescription)
			<div class="pd-sec-title">Description</div>
			<div class="pd-desc-card">{!! $product['html_description'] ?? '<em>No description available.</em>' !!}</div>
			@endif
			@if($hasMedia)
			<div class="pd-sec-title">Media</div>
			<div class="pd-media-wrap">
				@if(!empty($product['media']))
				<video controls>
					<source src="{{ $product['media'] }}" type="video/mp4">
					Your browser does not support video playback.
				</video>
				@else
				<div class="pd-media-empty">
					<i class="fa fa-video-camera"></i> No media attached
				</div>
				@endif
			</div>
			@endif
			@if(!$hasDescription && !$hasMedia)
			<p style="color:var(--tx3);font-size:14px;text-align:center;padding:40px 0">No description available.</p>
			@endif
		</div>

		{{-- ═══ WALLET PANEL ═══ --}}
		<div id="pd-tab-wallet" class="pd-tab-panel">
			<div class="pd-sec-title">Wallet</div>
			<div class="pd-wallet-card">
				<div>
					<div class="pd-wallet-lbl">AVAILABLE BALANCE</div>
					<div class="pd-wallet-amt" id="wallet_balance">{{ $wallet_balance ?? '0' }}</div>
				</div>
			</div>
			<button class="pd-claim-btn" style="margin-top:16px;">
				<i class="fa fa-gift"></i> Claim Reward
			</button>
		</div>

		<div class="pd-foot-hint">
			Your location may be used to verify product journey and detect counterfeit activity.
		</div>

	</div>{{-- /.pd-wrap --}}
</div>{{-- /.pd-page --}}

@endif