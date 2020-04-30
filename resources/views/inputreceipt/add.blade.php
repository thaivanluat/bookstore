@extends('layouts.master')

@section('title', 'Add Input Receipt')

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
			position: absolute;
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

@section('page-heading', 'Add Input Receipt')
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div style="text-align: right;padding: 10px 10%;">
		<strong>Total:</strong> <span id="total">0</span>
	</div>
    <table class="table" id="listItem">
        <thead>
            <tr>
                <th scope="col" style="width: 25%">Name</th>
                <th scope="col" style="width: 15%">Publisher</th>
                <th scope="col" style="width: 10%">Publisher Year</th>
                <th scope="col" style="width: 10%">Quantity</th>
                <th scope="col" style="width: 20%">Price</th>
                <th scope="col" style="width: 15%">Total</th>
                <th scope="col" style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>
            <tr class="blank-item">
				<input type="hidden" class="item-id">
                <td class="book-name">
                    <button type="button" class="btn btn-success choose-btn" data-toggle="modal" data-target="#chooseModal">Choose book</button>
                </td>
                <td class="book-publisher"></td>
                <td class="book-publishing-year"></td>
                <td><input class="form-control book-quantity" type="number" min="0" placeholder="0"></td>
                <td class="book-price"></td>
                <td class="book-total">0</td>
                <td><a class="remove-item-btn" style="color: red; cursor: pointer"><i class="fas fa-minus-circle"></i></a></td>
            </tr>
        </tbody>
    </table>

    <!-- Choose Modal -->
	<div class="modal fade" id="chooseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Choose book</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
            <div class="form-group">
			    <label>Book</label>
			    <select class="form-control" id="addBook">
					@foreach ($book as $b)
						<option value="{{ $b->madausach }}">{{ $b->tendausach }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
			    <label>Book Edition</label>
			    <select class="form-control" id="addBookEdition" placeholder="Select book edition">
					<option></option>	
				</select>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-success add-btn">Add</button>
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
				<p>Please wait...</p>
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
		<i class="fas fa-plus"></i> Add book
	</button>
@stop

@section('footer')
	<div class="footer">
		<button type="button" class="btn btn-success create-button">
			Create
		</button>
		<a href="{{url('/inputreceipt/index')}}" class="btn btn-light">Cancel</a>
    </div>
@stop