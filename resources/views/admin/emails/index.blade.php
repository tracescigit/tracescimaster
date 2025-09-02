@extends('admin.layout.' . $layout)

@section('subhead')
<title>Email templates - TRACESCI</title>
@endsection

@section('subcontent')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Email template</h2>
</div>

<div class="intro-y box p-5 mt-5">
	<div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
		<form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
			<div class="sm:flex items-center sm:mr-4">
				<label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
				<select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
					<option value="subject">Subject</option>
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
	</div>
	<div class="overflow-x-auto scrollbar-hidden">
		<div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>
	</div>
</div>

@endsection

@section('global_script')
<script>
	var tabulatorUrl =  '{{ route('admin-emails') }}';
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
		title: "Slug",
		minWidth: 400,
		responsive: 0,
		field: "slug",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().slug, "</div>");
		}
	}, 
	

	{
		title: "Subject",
		minWidth: 400,
		responsive: 0,
		field: "subject",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().subject, "</div>");
		}
	}, 
	{
		title: "Created At",
		minWidth: 400,
		responsive: 0,
		field: "created_at",
		hozAlign: "center",
		vertAlign: "middle",
		print: false,
		download: false,
		formatter: function formatter(cell, formatterParams) {
			return "<div>\n                            <div class=\"font-medium whitespace-nowrap\">".concat(cell.getData().created_at, "</div>");
		}
	}, 
	
	// {
	// 	title: "ACTIONS",
	// 	minWidth: 200,
	// 	field: "actions",
	// 	responsive: 1,
	// 	hozAlign: "center",
	// 	vertAlign: "middle",
	// 	print: false,
	// 	download: false,
	// 	formatter: function formatter(cell, formatterParams) {
	// 		return cell.getData().actions;
	// 	}
	// },

	{
		title: "Slug",
		field: "slug",
		visible: false,
		print: true,
		download: true
	}, 
	{
		title: "Subject",
		field: "subject",
		visible: false,
		print: true,
		download: true,
	},
	{
		title: "Created At",
		field: "created_at",
		visible: false,
		print: true,
		download: true,
	},
	];
</script>
@endsection