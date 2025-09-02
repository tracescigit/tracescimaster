@extends('admin.layout.' . $layout)

@section('subhead')
<title>Offers - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Offers</h2>
	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<a href="{{ route('admin-create-offers') }}" class="btn btn-primary shadow-md mr-2">Add New Offer</a>
		<div class="dropdown ml-auto sm:ml-0">
			<a href="{{ route('admin-create-offers') }}" class="btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
				<span class="w-5 h-5 flex items-center justify-center">
					<i class="w-4 h-4" data-feather="plus"></i>
				</span>
			</a>
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
					<option value="title">Title</option>
					<option value="code">Code</option>
					<option value="type">Type</option>
					<option value="status">Status</option>
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
	<x-delete-modal></x-delete-modal>
</div>
@endsection

@section('global_script')
<script>
	var tabulatorUrl =  '{{ route('admin-offers') }}';
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
		print: false,
		headerSort:false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return cell.getData().actions;
		}
	},{
		title: "OFFER TITLE",
		minWidth: 200,
		responsive: 0,
		field: "title",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().title, "</div>");
		}
	}, {
		title: "CODE",
		minWidth: 200,
		field: "code",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().code, "</div>\n                            ");
		}
	}, {
		title: "TYPE",
		minWidth: 200,
		field: "type",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false
	},
	 {
		title: "CREATED ON",
		minWidth: 200,
		field: "created_at",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false
	}, {
		title: "STATUS",
		minWidth: 200,
		field: "status",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div class=\"flex items-center lg:justify-center ".concat(cell.getData().status=='1' ? "text-theme-9" : "text-theme-6", "\">\n                            <i data-feather=\"check-square\" class=\"w-4 h-4 mr-2\"></i> ").concat(cell.getData().status=='1' ? "Active" : "Inactive", "\n                        </div>");
		}
	}, 
	
	{
		title: "OFFER TITLE",
		field: "title",
		visible: false,
		print: true,
		download: true
	}, {
		title: "CODE",
		field: "code",
		visible: false,
		print: true,
		download: true
	}, {
		title: "TYPE",
		field: "type",
		visible: false,
		print: true,
		download: true
	},  {
		title: "CREATED ON",
		field: "created_at",
		visible: false,
		print: true,
		download: true
	},  {
		title: "STATUS",
		field: "status",
		visible: false,
		print: true,
		download: true,
		formatterPrint: function formatterPrint(cell) {
			return cell.getValue()=='1' ? "Active" : "Inactive";
		}
	},
	];
</script>
@endsection

@section('script')
<script>
	cash(function () {
		async function del() {

			let url = cash('#target').val()

			if(!url){
				return false;
			}

			cash('#del-button').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

			let formData = {

			}

			axios.post(url, formData).then(res => {
				cash('#dismiss-modal').trigger('click')
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.reload()
				},1000)
			}).catch(err => {
				cash('#dismiss-modal').trigger('click')
				showNotification('error','Error !',err.response.data.message)
				cash('#del-button').html('Delete')
			})
		}

		cash('#del-button').on('click', function() {
			del()
		})
	})
</script>
@endsection

