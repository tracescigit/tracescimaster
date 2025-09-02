@extends('admin.layout.' . $layout)

@section('subhead')
<title>Support - TRACESCI</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">Support Ticket</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
	<div class="intro-y col-span-12 lg:col-span-12">
		<form id="edit-form">
			@csrf
			<div class="intro-y box">
				<div class="flex flex-col sm:flex-row items-center px-7 py-5 border-b border-gray-200 dark:border-dark-5">
					<h2 class="font-medium text-base mr-auto">Ticket details ( #{{$ticket->id}})</h2>
					<strong class="text-base ml-auto {{$ticket->status!='1'? 'text-theme-6':'text-theme-9'}}">{{$status}}</strong>
				</div>
				<div class="p-5">

					<div class="grid grid-cols-12">
						<div class="input-form col-span-12 px-2 py-1 mt-2">
							<label for="subject" class="form-label w-full flex flex-col sm:flex-row">
								<strong> Subject : {{$ticket->subject}}</strong>
							</label>
						</div>

						@php
						$content = json_decode($ticket->content,true);
						@endphp

						@if (!empty($content) && count($content)>0)
						@foreach ($content as $record)
						<div class="col-span-12 px-2 py-1 mt-2">
							<div class="form-control">
								<label class="form-label w-full flex flex-col sm:flex-row pb-2 mb-2 border-b">
									<strong>{{$record['time']}} -  {{$record['created_by']}} </strong>
								</label>
								{!!$record['message']!!}
							</div>
						</div>
						@endforeach

						@endif

					</div>
				</div>
			</div>

			<div class="intro-y box mt-3">
				<div class="p-5">
					<div class="grid grid-cols-12">
						<div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
							<label for="message" class="form-label w-full flex flex-col sm:flex-row">
								Message
							</label>
							<textarea id="message" rows="2" name="message" class="form-control form__input tinymce" placeholder="Enter message" minlength="2"></textarea>
							<div id="error-message" class="login__input-error w-5/6 text-theme-6"></div>
						</div>
					</div>

					<div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-2">
						<label for="status" class="form-label w-full flex flex-col sm:flex-row">
							Status
						</label>
						<select id="status" name="status" class="form-select form__input">
							@if ($ticket->status=='0')
							<option value="0" {{$ticket->status=='0'?'selected':''}}>Open</option>
							@else
							<option value="3" {{$ticket->status=='3'?'selected':''}}>Reopen</option>
							@endif

							@if($ticket->status=='0' || $ticket->status=='3')
							<option value="1" {{$ticket->status=='1'?'selected':''}}>Close</option>
							<option value="2" {{$ticket->status=='1'?'selected':''}}>Reject</option>
							@endif
						</select>
					</div>
				</div>
			</div>

			<div class="input-form col-span-12 lg:col-span-12 py-1 mt-3">
				<button type="submit" id="btn-submit" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Submit</button>
			</div>


		</form>
	</div>
	<x-notification></x-notification>
</div> 
@endsection

@section('script')
<script>
	cash(function () {
		async function add() {

			cash('#edit-form').find('.form__input').removeClass('border-theme-6')
			cash('#edit-form').find('.login__input-error').html('')

			var formData = new FormData(document.querySelector('#edit-form'))

			cash('#btn-submit').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
			cash('#btn-submit').attr('disabled', 'true');  

			

			axios.post('{{ url('/admin/support/'.encrypt($ticket->id).'/edit') }}', formData).then(res => {
				
				showNotification('success','Success !',res.data.message)
				setTimeout(()=>{
					window.location.href = '{{ url('/admin/support') }}'
				},1000)

			}).catch(err => {
				showNotification('error','Error !',err.response.data.message)
				cash('#btn-submit').html('Submit')   
				
				cash('#btn-submit').removeAttr('disabled');              

				if (err.response.data.errors) {
					for (const [key, val] of Object.entries(err.response.data.errors)){
						cash(`#${key}`).addClass('border-theme-6')
						cash(`#error-${key}`).html(val)
					}
				}

			})
		}

		cash('#edit-form').on('submit', function(e) {
			e.preventDefault();
			add();
		})

	})
</script>
@endsection
