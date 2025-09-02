@extends('vendor.layout.' . $layout)

@section('subhead')
<title>View Scheme - TRACESCI</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">

		<div class="intro-y box mt-4">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Transactions</h2>
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
							<th class="border text-center border-slate-600">Type</th>
							<th class="border text-center border-slate-600">Points</th>
							<th class="border text-center border-slate-600">Amount</th>
							<th class="border text-center border-slate-600">TXN Id</th>
						</tr>
					</thead>

					<tbody>
						@forelse($transactions as $key=>$transaction)

						<tr>
							<td class="text-center border border-slate-600">{{$key+1}}</td>
							<td class="text-center border border-slate-600">{{$transaction->getUser->name??'NA'}}</td>
							<td class="text-center border border-slate-600">{{$transaction->getUser->phone??'NA'}}</td>
							<td class="text-center border border-slate-600">{{$transaction->getScan->getCode->code_data??'NA'}}</td>
							<td class="text-center border border-slate-600">{{$transaction->type}}</td>
							<td class="text-center border border-slate-600">{{$transaction->points}}</td>
							<td class="text-center border border-slate-600">{{$transaction->amount??'NA'}}</td>
							<td class="text-center border border-slate-600">{{$transaction->transaction_id??'NA'}}</td>
						</tr>

						@empty
						<tr>
							<td colspan="8" class="text-center border border-slate-600"> No transactions Available</td>
						</tr>
						@endforelse

						<tr>
							<td colspan="1" style="text-align:right;">Total Credit Points : {{$credits}}</td>
							<td colspan="1" style="text-align:right;">Total Debit Points : {{$debits}}</td>
							<td colspan="5" style="text-align:right;">Remaining Balance : {{$balance}}</td>
						</tr>
					</tbody>	

				</table>
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
			name: `transactions-{{str_slug($reward->title,"-")}}.xlsx`, 
			sheet: {
				name: 'Sheet 1' 
			}
		});
	}
</script>
@endsection