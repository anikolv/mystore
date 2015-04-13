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
						<th colspan="6" class="ts-pager form-horizontal">
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

<div class="well">
	<div class="row" style="text-align: left; padding-left: 15px;">
		<div class="row">
			Продукти:
		</div>
		<br>
		<div class="row" id="cart_products">
		</div>
	</div>
</div>
@stop

@section('scripts')

<script>

	$('#loading-indicator').hide();
	$('.tablesorter').hide();

	$('#orders').addClass('liActive');

	$('.well').hide();


	$(document).ajaxStart(function() {
		$('#loading-indicator').show();
	});
	
	$(document).ajaxStop(function() {
		$('#loading-indicator').hide();
	});

	$(document).ready(function() {


		var selectedIndex;
		
		$('table')
	     .on('click', 'tbody tr', function(){
	         if ( typeof selectedIndex != 'undefined' ) {
	        	 $('tr', 0).removeAttr('style');
	         }
	         selectedIndex = $(this).closest('tr').children().eq(0).text();
	        // $(this).closest('tr').css('color','red');
	         $(this).closest('tr').css('background-color','blue');

	         if ( typeof selectedIndex != 'undefined' ) {
					$.ajax({
						method: "POST",
						url: "admin/getCartProducts", 
						data: JSON.stringify({ id: selectedIndex }),
						contentType: "application/json; charset=utf-8"
					}).done(function(returnedData) {
						var status = $.parseJSON(returnedData);
						for (i = 0; i < status.products.length; i++) { 
							console.log('test');
						    $('#cart_products').append(status.products[i].name);
						    $('.well').show();
						}
					});
				}
	     });
		
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
		      ajaxUrl : 'admin/orders?page={page}&size={size}&{sortList:col}',

		      customAjaxUrl: function(table, url) {
		          $(table).trigger('changingUrl', url);
		          return url;
		      },

			
		      ajaxObject: {
		        dataType: 'json'
		      },

		      ajaxProcessing: function(data){
		        if (data) {
		          var r, row, c, d = data.orders,
		          total = data.count,

		          headers = ["No", "Created at", "Customer Name", "Customer Address", "Amount", "Status"],
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