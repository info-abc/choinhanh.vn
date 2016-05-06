<div class="row">
	<div class="col-xs-12 center">
		<ul class="pagination">
    		{{ with(new Paginate($input))->render() }}
    	</ul>
	</div>
</div>
