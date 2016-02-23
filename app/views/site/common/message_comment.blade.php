@if (Session::has('comment'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><center>{{ Session::get('comment') }}</center></strong>
    </div>
@endif