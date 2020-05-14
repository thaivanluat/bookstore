@extends('layouts.master')

@section('title', trans('bookedition.book_list'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">  
	<link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('bookedition.book_search'))

@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <input type="hidden" id="bookId" value="{{ request()->route('id') }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">{{ trans('bookedition.book_list') }}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{ trans('book.book_edition_name') }}</th>
							<th>{{ trans('book.category') }}</th>
							<th>{{ trans('book.author') }}</th>
                            <th>{{ trans('book.publisher') }}</th>
                            <th>{{ trans('book.publishing_year') }}</th>
                            <th>{{ trans('book.price') }} (VND)</th>
							<th>{{ trans('book.amount') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $book)
						<tr>
							<th class="book-name"><a href="{{url('/book/detail', [$book->madausach])}}">{{ $book->tendausach }}</a></th>
							<th class="book-category"><a href="{{url('/bookcategory/detail', [$book->matheloai])}}">{{ $book->tentheloai}}</a></th>
							<th class="book-author"><a href="{{url('/author/detail', [$book->matacgia])}}">{{ $book->tentacgia }}</a></th>
                            <th class="book-publisher">{{ $book->nhaxuatban }}</th>
                            <th class="book-publishing-year">{{ $book->namxuatban }}</th>
                            <th class="book-price">{{ number_format($book->dongiaban) }}</th>
                            <th class="book-amount">{{ $book->soluongton }}</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop

@section('scripts')
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="js/demo/datatables-demo.js"></script>
	<script src="vendor/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
@stop


