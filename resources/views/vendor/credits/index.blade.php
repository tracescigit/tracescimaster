@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Credits - TRACESCI</title>
@endsection

@section('subcontent')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Credit history</h2>

	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<a href="{{ route('vendor-buy-credits') }}" class="btn btn-primary shadow-md mr-2">Upgrade Plan / Add Credits</a>
		<div class="dropdown ml-auto sm:ml-0">
			<a href="{{ route('vendor-buy-credits') }}" class="btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
				<span class="w-5 h-5 flex items-center justify-center">
					<i class="w-4 h-4" data-feather="plus"></i>
				</span>
			</a>
		</div>
	</div>
</div>

<div class="grid grid-cols-12 gap-6 mt-4">

	<div class="col-span-12 lg:col-span-12 bg-white">
		<div class="pos__ticket p-5">
			<div class="col-span-12 lg:col-span-12 bg-gray-200 p-3 box">
				<strong class="mb-2">Instructions:</strong>
				<p class="mb-0">Here you can see active plan and credit balance.</p>
				<p class="mb-0">When you registered Free plan is activated by default. You can upgrade your plan based on usage from “Upgrade Plan / Add Credits” Buttons.</p>
				<p class="mb-0">In the table you can see history of all the credits you have bought with respective plans.</p>
			</div>
		</div>
	</div>
	<div class="col-span-12 lg:col-span-3 intro-y">
		<div class="report-box zoom-in">
			<div class="box p-5">
				<div class="flex">
					<i data-feather="credit-card" class="report-box__icon text-theme-10"></i>

				</div>
				<div class="text-3xl font-bold leading-8 mt-6">
					@if (Auth::user()->getSubscription)
					{{Auth::user()->getSubscription->plan_name}}
					@else
					No active plans
					@endif
				</div>
				<div class="text-base text-gray-600 mt-1">Current Plan</div>
			</div>
		</div>
	</div>
	<div class="col-span-12 lg:col-span-3 intro-y">
		<div class="report-box zoom-in">
			<div class="box p-5">
				<div class="flex">
					<i data-feather="credit-card" class="report-box__icon text-theme-10"></i>

				</div>
				<div class="text-3xl font-bold leading-8 mt-6">{{getAvailableCredits(Auth::id())}}</div>
				<div class="text-base text-gray-600 mt-1">Available Credits</div>
			</div>
		</div>
	</div>
	<div class="col-span-12 lg:col-span-3 intro-y">
		<div class="report-box zoom-in">
			<div class="box p-5">
				<div class="flex">
					<i data-feather="credit-card" class="report-box__icon text-theme-10"></i>

				</div>
				<div class="text-3xl font-bold leading-8 mt-6">{{getUsedCredits(Auth::id())}}</div>
				<div class="text-base text-gray-600 mt-1">Used Credits</div>
			</div>
		</div>
	</div>
	<div class="col-span-12 lg:col-span-3 intro-y">
		<div class="report-box zoom-in">
			<div class="box p-5">
				<div class="flex">
					<i data-feather="credit-card" class="report-box__icon text-theme-10"></i>

				</div>
				<div class="text-3xl font-bold leading-8 mt-6">{{getLatestCreditAmount(Auth::id())}}</div>
				<div class="text-base text-gray-600 mt-1">Latest Credit</div>
			</div>
		</div>
	</div>
</div>


<div class="intro-y box p-5 mt-5">
	<div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
		
		<form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto col-span-12" >
			
			<div class="sm:flex items-center sm:mr-4">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.field')}}</label>
				<select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="">Please select</option>
					<option value="plan_name">Plan Name</option>
					<option value="payment_id">Payment ID</option>
					<option value="credits">Credits</option>
					<option value="status">Status</option>
				</select>
			</div>
			<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.type')}}</label>
				<select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
					<option value="like" selected>{{__('common.like')}}</option>
					<option value="=">=</option>
				</select>
			</div>
			<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.value')}}</label>
				<input id="tabulator-html-filter-value" type="text" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0"  placeholder="{{__('common.search')}}...">
			</div>
			<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.from_date')}}</label>
				<input id="tabulator-html-filter-start-date" type="date" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0">
			</div>
			<div class="sm:flex items-center mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.to_date')}}</label>
				<input id="tabulator-html-filter-end-date" type="date" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0">
			</div>			
		</form>
		<div class="mt-5 col-span-12">
			<div class="grid grid-cols-12">
				
				<div class="dropdown col-span-6 lg:col-span-9">
					<button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false">
						<i data-feather="file-text" class="w-4 h-4 mr-2"></i> {{__('common.export')}} <i data-feather="chevron-down" class="w-4 h-4 ml-auto sm:ml-2"></i>
					</button>
					<div class="dropdown-menu w-40">
						<div class="dropdown-menu__content box dark:bg-dark-1 p-2">
							<a id="tabulator-export-csv" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
								<i data-feather="file-text" class="w-4 h-4 mr-2"></i> {{__('common.export')}} CSV
							</a>
							<a id="tabulator-export-json" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
								<i data-feather="file-text" class="w-4 h-4 mr-2"></i> {{__('common.export')}} JSON
							</a>
							<a id="tabulator-export-xlsx" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
								<i data-feather="file-text" class="w-4 h-4 mr-2"></i> {{__('common.export')}} XLSX
							</a>
							<a id="tabulator-export-html" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
								<i data-feather="file-text" class="w-4 h-4 mr-2"></i> {{__('common.export')}} HTML
							</a>
						</div>
					</div>
				</div>
				<div class="flex  col-span-6 lg:col-span-3 justify-end">
					<button id="tabulator-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16" >{{__('common.go')}}</button>
					<button id="tabulator-html-filter-reset" type="button" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >{{__('common.reset')}}</button>
				</div>
			</div>
		</div>

	</div>
	<div class="overflow-x-auto scrollbar-hidden">
		<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>
	</div>
	<x-delete-modal></x-delete-modal>
</div>
@endsection

@section('global_script')
<script>
	var tabulatorUrl =  '{{ route('vendor-credits') }}';
	var tabulatorColumns = [
	{	
		formatter: "responsiveCollapse",
		width: 40,
		minWidth: 30,
		align: "center",
		resizable: false,
		headerSort: false,
		print: false,
		download: false,
		collapsed:true,
	},{
		title: "ACTIONS",
		maxWidth: 160,
		field: "actions",
		responsive: 0,
		vertAlign: "middle",
		headerSort: false,
		print: false,	
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return cell.getData().actions;
		}
	},{
		title: "CREDITS ADDED",
		minWidth: 200,
		responsive: 0,
		field: "credits",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().credits, "</div>");
		}
	}, {
		title: "PLAN",
		minWidth: 200,
		field: "plan_name",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().plan_name, "</div>\n                            ");
		}
	}, {
		title: "PAYMENT ID",
		minWidth: 200,
		field: "payment_id",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false
	}, {
		title: "CREATED ON",
		minWidth: 200,
		field: "created_at",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false
	},{
		title: "STATUS",
		minWidth: 200,
		field: "status",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div class=\"flex items-center lg:justify-center ".concat(cell.getData().status=='1' ? "text-theme-9" : "text-theme-6", "\">\n                            <i data-feather=\"check-square\" class=\"w-4 h-4 mr-2\"></i> ").concat(cell.getData().status=='1' ? "Success" : "Pending", "\n                        </div>");
		}
	}, 
	
	{
		title: "CREDITS ADDED",
		field: "credits",
		visible: false,
		print: true,
		download: true
	}, {
		title: "PLAN",
		field: "plan_name",
		visible: false,
		print: true,
		download: true
	}, {
		title: "PAYMENT ID",
		field: "payment_id",
		visible: false,
		print: true,
		download: true
	}, {
		title: "STATUS",
		field: "status",
		visible: false,
		print: true,
		download: true,
		formatterPrint: function formatterPrint(cell) {
			return cell.getValue()=='1' ? "Success" : "Pending";
		}
	},
	];
</script>
@endsection


