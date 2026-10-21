<?php
/**
 * includes/area-page.php — shared building blocks for /service-areas/ and /service-areas/<slug>/index.php (Phase 6, 2026-10-21).
 * Requires includes/service-page.php first (reuses spServiceCards, spService, spCrumbs, spReviews, spStyles).
 *
 * Pages own their copy, local facts, section order and page-specific <style>; this file only carries what every
 * area page needs identically:
 *   apArea($slug)            the config.php $serviceAreas row for a slug
 *   apSchema(...)            Electrician (#organization, same @id as the homepage — never a second business) with areaServed
 *                            = this town, City place node, WebPage (speakable) and BreadcrumbList
 *   apFacts($rows)           "<town> at a glance" definition table (every row sourced in the page's comment header)
 *   apServices(...)          services available in the town: 3 featured service-card-with-image cards + the other 7 as links
 *   apNearby($slug)          links to the other area pages (link integrity via areaUrl)
 *   apStyles()               shared area-page CSS (tokens only), echoed once after spStyles()
 * Shared-include rule: loop variables are prefixed ($apRow, $apSvc, $apCard, $apFact).
 */

if (!function_exists('apArea')) {
    /** config.php $serviceAreas row (name, slug, zip, county, primary) — null when unknown. */
    function apArea(string $slug): ?array {
        global $serviceAreas;
        foreach ((array) $serviceAreas as $apRow) {
            if ($apRow['slug'] === $slug) return $apRow;
        }
        return null;
    }
}

if (!function_exists('apSchema')) {
    /**
     * JSON-LD for a town page. The Electrician node reuses the homepage @id (#organization), so it adds this town to
     * the one business entity instead of declaring a duplicate LocalBusiness. Never aggregateRating, never FAQPage.
     * $place: ['name' => 'Corrales', 'county' => 'Sandoval', 'type' => 'City', 'url' => wikipedia/official URL (sameAs)].
     */
    function apSchema(array $place, string $canonical, string $title, string $description, array $crumbs, string $image = ''): array {
        global $siteUrl, $siteName, $phoneRaw, $email, $gbpMapsUrl, $address, $open24x7;
        $root = rtrim($siteUrl, '/');
        $placeNode = [
            '@type' => $place['type'] ?? 'City',
            '@id'   => $canonical . '#place',
            'name'  => $place['name'] . ', ' . $address['state'],
            'containedInPlace' => [
                '@type' => 'AdministrativeArea',
                'name'  => $place['county'] . ' County, New Mexico',
            ],
        ];
        if (!empty($place['sameAs'])) $placeNode['sameAs'] = (array) $place['sameAs'];

        $biz = [
            '@type'      => 'Electrician',
            '@id'        => $root . '/#organization',
            'name'       => $siteName,
            'url'        => $root . '/',
            'telephone'  => $phoneRaw,
            'email'      => $email,
            'address'    => schemaPostalAddress(),
            'areaServed' => ['@id' => $placeNode['@id']],
        ];
        if (!empty($gbpMapsUrl)) $biz['hasMap'] = $gbpMapsUrl;
        if (!empty($open24x7)) {
            $biz['openingHoursSpecification'] = [[
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens' => '00:00', 'closes' => '23:59',
            ]];
        }
        $img = $image !== '' ? absoluteUrl($image) : ogImageUrl();
        if ($img !== '') $biz['image'] = $img;

        $page = generateWebPageSchema($canonical, $title, $description);
        $page['about']      = [['@id' => $root . '/#organization'], ['@id' => $placeNode['@id']]];
        $page['speakable']  = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
        $page['breadcrumb'] = ['@id' => $canonical . '#breadcrumb'];
        $page['dateModified'] = date('Y-m-d', (int) @filemtime($_SERVER['SCRIPT_FILENAME'] ?? __FILE__) ?: time());

        $crumbNode = generateBreadcrumbSchema($crumbs);
        $crumbNode['@id'] = $canonical . '#breadcrumb';
        return [$biz, $placeNode, $page, $crumbNode];
    }
}

if (!function_exists('apFacts')) {
    /** "<town> at a glance" — [['label', 'value (HTML allowed)'], …] as a <dl>. */
    function apFacts(array $rows, string $caption = ''): string {
        $out = '<dl class="ap-facts">';
        foreach ($rows as $apFact) {
            $out .= '<div><dt>' . esc($apFact[0]) . '</dt><dd>' . $apFact[1] . '</dd></div>';
        }
        $out .= '</dl>';
        if ($caption !== '') $out .= '<p class="ap-facts__note">' . $caption . '</p>';
        return $out;
    }
}

if (!function_exists('apServices')) {
    /**
     * Services available in a town. $featured: 3 service slugs shown as service-card-with-image cards (tint + reveal
     * rotation 1→2→3), each with a town-specific one-liner in $why[slug]. The remaining services print as a link list.
     */
    function apServices(array $featured, array $why, string $town): string {
        global $services;
        $apCards = spServiceCards();
        $out = '<div class="services-grid ap-services-grid">';
        $apIdx = 0;
        foreach ($featured as $apSlug) {
            $apSvc = spService($apSlug);
            if (!$apSvc || !isset($apCards[$apSlug])) continue;
            $apCard = $apCards[$apSlug];
            $apTint = ($apIdx % 3) + 1;
            $apUrl  = serviceUrl($apSlug);
            $out .= '<article class="service-card-with-image card-tint-' . $apTint . ' reveal-up reveal-delay-' . $apTint . '">';
            $out .= '<div class="service-card__image">' . responsivePicture($apCard['photo'], $apCard['alt'], '(max-width: 720px) 100vw, (max-width: 1000px) 50vw, 380px') . '</div>';
            $out .= '<div class="service-card__body"><div class="service-card__icon">' . icon($apCard['icon'], 26) . '</div>';
            $out .= '<h3>' . esc($apSvc['name']) . '</h3><p class="service-card__desc">' . esc($why[$apSlug] ?? $apCard['desc']) . '</p><ul>';
            foreach ($apCard['bullets'] as $apBullet) $out .= '<li>' . esc($apBullet) . '</li>';
            $out .= '</ul>';
            $out .= $apUrl !== ''
                ? '<a href="' . esc($apUrl) . '" class="service-card__cta">' . esc($apSvc['name']) . ' details<span class="sr-only"> for ' . esc($town) . '</span></a>'
                : '<button type="button" class="service-card__cta sp-card-btn" data-open-estimate>Get an estimate<span class="sr-only"> for ' . esc($apSvc['name']) . '</span></button>';
            $out .= '</div></article>';
            $apIdx++;
        }
        $out .= '</div>';
        $apRest = [];
        foreach ((array) $services as $apSvc) {
            if (in_array($apSvc['slug'], $featured, true)) continue;
            $apUrl  = serviceUrl($apSvc['slug']);
            $apIcon = $apCards[$apSvc['slug']]['icon'] ?? 'zap';
            $apRest[] = '<li>' . icon($apIcon, 18) . ($apUrl !== '' ? '<a href="' . esc($apUrl) . '">' . esc($apSvc['name']) . '</a>' : '<span>' . esc($apSvc['name']) . '</span>') . '</li>';
        }
        if ($apRest) {
            $out .= '<div class="ap-more reveal-up"><p class="ap-more__label">Also available in ' . esc($town) . '</p><ul class="ap-more__list">' . implode('', $apRest) . '</ul></div>';
        }
        return $out;
    }
}

if (!function_exists('apNearby')) {
    /** Links to the other towns (built pages only; unbuilt towns print as text). */
    function apNearby(string $currentSlug, array $notes = []): string {
        global $serviceAreas, $address;
        $out = '<ul class="ap-nearby">';
        foreach ((array) $serviceAreas as $apRow) {
            if ($apRow['slug'] === $currentSlug) continue;
            $apUrl  = areaUrl($apRow['slug'], false);
            $apName = esc($apRow['name']) . '<small>' . esc($notes[$apRow['slug']] ?? ($apRow['county'] . ' County')) . '</small>';
            $out .= '<li>' . icon('map-pin', 18) . ($apUrl !== '' ? '<a href="' . esc($apUrl) . '"><span>' . $apName . '</span></a>' : '<span>' . $apName . '</span>') . '</li>';
        }
        return $out . '</ul>';
    }
}

if (!function_exists('apStyles')) {
    /** Shared area-page CSS (tokens only). Echo once, right after spStyles(), before the page's own <style>. */
    function apStyles(): string {
        return <<<'CSS'
<style>
/* ==========================================================================
   Area pages — shared composition (includes/area-page.php). Tokens only.
   ========================================================================== */
.hero--area .hero-title { max-width: 20ch; }
.hero--area .hero-form-card h2 { font-size: 1.35rem; }

/* Local story: prose column + sticky "at a glance" card */
.ap-local__grid { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, .85fr); gap: var(--space-2xl) var(--space-3xl); align-items: start; }
.ap-local__grid > aside { position: sticky; top: calc(var(--nav-height) + var(--space-lg)); }
.ap-prose { display: grid; gap: var(--space-md); max-width: var(--measure); }
.ap-prose p { margin: 0; color: var(--color-ink-2); line-height: 1.7; }
.ap-prose p:first-of-type::first-line { font-weight: 600; color: var(--color-ink); }
.ap-prose a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.ap-glance { background: var(--color-surface); border: 1px solid var(--color-line); border-top: 4px solid var(--color-accent); border-radius: var(--radius-lg); box-shadow: var(--shadow); padding: var(--space-lg); }
.ap-glance h3 { font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .03em; margin-bottom: var(--space-sm); }
.ap-facts { display: grid; gap: 0; margin: 0; }
.ap-facts > div { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.4fr); gap: var(--space-sm); padding: var(--space-sm) 0; border-top: 1px solid var(--color-line); }
.ap-facts dt { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-muted); padding-top: var(--space-1); }
.ap-facts dd { margin: 0; font-size: var(--fs-small); color: var(--color-ink); }
.ap-facts dd a { color: var(--color-primary); text-decoration: underline; text-decoration-color: var(--color-accent); }
.ap-facts__note { margin: var(--space-sm) 0 0; font-size: var(--font-size-xs); color: var(--color-muted); }
@media (max-width: 960px) { .ap-local__grid { grid-template-columns: 1fr; } .ap-local__grid > aside { position: static; } }

/* Services in this town */
.ap-services .services-grid { grid-template-columns: repeat(3, 1fr); gap: var(--space-lg); }
.ap-services .service-card__image picture { display: block; width: 100%; height: 100%; }
.ap-services .service-card__icon { color: var(--color-accent-dark); }
.ap-services .service-card-with-image h3 { text-transform: uppercase; letter-spacing: .02em; }
.ap-services .service-card-with-image:hover .service-card__icon { background: var(--color-accent); color: var(--color-ink); }
.ap-more { margin-top: var(--space-xl); padding: var(--space-lg); border: 1px dashed var(--color-line); border-radius: var(--radius-lg); background: var(--color-surface); }
.ap-more__label { margin: 0 0 var(--space-sm); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.ap-more__list { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: var(--space-xs) var(--space-lg); }
.ap-more__list li { display: flex; align-items: center; gap: var(--space-xs); font-weight: 600; }
.ap-more__list svg { color: var(--color-accent-dark); flex: 0 0 auto; }
.ap-more__list a { color: var(--color-ink); text-decoration: underline; text-decoration-color: var(--color-line); text-underline-offset: .2em; transition: text-decoration-color var(--transition); }
.ap-more__list a:hover { text-decoration-color: var(--color-accent); }
@media (max-width: 1000px) { .ap-services .services-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 640px) { .ap-services .services-grid { grid-template-columns: 1fr; } }

/* Nearby towns */
.ap-nearby { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: var(--space-sm); }
.ap-nearby li { display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md) var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-left: 4px solid var(--color-accent); border-radius: var(--radius); font-family: var(--font-heading); font-size: 1.15rem; text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); transition: transform var(--transition), box-shadow var(--transition); }
.ap-nearby li:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
.ap-nearby li span { display: grid; gap: 2px; line-height: 1.1; }
.ap-nearby small { font-family: var(--font-body); font-size: var(--fs-small); text-transform: none; letter-spacing: 0; color: var(--color-muted); }
.ap-nearby a { color: inherit; }
.ap-nearby svg { color: var(--color-accent-dark); flex: 0 0 auto; }

/* Last updated stamp */
.last-updated { margin: var(--space-lg) 0 0; font-size: var(--fs-small); color: var(--color-muted); }
.texture-grain .last-updated { color: color-mix(in srgb, var(--color-white) 66%, transparent); }
</style>
CSS;
    }
}
