<?php
/**
 * includes/head.php — doctype, <head>, SEO, Open Graph, font preload, critical CSS, favicons, schema. Ends by opening <body>.
 *
 * Page contract — set BEFORE including this file:
 *   $pageTitle, $pageDescription (alias $metaDescription), $canonicalUrl (optional — computed from the request URI when unset),
 *   $currentPage (nav state: home|services|areas|about|blog|faq|contact|legal),
 *   $pageType (home|service|city|blog|about|faq|contact|other) + $serviceSlug / $citySlug (attribution),
 *   $ogImage (optional, '/assets/images/…'), $ogType (optional), $noindex (thank-you / blog placeholder), $robotsMeta (verbatim robots content, e.g. "noindex, follow"), $bodyClass (optional),
 *   $schemaMarkup (JSON string, one node array, or a list of node arrays — merged into this page's @graph),
 *   $heroPreload = ['srcset' => '/assets/images/<hero>-480.avif 480w, …-960.avif 960w, …-1600.avif 1600w', 'sizes' => '100vw'] on photo-hero pages.
 * The homepage ($pageType === 'home') emits the full Electrician (#organization) + WebSite nodes; every other page
 * references them by @id (provider) and never duplicates the LocalBusiness block.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$headTitle = !empty($pageTitle) ? $pageTitle : defaultPageTitle();
$headDesc  = !empty($pageDescription) ? $pageDescription : (!empty($metaDescription) ? $metaDescription : defaultMetaDescription());
$headCanon = !empty($canonicalUrl) ? $canonicalUrl : requestCanonical();

$headNodes = [];
if (($pageType ?? '') === 'home' || ($currentPage ?? '') === 'home') {
    $headNodes[] = generateLocalBusinessSchema();
    $headNodes[] = generateWebSiteSchema();
}
if (!empty($schemaMarkup)) {
    $headExtra = is_string($schemaMarkup) ? json_decode($schemaMarkup, true) : $schemaMarkup;
    if (is_array($headExtra)) {
        // a single node (has @type / @graph) or a list of nodes; strip any per-node @context
        $headList = (isset($headExtra['@type']) || isset($headExtra['@graph'])) ? [$headExtra] : $headExtra;
        foreach ($headList as $headNode) {
            if (!is_array($headNode)) continue;
            if (isset($headNode['@graph'])) { foreach ($headNode['@graph'] as $headGraphNode) $headNodes[] = $headGraphNode; continue; }
            unset($headNode['@context']);
            $headNodes[] = $headNode;
        }
    }
}
$headNodes = array_values(array_filter($headNodes));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#100d0c">
<?php echo generateMetaTags($headTitle, $headDesc, $headCanon); ?>

<!-- Self-hosted fonts (v6.2): only the above-the-fold heading face is preloaded; @font-face lives in framework.css -->
<link rel="preload" href="/assets/fonts/barlow-condensed.woff2" as="font" type="font/woff2" crossorigin>

<!-- Critical CSS inlined (generated from framework.css — never hand-edit); framework.css loads non-blocking -->
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/critical.css'; ?></style>
<link rel="preload" href="/assets/css/framework.css?v=<?php echo $cssVersion; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="/assets/css/framework.css?v=<?php echo $cssVersion; ?>"></noscript>
<?php if (!empty($heroPreload['srcset'])): ?>
<link rel="preload" as="image" type="image/avif" imagesrcset="<?php echo $heroPreload['srcset']; ?>" imagesizes="<?php echo $heroPreload['sizes'] ?? '100vw'; ?>" fetchpriority="high">
<?php endif; ?>

<link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
<?php if (!empty($googleAnalyticsId) && $googleAnalyticsId !== 'G-XXXXXXXXXX'): ?>

<script defer src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc($googleAnalyticsId); ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo esc($googleAnalyticsId); ?>');</script>
<?php else: ?>

<!-- Google Analytics (GA4) placeholder — set $googleAnalyticsId in config.php to the client's measurement ID:
<script defer src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-XXXXXXXXXX');</script>
-->
<?php endif; ?>
<?php if ($headNodes): ?>

<script type="application/ld+json"><?php echo jsonLd(['@context' => 'https://schema.org', '@graph' => $headNodes]); ?></script>
<?php endif; ?>
</head>
<body<?php echo !empty($bodyClass) ? ' class="' . esc($bodyClass) . '"' : ''; ?>>
