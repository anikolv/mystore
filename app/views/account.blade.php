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
						@lang("user_panel.account")
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
				<form>
				<fieldset>
					<br/>
					<div class="form-group">
							 <label for="name">@lang("user_panel.name")</label>
							 <input type="text" class="form-control input" id="name" placeholder="" data-bind="value: name" name="first_name">
					</div>
					<div class="form-group">
							 <label for="address">@lang("user_panel.address")</label>
							 <input type="text" class="form-control input" id="address" placeholder="" data-bind="value: address" name="address1">
					</div>
					<div class="form-group">
							 <label for="email">@lang("user_panel.email")</label>
							 <input type="email" class="form-control input" id="email" placeholder="" data-bind="value: email" name="email">
					</div>
					<div class="row" style="margin-left: 140px;">
						<input id="buy" name="submit" type="submit" class="btn btn-primary" value="@lang('user_panel.save')" id="save" data-bind='click: save' style="margin-right: 150px;">
					</div>
				</fieldset>
				</form>
			</div>
		</div>
	</div>
	<div id="auth_failed" class="alert alert-info" role="alert" style="margin-right: 50px;margin-top: 120px;display: block;width: 700px;margin-left: 60px;"">
	</div>
	<div style="margin-top: 120px;">
		<img src="../assets/images/apple_ipad_mini.jpg" style="margin-right: 150px;width: 700px;margin-bottom: 100px;border: groove;"/>
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

	  		$.ajax({
				url : "/getAccount/"
			}).done(function(data) {
				var status = $.parseJSON(data);
				if ( !status.result ) {
					viewModel = ko.mapping.fromJS(status);
					$('#save').css('margin-right', '160px');
					$('#auth_failed').hide();

					viewModel.save = function() {

						var data =  ko.mapping.toJSON(this);

							$.ajax({
								method: "POST",
								url: "/changeAccount", 
								data: data,
								contentType: "application/json; charset=utf-8"
							}).done(function(returnedData) {
								$('.well').append('<div class="alert alert-success" role="alert" style="margin-right:156px; margin-top:30px;">@lang("user_panel.success")</div>');
							});
											
						
					};
					ko.applyBindings(viewModel);
				} else {
					$('#auth_failed').html('@lang("user_panel.not_profile")');
					$('.well').hide();
					$('#auth_failed').show();
				}
		});
		});
	</script>	
@stop