@extends('admin.layout.' . $layout)

@section('subhead')
<title>{{__('blog.blog')}} - TRACESCI</title>
@endsection
@section('subcontent')



<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{__('blog.blog')}}</h2>
	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<a href="{{ route('admin-blogs-create') }}" class="btn btn-primary shadow-md mr-2">Add New Blog</a>
		<div class="dropdown ml-auto sm:ml-0">
			<a href="{{ route('admin-blogs-create') }}" class="btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
				<span class="w-5 h-5 flex items-center justify-center">
					<i class="w-4 h-4" data-feather="plus"></i>
				</span>
			</a>
		</div>
	</div>
</div>

<div class="intro-y box p-5 mt-5">
	<div class="grid grid-cols-12">
		<form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto col-span-12">

			<div class="sm:flex items-center sm:mr-4">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.field')}}</label>
				<select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="">{{__('common.please_select')}}</option>
					<option value="title">{{__('blog.title')}}</option>
					<option value="publish_date">{{__('blog.Publishing_date')}}</option>
					<option value="publish_by">{{__('blog.created_by')}}</option>
					<option value="is_allowed">{{__('blog.allowed')}}</option>
					<option value="created_at">{{__('blog.created_at')}}</option>
					<option value="phone">{{__('blog.status')}}</option>
				</select>
			</div>
			<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.type')}}</label>
				<select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="like" selected>{{__('common.like')}}</option>
					<option value="=">=</option>
				</select>
			</div>
			<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.value')}}</label>
				<input id="tabulator-html-filter-value" type="text" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0" placeholder="{{__('common.search')}}...">
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
					<button id="tabulator-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16">{{__('common.go')}}</button>
					<button id="tabulator-html-filter-reset" type="button" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">{{__('common.reset')}}</button>
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
	var tabulatorUrl = "{{ route('admin-blog') }}";
	var tabulatorColumns = [{
		formatter: "responsiveCollapse",
		width: 40,
		minWidth: 30,
		align: "center",
		resizable: false,
		headerSort: false,
		print: false,
		download: false,
		collapsed: true,
	}, {
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
	}, {
		title: "{{strtoupper(__('blog.title'))}}",
		minWidth: 220,
		responsive: 0,
		field: "title",
		headerHozAlign: "left",
		hozAlign: "left",
		vertAlign: "left",
		print: true,
		download: true
	}, {
		title: "{{strtoupper('publishing date')}}",
		minWidth: 220,
		responsive: 0,
		field: "publish_date",
		headerHozAlign: "center",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true
	}, {
		title: "{{strtoupper(__('blog.created_by'))}}",
		minWidth: 200,
		responsive: 0,
		headerHozAlign: "left",
		field: "publish_by",
		vertAlign: "left",
		hozAlign: "left",
		print: true,
		download: true
	}, {
		title: "{{strtoupper(__('blog.allowed'))}}",
		minWidth: 200,
		headerHozAlign: "center",
		field: "is_allowed",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true
	}, {
		title: "{{strtoupper(__('blog.created_at'))}}",
		minWidth: 180,
		field: "created_at",
		headerHozAlign: "center",
		hozAlign: "center",
		headerSort: false,
		vertAlign: "middle",
		print: true,
		download: true
	}, {
		title: "{{strtoupper(__('blog.status'))}}",
		minWidth: 180,
		field: "status",
		headerHozAlign: "center",
		hozAlign: "center",
		vertAlign: "middle",
		print: true,
		download: true
	}, ];
</script>
@endsection