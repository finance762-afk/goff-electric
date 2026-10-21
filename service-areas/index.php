<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/ — Goff Electric service-areas hub (Phase 6, 2026-10-21).
 * Section script: photo hero → coverage (intro + drawn coverage map with the six towns) → town cards → who issues the permit,
 * town by town → closing CTA. Every town fact here is a summary of the sourced facts on that town's own page (see the source
 * headers in /service-areas/<slug>/index.php). Map positions are plotted from each town's published coordinates
 * (Wikipedia/GNIS), equirectangular, north up; the river, ridge and highways are simplified.
 * Link integrity: town links come from areaUrl() (built pages only); service links from serviceUrl().
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.php';

$pageTitle       = 'Electrician in Rio Rancho & Surrounding Communities | Goff Electric';
$pageDescription = 'Goff Electric serves Rio Rancho, Albuquerque, Corrales, Bernalillo, Placitas and Tijeras, NM from its Rio Rancho base. Open 24/7, licensed and insured.';
$canonicalUrl    = $siteUrl . '/service-areas/';
$currentPage     = 'areas';
$pageType        = 'other';

$heroImage   = 'gbp-12-additional';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$ogImage     = '/assets/images/' . $heroImage . '-960.webp';
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Service Areas', 'url' => '/service-areas/'],
];

/* Town cards — photo = that page's hero; hook + facts summarise the town page */
$towns = [
    'rio-rancho'  => ['photo' => 'gbp-06-at_work',    'alt' => 'Electrical equipment and conduit beside a home electric meter on a stucco wall', 'icon' => 'house',
                      'tag' => 'Home base · 87124', 'hook' => 'A young, fast-grown city on the mesa: most jobs are about panel capacity for hot tubs, chargers and cooling.'],
    'albuquerque' => ['photo' => 'gbp-09-at_work',    'alt' => 'Ring pendant lights and recessed downlights in a two-story commercial atrium', 'icon' => 'building-2',
                      'tag' => 'Bernalillo County', 'hook' => 'From Westside homes near Rio Rancho to mid-century Northeast Heights houses and commercial buildings.'],
    'corrales'    => ['photo' => 'gbp-04-additional', 'alt' => 'Mini excavator trench across a gravel lot toward a steel outbuilding', 'icon' => 'trees',
                      'tag' => 'Village · 87048', 'hook' => 'One-acre lots, private wells and cottonwoods: long underground runs to shops, barns and well houses.'],
    'bernalillo'  => ['photo' => 'gbp-03-additional', 'alt' => 'Bank of parallel EMT conduit runs dropping into a wireway between electrical panels', 'icon' => 'landmark',
                      'tag' => 'Sandoval County seat · 87004', 'hook' => 'Historic adobe on Camino del Pueblo, a mapped river floodplain and a state-issued permit path.'],
    'placitas'    => ['photo' => 'gbp-11-at_work',    'alt' => 'Living room with a ceiling fan light kit and recessed lights in a textured ceiling', 'icon' => 'mountain',
                      'tag' => 'Sandia foothills · 87043', 'hook' => 'Rocky ground, wells with uneven yields and subdivisions built with buried utilities.'],
    'tijeras'     => ['photo' => 'gbp-08-at_work',    'alt' => 'Open panelboard with breakers and color-coded conductors landed and dressed', 'icon' => 'snowflake',
                      'tag' => 'East Mountains · 87059', 'hook' => 'Canyon wind, zone 7a winters and fire-season outages at the edge of the state\'s largest wildland-urban interface.'],
];

/* Coverage map — published coordinates (lat, lon) projected to a 600×560 box: x = (lon + 106.75) / 0.42 × 600, y = (35.36 − lat) / 0.33 × 560 */
$mapTowns = [
    'rio-rancho'  => [123, 153, 'end'],
    'albuquerque' => [143, 468, 'end'],
    'corrales'    => [204, 207, 'end'],
    'bernalillo'  => [284, 102, 'start'],
    'placitas'    => [465, 90, 'start'],
    'tijeras'     => [519, 480, 'end'],
];

/* Who issues the electrical permit — summarised from each town page's sources */
$permitRows = [
    ['Rio Rancho (city limits)', 'City of Rio Rancho Building Division', 'rio-rancho'],
    ['Rio Rancho Estates (unincorporated)', 'State Construction Industries Division, after Sandoval County zoning', 'rio-rancho'],
    ['Albuquerque (city limits)', 'City of Albuquerque Building Safety Division, via ABQ-PLAN', 'albuquerque'],
    ['North Valley, Sandia Heights, Paradise Hills', 'Bernalillo County Planning & Development Services', 'albuquerque'],
    ['Village of Corrales', 'Confirm with the Village (Planning & Zoning) for your address', 'corrales'],
    ['Town of Bernalillo', 'State Construction Industries Division, after Town zoning and floodplain review', 'bernalillo'],
    ['Placitas (unincorporated)', 'State Construction Industries Division, after Sandoval County zoning', 'placitas'],
    ['Unincorporated East Mountains', 'Bernalillo County, via its Accela portal', 'tijeras'],
    ['Village of Tijeras', 'Confirm with the Village, (505) 281-1220', 'tijeras'],
];

/* Schema: CollectionPage + ItemList of the town pages + BreadcrumbList (the Electrician node lives on the homepage) */
$hubRoot  = rtrim($siteUrl, '/');
$hubItems = [];
foreach (array_values($serviceAreas) as $hubIdx => $areaRow) {
    $hubItem = ['@type' => 'ListItem', 'position' => $hubIdx + 1, 'name' => 'Electrician in ' . $areaRow['name'] . ', ' . $address['state']];
    $hubHref = areaUrl($areaRow['slug'], false);
    if ($hubHref !== '') $hubItem['url'] = $hubRoot . $hubHref;
    $hubItems[] = $hubItem;
}
$hubPage = generateWebPageSchema($canonicalUrl, $pageTitle, $pageDescription);
$hubPage['@type']      = 'CollectionPage';
$hubPage['mainEntity'] = ['@type' => 'ItemList', 'name' => $siteName . ' service areas', 'numberOfItems' => count($serviceAreas), 'itemListElement' => $hubItems];
$hubPage['speakable']  = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
$schemaMarkup = [$hubPage, generateBreadcrumbSchema($crumbs)];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<?php echo apStyles(); ?>
<style>
/* ==========================================================================
   Service-areas hub — page composition. Tokens only.
   ========================================================================== */
.hero--areas { --sp-hero-pos: 50% 30%; padding-bottom: calc(clamp(2.5rem, 5vw, 3.5rem) + 3.5vw); }
.hero--areas .hero-text { max-width: 56rem; }
.hero--areas .hero-title { max-width: 34ch; }
.hero--areas .hero-answer { max-width: 40rem; }

/* Coverage: copy + drawn map */
.areas-coverage { background: var(--color-paper); }
.areas-coverage__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.15fr); gap: var(--space-2xl) var(--space-3xl); align-items: center; }
.areas-map { position: relative; margin: 0; padding: var(--space-md); background: var(--color-dark); border-radius: var(--radius-xl); box-shadow: var(--shadow-lg); overflow: hidden; }
.areas-map::after { content: ""; position: absolute; inset: 0; pointer-events: none; background: radial-gradient(circle at 22% 28%, rgba(var(--color-accent-rgb), .16), transparent 45%); }
.areas-map svg { display: block; width: 100%; height: auto; }
.areas-map figcaption { position: relative; z-index: 1; margin-top: var(--space-xs); font-size: var(--font-size-xs); color: color-mix(in srgb, var(--color-white) 62%, transparent); }
.map-grid line { stroke: var(--color-white); stroke-opacity: .05; }
.map-river { fill: none; stroke: var(--color-secondary); stroke-width: 7; stroke-linecap: round; stroke-linejoin: round; opacity: .9; }
.map-river-label { fill: color-mix(in srgb, var(--color-white) 55%, transparent); font-family: var(--font-accent); font-size: 13px; letter-spacing: .14em; text-transform: uppercase; }
.map-ridge { fill: color-mix(in srgb, var(--color-white) 9%, transparent); stroke: color-mix(in srgb, var(--color-white) 24%, transparent); stroke-width: 1.5; }
.map-ridge-label { fill: color-mix(in srgb, var(--color-white) 55%, transparent); font-family: var(--font-accent); font-size: 13px; letter-spacing: .14em; text-transform: uppercase; }
.map-road { fill: none; stroke: color-mix(in srgb, var(--color-white) 34%, transparent); stroke-width: 2.5; stroke-dasharray: 10 7; }
.map-road-label { fill: var(--color-dark); font-family: var(--font-accent); font-size: 12px; font-weight: 700; }
.map-shield { fill: color-mix(in srgb, var(--color-white) 78%, transparent); }
.map-town circle.map-dot { fill: var(--color-accent); stroke: var(--color-dark); stroke-width: 3; }
.map-town circle.map-halo { fill: rgba(var(--color-accent-rgb), .18); }
.map-town text { fill: var(--color-white); font-family: var(--font-heading); font-size: 21px; font-weight: 700; letter-spacing: .02em; text-transform: uppercase; }
.map-town text tspan.map-sub { fill: color-mix(in srgb, var(--color-white) 60%, transparent); font-family: var(--font-body); font-size: 12px; font-weight: 500; text-transform: none; letter-spacing: 0; }
.map-town--base circle.map-dot { r: 11; }
.map-town--base circle.map-halo { animation: map-pulse 2.8s var(--ease) infinite; transform-origin: center; transform-box: fill-box; }
.map-town a:hover text, .map-town a:focus-visible text { fill: var(--color-accent-bright); }
@keyframes map-pulse { 0%, 100% { transform: scale(.85); opacity: 1; } 50% { transform: scale(1.25); opacity: .35; } }
.areas-coverage__stats { list-style: none; margin: var(--space-lg) 0 0; padding: 0; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-sm); }
.areas-coverage__stats li { display: grid; gap: var(--space-1); padding: var(--space-md); border-left: 4px solid var(--color-accent); background: var(--color-surface); border-radius: var(--radius); box-shadow: var(--shadow-sm); font-size: var(--fs-small); color: var(--color-ink-2); }
.areas-coverage__stats b { font-family: var(--font-accent); font-size: 2rem; line-height: 1; color: var(--color-ink); }
@media (max-width: 1000px) { .areas-coverage__grid { grid-template-columns: 1fr; } }
@media (max-width: 520px) { .areas-coverage__stats { grid-template-columns: 1fr; } }

/* Town cards: 3×2, image top, tinted bodies */
.areas-towns { background: var(--color-paper-2); }
.areas-towns__grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-lg); }
.area-card { position: relative; display: grid; grid-template-rows: auto 1fr; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-line); box-shadow: var(--shadow); transition: transform var(--transition), box-shadow var(--transition); }
.area-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
.area-card.card-tint-1 { background: var(--color-card-tint-1); }
.area-card.card-tint-2 { background: var(--color-card-tint-2); }
.area-card.card-tint-3 { background: var(--color-card-tint-3); }
.area-card__img { position: relative; aspect-ratio: 16 / 10; overflow: hidden; }
.area-card__img picture { display: block; width: 100%; height: 100%; }
.area-card__img img { width: 100%; height: 100%; object-fit: cover; filter: var(--photo-grade); transition: transform var(--transition-slow); }
.area-card:hover .area-card__img img { transform: scale(1.05); }
.area-card__img::after { content: ""; position: absolute; inset: 0; background: linear-gradient(to top, rgba(var(--color-dark-rgb), .7), transparent 55%); }
.area-card__tag { position: absolute; left: var(--space-md); bottom: var(--space-sm); z-index: 1; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.area-card__body { display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); }
.area-card__body h3 { display: flex; align-items: center; gap: var(--space-xs); font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .02em; }
.area-card__body h3 svg { color: var(--color-accent-dark); flex: 0 0 auto; }
.area-card__body p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.area-card__link { display: inline-flex; align-items: center; gap: var(--space-1); width: fit-content; margin-top: var(--space-xs); font-weight: 700; color: var(--color-primary); text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.area-card__link::after { content: ""; position: absolute; inset: 0; }
.area-card__link:focus-visible { outline: none; }
.area-card:has(.area-card__link:focus-visible) { outline: 3px solid var(--color-accent); outline-offset: 3px; }
@media (max-width: 1000px) { .areas-towns__grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 620px) { .areas-towns__grid { grid-template-columns: 1fr; } }

/* Permit table */
.areas-permits { background: var(--color-surface); }
.areas-permits__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.7fr); gap: var(--space-xl) var(--space-3xl); align-items: start; }
.areas-permits__grid .sp-head { position: sticky; top: calc(var(--nav-height) + var(--space-lg)); }
.areas-permits .sp-table td a { color: var(--color-primary); font-weight: 700; text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
@media (max-width: 1000px) { .areas-permits__grid { grid-template-columns: 1fr; } .areas-permits__grid .sp-head { position: static; } }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--areas" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Electrician on a ladder hanging pendant lights over a kitchen half-wall in a home', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-text hero-copy">
      <span class="eyebrow">Sandoval &amp; Bernalillo counties</span>
      <h1 class="hero-title" id="hero-title">Electrician in <span class="text-accent">Rio Rancho</span> &amp; Surrounding Communities</h1>
      <p class="hero-answer">Goff Electric covers six towns from its Rio Rancho base, with one phone line.</p>
      <div class="hero-actions">
        <button type="button" class="btn btn-primary btn-lg" data-open-estimate>Get a free estimate</button>
        <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
      </div>
      <ul class="hero-chips">
        <li><?php echo icon('map-pin', 16); ?>Based in Rio Rancho</li>
        <li><?php echo icon('clock', 16); ?>Open 24 hours, 7 days</li>
        <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
      </ul>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== COVERAGE + MAP ===================== -->
  <section class="section areas-coverage slant-top" aria-labelledby="coverage-title">
    <div class="container areas-coverage__grid">
      <div>
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Where we work</span>
          <h2 id="coverage-title">Which towns does Goff Electric serve around Rio Rancho?</h2>
          <p class="answer-block">Goff Electric serves six towns around its Rio Rancho base: Rio Rancho, Albuquerque, Corrales, Bernalillo, Placitas and Tijeras, across Sandoval and Bernalillo counties. Homes and businesses in all six get the same licensed, insured crew, free estimates and a phone answered around the clock.</p>
        </div>
        <div class="ap-prose reveal-up">
          <p>Goff Electric is a licensed and insured New Mexico electrical contractor based in Rio Rancho, ZIP 87124, and owned by Garrett Goff. The six towns it serves sit within about 30 miles of that base, but they could hardly be more different: a young city on the mesa, the state's largest city across the river, an acre-lot village on the bosque, the 17th-century county seat, foothill subdivisions on rock and a mountain village in a windy canyon.</p>
          <p>Each town page below covers what is specific to that place: the neighborhoods and landmarks, the elevation and climate, the utility and who issues the electrical permit, and the Goff Electric services that fit it best.</p>
        </div>
        <ul class="areas-coverage__stats reveal-up">
          <li><b><?php echo count($serviceAreas); ?></b>Towns served</li>
          <li><b>2</b>Counties: Sandoval &amp; Bernalillo</li>
          <li><b>24/7</b>Phone answered</li>
        </ul>
      </div>
      <figure class="areas-map reveal-right">
        <svg viewBox="0 0 600 560" role="img" aria-labelledby="map-title map-desc">
          <title id="map-title">Goff Electric coverage map</title>
          <desc id="map-desc">Map of the six towns Goff Electric serves: Rio Rancho northwest of the Rio Grande, Corrales between Rio Rancho and the river, Bernalillo upriver on the east bank, Placitas east of Bernalillo at the north end of the Sandia Mountains, Albuquerque south along the river, and Tijeras east of Albuquerque on I-40 beyond the Sandias.</desc>
          <g class="map-grid" aria-hidden="true">
            <line x1="0" y1="140" x2="600" y2="140"/><line x1="0" y1="280" x2="600" y2="280"/><line x1="0" y1="420" x2="600" y2="420"/>
            <line x1="150" y1="0" x2="150" y2="560"/><line x1="300" y1="0" x2="300" y2="560"/><line x1="450" y1="0" x2="450" y2="560"/>
          </g>
          <path class="map-ridge" aria-hidden="true" d="M400 150 L418 128 L432 158 L446 140 L452 190 L470 214 L446 236 L462 268 L440 300 L458 336 L444 372 L466 400 L452 430 L420 420 L428 380 L410 344 L424 300 L404 262 L420 226 L398 190 Z"/>
          <text class="map-ridge-label" x="472" y="300" aria-hidden="true">Sandia Mtns</text>
          <path class="map-river" aria-hidden="true" d="M293 0 C 286 40, 278 80, 271 102 S 248 150, 236 170 S 212 215, 200 238 S 168 290, 150 322 S 124 380, 114 407 S 98 450, 100 475 S 106 530, 107 560"/>
          <text class="map-river-label" x="28" y="330" transform="rotate(-62 28 330)" aria-hidden="true">Rio Grande</text>
          <path class="map-road" aria-hidden="true" d="M314 0 L286 102 L230 250 L186 390 L157 560"/>
          <path class="map-road" aria-hidden="true" d="M0 450 L143 462 L300 466 L420 468 L519 482 L600 476"/>
          <path class="map-road" aria-hidden="true" d="M286 102 C 340 92, 400 86, 465 90"/>
          <g aria-hidden="true"><rect class="map-shield" x="238" y="296" width="34" height="20" rx="4"/><text class="map-road-label" x="255" y="311" text-anchor="middle">I-25</text></g>
          <g aria-hidden="true"><rect class="map-shield" x="322" y="452" width="34" height="20" rx="4"/><text class="map-road-label" x="339" y="467" text-anchor="middle">I-40</text></g>
          <g aria-hidden="true"><rect class="map-shield" x="356" y="56" width="38" height="20" rx="4"/><text class="map-road-label" x="375" y="71" text-anchor="middle">165</text></g>
<?php foreach ($mapTowns as $mapSlug => $mapPos):
    $mapArea = apArea($mapSlug);
    $mapHref = areaUrl($mapSlug, false);
    $mapBase = !empty($mapArea['primary']);
    $mapDx   = $mapPos[2] === 'end' ? -16 : 16;
    $mapLabel = '<text x="' . ($mapPos[0] + $mapDx) . '" y="' . ($mapPos[1] + 6) . '" text-anchor="' . $mapPos[2] . '">' . esc($mapArea['name']) . '<tspan class="map-sub" x="' . ($mapPos[0] + $mapDx) . '" dy="17">' . esc($mapBase ? 'Home base' : $mapArea['county'] . ' County') . '</tspan></text>'; ?>
          <g class="map-town<?php echo $mapBase ? ' map-town--base' : ''; ?>">
            <circle class="map-halo" cx="<?php echo $mapPos[0]; ?>" cy="<?php echo $mapPos[1]; ?>" r="<?php echo $mapBase ? 26 : 17; ?>"/>
            <circle class="map-dot" cx="<?php echo $mapPos[0]; ?>" cy="<?php echo $mapPos[1]; ?>" r="8"/>
            <?php echo $mapHref !== '' ? '<a href="' . esc($mapHref) . '">' . $mapLabel . '</a>' : $mapLabel; ?>
          </g>
<?php endforeach; ?>
        </svg>
        <figcaption>Town positions plotted from published coordinates; river, mountains and highways simplified. North is up.</figcaption>
      </figure>
    </div>
  </section>

  <!-- ===================== TOWN CARDS ===================== -->
  <section class="section areas-towns edge-curve-top" aria-labelledby="towns-title">
    <div class="container-wide">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Six towns</span>
        <h2 id="towns-title">What is different about electrical work in each town Goff Electric serves?</h2>
        <p class="answer-block">Electrical work differs from town to town around Rio Rancho because the ground, the housing and the weather differ. Corrales and Placitas jobs often involve long runs and wells, Bernalillo has historic adobe and a floodplain, Tijeras has mountain winters, and Rio Rancho and Albuquerque homes need capacity.</p>
      </div>
      <div class="areas-towns__grid">
<?php $townIdx = 0; foreach ($serviceAreas as $areaRow):
    $townCard = $towns[$areaRow['slug']] ?? null;
    if (!$townCard) continue;
    $townTint = ($townIdx % 3) + 1;
    $townHref = areaUrl($areaRow['slug'], false); ?>
        <article class="area-card card-tint-<?php echo $townTint; ?> reveal-up reveal-delay-<?php echo $townTint; ?>" id="<?php echo esc($areaRow['slug']); ?>">
          <div class="area-card__img"><?php echo responsivePicture($townCard['photo'], $townCard['alt'], '(max-width: 620px) 100vw, (max-width: 1000px) 50vw, 440px'); ?><span class="area-card__tag"><?php echo esc($townCard['tag']); ?></span></div>
          <div class="area-card__body">
            <h3><?php echo icon($townCard['icon'], 22); ?><?php echo esc($areaRow['name']); ?>, <?php echo esc($address['state']); ?></h3>
            <p><?php echo esc($townCard['hook']); ?></p>
<?php if ($townHref !== ''): ?>
            <a class="area-card__link" href="<?php echo esc($townHref); ?>">Electrician in <?php echo esc($areaRow['name']); ?> <?php echo icon('arrow-right', 14); ?></a>
<?php endif; ?>
          </div>
        </article>
<?php $townIdx++; endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===================== PERMITS BY TOWN ===================== -->
  <section class="section areas-permits" aria-labelledby="permits-title">
    <div class="container areas-permits__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow-label">Permits, town by town</span>
        <h2 id="permits-title">Who issues electrical permits in each town Goff Electric serves?</h2>
        <p class="answer-block">Electrical permits around Rio Rancho come from four different offices depending on the address: the City of Rio Rancho, the City of Albuquerque, Bernalillo County, or the state Construction Industries Division. A Rio Rancho or Albuquerque mailing address does not always mean the city issues the permit.</p>
        <p><a class="btn btn-secondary" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 16); ?>Ask about your address</a></p>
      </div>
      <div class="sp-table-wrap reveal-right">
        <table class="sp-table">
          <caption>From each city, town, village and county's published permit pages, October 2026. Rules change; confirm for your parcel.</caption>
          <thead>
            <tr><th scope="col">Where the property is</th><th scope="col">Who issues the electrical permit</th></tr>
          </thead>
          <tbody>
<?php foreach ($permitRows as $permitRow): $permitHref = areaUrl($permitRow[2], false); ?>
            <tr><th scope="row"><?php echo $permitHref !== '' ? '<a href="' . esc($permitHref) . '">' . esc($permitRow[0]) . '</a>' : esc($permitRow[0]); ?></th><td><?php echo esc($permitRow[1]); ?></td></tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

</article>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('map-pin', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Six towns, one number</span>
      <h2 id="final-title">Need an electrician in Rio Rancho or a nearby town?</h2>
      <p>Tell Goff Electric the job and the town. You get the scope and the price before any work starts, and the phone is answered day and night.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request my estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
