@extends('layouts.master')

@section('title', trans('invoice.add_invoice'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">   
    <link href="vendor/select2-4.0.13/css/select2.min.css" rel="stylesheet">
	<link href="vendor/select2-4.0.13/css/select2-boostrap.min.css" rel="stylesheet">
	<style>
		#content {
			position:relative;
		}

		.footer{
    		bottom: 0;
			text-align: center;
			width: 100%;
			padding: 10px 0px;
		}

		.table {
			/* margin-bottom: 8rem; */
		}

		.customerInfo {
			font-size: 15px;
		}
	</style>   
@stop

@section('page-heading', trans('invoice.add_invoice'))
        
@section('content')
    
	<div id="searchCustomer">	
		<h5>{{trans('invoice.customer_information')}}</h5>
        <div class="customerInputArea" style="width: 30%;">
			<div class="form-group">
				<select class="form-control" id="customerSearch">
				</select>
			</div>           
        </div>
       
        <div id="customerInfo" style="display: none;">
            <table style="width: 30%;">
                <tr>
                    <th>{{trans('invoice.customer_id')}}:</th>
                    <td class="customer-id"></td>
                </tr>
                <tr>
                    <th>{{trans('invoice.customer_name')}}: </th>
                    <td class="customer-name"></td>
                </tr>
                <tr>
                    <th>{{trans('invoice.customer_phone')}}: </th>
                    <td class="customer-phone"></td>
                </tr>
				<tr>
                    <th>{{trans('invoice.customer_email')}}: </th>
                    <td class="customer-email"></td>
                </tr>
				<tr>
                    <th>{{trans('invoice.customer_address')}}: </th>
                    <td class="customer-address"></td>
                </tr>
				<tr>
                    <th>{{trans('invoice.customer_debt')}}: </th>
                    <td class="customer-debt"></td>
                </tr>
            </table>
        </div>      
    </div>
	<hr style="border: 1px solid black;">
	<h5>{{trans('invoice.detail_invoice')}}</h5>
	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	
    <table class="table" id="listItem">
        <thead>
            <tr>
                <th scope="col" style="width: 25%">{{trans('invoice.name')}}</th>
                <th scope="col" style="width: 15%">{{trans('invoice.publisher')}}</th>
                <th scope="col" style="width: 10%">{{trans('invoice.publishing_year')}}</th>
                <th scope="col" style="width: 10%">{{trans('invoice.quanlity')}}</th>
                <th scope="col" style="width: 20%">{{trans('invoice.price')}}</th>
                <th scope="col" style="width: 15%">{{trans('invoice.total_price')}}</th>
                <th scope="col" style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>
            <tr class="blank-item">
				<input type="hidden" class="item-id">
                <td class="book-name">
                    <button type="button" class="btn btn-success choose-btn" data-toggle="modal" data-target="#chooseModal">{{trans('invoice.choose_book')}}</button>
                </td>
                <td class="book-publisher"></td>
                <td class="book-publishing-year"></td>
                <td><input class="form-control book-quantity" type="number" min="0" placeholder="0"></td>
                <td class="book-price"></td>
				<input type="hidden" class="book-price-value" value="0">
                <td class="book-total">0</td>
				<input type="hidden" class="book-total-value" value="0">
                <td><a class="remove-item-btn" style="color: red; cursor: pointer"><i class="fas fa-minus-circle"></i></a></td>
            </tr>
        </tbody>
    </table>
	<hr style="border: 1px solid black;">

    <!-- Choose Modal -->
	<div class="modal fade" id="chooseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{trans('invoice.choose_book')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
            <div class="form-group">
			    <label>{{trans('invoice.book')}}</label>
			    <select class="form-control" id="addBook">
					@foreach ($book as $b)
						<option value="{{ $b->madausach }}">{{ $b->tendausach }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
			    <label>{{trans('invoice.book_edition')}}</label>
			    <select class="form-control" id="addBookEdition" placeholder="Select book edition">
					
				</select>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('invoice.close')}}</button>
	        <button type="button" class="btn btn-success add-btn">{{trans('invoice.add')}}</button>
	      </div>
	    </div>
	  </div>
	</div>

    <!-- Loading Modal -->
	<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		<div class="modal-body text-center">
			<div class="loader"></div>
			<div clas="loader-txt">
				<p>{{trans('invoice.please_wait')}}</p>
				<div class="spinner-border text-primary"></div>
			</div>
		</div>
		</div>
	</div>
	</div>
@stop

@section('scripts')
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script src="vendor/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
    <script src="vendor/notify/notify.js"></script>
    <script src="vendor/select2-4.0.13/js/select2.min.js"></script>
    <script src="js/invoice_add.js"></script>
@stop

@section('add-button')
	<button type="button" class="btn btn-success add-button">
		<i class="fas fa-plus"></i> {{trans('invoice.add_book')}}
	</button>
@stop

@section('footer')
	<div class="footer">
		<div style="text-align: right;padding: 10px;float: right; width: 100%;">
			<div style="float: left; width: 85%;padding: 10px;"><strong>{{trans('invoice.amount_received')}}: </strong></div>
			<div style="float: right; width: 15%"><input class="form-control amount-received" style="float:right;" type="number" min="0" placeholder="0"></div>
		</div>
		<div style="text-align: right;padding: 10px 10%;">
			<strong>{{trans('invoice.total')}}:</strong> <span id="total">0</span>
		</div>
		<button type="button" class="btn btn-success create-button">
			{{trans('invoice.create')}}
		</button>
		<a href="{{url('/invoice/index')}}" class="btn btn-light">{{trans('invoice.cancel')}}</a>
    </div>
@stop