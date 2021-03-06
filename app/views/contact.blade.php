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
						@lang("user_panel.contact")
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
							 <input type="text" class="form-control input" id="name" placeholder="" data-bind="value: name">
					</div>
					<div class="form-group">
							 <label for="email">@lang("user_panel.email")</label>
							 <input type="email" class="form-control input" id="email" placeholder="" data-bind="value: email">
					</div>
					<div class="form-group">
							 <label for="password">@lang("user_panel.message")</label>
							 <textarea class="form-control" rows="3" placeholder="@lang('user_panel.your_message')" data-bind="value: message" required></textarea>
					</div>
					<div>
						<input type="button" class="btn btn-primary" value="@lang('user_panel.send')" data-bind='click: send'>
					</div>
				</fieldset>
				</form>
			</div>
		</div>
	</div>
	
	<div class="row" style="margin-right: 170px;">
		@lang("user_panel.my_contacts")
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

	  		viewModel = {
	  		  		
	  				name: ko.observable()
							.extend({required: {
								params: true,
								message: "@lang('user_panel.required')"
					        }}),
	

					email: ko.observable()
							.extend({required: {
								params: true,
								message: "@lang('user_panel.required')"
					        }})
							.extend({pattern: {params: '^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$', message: "@lang('user_panel.valid_mail')"}}),

					message: ko.observable()
							.extend({required: {
								params: true,
								message: "@lang('user_panel.required')"
					        }}),

					validateFields : function(){
								this.errors = ko.validation.group([this.name, this.email, this.message]);
							},

					send : function() {
							var data =  ko.mapping.toJSON(this);
								if (this.errors().length == 0) {
									$.ajax({
										method: "POST",
										url: "/sendMessage", 
										data: data,
										contentType: "application/json; charset=utf-8"
									}).done(function(returnedData) {
  										var status = $.parseJSON(returnedData);
 										if (status.result) $('.well').append('<div class="alert alert-danger" role="alert" style="margin-right:156px; margin-top:30px;">' + status.message + '</div>');
 										else $('.well').html('<div class="alert alert-success" role="alert" style="margin-right:156px;margin-top:30px;">' + status.message + '</div>');
									});
								} else {
									this.errors.showAllMessages();
									this.validateFields();
								}
							}
	  		}
	  		viewModel.validateFields();
	  		ko.applyBindings(viewModel);
		});
	</script>	
@stop