@if (!empty($product))
<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#product" class="btn btn-primary">Product</a></li>
	<li><a data-toggle="tab" href="#wallet" class="btn btn-primary">Wallet</a></li>
</ul>

<div class="tab-content mt-4">
	<div id="product" class="tab-pane fade in active">
		<h3 class="w-full my-4 text-2xl px-2" style="margin:25px 0;">
			@if ($product['genuine_product']==true)
			This product is genuine : 
			@else
			Suspicious product
			@endif
		</h3>
		<table class="table w-full border">
			<tr>
				<th class="px-2"><strong>Product Name</strong></th>
				<th class="px-2">{{$product['name']??''}}</th>
			</tr>
			<tr>
				<th class="px-2"><strong>Brand</strong></th>
				<th class="px-2">{{$product['brand']??''}}</th>
			</tr>

			<tr>
				<th class="px-2"><strong>Price</strong></th>
				<th class="px-2">{{$product['price']??''}}</th>
			</tr>
			<tr>
				<th class="px-2"><strong>Scan Counts</strong></th>
				<th class="px-2">{{$product['scan_count']??''}}</th>
			</tr>

			<tr>
				<th class="px-2"><strong>Last Scanned</strong></th>
				<th class="px-2">{{$product['last_scanned']??''}}</th>
			</tr>
			<tr>
				<th class="px-2"><strong>Batch Code</strong></th>
				<th class="px-2">{{$product['batch_code']??''}}</th>
			</tr>

<!-- 			<tr>
				<th class="px-2"><strong>Manufacturer Name</strong></th>
				<th class="px-2">{{$product['manufacturer']??''}}</th>
			</tr> -->
			<tr>
				<th class="px-2"><strong>Manufactured on</strong></th>
				<th class="px-2">{{$product['manufactured_on']??''}}</th>
			</tr>

			<tr>
				<th class="px-2"><strong>Expiry on</strong></th>
				<th class="px-2">{{$product['expiry_on']??''}}</th>
			</tr>
			<tr>
				<th class="px-2"><strong>Genuine Product</strong></th>
				<th class="px-2">{{$product['genuine_product']==true?'Yes':'No'}}</th>
			</tr>

			<tr>
				<th class="px-2"><strong>Product Image</strong></th>
				<th class="px-2">

					@if ($product['image'])
					<a href="javascript:void(0)" class="image-link" data-toggle="modal" data-target="#image-modal" data-src="{{$product['image']}}">
						<img src="{{$product['image']}}" class="img-thumbnail" style="max-height:100px;" alt="">
					</a>
					@else
					NA
					@endif

				</th>
			</tr>
			<tr>
				<th class="px-2"><strong>Label Image</strong></th>
				<th class="px-2">

					@if ($product['label_image'])
					<a href="javascript:void(0)" class="image-link" data-toggle="modal" data-target="#image-modal" data-src="{{$product['label_image']}}">
						<img src="{{$product['label_image']}}" class="img-thumbnail" style="max-height:100px;" alt="">
					</a>
					@else
					NA
					@endif

				</th>
			</tr>

			<tr>
				<th class="px-2"><strong>Media</strong></th>
				<th class="px-2">
					@if ($product['media'])
					<video width="200" height="150" controls autoplay muted>
						<source src="{{$product['media']}}" type="video/mp4">
							<source src="{{$product['media']}}" type="video/ogg">
								Your browser does not support the video tag.
							</video>
					@else
					NA
					@endif
				</th>
			</tr>

			<tr>
				<th class="px-2"><strong>Description</strong></th>
				<th class="px-2">{!!$product['html_description']??''!!}</th>
			</tr>

			<tr>
				<th class="px-2">
					Product Journey
				</th>
				<th class="px-2">
					@if(!empty($journey) && count($journey)>0)
					<div class="row m-0">
						@foreach($journey as $key=>$detail)
						<div class="col-sm-12 p-0">
							{{__('ACTION')}} : <span class="font-bold text-red-900 ml-2">{{$detail['action']?ucfirst($detail['action']):'-'}}</span><br>
							{{__('SCANNED AT')}} : <span class="font-bold ml-2">{{$detail['scanned_at']??''}}</span><br>
							{{__('SCANNED BY')}} : <span class="font-bold ml-2">{{$detail['scanned_by']??''}}</span><br>
							<hr>
						</div>
						@endforeach
					</div>
					@else
					NA
					@endif
				</th>
			</tr>

		</table>

		<div class="mt-4">
			<h5>Do you have any issue related with this product ? Please <a href="javascript:void(0)" class="report-link" data-toggle="modal" data-target="#report-modal" data-product="{{$product['id']}}" data-batch="{{$product['batch']}}"> Click Here </a> to register your report.</h5>
		</div>
	</div>
	<div id="wallet" class="tab-pane fade">

		@php
		$wallet_balance = getWalletBalance($user->id,$product['brand']??null);
		$reward_scheme  = codeDataRewardScheme($product['code_data']);
		@endphp

		<h3 class="w-full my-4 text-2xl px-2" style="margin:25px 0;">
			Reward Points Available : <span id="wallet_balance">{{$wallet_balance}}</span>
		</h3>

		@if($reward_scheme)		

		<div class="row claim-div">
			<div class="col-sm-12 mb-2">
				<button type="button" class="btn btn-sm" id="redeem-menu">Redeem Rewards</button>
			</div>
			<div class="col-sm-12">
				<h3 class="w-full my-4 text-2xl px-2" style="margin:25px 0;">
					Claim Reward Points
				</h3>
			</div>

			<div class="col-sm-4">
				<input type="text" class="form-control" style="margin-top: 10px;" id="coupon_code" placeholder="Enter secret pin">
				<div id="redeem-message"></div>
			</div>
			<div class="col-sm-2">
				<a href="javascript:;" class="redeem-points btn btn-primary" style="margin-top: 10px;" data-scan="{{$product['scan_id']}}">Claim Points</a>
			</div>

			<div class="col-sm-12 table-responsive">
				<h4 class="w-full my-4 text-xl px-2" style="margin:25px 0;">
					Wallet history
				</h4>

				<table class="table w-full border table-striped">
					<thead>
						<th class="text-center border border-slate-600">Date</th>
						<th class="text-center border border-slate-600">Code Data</th>
						<th class="text-center border border-slate-600">Product</th>
						<th class="text-center border border-slate-600">Type</th>
						<th class="text-center border border-slate-600">Points</th>
						<th class="text-center border border-slate-600">Amount</th>
						<th class="text-center border border-slate-600">Txn Id</th>
					</thead>

					<tbody>

						@forelse(getWalletHistory($user->id,$product['brand']??null) as $key=>$transaction)

						<tr>
							<td class="text-center border border-slate-600">{{date('d M, Y',strtotime($transaction->created_at))}}</td>
							<td class="text-center border border-slate-600">{{$transaction->getScan->getCode->code_data??'NA'}}</td>
							<td class="text-center border border-slate-600">{{$transaction->getScan->getCode->getProduct->name??'NA'}}</td>
							<td class="text-center border border-slate-600">{{ucfirst($transaction->type)}}</td>
							<td class="text-center border border-slate-600">{{$transaction->points}}</td>
							<td class="text-center border border-slate-600">{{$transaction->amount??'NA'}}</td>
							<td class="text-center border border-slate-600">{{$transaction->transaction_id??'NA'}}</td>
						</tr>

						@empty
						<tr>
							<td colspan="7" class="text-center border border-slate-600"> No transactions Available</td>
						</tr>
						@endforelse

						<tr>
							<td colspan="1" style="text-align:right;">Credit Points : {{getWalletData($user->id,$product['brand']??null)['credit']}}</td>
							<td colspan="1" style="text-align:right;">Debit Points : {{getWalletData($user->id,$product['brand']??null)['debit']}}</td>
							<td colspan="5" style="text-align:right;">Wallet Balance : {{getWalletData($user->id,$product['brand']??null)['balance']}}</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>

		@php
		$items = json_decode($reward_scheme->items,true);
		@endphp

		@if(!empty($items))
		<div class="row mt-3 redeem-div" style="display:none;">
			<div class="col-sm-12 mb-2">
				<button type="button" class="btn btn-sm" id="claim-menu">Claim Rewards</button>
			</div>
			<div class="col-sm-12">
				<h3 class="w-full my-4 text-2xl px-2" style="margin:25px 0;">
					Redeem Rewards
				</h3>
			</div>
			@foreach($items as $key=>$item)
			<div class="col-sm-3">
				<div style="border: 1px solid #ccc; padding: 30px 10px; text-align: center;">
					@if($item['type']=='amount')
					<span>Redeem amount {{$item['item']}} for  {{$item['points']}} points.</span>
					@else
					<span>{{$item['item']}} for  {{$item['points']}} points.</span>
					@endif
					<br>
					<a href="javascript:;" data-toggle="modal" data-target="{{$item['type']=='amount'?'#reward-modal':'#address-modal'}}" class="redeem btn btn-primary" data-type="{{$item['type']}}" data-points="{{$item['points']}}" data-scheme="{{$reward_scheme->id}}" data-brand="{{$product['brand']??''}}" style="margin-top:10px;">Redeem Now</a>
				</div>
			</div>
			@endforeach
		</div>

		@endif
		@endif

	</div>
</div>
@endif