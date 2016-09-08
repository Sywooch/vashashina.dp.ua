<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($items as $item): ?>
    <url>
<loc><?php echo $host; ?><?php echo htmlspecialchars($item->getUrl()); ?></loc>
<lastmod><?php echo date(DATE_W3C, $item->updated); ?></lastmod>
<changefreq><?php echo\frontend\controllers\SitemapController::DAILY;?></changefreq>
<priority>0.5</priority>
    </url>
    <?php endforeach; ?>
</urlset>

