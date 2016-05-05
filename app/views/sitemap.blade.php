<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{url()}}</loc>
        <priority>0.5</priority>
    </url>
    @foreach(SiteMap::getTypeUrlSiteMap() as $type)
    <url>
    	<loc>{{ url().'/game-'.$type->slug }}</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
    </url>
    @endforeach

    @foreach(SiteMap::getGameUrlSiteMap() as $game)
	    <url>
	    	<loc>{{ CommonGame::getUrlGame($game) }}</loc>
			<lastmod>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $game->start_date)->format('Y-m-d') }}</lastmod>
			<changefreq>weekly</changefreq>
			<priority>0.8</priority>
	    </url>
	@endforeach

	@foreach(SiteMap::getNewUrlSiteMap() as $new)
	    <url>
	    	<loc>{{ url().'/'.'tin-tuc'.'/'.$new->slug }}</loc>
			<lastmod>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $new->start_date)->format('Y-m-d') }}</lastmod>
			<changefreq>weekly</changefreq>
			<priority>0.7</priority>
	    </url>
	@endforeach

	<url>
		<loc>http://choinhanh.vn/game-binh-chon-nhieu</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
	</url>

	<url>
		<loc>http://choinhanh.vn/game-hay-nhat</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
	</url>

	<url>
		<loc>http://choinhanh.vn/game-android</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
	</url>

</urlset>
