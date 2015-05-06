@extends('layouts.master')


@section('user-sidebar')
	@parent
@stop

@section('admin-sidebar')

@stop


@section('content')

<div class="row">
		<div class="col-md-11">
			<div id="legend" style="margin-right: 60px;">
					<legend>
						@lang("user_panel.cart")
					</legend>
			</div>
		</div>
		<div class="col-md-1">
			<img src="../assets/images/loader.gif" id="loading-indicator" />
		</div>
</div>

<div id="products" data-bind="foreach: products">
		<div class="well-white">
			<div class="row">
				<div class="col-md-3" style="margin-right: 60px;">
					<span class="product-title" data-bind="'text': name"></span>
				</div>
				<div class=col-md-3 style="margin-right: 50px;">
					<span class="product-price" data-bind="'text': price_computed"></span>
				</div>
			 	<div class="col-md-4">
			 		<input type="button" class="btn btn-primary" value="@lang('user_panel.remove_cart')" data-bind='click:  function(product) { $parent.remove_product(product)}'>
			 	</div>
			</div>
		</div>
</div>
<div class="row" style="text-align: right;padding-right: 300px;margin-bottom: 40px;">
	<span class="product-price" data-bind="'text': total_comp" style="font-size: 20px;"></span>
</div>

<div class="row" style="display:none;text-align: right;padding-right: 300px;margin-bottom: 40px;" data-bind="'visible': bgn_total() >= 1000">
	<span class="product-price" data-bind="'text': discount_comp, 'visible': bgn_total() >= 1000" style="font-size: 20px;"></span>
	<hr style="border-top:1px solid #0B0808">
	<span class="product-price" data-bind="'text': final_price ,'visible': bgn_total() >= 1000" style="font-size: 20px;"></span>
</div>

<div id="empty_cart" class="alert alert-info" role="alert" style="margin-right: 50px; display: block;width: 700px;margin-left: 60px;">
</div>

<div class="row" style="margin-bottom:100px">
	<input id="go" type="button" class="btn btn-success" value="@lang('user_panel.buy')" style="width: 200px;margin-right: 150px;">
</div>

<div>
	<img src="../assets/images/discount.jpg" style="margin-right: 120px;width: 700px;margin-bottom: 100px;border: groove;"/>
</div>


@stop

@section('scripts')
	<script>
		$('#loading-indicator').hide();

		var viewModel = null;
		$('#empty_cart').hide();
		$('#go').hide();

		$('#mycart').addClass('liActive');
		
		
		$(document).ready(function(){

			$( "#go" ).click(function() {
				window.location = "/store/choose_details/";
			});
			
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
					$('#empty_cart').html('@lang("user_panel.empty_cart")');
					$('#empty_cart').show();
				} else {
					$('#empty_cart').hide();
					$('#go').show();
					viewModel = ko.mapping.fromJS(status);
					viewModel.products().forEach(function(product) {

						product.image_src = ko.computed(function() {
							return '../assets/product_images/' + product.image();
						}, viewModel);

						product.price_computed = ko.computed(function() {
							return product.price_bgn() + " " +  status.currency;
						}, viewModel);
						
					});

					viewModel.discount = ko.computed(function() {
						return viewModel.total() * 0.1;
					}, viewModel);

					viewModel.discount_comp = ko.computed(function() {
						return "@lang('user_panel.discount')" + ": " + viewModel.discount().toFixed(2) + " " +  status.currency;
					}, viewModel);

					viewModel.total = ko.computed(function() {
						return viewModel.total();
					}, viewModel);
					
					viewModel.total_comp = ko.computed(function() {
						return "@lang('user_panel.total')" + ': ' + viewModel.total() + " " + status.currency;
					}, viewModel);

					viewModel.final_price = ko.computed(function() {
						return "@lang('user_panel.final_price')" + ": " + (viewModel.total() - viewModel.discount()).toFixed(2) + " " + status.currency ;
					}, viewModel);


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