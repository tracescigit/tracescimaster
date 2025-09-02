@extends('admin.layout.' . $layout)

@section('subhead')
<title>Lost/Damage Details - TRACESCI</title>
@endsection
@php
$stamps = json_decode($damage->stamps,true);
@endphp
@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<div class="intro-y box">
			<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto">Lost/Damage Details</h2>
			</div>
			<div class="p-5 mb-4 ">
				<div class="grid grid-cols-12 pb-10">
					<div class="intro-y col-span-12 lg:col-span-6 " id="printable">
						<table class="w-100 ml-4 border border-collapse border-dark-5">
							<tr>
								<th class="text-lg border p-5  border-dark-5">Stamps Reported</th>
							</tr>
							@foreach($stamps as $stamp)
							<tr>
								<td class="text-md text-center mt-3  border p-5 border-dark-5">{{$stamp}}</td>
							</tr>
							@endforeach

						</table>
						<p class="ml-4 mt-4 text-md"><strong>Total: {{count($stamps	)}} </strong></p>
					</div>
				</div>
				<button type="button" class="btn btn-primary ml-4" onclick="printTable()">Print List</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	function printTable(){
			var printContents = document.getElementById("printable").innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
	}
</script>
@endsection