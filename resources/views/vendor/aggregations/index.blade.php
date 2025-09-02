@extends('vendor.layout.' . $layout)

@section('subhead')
<title>{{ucfirst($_GET['level'])}} Aggregation - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{ucfirst($_GET['level'])}} Aggregation</h2>
	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<a href="javascript:void(0);" data-toggle="modal" data-target="#action-modal" class="btn btn-primary shadow-md mr-2">Add New Aggregation</a>
	</div>
</div>

<div class="intro-y box p-5 mt-5">
	<div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
		<form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
			<div class="sm:flex items-center sm:mr-4">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
				<select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="unique_id">Serial NO</option>
				</select>
			</div>
			<div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
				<select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
					<option value="like" selected>like</option>
					<option value="=">=</option>
					<option value="<">&lt;</option>
						<option value="<=">&lt;=</option>
							<option value=">">></option>
							<option value=">=">>=</option>
							<option value="!=">!=</option>
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
			<x-aggregations></x-aggregations>
			<x-notification></x-notification>
		</div>
		@endsection

		@section('global_script')
		<script>
			var tabulatorUrl =  '{{ url('vendor/aggregations?level='.$_GET['level']) }}';
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
				minWidth: 200,
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
				title: "INDEX",
				minWidth: 200,
				responsive: 0,
				field: "id",
				hozAlign: "center",
				vertAlign: "middle",
				print: false,
				download: false,
				formatter: function formatter(cell, formatterParams) {
					return "<div>\n<div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().id, "</div>");
				}
			},{
				title: "SERIAL NO",
				minWidth: 200,
				responsive: 0,
				field: "unique_id",
				hozAlign: "center",
				vertAlign: "middle",
				print: false,
				download: false,
				formatter: function formatter(cell, formatterParams) {
					return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().unique_id, "</div>");
				}
			},{
				title: "QUANTITY",
				minWidth: 200,
				responsive: 0,
				field: "quantity",
				hozAlign: "center",
				vertAlign: "middle",
				print: false,
				download: false,
				headerSort: false,
				formatter: function formatter(cell, formatterParams) {
					return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().quantity, "</div>");
				}
			},{
				title: "CREATED ON",
				minWidth: 200,
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
				title: "SERIAL NO",
				field: "unique_id",
				visible: false,
				print: true,
				download: true
			},{
				title: "QUANTITY",
				field: "quantity",
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

				async function action() {

					cash('#action-form').find('.form__input').removeClass('border-theme-6')
					cash('#action-form').find('.login__input-error').html('')

					var formData = new FormData(document.querySelector('#action-form'))

					cash('#action-button').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

					axios.post('{{ url('/vendor/aggregations/create') }}', formData).then(res => {

						showNotification('success','Success !',res.data.message)

						setTimeout(()=>{
							window.location.reload()
						},1000)


					}).catch(err => {
						showNotification('error','Error !',err.response.data.message)
						cash('#action-button').html('Submit')                   

						if (err.response.data.errors) {
							for (const [key, val] of Object.entries(err.response.data.errors)){
								cash(`#${key}`).addClass('border-theme-6')
								cash(`#error-${key}`).html(val)
							}
						}

					})
				}

				cash('#action-button').on('click', function() {
					action()
				})
			})
		</script>
		@endsection

