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
		<div class="row">
			<div class="col-sm-8">
				<h5>{{trans('invoice.customer_information')}}</h5>	
			</div>
			<div class="col-sm-4">
				<button style="float: right;" type="button" class="btn btn-success add-customer" data-toggle="modal" data-target="#addCustomerModal">
					<i class="fas fa-plus"></i> {{ trans('customer.add_customer') }}
				</button>
			</div>
		</div>
		
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
				<tr>
                    <th>{{trans('customer.customer_type')}}: </th>
                    <td class="customer-type"></td>
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
	<div class="row" style="margin-left: 1%">
		<button type="button" class="btn btn-success add-button">
			<i class="fas fa-plus"></i> {{trans('invoice.add_book')}}
		</button>
	</div>

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

	<!-- Add Customer Modal -->
	<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('customer.add_customer') }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>{{ trans('customer.customer_name') }}</label>
			    <input type="text" class="form-control" id="addCustomerName">
			</div>
			<div class="form-group">
			    <label>{{ trans('customer.customer_phone') }}</label>
			    <input type="number" min="0" class="form-control" id="addCustomerPhone">
			</div>
            <div class="form-group">
			    <label>{{ trans('customer.customer_address') }}</label>
			    <input type="text" class="form-control" id="addCustomerAddress">
			</div>
            <div class="form-group">
			    <label>{{ trans('customer.customer_email') }}</label>
			    <input type="email" class="form-control" id="addCustomerEmail">
			</div>
			<div class="form-group">
			    <label>{{ trans('customer.customer_birthday') }}</label>
			    <input type="date" min="0" class="form-control" id="addCustomerBirthday">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('customer.close') }}</button>
	        <button type="button" class="btn btn-success add-customer-btn">{{ trans('customer.add') }}</button>
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
		<div class="row">
			<div class="col-sm-9" style="text-align: right">
				<strong>{{trans('invoice.total')}}:</strong> 
			</div>
			<div class="col-sm-3" style="text-align: left">
				<span id="total">0</span>
			</div>
		</div>
		<br>
		<div class="discount-area" style="display: none">
			<div class="row">
				<div class="col-sm-9" style="text-align: right">
					<strong>{{ trans('invoice.discount') }}:</strong> 
				</div>
				<div class="col-sm-3" style="text-align: left">
					<span id="discount">{{ $discount->tilegiamgia }}</span> %
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-9" style="text-align: right">
					<strong>{{trans('invoice.final_total')}}:</strong> 
				</div>
				<div class="col-sm-3" style="text-align: left">
					<span id="finalTotal">0</span>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-9" style="text-align: right">
				<strong>{{trans('invoice.amount_received')}}: </strong>
			</div>
			<div class="col-sm-3 form-inline" style="text-align: left">
				<input class="col-sm-8 form-control amount-received" type="number" min="0" placeholder="0">
				<span>&nbsp ₫</span>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-9" style="text-align: right">
				<strong>{{trans('invoice.change')}}:</strong> 
			</div>
			<div class="col-sm-3" style="text-align: left">
				<span id="change">0</span>
			</div>
		</div>
		
		<button type="button" class="btn btn-success create-button">
			{{trans('invoice.create')}}
		</button>
		<a href="{{url('/invoice/index')}}" class="btn btn-light">{{trans('invoice.cancel')}}</a>
    </div>
@stop