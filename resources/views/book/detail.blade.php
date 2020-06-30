@extends('layouts.master')

@section('title', trans('book.detail_about').$name)

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">  
	<link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', $name)

@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <input type="hidden" id="bookId" value="{{ request()->route('id') }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">{{ trans('book.book_edition') }}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{ trans('book.book_id') }}</th>
							<th>{{ trans('book.book_edition_name') }}</th>	
							<th>{{ trans('book.category') }}</th>
							<th>{{ trans('book.author') }}</th>
                            <th>{{ trans('book.publisher') }}</th>
                            <th>{{ trans('book.publishing_year') }}</th>
                            <th>{{ trans('book.price') }} (VND)</th>
							<th>{{ trans('book.amount') }}</th>
                            <th style="width: 20%;">{{ trans('book.action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $book)
						<tr>
							<th class="book-id">{{ $book->masach }}</th>
							<th class="book-name">{{ $name }}</th>	
							<th class="book-category">{{ $book->tentheloai}}</th>
							<th class="book-author">{{ $book->tentacgia }}</th>
                            <th class="book-publisher">{{ $book->nhaxuatban }}</th>
                            <th class="book-publishing-year">{{ $book->namxuatban }}</th>
                            <th class="book-price">{{ number_format($book->dongiaban) }}</th>
                            <th class="book-amount">{{ $book->soluongton }}</th>
							<th style="text-align: center;">
								<input type="hidden" class="book-edition-id" value="{{ $book->masach }}">
								<button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal">{{ trans('book.edit') }}</button>
								<button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteModal">{{ trans('book.delete') }}</button>
							</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Edit Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('book.edit_book_edition') }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<div class="form-group">
                <div class="form-group">
                    <label>{{ trans('book.publisher') }}</label>
                    <input type="text" class="form-control" id="bookPublisher">
                </div>
			</div>
			<div class="form-group">
                <div class="form-group">
                    <label>{{ trans('book.publishing_year') }}</label>
                    <input type="number" min="0" class="form-control" id="bookPublishingYear">
                </div>
			</div>
			<div class="form-group">
                <div class="form-group">
                    <label>{{ trans('book.price') }}</label>
                    <input type="number" min="0" class="form-control" id="bookPrice">
                </div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('book.close') }}</button>
	        <button type="button" class="btn btn-primary save-change-btn">{{ trans('book.save_changes') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('book.delete_this_book_edition') }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
            <table style="margin: auto; width: 60%;">
                <tr>
                    <td style="width: 50%"><strong>{{ trans('book.publisher') }}:</strong></td>
                    <td class="heading-book-publisher"></td>
                </tr>
                <tr>
                    <td><strong>{{ trans('book.publishing_year') }}:</strong></td>
                    <td class="heading-book-publishing-year"></td>
                </tr>
                <tr>
                    <td><strong>{{ trans('book.price') }}:</strong></td>
                    <td class="heading-book-price"></td>
                </tr>
                <tr>
                    <td><strong>{{ trans('book.amount') }}:</strong></td>
                    <td class="heading-book-amount"></td>
                </tr>
            </table>
            <br>
		  	<p>{{ trans('book.are_you_sure') }}</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('book.close') }}</button>
	        <button type="button" class="btn btn-danger delete-btn">{{ trans('book.delete') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Add Modal -->
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('book.add_book_edition') }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>{{ trans('book.publisher') }}</label>
			    <input type="text" class="form-control" id="addBookPublisher">
			</div>
            <div class="form-group">
			    <label>{{ trans('book.publishing_year') }}</label>
			    <input type="number" min="0" class="form-control" id="addBookPublishingYear" placeholder="{{ now()->year }}">
			</div>
			<div class="form-group">
			    <label>{{ trans('book.price') }}</label>
			    <input type="number" min="0" class="form-control" id="addBookPrice" value="0">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('book.close') }}</button>
	        <button type="button" class="btn btn-success add-btn">{{ trans('book.add') }}</button>
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
				<p>{{ trans('book.please_wait') }}</p>
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
	<script src="js/book_detail.js"></script>
@stop

@section('add-button')
	<button type="button" class="btn btn-success add-button" data-toggle="modal" data-target="#addModal">
		<i class="fas fa-plus"></i> {{ trans('book.add_book_edition') }}
	</button>
@stop
