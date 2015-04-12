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
    					</tr>
  				</thead>
   				<tfoot>
    				<tr>
    				</tr>
    				<tr>
						<th colspan="5" class="ts-pager form-horizontal">
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
	<input type="button" class="btn btn-primary" value="Add" id='add'>
	<input type="button" class="btn btn-primary" value="Remove" id='remove'>
	<input type="button" class="btn btn-primary" value="Modify" id='modify'>
</div>

<div class="well">
	<div class="row" style="text-align: left; padding-left: 15px;">
		<form enctype="multipart/form-data">
			<fieldset>
				<div class="form-group">
					 <label for="name">Name</label>
				 	<input type="text" class="form-control input" id="name" placeholder="" data-bind="value: name">
				</div>
				<div class="form-group">
					 <label for="description">Description</label>
				 	 <textarea class="form-control" rows="3" placeholder="Product description..." data-bind="value: description" required></textarea>
				</div>
				<div class="form-group">
					 <label for="category">Category</label>
					 <br>
				 	<select class="form-control input" data-bind="value: category">
				 		<option value='1'>Phones</option>
				 		<option value='2'>Tablets</option>
				 		<option value='3'>Notebooks</option>
				 		<option value='4'>TVs</option>
					</select>
				</div>
				<div class="form-group">
					 <label for="name">Price</label>
				 	<input type="text" class="form-control input" id="price" placeholder="" data-bind="value: price">
				</div>
				<div class="form-group">
					 <label for="description">Qty</label>
					 <input type="text" class="form-control input" id="qty" placeholder="" data-bind="value: qty">		</div>
				<div class="form-group">
					 <label for="name">Image</label>
				 	 <div style="position:relative;">
						<a class='btn btn-primary' href='javascript:;'>
						Choose File...
						<input type="file" class="file-input" name="file_source" size="40"  onchange=''>
						</a>
						&nbsp;
						<span class='label label-info' id="upload-file-info" data-bind="text: image"></span>
					 </div>
				</div>
				<div style="text-align: center;">
					<input type="button" class="btn btn-primary" value="Add" data-bind='click: add'>
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

	$('#products').addClass('liActive');
	$('.well').hide();
	$('#remove').hide();
	$('#modify	').hide();

	var selectedIndex;

	 $('table')
     .on('click', 'tbody tr', function(){
         if ( typeof selectedIndex != 'undefined' ) {
        	 $('tr', 0).removeAttr('style');
         }
         selectedIndex = $(this).closest('tr').children().eq(0).text();
         $(this).closest('tr').css('color','red');
         $(this).closest('tr').css('background-color','yellow');
         $('#remove').fadeIn();
     	 $('#modify	').fadeIn();
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

		$( "#remove" ).click(function() {
			if ( typeof selectedIndex != 'undefined' ) {
				$.ajax({
					method: "POST",
					url: "admin/removeProduct", 
					data: JSON.stringify({ id: selectedIndex }),
					contentType: "application/json; charset=utf-8"
				}).done(function(returnedData) {
						location.href = 'adminProducts';
				});
			}
			});

		$( "#modify" ).click(function() {
			
			
			});
		
		$(".file-input").change(function() {
			var elem = $("#upload-file-info");
			fullPath = $(this).val();

	        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
	    	var filename = fullPath.substring(startIndex);
	    	if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
	    		filename = filename.substring(1);
	    	}

	    	viewModel.image(filename);
	  	    });
		

		viewModel = {
	  		  		
	  				name: ko.observable()
							.extend({required: true}),

					description: ko.observable()
							.extend({required: true}),		

					category: ko.observable()
							.extend({required: true}),

					price: ko.observable()
							.extend({required: true}),
							
					qty: ko.observable()
							.extend({required: true}),
							
 					image: ko.observable(),

					validateFields : function(){
								this.errors = ko.validation.group([this.name, this.description, this.price, this.qty]);
							},

					add : function() {
							var data =  ko.mapping.toJSON(this);
								if (this.errors().length == 0) {
									$.ajax({
										method: "POST",
										url: "admin/addProduct", 
										data: data,
										contentType: "application/json; charset=utf-8"
									}).done(function(returnedData) {
 										location.href = 'adminProducts';
									});
								} else {
									this.errors.showAllMessages();
									this.validateFields();
								}
							}
	  		}

			viewModel.image.subscribe(function (value) {
	        	
			 });
	  		viewModel.validateFields();
	  		ko.applyBindings(viewModel);
		
		$("table").tablesorter({
			    theme : "bootstrap",
			    headerTemplate : '{content} {icon}',
			    widgets : [ "uitheme", "zebra", "pager"],
			    widgetOptions : {
			      zebra : ["even", "odd"],
			        pager_startPage: 0,

			        // Number of visible rows
			        pager_size: 10,
			    }
			  })
			
		    .tablesorterPager({
		      container: $(".ts-pager"),
		      ajaxUrl : 'admin/products?page={page}&size={size}&{sortList:col}',

		      customAjaxUrl: function(table, url) {
		          $(table).trigger('changingUrl', url);
		          return url;
		      },

			
		      ajaxObject: {
		        dataType: 'json'
		      },

		      ajaxProcessing: function(data){
		        if (data) {
		          var r, row, c, d = data.products,
		          total = data.count,

		          headers = ["No", "Name", "Category", "Price", "Qty"],
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