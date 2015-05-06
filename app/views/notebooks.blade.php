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
						@lang('user_panel.notebooks')
			</legend>
		</div>
		<div class="col-md-1">
			<img src="../assets/images/loader.gif" id="loading-indicator" />
		</div>
</div>

	<div data-bind="foreach: notebooks">
		<div class="well-white">
			<div class="row">
				<div class="col-md-3" style="margin-top: 50px;">
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
			 			<input type="button" class="btn btn-primary" value="@lang('user_panel.add_cart')" data-bind='click:  function(notebook) { $parent.cart_request(notebook)}'>
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

		$('#notebooks').addClass('liActive');
		
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
				url : "/store/getNotebooks"
			}).done(function(data) {
				var status = $.parseJSON(data);
				console.log(status);
				viewModel = ko.mapping.fromJS(status);
				viewModel.notebooks().forEach(function(notebook) {

					notebook.image_src = ko.computed(function() {
						return '../assets/product_images/' + notebook.image();
					}, viewModel);

					notebook.amount = ko.computed(function() {
						return "@lang('user_panel.available')" + ': ' + notebook.qty();
					}, viewModel);

					notebook.price_computed = ko.computed(function() {
						return notebook.price_bgn() + " " + status.currency;
					}, viewModel);
					
				});

				viewModel.cart_request = function(notebook) {
					
					$.ajax({
						method: "POST",
						url: "/store/addToCart/" + notebook.id(),
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