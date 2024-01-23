@foreach ($pages as $key => $value)
    <url>
        <loc>{!! $value['page'] !!}</loc>
        <lastmod>{!! $value['date'] !!}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
@endforeach
