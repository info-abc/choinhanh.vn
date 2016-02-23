<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{url()}}</loc>
        <priority>0.5</priority>
    </url>
    @foreach(SiteMap::getTypeUrlSiteMap() as $type)
    <url>
    	<loc>{{ url().'/'.$type->slug }}</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
    </url>
    @endforeach

    @foreach(SiteMap::getGameUrlSiteMap() as $game)
	    <url>
	    	<loc>{{ url().'/'.Type::find($game->type_main)->slug.'/'.$game->slug }}</loc>
			<lastmod>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $game->start_date)->format('Y-m-d') }}</lastmod>
			<changefreq>weekly</changefreq>
			<priority>0.5</priority>
	    </url>
	@endforeach

	@foreach(SiteMap::getNewUrlSiteMap() as $new)
	    <url>
	    	<loc>{{ url().'/'.'tin-tuc'.'/'.$new->slug }}</loc>
			<lastmod>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $new->start_date)->format('Y-m-d') }}</lastmod>
			<changefreq>weekly</changefreq>
			<priority>0.5</priority>
	    </url>
	@endforeach
</urlset>
