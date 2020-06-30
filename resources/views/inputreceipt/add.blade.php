@extends('layouts.master')

@section('title', trans('inputreceipt.add_input_receipt'))

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
			margin-bottom: 4rem;
		}
	</style>   
@stop

@section('page-heading', trans('inputreceipt.add_input_receipt'))
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div style="text-align: right;padding: 10px 10%;">
		<strong>{{trans('inputreceipt.total')}}:</strong> <span id="total">0</span>
	</div>
    <table class="table" id="listItem">
        <thead>
            <tr>
				<th scope="col" style="width: 3%">{{trans('inputreceipt.book_id')}}</th>
                <th scope="col" style="width: 17%">{{trans('inputreceipt.name')}}</th>
				<th scope="col" style="width: 8%">{{trans('inputreceipt.category')}}</th>
				<th scope="col" style="width: 7%">{{trans('inputreceipt.author')}}</th>
                <th scope="col" style="width: 10%">{{trans('inputreceipt.publisher')}}</th>
                <th scope="col" style="width: 10%">{{trans('inputreceipt.publishing_year')}}</th>
                <th scope="col" style="width: 10%">{{trans('inputreceipt.quanlity')}}</th>
                <th scope="col" style="width: 15%">{{trans('inputreceipt.price')}}</th>
                <th scope="col" style="width: 15%">{{trans('inputreceipt.total_price')}}</th>
                <th scope="col" style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>
            <tr class="blank-item">
				<input type="hidden" class="item-id">
				<td class="book-id"></td>
                <td class="book-name">
                    <button type="button" class="btn btn-success choose-btn" data-toggle="modal" data-target="#chooseModal">{{trans('inputreceipt.choose_book')}}</button>
                </td>
				<td class="book-category"></td>
				<td class="book-author"></td>
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
			<i class="fas fa-plus"></i> {{trans('inputreceipt.add_book')}}
		</button>
	</div>

    <!-- Choose Modal -->
	<div class="modal fade" id="chooseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{trans('inputreceipt.choose_book')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
            <div class="form-group">
			    <label>{{trans('inputreceipt.book')}}</label>
			    <select class="form-control" id="addBook">
					@foreach ($book as $b)
						<option value="{{ $b->madausach }}">{{ $b->tendausach }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
			    <label>{{trans('inputreceipt.book_edition')}}</label>
			    <select class="form-control" id="addBookEdition" placeholder="Select book edition">
					<option></option>	
				</select>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('inputreceipt.close')}}</button>
	        <button type="button" class="btn btn-success add-btn">{{trans('inputreceipt.add')}}</button>
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
				<p>{{trans('inputreceipt.please_wait')}}</p>
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
    <script src="js/inputreceipt_add.js"></script>
@stop

@section('add-button')
	<button type="button" class="btn btn-success add-button">
		<i class="fas fa-plus"></i> {{trans('inputreceipt.add_book')}}
	</button>
@stop

@section('footer')
	<div class="footer">
		<button type="button" class="btn btn-success create-button">
		{{trans('inputreceipt.create')}}
		</button>
		<a href="{{url('/inputreceipt/index')}}" class="btn btn-light">{{trans('inputreceipt.cancel')}}</a>
    </div>
@stop