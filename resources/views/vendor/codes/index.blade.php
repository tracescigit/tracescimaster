@extends('vendor.layout.' . $layout)

@section('subhead')
<title>QR Codes - TRACESCI</title>
@endsection

@section('subcontent')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">QR Codes log</h2>

	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<a href="{{ route('vendor-create-codes') }}" class="btn btn-primary shadow-md mr-2" id="upload-codes-btn" style="display:{{$progress==true?'none':''}};">Upload More Codes</a>
		<a href="javascript:void(0);" data-toggle="modal" data-target="#action-modal" class="btn btn-primary shadow-md mr-2">Activate / Deactivate / Export Codes</a>
	</div>
</div>

<div class="col-span-12 lg:col-span-12 bg-white">
	<div class="pos__ticket mt-5 p-5">
		<div class="col-span-12 lg:col-span-12 bg-gray-200 p-3 box">
			<p class="mb-2 text-md">{{__('code.once_the_stamps')}} </p>
			<p class="mb-2 text-md">{{__('code.codes_have_to')}} </p>
			<p class="mb-2">
				{!!__('code.instructions_for_code_activation')!!}
			</p>
		</div>
	</div>
</div>

<div class="intro-y box p-5 mt-5">
	<div class="grid grid-cols-12">
		<form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto col-span-12" >

			<div class="sm:flex items-center sm:mr-4">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">{{__('common.field')}}</label>
				<select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="">Please select</option>
					<option value="products.name">Product Name</option>
					<option value="batch">Batch</option>
					<option value="code_data">Code Data</option>
					<option value="codes.status">Status</option>
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
	<x-deactivate></x-deactivate>
	<x-notification></x-notification>
	<x-bulkaction></x-bulkaction>
</div>
@endsection

@section('global_script')
<script>
	var tabulatorUrl =  '{{ route('vendor-codes') }}';
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
		title: "INDEX SERIAL NO",
		maxWidth: 100,
		responsive: 0,
		field: "id",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n<div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().id, "</div>");
		}
	},{
		title: "PRODUCT NAME",
		minWidth: 180,
		responsive: 0,
		field: "product_id",
		vertAlign: "middle",
		hozAlign: "center",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().product_id, "</div>");
		}
	},{
		title: "PRODUCT SERIAL NO",
		minWidth: 180,
		responsive: 0,
		field: "code_data",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().code_data, "</div>");
		}
	},{
		title: "WEB LINK",
		minWidth: 160,
		responsive: 0,
		field: "url",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return '<a class="btn p-1 btn-primary" href="'+cell.getData().url+'" title="View Link" target="_blank">Link</a>';
		}
	}, {
		title: "BATCH CODE",
		minWidth: 180,
		field: "batch",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().batch, "</div>\n                            ");
		}
	}, {
		title: "CREATED ON",
		minWidth: 160,
		field: "created_at",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false
	},  {
		title: "STATUS",
		minWidth: 160,
		field: "status",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return cell.getData().actions;
		}
	},
	{
		title: "PRODUCT NAME",
		field: "product_id",
		visible: false,
		print: true,
		download: true
	}, {
		title: "BATCH",
		field: "batch",
		visible: false,
		print: true,
		download: true
	},{
		title: "CODE DATA",
		field: "code_data",
		visible: false,
		print: true,
		download: true
	},{
		title: "WEB LINK",
		field: "url",
		visible: false,
		print: true,
		download: true
	}, {
		title: "CREATED AT",
		field: "created_at",
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
			return cell.getValue()=='1' ? "Active" : "Inactive";
		}
	},
	];
</script>

@endsection

@section('script')

<script>
	cash(function () {
		async function deactivate() {

			let url = cash('#target').val()

			if(!url){
				return false;
			}

			cash('#deact-button').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()

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
				cash('#deact-button').html('Deactivate Now')
			})
		}

		cash('#deact-button').on('click', function() {
			deactivate()
		})


		async function action() {

			cash('#action-form').find('.form__input').removeClass('border-theme-6')
			cash('#action-form').find('.login__input-error').html('')

			var action = cash('#action').val()

			var formData = new FormData(document.querySelector('#action-form'))

			cash('#action-button').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			// await helper.delay(500)

			axios.post('{{ url('/vendor/codes/action') }}', formData).then(res => {
				// cash('#action-button').attr('disabled', 'true');
				showNotification('success','Success !',res.data.message)
				cash('#action-button').html('Submit')
				cash('#action-modal').modal('hide')
				

				if(action!='export'){
					setTimeout(()=>{
						window.location.href = '{{ url('/vendor/codes') }}'
					},1000)
				}else{
					const method = 'GET';
					const url = '{{ url('/vendor/codes/bulkexport') }}';

					axios.request({
						url,
						method,
						responseType: 'blob', 
					})
					.then(({ data }) => {
						const downloadUrl = window.URL.createObjectURL(new Blob([data]));
						const link = document.createElement('a');
						link.href = downloadUrl;
						link.setAttribute('download', 'code.xlsx'); 
						document.body.appendChild(link);
						link.click();
						link.remove();
					});
				}

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


