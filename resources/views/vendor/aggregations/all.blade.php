@extends('vendor.layout.' . $layout)

@section('subhead')
<title>{{ucfirst($_GET['level'])}} Aggregations - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">{{ucfirst($_GET['level'])}} Aggregations</h2>
</div>

<div class="grid grid-cols-12">
	<div class="col-span-7 pr-2">
		<div class="intro-y box p-5 mt-5">
			<div class="grid grid-cols-12 gap-6">
				<div class="col-span-12 intro-y mt-1 mb-3">
					<input type="text" class="form-control" id="search" placeholder="Search" onkeyup="search()">
				</div>
			</div>

			<div class="col-span-12">
				<table class="table border-collapse border border-slate-400" id="table">
					<thead>
						<tr>
							<th>
								Serial Number <span class="float-right">Level</span>
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($aggregations as $aggregation)
						<tr>
							<td class="border border-slate-300">
								@if(strtolower($aggregation->level)=='primary')
								@if ($aggregation->getCodes && count($aggregation->getCodes)>0)
								<a href="javascript:;" data-id="{{encrypt($aggregation->id)}}" class="child-has-children closed">[+]</a>
								@endif
								{{$aggregation->unique_id}} <span class="float-right bg-red-800 text-white px-1" style="font-size: 10px;">{{strtoupper($aggregation->level)}}</span>
								@if ($aggregation->getCodes && count($aggregation->getCodes)>0)
								<div class="grid grid-cols-12 children-area">
								</div>
								@endif
								@else
								@if ($aggregation->getChildren && count($aggregation->getChildren)>0)
								<a href="javascript:;" data-id="{{encrypt($aggregation->id)}}" class="child-has-children closed">[+]</a>
								@endif
								{{$aggregation->unique_id}} <span class="float-right bg-red-800 text-white px-1" style="font-size: 10px;">{{strtoupper($aggregation->level)}}</span>
								@if ($aggregation->getChildren && count($aggregation->getChildren)>0)
								<div class="grid grid-cols-12 children-area">
								</div>
								@endif
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-span-5 pl-2">
		<div class="intro-y box p-5 mt-5">
			<div class="grid grid-cols-12 gap-6">
				<div class="col-span-12 intro-y mt-1">
					<h2 class="text-lg font-medium mr-auto mb-4 text-center">Additional Info</h2>
				</div>
			</div>

			<div class="grid grid-cols-12 code-area" style="max-height: 300px; overflow-y: scroll;">
				<div class="col-span-12 text-center">Additional informations will come here</div>
			</div>
		</div>
	</div>
</div>
<x-notification></x-notification>
@endsection

@section('script')
<script>
	cash(function () {

		cash(document).on('click','.parent', function() {
			cash('.code-area').html('<div class="col-span-12 text-center">Additional informations will come here</div>')
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
			cash('.code-area').html('<div class="col-span-12 text-center">Additional informations will come here</div>')
			
			if(cash(this).hasClass('opened')){
				cash(this).html('[+]');
				cash(this).removeClass('opened');
				cash(this).addClass('closed');
				cash(this).parent().find('.children-area').html('')
			}else{
				cash(this).parent().find('.children-area').html('<div class="col-span-12"><h5 class="text-center">Please wait</h5></div>')
				var id = cash(this).data('id')
				axios.get(`{{ url('vendor/aggregations') }}/${id}`).then(res => {
					cash(this).html('[-]');
					cash(this).removeClass('closed');
					cash(this).addClass('opened');
					cash(this).parent().find('.children-area').html(res.data)
				}).catch(err => {
					showNotification('error','Error !',err.response.data.message)
					cash(this).parent().find('.children-area').html('')
				})
			}

		})

		cash(document).on('click','.code-data', function() {
			cash('.code-data').removeClass('bg-gray-600')
			cash('.code-area').html('<div class="col-span-12"><h5 class="text-center">Please wait</h5></div>')
			var id = cash(this).data('id')
			cash(this).addClass('bg-gray-600')
			axios.get(`{{ url('vendor/aggregations') }}/${id}/code-data`).then(res => {
				cash('.code-area').html(res.data)
			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('.code-area').html('<div class="col-span-12 text-center">Additional informations will come here</div>')
			})
		})
	})

	function search() {
		var input, filter, table, tr, td, i, txtValue;
		input = document.getElementById("search");
		filter = input.value.toUpperCase();
		table = document.getElementById("table");
		tr = table.getElementsByTagName("tr");

		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[0];
			if (td) {
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
		}
	}

</script>
@endsection

