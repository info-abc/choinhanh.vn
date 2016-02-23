@extends('admin.error.default')

@section('title')
	403 Restricted Access
@stop

@section('content')
<div class="error-page">
	<h2 class="headline text-info"> 403</h2>
	<div class="error-content">
		<h3><i class="fa fa-warning text-yellow"></i> Server Error: 403 (Forbidden).</h3>
		<p>
			We could not find the page you were looking for.
			Meanwhile, you may <a href='{{ url('/') }}'>return to dashboard</a> or try using the search form.
		</p>
	</div>
</div>
@stop