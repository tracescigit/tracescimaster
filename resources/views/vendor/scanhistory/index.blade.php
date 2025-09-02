@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Scan History - TRACESCI</title>
@endsection
@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Scan History</h2>
</div>

<div class="col-span-12 lg:col-span-12 bg-white">
	<div class="pos__ticket mt-5 p-5">
		<div class="col-span-12 lg:col-span-12 bg-gray-200 p-3 box">
			<p class="mb-1 text-lg">Instructions: </p>
			<p class="mb-2 text-md">
				Once codes are activated and products are sold in the market, both consumers as well as brand officials will be able to scan the QR code on the product in order to verify its authenticity. Consumers and brand officials can also report on suspicious scan activity. This is the page where you can see all the scan history, including its geographical location and scan report. 
			</p>
			<p class="font-bold">
				To see authority scans: <br> Go to Field->Select User Type; In Value, type "Brand".
				<br>
				<br>
				To see consumer scans: <br> Go to Field->Select User Type; In Value, type "Users".
			</p>
		</div>
	</div>
</div>

<div class="intro-y box p-5 mt-5">
	<div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
		<form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
			<div class="sm:flex items-center sm:mr-4">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
				<select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="">Please select</option>
					<option value="phone">Scanned by</option>
					<option value="ip_address">IP Address</option>
				</select>
			</div>
			<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
				<select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
					<option value="like" selected>like</option>
					<option value="=">=</option>
				</select>
			</div>
			<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Value</label>
				<input id="tabulator-html-filter-value" type="text" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0"  placeholder="Search...">
			</div>
			<div class="mt-2 xl:mt-0">
				<button id="tabulator-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16" >Go</button>
				<button id="tabulator-html-filter-reset" type="button" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</button>
			</div>
		</form>
		<div class="flex mt-5 sm:mt-0">
			<button id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
				<i data-feather="printer" class="w-4 h-4 mr-2"></i> Print
			</button>
			<div class="dropdown w-1/2 sm:w-auto">
				<button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false">
					<i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export <i data-feather="chevron-down" class="w-4 h-4 ml-auto sm:ml-2"></i>
				</button>
				<div class="dropdown-menu w-40">
					<div class="dropdown-menu__content box dark:bg-dark-1 p-2">
						<a id="tabulator-export-csv" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
							<i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export CSV
						</a>
						<a id="tabulator-export-json" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
							<i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export JSON
						</a>
						<a id="tabulator-export-xlsx" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
							<i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export XLSX
						</a>
						<a id="tabulator-export-html" href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
							<i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export HTML
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="overflow-x-auto scrollbar-hidden">
		<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>
	</div>
</div>
@endsection
@section('global_script')
<script>
	var tabulatorUrl =  '{{ route('vendor-scan-history') }}';
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
		minWidth: 180,
		field: "actions",
		responsive: 1,
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return cell.getData().actions;
		}
	},{
		title: "{{strtoupper('PRODUCT NAME')}}",
		minWidth: 200,
		responsive: 0,
		field: "product_name",
		headerSort:false,
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().product_name, "</div>");
		}
	},
	{
		title: "{{strtoupper('Product Serial No.')}}",
		minWidth: 220,
		field: "code_data",
		responsive: 0,
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().code_data, "</div>");
		}
	},{
		title: "{{strtoupper(__('scanhistory.ip_address'))}}",
		minWidth: 200,
		responsive: 0,
		field: "ip_address",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().ip_address, "</div>");
		}
	}, {
		title: "{{strtoupper(__('scanhistory.scanned_by'))}}",
		minWidth: 200,
		field: "phone",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().phone, "</div>\n                            ");
		}
	},{
		title: "{{strtoupper(__('common.web_link'))}}",
		minWidth: 200,
		responsive: 0,
		field: "url",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true,
		formatter: function formatter(cell, formatterParams) {
			return '<a class="btn p-1 btn-primary" href="'+cell.getData().url+'" title="View Link" target="_blank">Link</a>';
		}
	},  {
		title: "{{strtoupper(__('scanhistory.scan_date'))}}",
		minWidth: 200,
		field: "created_at",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().created_at, "</div>\n                            ");
		}
	}, {
		title: "GENUINE",
		minWidth: 180,
		field: "genuine",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true,
		formatter: function formatter(cell, formatterParams) {
			return cell.getData().genuine;
		}
	}
	];
</script>
@endsection