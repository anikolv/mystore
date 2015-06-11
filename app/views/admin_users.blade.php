@extends('layouts.master')


@section('user-sidebar')
	
@stop

@section('admin-sidebar')
	@parent
@stop

@section('content')


<div class="row">
		<div class="col-md-11">
			<div>
				<table id="orders_table">
  					<thead>
    					<tr>
      						<th></th>
      						<th></th>
      						<th></th>
      						<th></th>
      						<th></th>
      						<th></th>
    					</tr>
  				</thead>
   				<tfoot>
    				<tr>
    				</tr>
    				<tr>
						<th colspan="7" class="ts-pager form-horizontal">
						<button type="button" class="btn first"><i class="icon-step-backward fa fa-step-backward"></i></button>
						<button type="button" class="btn prev"><i class="icon-arrow-left fa fa-backward"></i></button>
						<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
						<button type="button" class="btn next"><i class="icon-arrow-right fa fa-forward"></i></button>
						<button type="button" class="btn last"><i class="icon-step-forward fa fa-step-forward"></i></button>
					</th>
   	 				</tr>
  				</tfoot>
  				<tbody> <!-- tbody will be loaded via JSON -->
  				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-1">
		<img src="../assets/images/loader.gif" id="loading-indicator" />
	</div>
</div>
<div class="row" style="text-align: left; padding-left: 15px;margin-bottom:40px;">
	<input type="button" class="btn btn-primary" value="@lang('admin_panel.add')" id='add'>
	<input type="button" class="btn btn-primary" value="@lang('admin_panel.remove')" id='remove'>
	<input type="button" class="btn btn-primary" value="Modify" id='modify'>
</div>

<div class="well">
	<div class="row" style="text-align: left; padding-left: 15px;">
		<form enctype="multipart/form-data">
			<fieldset>
				<div class="form-group">
					 <label for="name">@lang('user_panel.name')</label>
				 	<input type="text" class="form-control input" id="name" placeholder="" data-bind="value: name">
				</div>
				<div class="form-group">
					 <label for="address">@lang('user_panel.address')</label>
				 	 <textarea class="form-control" rows="3" placeholder="User address..." data-bind="value: address" required></textarea>
				</div>
				<div class="form-group">
					 <label for="email">@lang('user_panel.email')</label>
				 	 <input type="text" class="form-control input" id="email" placeholder="" data-bind="value: email">
				</div>
				<div class="form-group">
					 <label for="address">@lang('user_panel.password')</label>
				 	<input type="password" class="form-control input" id="password" placeholder="" data-bind="value: password">
				</div>
				<div class="form-group">
					 <label for="role">@lang('admin_panel.role')</label>
					 <br>
				 	<select class="form-control input" data-bind="value: role">
				 		<option value='1'>@lang('admin_panel.user')</option>
				 		<option value='2'>@lang('admin_panel.admin')</option>
					</select>
				</div>
				<div style="text-align: center;" id="add_user">
					<input type="button" class="btn btn-primary" value="@lang('admin_panel.add')" data-bind='click: add'>
				</div>
			</fieldset>
		</form>
	</div>
</div>
@stop

@section('scripts')

<script>

	$('#loading-indicator').hide();
	$('.tablesorter').hide();

	$('#users').addClass('liActive');

	$('.well').hide();
	$('#remove').hide();
	$('#modify	').hide();

	$('#cur_div').hide();
	var selectedIndex;

	 $('table')
     .on('click', 'tbody tr', function(){
         if ( typeof selectedIndex != 'undefined' ) {
        	 $('tr', 0).removeAttr('style');
         }
         selectedIndex = $(this).closest('tr').children().eq(0).text();
        // $(this).closest('tr').css('color','red');
         $(this).closest('tr').css('background-color','blue');
         $('#remove').fadeIn();
     	// $('#modify	').fadeIn();
     });

	 $( "#remove" ).click(function() {
			if ( typeof selectedIndex != 'undefined' ) {
				$.ajax({
					method: "POST",
					url: "admin/removeUser", 
					data: JSON.stringify({ id: selectedIndex }),
					contentType: "application/json; charset=utf-8"
				}).done(function(returnedData) {
						location.href = 'adminUsers';
				});
			}
			});


	$(document).ajaxStart(function() {
		$('#loading-indicator').show();
	});
	
	$(document).ajaxStop(function() {
		$('#loading-indicator').hide();
	});

	$(document).ready(function() {

		$( "#add" ).click(function() {
			$('.well').fadeIn();
			});

		viewModel = {
  		  		
  				name: ko.observable()
						.extend({required: {
							params: true,
							message: "@lang('user_panel.required')"
				        }}),

				address: ko.observable()
						.extend({required: {
							params: true,
							message: "@lang('user_panel.required')"
				        }}),		

				email: ko.observable()
						.extend({required: {
							params: true,
							message: "@lang('user_panel.required')"
				        }}),

				role: ko.observable()
						.extend({required: {
							params: true,
							message: "@lang('user_panel.required')"
				        }}),

				password: ko.observable()
						.extend({required: {
							params: true,
							message: "@lang('user_panel.required')"
				        }}),

				validateFields : function(){
							this.errors = ko.validation.group([this.name, this.address, this.email, this.role, this.password]);
						},

				add : function() {
						var data =  ko.mapping.toJSON(this);
							if (this.errors().length == 0) {
								$.ajax({
									method: "POST",
									url: "admin/addUser", 
									data: data,
									contentType: "application/json; charset=utf-8"
								}).done(function(returnedData) {
										location.href = 'adminUsers';
								});
							} else {
								this.errors.showAllMessages();
								this.validateFields();
							}
						}
  		}

		viewModel.validateFields();
  		ko.applyBindings(viewModel);
	
		
		$("table").tablesorter({
			    theme : "bootstrap",
			    headerTemplate : '{content} {icon}',
			    widgets : [ "uitheme", "zebra", "pager", "select"],
	   
			    widgetOptions : {
	
			      zebra : ["even", "odd"],
			        pager_startPage: 0,

			        // Number of visible rows
			        pager_size: 10,
			    }
			  })
			
		    .tablesorterPager({
		      container: $(".ts-pager"),
		      ajaxUrl : 'admin/users?page={page}&size={size}&{sortList:col}',

		      customAjaxUrl: function(table, url) {
		          $(table).trigger('changingUrl', url);
		          return url;
		      },

			
		      ajaxObject: {
		        dataType: 'json'
		      },

		      ajaxProcessing: function(data){
		        if (data) {
		          var r, row, c, d = data.users,
		          total = data.count,

		          headers = ["@lang('admin_panel.number')", "@lang('admin_panel.created')", "@lang('user_panel.name')", "@lang('user_panel.address')", "@lang('user_panel.email')", "@lang('admin_panel.role')"],
				  rows = [],
		          len = d.length;
		          for ( r=0; r < len; r++ ) {
		            row = [];

		            for ( c in d[r] ) {
		              if (typeof(c) === "string") {
		                row.push(d[r][c]); 
		              }
		            }
		            rows.push(row); 
		          }
		          return [ total, rows, headers ];
		        }
		      },
		      
		      fixedWidth: true,
		      removeRows: false,
		      startPage: 0,
		      size: 10,
		      savePages: true,
		      cssGoto: ".pagenum"
		    });		

	});
		  
</script>

@stop