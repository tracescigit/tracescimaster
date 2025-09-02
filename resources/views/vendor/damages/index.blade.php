@extends('vendor.layout.' . $layout)

@section('subhead')
<title>Report Lost/Damages TRACESCI</title>
@endsection
@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Report Lost/Damages</h2>
	@if (hasRoutePermission('lost-damage-create',Auth::id()))
	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<a href="{{ route('lost-damage-create') }}" class="btn btn-primary shadow-md mr-2">Report New</a>
		<div class="dropdown ml-auto sm:ml-0">
			<a href="{{ route('lost-damage-create') }}" class="btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
				<span class="w-5 h-5 flex items-center justify-center">
					<i class="w-4 h-4" data-feather="plus"></i>
				</span>
			</a>
		</div>
	</div>
	@endif
</div>
<div class="col-span-12 lg:col-span-12 bg-white">
	<div class="pos__ticket mt-5 p-5">
		<div class="col-span-12 lg:col-span-12 bg-gray-200 p-3 box">
			<p class="mb-2 text-lg">Instructions:</p>
			<p class="mb-2 text-md">
				Below is the list of codes reported as damaged or lost/Stolen from premises.<br>
				Once the codes are reported as damaged/Lost/Stolen, it will be deactivated in the system by default.<br>
				Damaged labels with code must be discarded.<br>
				Manufacturer/Brand can inform local police about lost or stolen labels from there factory.<br>
			</p>
		</div>
	</div>
</div>
<div class="intro-y box p-5 mt-5">
	<div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
		<form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
			<div class="sm:flex items-center sm:mr-4">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.field')}}</label>
				<select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="">{{__('common.please_select')}}</option>
					<option value="">Lot Id</option>
				</select>
			</div>
			<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.type')}}</label>
				<select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
					<option value="like" selected>{{__('common.like')}}</option>
					<option value="=">=</option>
					<option value="<">&lt;</option>
						<option value="<=">&lt;=</option>
							<option value=">">></option>
							<option value=">=">>=</option>
							<option value="!=">!=</option>
						</select>
					</div>
					<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
						<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.value')}}</label>
						<input id="tabulator-html-filter-value" type="text" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0"  placeholder="Search...">
					</div>
					<div class="mt-2 xl:mt-0">
						<button id="tabulator-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16" >{{__('common.go')}}</button>
						<button id="tabulator-html-filter-reset" type="button" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >{{__('common.reset')}}</button>
					</div>
				</form>
				<div class="flex mt-5 sm:mt-0">
					<button id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
						<i data-feather="printer" class="w-4 h-4 mr-2"></i> {{__('common.print')}}
					</button>
					<div class="dropdown w-1/2 sm:w-auto">
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
				</div>
			</div>
			<div class="overflow-x-auto scrollbar-hidden">
				<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>
			</div>
		</div>
		@endsection
		@section('global_script')
		<script>
			var tabulatorUrl =  '{{ route('lost-damage') }}';
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
			},	{
				title: "ACTIONS",
				maxWidth: 150,
				field: "actions",
				responsive: 1,
				vertAlign: "middle",
				print: false,
				headerSort: false,
				download: false,
				formatter: function formatter(cell, formatterParams) {
					return cell.getData().actions;
				}
			},{
				title: "LOT ID",
				minWidth: 220,
				responsive: 0,
				field: "lot_id",
				hozAlign: "center",
				vertAlign: "middle",
				print: false,
				download: false,
				formatter: function formatter(cell, formatterParams) {
					return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().lot_id, "</div>");
				}
			},{
				title: "TOTAL LABELS",
				minWidth: 200,
				responsive: 0,
				field: "total_stamps",
				vertAlign: "middle",
				hozAlign: "center",
				print: false,
				download: false,
				formatter: function formatter(cell, formatterParams) {
					return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().total_stamps, "</div>");
				}
			}, {
				title: "REASON",
				minWidth: 200,
				field: "reason",
				hozAlign: "center",
				vertAlign: "middle",
				print: false,
				download: false,
				formatter: function formatter(cell, formatterParams) {
					return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().reason, "</div>\n                            ");
				}
			},{
				title: "CREATED ON",
				minWidth: 180,
				field: "created_at",
				hozAlign: "center",
				vertAlign: "middle",
				print: false,
				download: false,
				formatter: function formatter(cell, formatterParams) {
					return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().created_at, "</div>\n                            ");
				}
			},

			{
				title: "LOT ID",
				field: "lot_id",
				visible: false,
				print: true,
				download: true
			}, {
				title: "TOTAL LABELS",
				field: "total_stamps",
				visible: false,
				print: true,
				download: true
			},{
				title: "REASON",
				field: "reason",
				visible: false,
				print: true,
				download: true
			}, {
				title: "CREATED ON",
				field: "created_at",
				visible: false,
				print: true,
				download: true
			},  
			];
		</script>
		@endsection