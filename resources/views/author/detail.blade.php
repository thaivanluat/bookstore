@extends('layouts.master')

@section('title', trans('author.books_written_by').$name)

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('author.author_detail'))
        
@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">{{ $name }}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{ trans('author.book_name') }}</th>
                            <th>{{ trans('author.category') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $book)
						<tr>
							<th class="book-name"><a href="{{url('/book/detail', [$book->madausach])}}">{{ $book->tendausach }}</a></th>
                            <th class="book-category"><a href="{{url('/bookcategory/detail', [$book->matheloai])}}">{{ $book->tentheloai }}</a></th>
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
@stop