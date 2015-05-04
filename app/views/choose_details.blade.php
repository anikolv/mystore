@extends('layouts.master')


@section('user-sidebar')
	@parent
@stop

@section('admin-sidebar')
	
@stop

@section('content')

<div class="row">
		<div class="col-md-11">
			<div id="legend">
					<legend style="padding-right: 120px;">
						Потребителски данни
					</legend>
			</div>
		</div>
		<div class="col-md-1">
			<img src="../assets/images/loader.gif" id="loading-indicator" />
		</div>
	</div>
	<div class="well">
		<div class="row" id="register">
			<div class="col-md-9">
				<form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
				<fieldset>
					<br/>
					<div class="form-group">
							 <label for="name">Име</label>
							 <input type="text" class="form-control input" id="name" placeholder="" data-bind="value: name" name="first_name">
					</div>
					<div class="form-group">
							 <label for="address">Адрес</label>
							 <input type="text" class="form-control input" id="address" placeholder="" data-bind="value: address" name="address1">
					</div>
					<div class="form-group">
							 <label for="email">Имейл</label>
							 <input type="email" class="form-control input" id="email" placeholder="" data-bind="value: email" name="email">
					</div>
					<div class="row" style="margin-left: 140px;">
						<input id="buy" name="submit" type="submit" class="btn btn-primary" value="Купи" id="">
					</div>
					<input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="webteck-facilitator@abv.bg">
                    <input type="hidden" name="item_name" value="Webteck online store">
                    <input type="hidden" name="item_number" data-bind="value: orderid">
                    <input type="hidden" name="currency_code" value="EUR">
                    <input type="hidden" name="amount" data-bind="value: amount"> 
                    <input type="hidden" name="notify_url" data-bind="value: notify_url">
                    <input type="hidden" name="return" data-bind="value: return_url">
                    <input type="hidden" name="cancel_return" data-bind="value: return_url">
				</fieldset>
				</form>
			</div>
		</div>
	</div>
	
@stop

@section('scripts')
	<script>
		$(document).ready(function(){

			$('#loading-indicator').hide();
			
	  		$('.slider8').bxSlider({
	    		mode: 'vertical',
	    		slideWidth: 300,
	    		minSlides: 2,
	    		slideMargin: 10
	  		});

	  		$(document).ajaxStart(function() {
	  			$('#loading-indicator').show();
	  		});
	  		
	  		$(document).ajaxStop(function() {
	  			$('#loading-indicator').hide();
	  		});

	  		$( "#buy" ).click(function() {
	  			$.ajax({
					url : "/flushSession/"
				}).done(function(data) {
				});
	  		});

	  		$.ajax({
				url : "/user/getDetails/"
			}).done(function(data) {
				var status = $.parseJSON(data);
				viewModel = ko.mapping.fromJS(status);
				ko.applyBindings(viewModel);
				$('#buy').css('margin-right', '160px');
			});
		});
	</script>	
@stop