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
				<form>
				<fieldset>
					<br/>
					<div class="form-group">
							 <label for="name">Име</label>
							 <input type="text" class="form-control input" id="name" placeholder="" data-bind="value: name">
					</div>
					<div class="form-group">
							 <label for="address">Адрес</label>
							 <input type="text" class="form-control input" id="address" placeholder="" data-bind="value: address">
					</div>
					<div class="form-group">
							 <label for="email">Имейл</label>
							 <input type="email" class="form-control input" id="email" placeholder="" data-bind="value: email">
					</div>
					<div class="row" style="margin-left: 140px;">
						<input type="button" class="btn btn-primary" value="Купи" data-bind='click: buy'>
						<a href="">.. или влез в профила си</a>
					</div>
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
		});
	</script>	
@stop