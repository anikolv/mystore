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

<div id="products" data-bind="foreach: products">
		<div class="well-white">
			<div class="row">
				<div class="col-md-3">
					<img class="image-small" alt=""  data-bind="attr: { src: image_src }">
				</div>
				<div class="col-md-4" style="margin-right: 60px;">
					<div class="row" style="margin-bottom: 40px;">
						<span class="product-title" data-bind="'text': name"></span>
					</div>
					<div class="row">
						<span class="" data-bind="'text': description" style="color: black;font-size:20px;"></span>
					</div>
				</div>
			 	<div class="col-md-4">
			 		<div class="row" style="text-align: center;margin-top: 90px;">
			 			<input type="button" class="btn btn-primary" value="Премахни от количка" data-bind='click:  function(product) { $parent.remove_product(product)}'>
			 		</div>
			 	</div>
			</div>
			<div class="row">
				<span class="product-price" data-bind="'text': price_computed"></span>
			</div>
		</div>
	</div>

	<div id="empty_cart" class="alert alert-info" role="alert" style="margin-right: 50px;margin-top: 300px">
	</div>


@stop

@section('scripts')
	<script>
		$('#loading-indicator').hide();

		var viewModel = null;

		$('#mycart').addClass('liActive');
		
		
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
				url : "/store/getMyCart"
			}).done(function(data) {
				var status = $.parseJSON(data);
				if ( status.result ) {
					$('#products').hide();
					$('#empty_cart').html('Вашата количка е празна !');
				} else {
					$('#empty_cart').hide();
					viewModel = ko.mapping.fromJS(status);
					viewModel.products().forEach(function(product) {

						product.image_src = ko.computed(function() {
							return '../assets/product_images/' + product.image();
						}, viewModel);

						product.price_computed = ko.computed(function() {
							return product.price_bgn() + ' лв';
						}, viewModel);
						
					});

					viewModel.remove_product = function(product) {
						
						$.ajax({
							method: "POST",
							url: "/store/removeFromCart/" + product.id(),
							contentType: "application/json; charset=utf-8"
						}).done(function(returnedData) {
							window.location = "/store/mycart";
					});
				};
					ko.applyBindings(viewModel);
				}
			});
		});
	</script>		
@stop