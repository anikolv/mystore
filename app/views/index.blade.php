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
		<div class="well-white">
			<div class="row">
				<div class="col-md-3">
					<img class="image-small" alt=""  data-bind="attr: { src: image_src }">
				</div>
				<div class="col-md-4">
					<div class="row" style="">
						<span class="product-title" data-bind="'text': name"></span>
					</div>
					<div class="row">
						<span class="" data-bind="'text': description" style="color: black;font-size:20px;"></span>
					</div>
				</div>
			 	<div class="col-md-4">
			 	</div>
			</div>
			<div class="row">
				<span class="product-price" data-bind="'text': price_computed"></span>
			</div>
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

					phone.price_computed = ko.computed(function() {
						return phone.price_bgn() + ' лв';
					}, viewModel);
					
				});
				ko.applyBindings(viewModel);
			});
		});
	</script>		
@stop