{!! header ( "content-type: text/xml" ); !!}
<?php echo '<'.'?xml version="1.0" encoding="UTF-8"'.'?'.'>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{!! \Config::get('app.url') !!}</loc>
        <lastmod>{!! date('Y-m-d') !!}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    {!! $data['entries'] !!}
</urlset>