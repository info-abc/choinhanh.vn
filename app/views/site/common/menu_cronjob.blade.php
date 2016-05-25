<!-- menu -->
<div id='cssmenu'>

	<!-- <?php //echo '<?php include("menu_cronjob_inc.php"); ?>'; ?> -->
	<?php echo '@include("site.common.menu_cronjob_inc")'; ?>

	<div class="search1">
		<form action="{{ action('SearchGameController@index') }}" >
			<input type="text" name="search" value="" title="search" id="searchmenu" placeholder="Tìm kiếm game" />
			<input type="submit" value="search" title="submit" />
		</form>
	</div>
	<ul>
		<li class='active'><a href="{{ url('/') }}" class="color1"><i class="fa fa-home"></i> <span>Trang chủ</span></a></li>
		@foreach($menuHeader = CategoryParent::where('status', ACTIVE)->where('position', MENU)->orderBy('weight_number', 'asc')->get() as $key => $value)
			@if($value->position == MENU)
				@if(count($value->parenttypes) == 0)
					@if($value->id == MENU_GAME_ANDROID)
						<li><a href="{{ action('GameController@getListGameAndroid') }}" class="color2"><span>{{ $value->name }}</span></a></li>
					@else
						<?php
						// if($value->id == MENU_GAME_ONLINE) {
						// 	$slug = 'game-online';
						// }
						// else {
						// 	$slug = $value->slug;
						// }
						?>
						<!-- <li><a href="{{-- url('/' . $slug) --}}" class="color2"><span>{{-- $value->name --}}</span></a></li> -->
					@endif
				@else
				<li class='has-sub'><a href= '#' class="color2"><span>{{ $value->name }}</span></a>
					<ul>
					@foreach(SiteIndex::getTypeOfParent($value->id) as $k => $v)
						<li><a href="{{ url('game-' . SiteIndex::getFieldByType($v, 'slug')) }}"><span>{{ SiteIndex::getFieldByType($v, 'name') }}</span></a></li>
					@endforeach
					</ul>
				</li>
				@endif
			@endif
		@endforeach
		<!-- <li class="has-sub">
			<a href="#" class="color2"><span>Tin game</span></a>
			<ul>
				@foreach(SiteIndex::getTypeNewMenu() as $kTypeNew => $vTypeNew)
					<li><a href="{{-- url($vTypeNew->slug) }}"><span>{{ $vTypeNew->name --}}</span></a></li>
				@endforeach
			</ul>
		</li> -->
	</ul>
	<div class="menu-hide"><a onclick="menuhide()"><i class="fa fa-times-circle-o"></i> Đóng lại</a></div>
</div>