<?php
/**
 * sitemap.php — dynamic sitemap; .htaccess rewrites /sitemap.xml to this file. Never a static sitemap.xml / sitemap-images.xml.
 * Nothing here lists a service or city by hand: URLs come from config.php ($services, $serviceAreas), the blog registry
 * (includes/blog-data.php, once real posts exist) and a fixed list of top-level pages filtered by siteHas(), so an unbuilt
 * page can never appear. Noindexed pages (/thank-you, /404, the /blog/ coming-soon placeholder) are left out.
 * lastmod = the page file's mtime. Each page's hero photo ($heroImage in the page file) is listed as an image entry.
 * Locs use $siteUrl and the trailing-slash form, identical to the on-page canonicals.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$smRoot = rtrim($siteUrl, '/');
$smDocRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

/** The page's own file for a URL path. */
$smFile = function (string $path) use ($smDocRoot): string {
    $path = '/' . trim($path, '/');
    $file = $path === '/' ? $smDocRoot . '/index.php' : $smDocRoot . $path . '/index.php';
    return is_file($file) ? $file : $smDocRoot . $path . '.php';
};

/** lastmod from the page file's mtime. */
$smMtime = function (string $path) use ($smFile): string {
    $file = $smFile($path);
    return date('Y-m-d', is_file($file) ? (int) filemtime($file) : time());
};

/** Hero photo declared in the page file ($heroImage = '<name>'), as its largest on-disk webp variant. */
$smHero = function (string $path) use ($smFile, $smDocRoot): array {
    $file = $smFile($path);
    if (!is_file($file) || !preg_match('/\$heroImage\s*=\s*\'([a-z0-9_-]+)\'/i', (string) file_get_contents($file), $m)) return [];
    foreach ([1600, 960, 480] as $smW) {
        $img = '/assets/images/' . $m[1] . '-' . $smW . '.webp';
        if (is_file($smDocRoot . $img)) return [$img];
    }
    return [];
};

$smUrls = [];   // [loc path, lastmod, changefreq, priority, images[]]
$smAdd = function (string $path, string $freq, string $priority) use (&$smUrls, $smMtime, $smHero): void {
    $smUrls[] = [$path, $smMtime($path), $freq, $priority, $smHero($path)];
};

$smAdd('/', 'weekly', '1.0');
if (siteHas('/services/')) $smAdd('/services/', 'monthly', '0.8');
foreach ($services as $smSvc) {
    $smPath = serviceUrl($smSvc['slug']);
    if ($smPath !== '') $smAdd($smPath, 'monthly', '0.8');
}
if (areasHubUrl() !== '') $smAdd(areasHubUrl(), 'monthly', '0.6');
foreach ($serviceAreas as $smArea) {
    $smPath = areaUrl($smArea['slug'], false);
    if ($smPath !== '') $smAdd($smPath, 'monthly', '0.6');
}
foreach (['/about/' => 'yearly', '/faq/' => 'monthly', '/contact/' => 'yearly'] as $smPath => $smFreq) {
    if (siteHas($smPath)) $smAdd($smPath, $smFreq, '0.6');
}

// Blog posts join automatically once the design-portal Blogs tab writes the registry. The blog index itself is never
// listed (qa_audit blocks any bare blog-index URL here); crawlers reach it from every post's breadcrumb.
if (is_file($smDocRoot . '/includes/blog-data.php')) {
    require_once $smDocRoot . '/includes/blog-data.php';
    if (!empty($blogPosts)) {
        foreach ($blogPosts as $smPost) {
            $smPath = '/blog/' . $smPost['slug'] . '/';
            if (!siteHas($smPath)) continue;
            $smImages = (!empty($smPost['image']) && is_file($smDocRoot . $smPost['image'])) ? [$smPost['image']] : [];
            $smUrls[] = [$smPath, $smPost['dateISO'] ?? $smMtime($smPath), 'monthly', '0.6', $smImages];
        }
    }
}

foreach (['/privacy-policy/', '/terms/', '/cookie-policy/', '/accessibility/'] as $smPath) {
    if (siteHas($smPath)) $smUrls[] = [$smPath, $smMtime($smPath), 'yearly', '0.3', []];
}

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach ($smUrls as $smUrl): ?>
  <url>
    <loc><?php echo esc($smRoot . $smUrl[0]); ?></loc>
    <lastmod><?php echo esc($smUrl[1]); ?></lastmod>
    <changefreq><?php echo esc($smUrl[2]); ?></changefreq>
    <priority><?php echo esc($smUrl[3]); ?></priority>
<?php foreach ($smUrl[4] as $smImg): ?>
    <image:image>
      <image:loc><?php echo esc($smRoot . $smImg); ?></image:loc>
    </image:image>
<?php endforeach; ?>
  </url>
<?php endforeach; ?>
</urlset>
