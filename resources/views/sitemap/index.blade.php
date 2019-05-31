<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ config('app.url') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('about') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('service') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @if(!$services->isEmpty())
        @foreach ($services as $row)
            <url>
                <loc>{{ route('service.show', ['seo_link' => $row->seo_link]) }}</loc>
                <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.6</priority>
            </url>
        @endforeach
    @endif
    <url>
        <loc>{{ route('modality') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @if(!$modalities->isEmpty())
        @foreach ($modalities as $row)
            <url>
                <loc>{{ route('modality.show', ['seo_link' => $row->seo_link]) }}</loc>
                <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.6</priority>
            </url>
        @endforeach
    @endif
    <url>
        <loc>{{ route('driver') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('passenger') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('trading-partner') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('trading-partner.register') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('privacy-policy') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('partner') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('blog') }}</loc>
        <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @if(!$tags->isEmpty())
        @foreach ($tags as $row)
            <url>
                <loc>{{ route('blog.tag', ['seo_link' => $row->seo_link]) }}</loc>
                <lastmod>{{ date('Y-m-d') }}T00:00:00+00:00</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.6</priority>
            </url>
        @endforeach
    @endif
    @if(!$posts->isEmpty())
        @foreach ($posts as $row)
            <url>
                <loc>{{ route('blog.show', ['seo_link' => $row->seo_link]) }}</loc>
                <lastmod>{{ $row->date }}T00:00:00+00:00</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.6</priority>
            </url>
        @endforeach
    @endif
</urlset>