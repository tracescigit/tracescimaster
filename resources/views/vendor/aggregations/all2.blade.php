@extends('vendor.layout.' . $layout)

@section('subhead')
<title>{{ucfirst($_GET['level'])}} Aggregations - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{ucfirst($_GET['level'])}} Aggregations</h2>
</div>

<div class="intro-y box p-5 mt-5">
	<div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
		<form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
			<div class="sm:flex items-center sm:mr-4">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
				<select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="unique_id">Unique ID</option>
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
	</div>
	<div class="overflow-x-auto scrollbar-hidden">
		<div id="tabulator" class="mt-5 table-report table-report--tabulator" style="max-height:350px;"></div>
	</div>
</div>
<div class="grid grid-cols-12">
	<div class="col-span-7 pr-2">
		<div class="intro-y box p-5 mt-5">
			<div class="grid grid-cols-12 gap-6">
				<div class="col-span-12 intro-y mt-1">
					<h2 class="text-lg font-medium mr-auto mb-4">Aggregation Details</h2>
				</div>
			</div>

			<div class="grid grid-cols-12 view-area" style="max-height: 300px; overflow-y: scroll;">

			</div>
		</div>
	</div>
	<div class="col-span-5 pl-2">
		<div class="intro-y box p-5 mt-5">
			<div class="grid grid-cols-12 gap-6">
				<div class="col-span-12 intro-y mt-1">
					<h2 class="text-lg font-medium mr-auto mb-4">Additional Info</h2>
				</div>
			</div>

			<div class="grid grid-cols-12 code-area" style="max-height: 300px; overflow-y: scroll;">

			</div>
		</div>
	</div>
</div>
<x-notification></x-notification>
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
		title: "SERIAL NO",
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
		title: "Unique ID",
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
		title: "Unique ID",
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

		cash(document).on('click','.parent', function() {
			cash('.code-area').html('')
			cash('.view-area').html('<div class="col-span-12"><h5 class="text-center">Please wait</h5></div>')
			var id = cash(this).data('id')
			axios.get(`{{ url('vendor/aggregations') }}/${id}`).then(res => {
				cash('.view-area').html(res.data)
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('.view-area').html('')
			})
		})

		cash(document).on('click','.child-has-children', function() {
			cash('.code-area').html('')
			cash(this).parent().find('.children-area').html('<div class="col-span-12"><h5 class="text-center">Please wait</h5></div>')
			var id = cash(this).data('id')
			axios.get(`{{ url('vendor/aggregations') }}/${id}`).then(res => {
				cash(this).parent().find('.children-area').html(res.data)
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash(this).parent().find('.children-area').html('')
			})
		})

		cash(document).on('click','.code-data', function() {
			cash('.code-data').removeClass('bg-blue-600')
			cash('.code-area').html('<div class="col-span-12"><h5 class="text-center">Please wait</h5></div>')
			var id = cash(this).data('id')
			cash(this).addClass('bg-blue-600')
			axios.get(`{{ url('vendor/aggregations') }}/${id}/code-data`).then(res => {
				cash('.code-area').html(res.data)
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('.code-area').html('')
			})
		})
	})
</script>
@endsection

