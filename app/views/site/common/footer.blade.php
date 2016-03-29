<div class="footer">
	<ul>
	  <li><a href="{{ url('/') }}" {{ checkActive() }}>Home</a></li>
	  <li><a href="{{ action('SiteFeedbackController@create') }}" {{ checkActive('gop-y') }}>Góp ý</a></li>
	  <li><a href="{{ action('SiteFeedbackController@policy') }}" {{ checkActive('chinh-sach') }}>Chính sách</a></li>
	</ul>
	<div class="copyright">
	  	<p>Giấy phép thiết lập mạng xã hội trên mạng số 58/GP-BTTTT cấp ngày 02/02/2016</p>
		{{-- <p>Cơ quan chủ quản: Công ty Cổ phần truyền thông ABC</p>
		<p>Địa chỉ: P501, Tầng 5, Tòa nhà văn phòng, Số 5B/55, Huỳnh Thúc Kháng, Phường Láng Hạ, Quận Đống Đa, Hà Nội</p>
		<p>Tel: (84-4) 3.775.4334 - Fax: (84-4) 3512 1804</p> --}}
	</div>
</div>
<div class="tags">
	<ul>
	@foreach(AdminTag::all() as $value)
		<li><a href="{{ url('tag/'.$value->slug) }}">{{ $value->name }}</a></li>
	@endforeach
	</ul>
	<div class="clearfix"></div>
</div>