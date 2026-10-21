<?php
/**
 * includes/service-page.php — shared building blocks for /services/<slug>/index.php (Phase 4, 2026-10-21).
 *
 * Pages own their copy, section order and page-specific <style>; this file only carries what every service
 * page needs identically:
 *   spServiceCards()        card data for all 10 services (photo, alt, icon, desc, 3 bullets) — related-services grid
 *   spService($slug)        the config.php $services row for a slug
 *   spSchema(...)           Service (#service-<slug>, provider → homepage #organization Electrician) + WebPage + BreadcrumbList
 *   spCrumbs($crumbs)       visible breadcrumb for the hero
 *   spReviews($pattern)     real Google reviews from the Page One feed whose text matches this service (fail-quiet → '')
 *   spRelated(...)          "Other Services You May Need" — required services-grid / service-card-with-image pattern, 3 cards
 *   spStyles()              shared service-page CSS (tokens only), echoed once per page before the page's own <style>
 * Shared-include rule: loop variables are prefixed ($spCard, $spRev, $spCrumb).
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';

if (!function_exists('spServiceCards')) {
    /** Card data for every service. Photos are manifest photos; alt text says only what the photo shows. */
    function spServiceCards(): array {
        return [
            'residential-electrical' => [
                'photo' => 'gbp-12-additional', 'icon' => 'house',
                'alt'   => 'Electrician on a ladder hanging pendant lights over a kitchen half-wall in a home',
                'desc'  => 'Repairs, upgrades and new circuits for houses in Rio Rancho and Albuquerque.',
                'bullets' => ['Dead circuits traced and fixed', 'Hot tub and appliance circuits', 'Remodel and addition wiring'],
            ],
            'commercial-electrical' => [
                'photo' => 'gbp-01-additional', 'icon' => 'building-2',
                'alt'   => 'Commercial electrical room with new panels, a dry-type transformer, EMT conduit runs and spools of wire',
                'desc'  => 'Electrical rooms, panels, conduit and lighting for offices, shops and commercial buildings.',
                'bullets' => ['Electrical room build-outs', 'EMT conduit and feeders', 'Tenant power and lighting'],
            ],
            'ev-charger-installation' => [
                'photo' => 'gbp-04-additional', 'icon' => 'plug-zap',
                'alt'   => 'Mini excavator trench across a gravel lot toward a steel outbuilding for an underground electrical run',
                'desc'  => 'Level 2 charger circuits, sized with a load calculation on your existing panel.',
                'bullets' => ['Load calculation before install', 'Dedicated 240-volt circuit', 'Garage or exterior mounting'],
            ],
            'electrical-panel-upgrades-repair' => [
                'photo' => 'gbp-08-at_work', 'icon' => 'gauge',
                'alt'   => 'Open panelboard with breakers and color-coded conductors landed and dressed',
                'desc'  => 'Panel replacements, service upgrades and breaker repair when a building needs more capacity.',
                'bullets' => ['Room for new circuits', 'Fixes for tripping breakers', 'Safer, code-current equipment'],
            ],
            'lighting-installation' => [
                'photo' => 'gbp-09-at_work', 'icon' => 'lightbulb',
                'alt'   => 'Ring pendant lights and recessed downlights in a two-story commercial atrium',
                'desc'  => 'Recessed cans, pendants, fixtures and exterior lights, indoors and out.',
                'bullets' => ['Recessed and pendant lighting', 'Fixture swaps and upgrades', 'Exterior and security lights'],
            ],
            'ceiling-fan-installation' => [
                'photo' => 'gbp-11-at_work', 'icon' => 'fan',
                'alt'   => 'Living room with a ceiling fan light kit and recessed lights in a textured ceiling',
                'desc'  => 'New and replacement ceiling fans on fan-rated boxes, with wall controls.',
                'bullets' => ['Fan-rated box installed', 'Light kits and wall controls', 'Wobbly fans replaced'],
            ],
            'outlets-switches' => [
                'photo' => 'gbp-12-additional', 'icon' => 'plug',
                'alt'   => 'Kitchen half-wall with a duplex outlet below an electrician hanging pendant lights',
                'desc'  => 'Dead, warm or loose outlets repaired, GFCI protection added, new outlets installed.',
                'bullets' => ['GFCI for kitchens and baths', 'Warm outlets diagnosed', 'Patio and exterior outlets'],
            ],
            'electrical-wiring-installation-repair' => [
                'photo' => 'gbp-03-additional', 'icon' => 'cable',
                'alt'   => 'Bank of parallel EMT conduit runs dropping into a wireway between electrical panels',
                'desc'  => 'New wiring, rewiring and faulty-wire repair for homes, remodels and additions.',
                'bullets' => ['Shorts traced to the source', 'Basement and addition rough-in', 'Underground feeders trenched'],
            ],
            'electrical-inspections' => [
                'photo' => 'gbp-08-at_work', 'icon' => 'clipboard-check',
                'alt'   => 'Inside of an open panelboard showing breakers and the conductors landed on them',
                'desc'  => 'Electrical safety checks for homeowners, buyers and businesses, with a clear list of what needs attention.',
                'bullets' => ['Panel and breakers checked', 'Warm or dead outlets tested', 'Straight answer on what to fix'],
            ],
            '24-7-emergency-electrical-service' => [
                'photo' => 'gbp-06-at_work', 'icon' => 'alert-triangle',
                'alt'   => 'Electrical equipment and conduit beside a home electric meter, with an open trench along the stucco wall',
                'desc'  => 'Power loss, breakers that will not reset, burning smells and storm damage, at any hour.',
                'bullets' => ['Phone answered day and night', 'Faults found and made safe', 'Utility-side problems reported'],
            ],
        ];
    }
}

if (!function_exists('spService')) {
    /** config.php $services row for a slug (name, slug, description, keywords) — null when unknown. */
    function spService(string $slug): ?array {
        global $services;
        foreach ((array) $services as $spRow) {
            if ($spRow['slug'] === $slug) return $spRow;
        }
        return null;
    }
}

if (!function_exists('spSchema')) {
    /**
     * JSON-LD nodes for a service page: Service (@id <canonical>#service-<slug>, provider = homepage Electrician
     * #organization), WebPage (speakable → .hero-answer + .answer-block) and BreadcrumbList.
     * $crumbs: [['name' => 'Home', 'url' => '/'], …, ['name' => <service>, 'url' => '/services/<slug>/']].
     * Never FAQPage, never aggregateRating.
     */
    function spSchema(array $svcRow, string $canonical, string $title, string $description, array $crumbs, string $image = ''): array {
        global $siteUrl, $siteName;
        $root = rtrim($siteUrl, '/');
        $service = generateServiceSchema($svcRow + ['url' => $canonical]);
        $service['@id']      = $canonical . '#service-' . $svcRow['slug'];
        $service['category'] = 'Electrical contracting';
        $service['provider'] = ['@type' => 'Electrician', '@id' => $root . '/#organization', 'name' => $siteName];
        if ($image !== '') $service['image'] = absoluteUrl($image);

        $page = generateWebPageSchema($canonical, $title, $description);
        $page['mainEntity'] = ['@id' => $service['@id']];
        $page['speakable']  = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
        $page['breadcrumb'] = ['@id' => $canonical . '#breadcrumb'];

        $crumbNode = generateBreadcrumbSchema($crumbs);
        $crumbNode['@id'] = $canonical . '#breadcrumb';
        return [$service, $page, $crumbNode];
    }
}

if (!function_exists('spCrumbs')) {
    /** Visible breadcrumb (last crumb = current page, aria-current). */
    function spCrumbs(array $crumbs): string {
        $out = '<nav class="breadcrumb sp-crumbs" aria-label="Breadcrumb"><ol>';
        $last = count($crumbs) - 1;
        foreach (array_values($crumbs) as $spIdx => $spCrumb) {
            $out .= $spIdx === $last
                ? '<li><span aria-current="page">' . esc($spCrumb['name']) . '</span></li>'
                : '<li><a href="' . esc($spCrumb['url']) . '">' . esc($spCrumb['name']) . '</a></li>';
        }
        return $out . '</ol></nav>';
    }
}

if (!function_exists('spReviews')) {
    /**
     * Up to $limit real Google reviews (Page One feed, 4–5 stars) whose text matches $pattern (PCRE, case-insensitive),
     * newest first, as <figure> quote cards. Text is shown as written (trimmed at a word boundary past ~320 chars).
     * Feed down / nothing matches → '' so the page can drop the section. Never invents or hard-codes a review.
     */
    function spReviews(string $pattern, int $limit = 3): string {
        global $slug;
        $spData = p1_google_reviews_data($slug, 30, 4);
        if (!$spData || empty($spData['reviews'])) return '';
        $spHits = [];
        foreach ($spData['reviews'] as $spRev) {
            $spText = trim((string) ($spRev['text'] ?? ''));
            if ($spText === '' || !preg_match('~' . $pattern . '~iu', $spText)) continue;
            $spHits[] = $spRev;
            if (count($spHits) >= $limit) break;
        }
        if (!$spHits) return '';
        $star = icon('star', 16);
        $out = '<div class="sp-reviews">';
        foreach ($spHits as $spRev) {
            $spText = preg_replace('/\s+/u', ' ', trim((string) $spRev['text']));
            if (mb_strlen($spText) > 340) {
                $spCut = mb_substr($spText, 0, 320);
                $spText = mb_substr($spCut, 0, (int) mb_strrpos($spCut, ' ')) . '…';
            }
            $spWhen = !empty($spRev['date']) && strtotime($spRev['date']) ? date('F Y', strtotime($spRev['date'])) : '';
            $spStars = (int) round((float) ($spRev['rating'] ?? 5));
            $out .= '<figure class="sp-review">'
                  . '<span class="sp-review__stars" role="img" aria-label="' . $spStars . ' out of 5 stars">' . str_repeat($star, max(0, min(5, $spStars))) . '</span>'
                  . '<blockquote><p>' . esc($spText) . '</p></blockquote>'
                  . '<figcaption><b>' . esc($spRev['name'] ?? 'Google reviewer') . '</b><span>Google review' . ($spWhen !== '' ? ' · ' . esc($spWhen) : '') . '</span></figcaption>'
                  . '</figure>';
        }
        return $out . '</div>';
    }
}

if (!function_exists('spRelated')) {
    /**
     * "Other Services You May Need" — 3 cards in the required services-grid / service-card-with-image pattern
     * (tint + reveal-delay rotation 1→2→3). $h2 is a question; $answer is the 40–60 word answer under it.
     */
    function spRelated(array $slugs, string $h2, string $answer): string {
        global $services;
        $spCards = spServiceCards();
        $out  = '<section class="section sp-related" aria-labelledby="related-title"><div class="container">';
        $out .= '<div class="section-title sp-related__head reveal-up"><span class="eyebrow-label">Other Services You May Need</span>';
        $out .= '<h2 id="related-title">' . $h2 . '</h2><p class="answer-block">' . $answer . '</p></div>';
        $out .= '<div class="services-grid">';
        $spIdx = 0;
        foreach ($slugs as $spSlug) {
            $spRow = spService($spSlug);
            if (!$spRow || !isset($spCards[$spSlug])) continue;
            $spCard = $spCards[$spSlug];
            $spTint = ($spIdx % 3) + 1;
            $spUrl  = serviceUrl($spSlug);
            $out .= '<article class="service-card-with-image card-tint-' . $spTint . ' reveal-up reveal-delay-' . $spTint . '">';
            $out .= '<div class="service-card__image">' . responsivePicture($spCard['photo'], $spCard['alt'], '(max-width: 720px) 100vw, (max-width: 1000px) 50vw, 380px') . '</div>';
            $out .= '<div class="service-card__body"><div class="service-card__icon">' . icon($spCard['icon'], 26) . '</div>';
            $out .= '<h3>' . esc($spRow['name']) . '</h3><p class="service-card__desc">' . esc($spCard['desc']) . '</p><ul>';
            foreach ($spCard['bullets'] as $spBullet) $out .= '<li>' . esc($spBullet) . '</li>';
            $out .= '</ul>';
            $out .= $spUrl !== ''
                ? '<a href="' . esc($spUrl) . '" class="service-card__cta">Learn more<span class="sr-only"> about ' . esc($spRow['name']) . '</span></a>'
                : '<button type="button" class="service-card__cta sp-card-btn" data-open-estimate>Get an estimate<span class="sr-only"> for ' . esc($spRow['name']) . '</span></button>';
            $out .= '</div></article>';
            $spIdx++;
        }
        $out .= '</div>';
        if (siteHas('/services/')) {
            $out .= '<p class="sp-related__all"><a class="btn btn-secondary" href="/services/">View all ' . count((array) $services) . ' services ' . icon('arrow-right', 16) . '</a></p>';
        }
        return $out . '</div></section>';
    }
}

if (!function_exists('spStyles')) {
    /** Shared service-page CSS (tokens only). Echo once, right after header.php, before the page's own <style>. */
    function spStyles(): string {
        return <<<'CSS'
<style>
/* ==========================================================================
   Service pages — shared composition (includes/service-page.php). Tokens only.
   ========================================================================== */
/* Hero: photo under a 3-stop diagonal, compact interior padding, amber glow */
.hero--service { --sp-hero-pos: 50% 45%; padding-bottom: calc(clamp(2.5rem, 5vw, 3.5rem) + 3vw); }
.hero--service .hero-bg picture { display: block; width: 100%; height: 100%; }
.hero--service .hero-bg img { object-position: var(--sp-hero-pos); }
.hero--service .hero-overlay { background: linear-gradient(105deg, rgba(var(--color-dark-rgb), .95) 0%, rgba(var(--color-dark-rgb), .86) 46%, rgba(var(--color-dark-rgb), .58) 100%); }
.hero--service::before { content: ""; position: absolute; inset: auto -12% -50% 45%; height: 115%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side, rgba(var(--color-accent-rgb), .2), transparent 72%); }
.hero--service .hero-title { max-width: 24ch; }
.hero--service .hero-answer { max-width: 34rem; }
.hero--service .btn-primary { background: var(--color-accent); color: var(--color-ink); box-shadow: var(--shadow); }
.hero--service .btn-primary:hover { background: var(--color-accent-bright); color: var(--color-ink); }
.hero--service .link-call strong { color: var(--color-white); }
.hero--service .hero-form-card { border-top: 4px solid var(--color-accent); }
.hero--service .hero-form-card h2 { text-transform: uppercase; letter-spacing: .02em; }
.hero--service .hero-form-card .btn-primary { background: var(--color-primary); color: var(--color-white); }
.hero--service .hero-form-card .btn-primary:hover { background: var(--color-dark); }
.hero-form .hf-pair { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-xs); }
.sp-crumbs { margin: 0 0 var(--space-lg); color: color-mix(in srgb, var(--color-white) 74%, transparent); }
.sp-crumbs ol { display: flex; flex-wrap: wrap; align-items: center; gap: 0 var(--space-xs); list-style: none; margin: 0; padding: 0; }
.sp-crumbs li { display: inline-flex; align-items: center; gap: var(--space-xs); }
.sp-crumbs li + li::before { content: "/"; opacity: .5; }
.sp-crumbs a { color: inherit; }
.sp-crumbs a:hover { color: var(--color-accent-bright); }
.sp-crumbs [aria-current] { color: var(--color-white); }
@media (max-width: 900px) {
  .hero--service .hero-overlay { background: linear-gradient(180deg, rgba(var(--color-dark-rgb), .84) 0%, rgba(var(--color-dark-rgb), .9) 100%); }
  .sp-crumbs { margin-bottom: var(--space-sm); }
}
@media (max-width: 560px) {
  .hero--service .hero-answer { font-size: var(--fs-body); }
  .hero--service .hero-chips { gap: var(--space-xs); }
  .hero--service .hero-chips li { font-size: var(--fs-small); }
}

/* Article rhythm + body links */
.sp-article > section:first-child { margin-top: -3vw; z-index: 1; }
.sp-head { display: grid; gap: var(--space-sm); max-width: 62ch; margin-bottom: var(--space-xl); }
.sp-head .answer-block { margin: 0; }
.sp-article p a:not(.btn), .sp-related .answer-block a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.sp-article p a:not(.btn):hover { color: var(--color-accent-dark); }
.sp-article .texture-grain p a:not(.btn) { color: var(--color-accent-bright); }
.texture-grain .answer-block { background: color-mix(in srgb, var(--color-white) 7%, transparent); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.texture-grain .answer-block a { color: var(--color-accent-bright); }
div.sp-copy { display: grid; gap: var(--space-md); }
.sp-copy { max-width: var(--measure); }
.sp-copy p, p.sp-copy { margin: 0; color: var(--color-ink-2); }
.texture-grain .sp-copy p, .texture-grain p.sp-copy { color: color-mix(in srgb, var(--color-white) 82%, transparent); }

/* Problem statement: pull quote + bento sign cards */
.sp-pull { font-family: var(--font-heading); font-weight: 700; font-style: italic; font-size: clamp(1.5rem, 1rem + 2.2vw, 2.4rem); line-height: 1.15; max-width: 26ch; margin: 0; padding-left: var(--space-lg); border-left: 4px solid var(--color-accent); color: var(--color-ink); text-transform: uppercase; }
.texture-grain .sp-pull { color: var(--color-white); }
.sp-signs { display: grid; grid-template-columns: repeat(12, 1fr); gap: var(--space-md); margin-top: var(--space-2xl); }
.sp-sign { grid-column: span 4; display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.sp-sign:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.sp-sign svg { color: var(--color-accent-dark); }
.sp-sign h3 { font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .02em; }
.sp-sign p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.sp-sign--lead { grid-column: span 6; grid-row: span 2; background: var(--color-dark); border-color: var(--color-dark); align-content: end; min-height: 15rem; }
.sp-sign--lead h3 { color: var(--color-white); font-size: var(--fs-h2); }
.sp-sign--lead p { color: color-mix(in srgb, var(--color-white) 80%, transparent); font-size: var(--fs-body); }
.sp-sign--lead svg { color: var(--color-accent); }
.sp-sign--lead + .sp-sign, .sp-sign--lead ~ .sp-sign { grid-column: span 6; }
@media (max-width: 800px) { .sp-sign, .sp-sign--lead, .sp-sign--lead ~ .sp-sign { grid-column: span 12; grid-row: auto; min-height: 0; } }

/* Expert positioning: big proof figure + paragraph (asymmetric 40/60) */
.sp-expert { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.4fr); gap: var(--space-xl) var(--space-3xl); align-items: start; }
.sp-figure { display: grid; gap: var(--space-xs); padding-top: var(--space-md); border-top: 4px solid var(--color-accent); }
.sp-figure b { font-family: var(--font-accent); font-size: clamp(3.5rem, 2.4rem + 4.5vw, 6.5rem); line-height: .85; color: var(--color-ink); text-transform: uppercase; letter-spacing: -.01em; }
.texture-grain .sp-figure b { color: var(--color-white); }
.sp-figure span { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.texture-grain .sp-figure span { color: var(--color-accent-bright); }
.sp-figure a { color: inherit; }
.sp-diffs { list-style: none; margin: var(--space-lg) 0 0; padding: 0; display: grid; gap: 0; }
.sp-diffs li { display: grid; grid-template-columns: 32px minmax(0, 1fr); gap: var(--space-2) var(--space-sm); padding: var(--space-md) 0; border-top: 1px solid var(--color-line); }
.texture-grain .sp-diffs li { border-top-color: color-mix(in srgb, var(--color-white) 14%, transparent); }
.sp-diffs svg { color: var(--color-accent-dark); margin-top: var(--space-1); }
.texture-grain .sp-diffs svg { color: var(--color-accent); }
.sp-diffs b { display: block; font-family: var(--font-heading); font-size: 1.1rem; text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); }
.texture-grain .sp-diffs b { color: var(--color-white); }
.sp-diffs span { color: var(--color-ink-2); font-size: var(--fs-small); }
.texture-grain .sp-diffs span { color: color-mix(in srgb, var(--color-white) 78%, transparent); }
@media (max-width: 900px) { .sp-expert { grid-template-columns: 1fr; } }

/* What's included + photo */
.sp-split { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(0, 1fr); gap: var(--space-2xl) var(--space-3xl); align-items: start; }
.sp-split--flip > :first-child { order: 2; }
.sp-included { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-sm); }
.sp-included li { display: grid; grid-template-columns: 26px minmax(0, 1fr); gap: var(--space-sm); align-items: start; color: var(--color-ink-2); }
.sp-included svg { color: var(--color-accent-dark); margin-top: var(--space-1); }
.sp-included b { color: var(--color-ink); }
.sp-photo { position: relative; margin: 0; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); }
.sp-photo picture { display: block; width: 100%; height: 100%; }
.sp-photo img { width: 100%; height: 100%; object-fit: cover; }
.sp-photo figcaption { position: absolute; inset: auto 0 0 0; padding: var(--space-xl) var(--space-md) var(--space-sm); background: linear-gradient(to top, rgba(var(--color-dark-rgb), .86), transparent); color: var(--color-white); font-size: var(--fs-small); }
.sp-photo--tall { aspect-ratio: 3 / 4; }
.sp-photo--wide { aspect-ratio: 4 / 3; }
.sp-photo--offset { margin-top: var(--space-2xl); }
.sp-photos { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-md); align-items: start; }
.sp-photos .sp-photo:nth-child(2) { margin-top: var(--space-3xl); }
@media (max-width: 900px) { .sp-split { grid-template-columns: 1fr; } .sp-split--flip > :first-child { order: 0; } .sp-photo--offset { margin-top: 0; } }
@media (max-width: 560px) { .sp-photos { grid-template-columns: 1fr; } .sp-photos .sp-photo:nth-child(2) { margin-top: 0; } }

/* Data tables (comparisons, options) */
.sp-table-wrap { overflow-x: auto; border: 1px solid var(--color-line); border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow-sm); }
.sp-table { width: 100%; min-width: 560px; border-collapse: collapse; font-size: var(--fs-small); color: var(--color-ink-2); }
.sp-table caption { caption-side: bottom; padding: var(--space-sm) var(--space-lg); text-align: left; font-size: var(--fs-small); color: var(--color-muted); }
.sp-table th, .sp-table td { padding: var(--space-md) var(--space-lg); text-align: left; vertical-align: top; border-bottom: 1px solid var(--color-line); }
.sp-table tbody tr:last-child > * { border-bottom: 0; }
.sp-table thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-ink); background: var(--color-paper-2); }
.sp-table tbody th { width: 26%; font-weight: 700; color: var(--color-ink); }
.sp-table .is-us { background: color-mix(in srgb, var(--color-accent) 9%, var(--color-surface)); color: var(--color-ink); }
.sp-table thead .is-us { background: var(--color-dark); color: var(--color-accent-bright); }

/* Process: sticky heading column + numbered steps (scroll storytelling) */
.sp-process { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.3fr); gap: var(--space-2xl) var(--space-3xl); align-items: start; }
.sp-process__head { position: sticky; top: calc(var(--nav-height) + var(--space-lg)); display: grid; gap: var(--space-sm); }
.sp-steps { list-style: none; counter-reset: sp-step; margin: 0; padding: 0; display: grid; gap: var(--space-md); position: relative; }
.sp-steps::before { content: ""; position: absolute; top: var(--space-lg); bottom: var(--space-lg); left: 27px; width: 2px; background: linear-gradient(var(--color-accent), color-mix(in srgb, var(--color-accent) 15%, transparent)); }
.sp-steps li { counter-increment: sp-step; position: relative; display: grid; gap: var(--space-xs); padding: var(--space-lg) var(--space-lg) var(--space-lg) calc(56px + var(--space-lg)); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); }
.sp-steps li::before { content: counter(sp-step, decimal-leading-zero); position: absolute; left: var(--space-xs); top: var(--space-lg); display: grid; place-items: center; width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--color-dark); color: var(--color-accent); font-family: var(--font-accent); font-weight: 700; font-size: 1.05rem; }
.sp-steps h3 { font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .02em; }
.sp-steps p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 900px) { .sp-process { grid-template-columns: 1fr; } .sp-process__head { position: static; } }

/* Proof: matched Google reviews */
.sp-reviews { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-md); }
.sp-review { position: relative; margin: 0; display: grid; gap: var(--space-sm); align-content: start; padding: var(--space-xl) var(--space-lg) var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow); color: var(--color-ink); }
.sp-review::after { content: "\201C"; position: absolute; top: var(--space-xs); right: var(--space-md); font-family: var(--font-heading); font-size: 4.5rem; line-height: 1; color: var(--color-accent); opacity: .35; }
.sp-review__stars { display: inline-flex; gap: 2px; color: var(--color-star); }
.sp-review__stars svg { fill: currentColor; }
.sp-review blockquote { margin: 0; }
.sp-review blockquote p { margin: 0; color: var(--color-ink-2); line-height: 1.6; }
.sp-review figcaption { display: grid; gap: 2px; font-size: var(--fs-small); color: var(--color-muted); padding-top: var(--space-sm); border-top: 1px solid var(--color-line); }
.sp-review figcaption b { color: var(--color-ink); }
.texture-grain .sp-review blockquote p { color: var(--color-ink-2); }
.sp-proof-foot { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-md) var(--space-lg); margin-top: var(--space-xl); }
.sp-proof-foot p { margin: 0; font-size: var(--fs-small); }

/* FAQ (visible text only — never FAQPage JSON-LD) */
.sp-faq .faq summary { text-transform: none; }
.sp-faq .faq p a { color: var(--color-primary); }

/* Recent work strip */
.sp-gallery .sp-gallery-grid { min-height: 420px; }
.sp-gallery .sp-gallery-item picture { display: block; width: 100%; height: 100%; }

/* Related services: 3-up grid */
.sp-related { background: var(--color-paper-2); }
.sp-related .services-grid { grid-template-columns: repeat(3, 1fr); gap: var(--space-lg); }
.sp-related .service-card__image picture { display: block; width: 100%; height: 100%; }
.sp-related .service-card__icon { color: var(--color-accent-dark); }
.sp-related .service-card-with-image h3 { text-transform: uppercase; letter-spacing: .02em; }
.sp-related .service-card-with-image:hover .service-card__icon { background: var(--color-accent); color: var(--color-ink); }
.sp-card-btn { background: none; border: 0; padding: var(--space-xs) 0 0; font: inherit; font-size: var(--fs-small); font-weight: 600; color: var(--color-primary); cursor: pointer; text-align: left; }
.sp-related__all { margin: var(--space-xl) 0 0; }
@media (max-width: 1000px) { .sp-related .services-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 640px) { .sp-related .services-grid { grid-template-columns: 1fr; } }

/* Final CTA */
.sp-final { margin-top: -3.5vw; z-index: 1; }
.sp-final h2 { text-transform: uppercase; max-width: 22ch; }
.sp-final .eyebrow { color: var(--color-accent-bright); }
.sp-final .actions .btn-accent { box-shadow: var(--shadow); }
.sp-final small { display: block; margin-top: var(--space-sm); color: color-mix(in srgb, var(--color-white) 70%, transparent); font-size: var(--fs-small); }
.sp-final .floating-accent { position: absolute; right: -2%; bottom: -14%; width: clamp(200px, 24vw, 340px); color: var(--color-accent); opacity: .07; pointer-events: none; }
.sp-final .floating-accent svg { width: 100%; height: auto; }
</style>
CSS;
    }
}
