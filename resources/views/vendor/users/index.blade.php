@extends('vendor.layout.' . $layout)

@section('subhead')
<title>{{__('common.users')}}</title>
@endsection
@section('subcontent')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{__('common.users')}}</h2>
	@if (hasRoutePermission('vendor-create-users',Auth::id()))
	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<a href="{{ route('vendor-create-users') }}" class="btn btn-primary shadow-md mr-2">{{__('common.add_user')}}</a>
		<div class="dropdown ml-auto sm:ml-0">
			<a href="{{ route('vendor-create-users') }}" class="btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
				<span class="w-5 h-5 flex items-center justify-center">
					<i class="w-4 h-4" data-feather="plus"></i>
				</span>
			</a>
		</div>
	</div>
	@endif
</div>

<div class="intro-y box p-5 mt-5">
	<div class="grid grid-cols-12">
		<form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto col-span-12" >
			
			<div class="sm:flex items-center sm:mr-4">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.field')}}</label>
				<select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="">{{__('common.please_select')}}</option>
					<option value="first_name">{{__('common.first_name')}}</option>
					<option value="email">{{__('common.email')}}</option>
					<option value="phone">{{__('common.mobile')}}</option>
					<option value="who_you_are">Role</option>
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
</div>
@endsection
@section('global_script')
<script>
	var tabulatorUrl =  '{{ route('vendor-users') }}';
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
	}, 
	@if (hasRoutePermission('vendor-create-users',Auth::id()))
	{
		title: "ACTIONS",
		minWidth: 200,
		field: "actions",
		responsive: 1,
		vertAlign: "middle",
		print: false,
		download: false,
		headerSort: false,
		formatter: function formatter(cell, formatterParams) {
			return cell.getData().actions;
		}
	},
	@endif
	{
		title: "{{strtoupper(__('common.user_name'))}}",
		minWidth: 200,
		responsive: 0,
		field: "first_name",
		@if (hasRoutePermission('vendor-create-users',Auth::id()))
		hozAlign: "center",
		@endif
		vertAlign: "middle",	
		print: true,
		download: true
	}, {
		title: "{{strtoupper(__('common.email'))}}",
		minWidth: 200,
		field: "email",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true
	}, {
		title: "{{strtoupper(__('common.mobile'))}}",
		minWidth: 200,
		field: "phone",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true
	},
	{
		title: "{{strtoupper(__('common.role'))}}",
		minWidth: 200,
		field: "who_you_are",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true
	},
	{
		title: "{{strtoupper(__('common.status'))}}",
		minWidth: 200,
		field: "status",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true
	},
	];
</script>
@endsection