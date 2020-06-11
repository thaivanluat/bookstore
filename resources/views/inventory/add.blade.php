@extends('layouts.master')

@section('title', trans('inventory.add_inventory_check'))

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

@section('page-heading', trans('inventory.add_inventory_check'))
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <table class="table" id="listItem">
        <thead>
            <tr>
                <th scope="col" style="width: 20%">{{trans('inventory.name')}}</th>
				<th scope="col" style="width: 10%">{{trans('inventory.category')}}</th>
				<th scope="col" style="width: 10%">{{trans('inventory.author')}}</th>
                <th scope="col" style="width: 10%">{{trans('inventory.publisher')}}</th>
                <th scope="col" style="width: 10%">{{trans('inventory.publishing_year')}}</th>
                <th scope="col" style="width: 10%">{{trans('inventory.price')}}</th>
                <th scope="col" style="width: 10%">{{trans('inventory.stock')}}</th>
                <th scope="col" style="width: 10%">{{trans('inventory.check_stock')}}</th>
                <th scope="col" style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>
            <tr class="blank-item">
				<input type="hidden" class="item-id">
                <td class="book-name">
                    <button type="button" class="btn btn-success choose-btn" data-toggle="modal" data-target="#chooseModal">{{trans('inputreceipt.choose_book')}}</button>
                </td>
				<td class="book-category"></td>
				<td class="book-author"></td>
                <td class="book-publisher"></td>
                <td class="book-publishing-year"></td>
                <td class="book-price"></td>
                <td class="book-stock"></td>
                <td><input class="form-control book-check-stock" type="number" min="0" placeholder="0"></td>
                <td><a class="remove-item-btn" style="color: red; cursor: pointer"><i class="fas fa-minus-circle"></i></a></td>
            </tr>
        </tbody>
    </table>
	<hr style="border: 1px solid black;">
	<div class="row" style="margin-left: 1%">
		<button type="button" class="btn btn-success add-button">
			<i class="fas fa-plus"></i> {{trans('inventory.add_book')}}
		</button>
	</div>

    <!-- Choose Modal -->
	<div class="modal fade" id="chooseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{trans('inventory.choose_book')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
            <div class="form-group">
			    <label>{{trans('inventory.book')}}</label>
			    <select class="form-control" id="addBook">
					@foreach ($book as $b)
						<option value="{{ $b->madausach }}">{{ $b->tendausach }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
			    <label>{{trans('inventory.book_edition')}}</label>
			    <select class="form-control" id="addBookEdition" placeholder="Select book edition">
					<option></option>	
				</select>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('inventory.close')}}</button>
	        <button type="button" class="btn btn-success add-btn">{{trans('inventory.add')}}</button>
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
				<p>{{trans('inventory.please_wait')}}</p>
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
    <script src="js/inventory_add.js"></script>
@stop

@section('add-button')
	<button type="button" class="btn btn-success add-button">
		<i class="fas fa-plus"></i> {{trans('inventory.add_book')}}
	</button>
@stop

@section('footer')
	<div class="footer">
		<button type="button" class="btn btn-success create-button">
		{{trans('inventory.create')}}
		</button>
		<a href="{{url('/inventory/index')}}" class="btn btn-light">{{trans('inventory.cancel')}}</a>
    </div>
@stop