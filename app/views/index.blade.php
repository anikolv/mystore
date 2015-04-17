@extends('layouts.master')


@section('user-sidebar')
	@parent
@stop

@section('admin-sidebar')

@stop


@section('content')

<div class="row">
		<div class="col-md-11">
		</div>
		<div class="col-md-1">
			<img src="../assets/images/loader.gif" id="loading-indicator" />
		</div>
</div>

	<div data-bind="foreach: phones">
		<div style="width: 200px;">
			<img class="image-small" alt=""  data-bind="attr: { src: image_src }">
			<span data-bind="'text': name"></span>
			<span data-bind="'text': description"></span>
		</div>
	</div>


@stop

@section('scripts')
	<script>
		$('#loading-indicator').hide();

		var viewModel = null;
		
		$(document).ready(function(){

			$(document).ajaxStart(function() {
				$('#loading-indicator').show();
			});

			$(document).ajaxStop(function() {
				$('#loading-indicator').hide();	
			});
			
	  		$('.slider8').bxSlider({
	    		mode: 'vertical',
	    		slideWidth: 300,
	    		minSlides: 2,
	    		slideMargin: 10
	  		});

	  		$.ajax({
				url : "store/getPhones"
			}).done(function(data) {
				var status = $.parseJSON(data);
				console.log(status);
				viewModel = ko.mapping.fromJS(status);
				viewModel.phones().forEach(function(phone) {

					phone.image_src = ko.computed(function() {
						return '../assets/product_images/' + phone.image();
					}, viewModel);
					
				});
				ko.applyBindings(viewModel);
			});
		});
	</script>		
@stop