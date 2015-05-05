@extends('layouts.master')


@section('user-sidebar')
	@parent
@stop

@section('admin-sidebar')

@stop


@section('content')

<div class="row">
		<div class="col-md-11">
			<legend style="padding-right: 120px;">
						@lang('user_panel.phones')
			</legend>
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
				<div class="col-md-4" style="margin-right: 60px;">
					<div class="row" style="margin-bottom: 40px;">
						<span class="product-title" data-bind="'text': name"></span>
					</div>
					<div class="row" style="font-style: oblique;font-family: -webkit-pictograph;">
						<span class="" data-bind="'text': description" style="color: black;font-size:20px;"></span>
					</div>
				</div>
			 	<div class="col-md-4">
			 		<div class="row" style="margin-bottom: 80px;text-align: center;">
			 			<span class="product-title" data-bind="'text': amount"></span>
			 		</div>
			 		<div class="row" style="text-align: center;">
			 			<input type="button" class="btn btn-primary" value="Добави в количка" data-bind='click:  function(phone) { $parent.cart_request(phone)}'>
			 		</div>
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

		$('#phones').addClass('liActive');
		
		$(document).ready(function(){

			$(document).ajaxStart(function() {
				$('#loading-indicator').show();
			});

			$(document).ajaxStop(function() {
				$('#loading-indicator').hide();	
			});
			
			slider = $('.slider8').bxSlider({
	    		mode: 'vertical',
	    		slideWidth: 300,
	    		minSlides: 2,
	    		slideMargin: 10
	  		});

			slider.startAuto();

	  		$.ajax({
				url : "store/getPhones"
			}).done(function(data) {
				var status = $.parseJSON(data);
				viewModel = ko.mapping.fromJS(status);
				viewModel.phones().forEach(function(phone) {

					phone.image_src = ko.computed(function() {
						return '../assets/product_images/' + phone.image();
					}, viewModel);

					phone.amount = ko.computed(function() {
						return 'Налично количество: ' + phone.qty();
					}, viewModel);

					phone.price_computed = ko.computed(function() {
						return phone.price_bgn() + ' лв';
					}, viewModel);
					
				});

				viewModel.cart_request = function(phone) {
						
					$.ajax({
						method: "POST",
						url: "/store/addToCart/" + phone.id(),
						contentType: "application/json; charset=utf-8"
					}).done(function(returnedData) {
						window.location = "/";
				});
			};
			ko.applyBindings(viewModel);
		});
	});
	</script>		
@stop