@extends('vendor.layout.' . $layout)

@section('subhead')
<title>View Cashback - TRACESCI</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<div class="intro-y box">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Offer details</h2>
			</div>
			<div class="p-5">

				<div class="grid grid-cols-12">

					<div class="input-form col-span-12 lg:col-span-12 px-2 py-1">
						<div class=" w-full flex flex-col sm:flex-row">
							Offer Title: {{$cashback->title}}
						</div>
						<div id="error-title" class="login__input-error w-5/6 text-theme-6"></div>
					</div>

					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						<div class="w-full flex flex-col sm:flex-row">
							From Date:  {{$cashback->from}} 
						</div>
						<div id="error-from" class="login__input-error w-5/6 text-theme-6"></div>
					</div>

					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						<div class="w-full flex flex-col sm:flex-row">
							To Date: {{$cashback->to}}
						</div>
						<div id="error-to" class="login__input-error w-5/6 text-theme-6"></div>
					</div>

					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						<div class="w-full flex flex-col sm:flex-row">
							Allow Single User to Win Multiple: {{$cashback->allow_multiple}} 
						</div>
					</div>

					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						Status: {{$cashback->status}}
					</div>

				</div>
			</div>
		</div>

		<div class="intro-y box mt-4">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Codes Details</h2>
			</div>
			<div class="p-5 codes-area">
				@php
				$codes = json_decode($cashback->codes,true);
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

		<div class="intro-y box mt-4">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Prizes Details</h2>
			</div>
			<div class="p-5 prizes-area">
				@php
				$items = json_decode($cashback->items,true);
				@endphp

				@if (!empty($items))
				@foreach ($items as $key =>  $item)
				<p class="mb-2">
					{{$key+1}}. <strong>INR{{$item['item']}} - {{$item['quantity']}}</strong>
				</p>
				@endforeach
				@endif
			</div>
		</div>

		@if (strtotime('now')>strtotime($cashback->to_date) && ($cashback->status=='Finalized' || $cashback->status=='Executed'))
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
							<td class="text-center border border-slate-600">INR {{$win->item}}</td>
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

						@if (strtotime('now')>strtotime($cashback->to) && $cashback->status!='Finalized')
						<a href="{{ url('vendor/cashbacks/'.encrypt($cashback->id).'/execute') }}" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top" id="Executed">
							@if ($cashback->status!='Executed')
							Execute
							@else
							Reshuffle
							@endif
						</a>
						@endif

						@if (strtotime('now')>strtotime($cashback->to) && $cashback->status=='Executed')
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
			name: `winners-{{str_slug($cashback->title,"-")}}.xlsx`, 
			sheet: {
				name: 'Sheet 1' 
			}
		});
	}

	cash('#confirm-button').on('click', function(event) {
		event.preventDefault();
		window.location.href = '{{ url('vendor/cashbacks/'.encrypt($cashback->id).'/finalize') }}';
	});
</script>
@endsection