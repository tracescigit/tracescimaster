@extends('vendor.layout.' . $layout)

@section('subhead')
<title>View Scheme - TRACESCI</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<div class="intro-y box">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Scheme details</h2>
			</div>
			<div class="p-5">

				<div class="grid grid-cols-12">

					<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
						<div class=" w-full flex flex-col sm:flex-row">
							Scheme Title: {{$scheme->title}}
						</div>
						<div id="error-title" class="login__input-error w-5/6 text-theme-6"></div>
					</div>

					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						<div class="w-full flex flex-col sm:flex-row">
							From Date:  {{$scheme->from}} 
						</div>
						<div id="error-from" class="login__input-error w-5/6 text-theme-6"></div>
					</div>

					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						<div class="w-full flex flex-col sm:flex-row">
							To Date: {{$scheme->to}}
						</div>
						<div id="error-to" class="login__input-error w-5/6 text-theme-6"></div>
					</div>

					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						<div class="w-full flex flex-col sm:flex-row">
							Allow Single User to Win Multiple: {{$scheme->allow_multiple}} 
						</div>
					</div>

					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						Status: {{$scheme->status}}
					</div>

					@if ($scheme->product_selection_type=='product')
					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						Product: {{$scheme->getProduct->name??''}}
					</div>
					@elseif($scheme->product_selection_type=='batch')
					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						Product: {{$scheme->getProduct->name??''}}
					</div>
					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						Batch: {{$scheme->getBatch->code??''}}
					</div>
					@endif

				</div>
			</div>
		</div>

		@if ($scheme->product_selection_type=='chunk')
		<div class="intro-y box mt-4">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Codes Details</h2>
			</div>
			<div class="p-5 codes-area">
				@php
				$codes = json_decode($scheme->codes,true);
				@endphp

				@if (!empty($codes))
				@foreach ($codes as $key =>  $code)
				<p class="mb-2">
					{{$key+1}}. <strong>{{$code['from']}} - {{$code['to']}}</strong>
				</p>
				@endforeach
				@endif
			</div>
		</div>
		@endif

		<div class="intro-y box mt-4">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Prizes Details</h2>
			</div>
			<div class="p-5 prizes-area">
				@php
				$items = json_decode($scheme->items,true);
				@endphp

				@if (!empty($items))
				@foreach ($items as $key =>  $item)
				<p class="mb-2">
					{{$key+1}}. <strong>{{$item['item']}} - {{$item['quantity']}}</strong>
				</p>
				@endforeach
				@endif
			</div>
		</div>

		@if (strtotime('now')>strtotime($scheme->to_date) && ($scheme->status=='Finalized' || $scheme->status=='Executed'))
		<div class="intro-y box mt-4">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Winners</h2>
				<div class="flex mt-5 sm:mt-0">
					<button id="export" onclick="exportReportToExcel()" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
						<i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export
					</button>
				</div>
			</div>	
			<div class="p-5">
				<table class="table border-collapse border border-slate-500">
					<thead>
						<tr>
							<th class="border text-center border-slate-600">S. No.</th>
							<th class="border text-center border-slate-600">User</th>
							<th class="border text-center border-slate-600">Mobile No</th>
							<th class="border text-center border-slate-600">Code Data</th>
							<th class="border text-center border-slate-600">Winning Item</th>
						</tr>
					</thead>

					<tbody>
						@forelse($winners as $key=>$win)

						<tr>
							<td class="text-center border border-slate-600">{{$key+1}}</td>
							<td class="text-center border border-slate-600">{{$win->getWinner->name??'NA'}}</td>
							<td class="text-center border border-slate-600">{{$win->getWinner->phone??'NA'}}</td>
							<td class="text-center border border-slate-600">{{$win->getScan->getCode->code_data??'NA'}}</td>
							<td class="text-center border border-slate-600">{{$win->item}}</td>
						</tr>

						@empty
						<tr>
							<td colspan="5" class="text-center border border-slate-600"> No Winners Available</td>
						</tr>
						@endforelse
					</tbody>	

				</table>
			</div>
		</div>
		@endif

		<div class="intro-y box mt-4">
			<div class="p-5">
				<div class="grid grid-cols-12">	
					<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-3" id="buttonAction">

						@if (strtotime('now')>strtotime($scheme->to) && $scheme->status!='Finalized')
						<a href="{{ url('vendor/schemes/'.encrypt($scheme->id).'/execute') }}" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top" id="Executed">
							@if ($scheme->status!='Executed')
							Execute
							@else
							Reshuffle
							@endif
						</a>
						@endif

						@if (strtotime('now')>strtotime($scheme->to) && $scheme->status=='Executed')
						<a href="javascript:;" data-toggle="modal" data-target="#confirmation-modal"  class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Finalize</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 
<x-confirm></x-confirm>
@endsection

@section('script')
<script src="{{url('dist/js/tableToExcel.js')}}"></script>
<script type="text/javascript">
	function exportReportToExcel() {
		let table = document.getElementsByTagName("table");
		TableToExcel.convert(table[0], { 
			name: `winners-{{str_slug($scheme->title,"-")}}.xlsx`, 
			sheet: {
				name: 'Sheet 1' 
			}
		});
	}

	cash('#confirm-button').on('click', function(event) {
		event.preventDefault();
		window.location.href = '{{ url('vendor/schemes/'.encrypt($scheme->id).'/finalize') }}';
	});
</script>
@endsection