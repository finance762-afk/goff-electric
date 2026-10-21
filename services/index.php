<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/ — Goff Electric services hub (Phase 4, 2026-10-21).
 * All 10 services from config.php render here (the homepage shows 8 + "View All"). Layout: photo hero → who-it's-for pair
 * (residential + commercial, wide cards) → the 8 specific jobs (4×2 grid, no orphans) → symptom-to-service table →
 * towns served → closing CTA. Every fact traces to build-plan.json / config.php / research brief warning signs.
 * Link integrity: service cards link only to pages on disk (serviceUrl); towns print as text until area pages exist.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$pageTitle       = 'Electrical Services Rio Rancho & Albuquerque NM | Goff Electric';
$pageDescription = 'All 10 Goff Electric services in Rio Rancho and Albuquerque, NM: panels, EV chargers, wiring, lighting, fans, outlets, inspections and emergency calls.';
$canonicalUrl    = $siteUrl . '/services/';
$currentPage     = 'services';
$pageType        = 'other';

$heroImage   = 'gbp-01-additional';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
];

$hubCards = spServiceCards();
$hubSvc   = [];
foreach ($services as $svcRow) $hubSvc[$svcRow['slug']] = $svcRow + $hubCards[$svcRow['slug']];
$audienceSlugs = ['residential-electrical', 'commercial-electrical'];
$jobSlugs      = array_values(array_diff(array_keys($hubSvc), $audienceSlugs));

/* Symptom → service guide (research-brief warning signs + the service list) */
$guideRows = [
    ['A breaker trips again right after you reset it', 'electrical-panel-upgrades-repair', 'Electrical Panel Upgrades & Repair', 'An overloaded circuit or a failing breaker. If you also smell burning, treat it as an emergency.'],
    ['Burning smell, sparking or a buzzing panel', '24-7-emergency-electrical-service', '24/7 Emergency Electrical Service', 'Call now, any hour. Smoke or flames: get out and call 911 first.'],
    ['An outlet or switch is warm, discolored or dead', 'outlets-switches', 'Outlets & Switches', 'A loose connection or worn device, usually fixed at the box.'],
    ['Lights flicker or dim when the air conditioning starts', 'electrical-wiring-installation-repair', 'Electrical Wiring Installation & Repair', 'A shared or loose circuit, sometimes a panel short on capacity.'],
    ['A new EV is coming home', 'ev-charger-installation', 'EV Charger Installation', 'A load calculation decides whether the panel can carry a Level 2 circuit.'],
    ['A hot tub or swim spa is being delivered', 'residential-electrical', 'Residential Electrical', 'A dedicated 240-volt circuit with a disconnect, ready before delivery day.'],
    ['You want pendants, recessed cans or brighter outdoor lights', 'lighting-installation', 'Lighting Installation', 'New boxes and switching, or a straight fixture swap.'],
    ['A fan wobbles, or a light fixture should become a fan', 'ceiling-fan-installation', 'Ceiling Fan Installation', 'A fan needs a box rated to carry it, not just a light-fixture box.'],
    ['You are buying a house or something just seems off', 'electrical-inspections', 'Electrical Inspections', 'A look at the panel, outlets and visible wiring, with a clear list of what needs attention.'],
    ['An office, shop or electrical room needs work', 'commercial-electrical', 'Commercial Electrical', 'Panels, conduit, feeders and lighting for commercial buildings.'],
];

/* Schema: CollectionPage + ItemList of the service pages (each Service is defined on its own page) + BreadcrumbList */
$hubRoot  = rtrim($siteUrl, '/');
$hubItems = [];
foreach (array_values($services) as $hubIdx => $svcRow) {
    $hubItem = ['@type' => 'ListItem', 'position' => $hubIdx + 1, 'name' => $svcRow['name']];
    if (serviceUrl($svcRow['slug']) !== '') $hubItem['url'] = $hubRoot . '/services/' . $svcRow['slug'] . '/';
    $hubItems[] = $hubItem;
}
$hubPage = generateWebPageSchema($canonicalUrl, $pageTitle, $pageDescription);
$hubPage['@type']      = 'CollectionPage';
$hubPage['mainEntity'] = ['@type' => 'ItemList', 'name' => $siteName . ' electrical services', 'numberOfItems' => count($services), 'itemListElement' => $hubItems];
$hubPage['speakable']  = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
$schemaMarkup = [$hubPage, generateBreadcrumbSchema($crumbs)];

$areaLinks = [];
foreach ($serviceAreas as $areaRow) {
    $areaHref = areaUrl($areaRow['slug']);
    $areaLinks[] = $areaHref !== '' ? '<a href="' . esc($areaHref) . '">' . esc($areaRow['name']) . '</a>' : esc($areaRow['name']);
}
$areaSentence = implode(', ', array_slice($areaLinks, 0, -1)) . ' and ' . end($areaLinks);
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Services hub — page composition. Tokens only.
   ========================================================================== */
.hero--hub { --sp-hero-pos: 50% 40%; padding-bottom: calc(clamp(2.5rem, 5vw, 3.5rem) + 3.5vw); }
.hero--hub .hero-text { max-width: 44rem; }
.hero--hub .hero-title { max-width: 26ch; }
.hero--hub .hero-actions .btn { display: inline-flex; }
.hub-count { display: inline-flex; align-items: baseline; gap: var(--space-xs); font-family: var(--font-accent); text-transform: uppercase; letter-spacing: .1em; font-size: var(--fs-eyebrow); color: color-mix(in srgb, var(--color-white) 72%, transparent); }
.hub-count b { font-size: 2.6rem; line-height: 1; letter-spacing: 0; color: var(--color-accent); }

/* Who it's for: two wide cards, image left */
.hub-audience { background: var(--color-paper); margin-top: -3.5vw; z-index: 1; }
.hub-audience__head { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-md) var(--space-3xl); align-items: end; max-width: none; }
.hub-audience__head .answer-block { margin: 0; }
.hub-audience .services-grid { grid-template-columns: 1fr 1fr; gap: var(--space-lg); }
.hub-audience .service-card-with-image { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); }
.hub-audience .service-card__image { aspect-ratio: auto; height: 100%; min-height: 320px; }
.hub-audience .service-card-with-image h3 { font-size: var(--fs-h3); }
.hub-audience .service-card__image + .service-card__body .service-card__icon { margin-top: 0; }
@media (max-width: 1000px) { .hub-audience .services-grid, .hub-audience__head { grid-template-columns: 1fr; } }
@media (max-width: 640px) { .hub-audience .service-card-with-image { grid-template-columns: 1fr; } .hub-audience .service-card__image { min-height: 220px; } }

/* The eight jobs: dark band, 4×2 grid */
.hub-jobs .sp-head { max-width: 64ch; }
.hub-jobs .services-grid { gap: var(--space-md); }
.hub-jobs .service-card-with-image { color: var(--color-ink); }
.hub-jobs .service-card-with-image p, .hub-jobs .service-card-with-image li { color: var(--color-ink-2); }
.hub-jobs .service-card__icon { color: var(--color-accent-dark); }
.hub-jobs .service-card-with-image h3 { color: var(--color-ink); text-transform: uppercase; letter-spacing: .02em; }
.hub-audience .service-card__image picture, .hub-jobs .service-card__image picture { display: block; width: 100%; height: 100%; }
.hub-audience .service-card__icon { color: var(--color-accent-dark); }
.hub-audience .service-card-with-image h3 { text-transform: uppercase; letter-spacing: .02em; }
@media (max-width: 1000px) { .hub-jobs .services-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 560px) { .hub-jobs .services-grid { grid-template-columns: 1fr; } }

/* Symptom guide */
.hub-guide { background: var(--color-surface); }
.hub-guide__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.7fr); gap: var(--space-xl) var(--space-3xl); align-items: start; }
.hub-guide__grid .sp-head { position: sticky; top: calc(var(--nav-height) + var(--space-lg)); }
.hub-guide .sp-table td a { color: var(--color-primary); font-weight: 700; text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.hub-guide .sp-table tr.is-urgent th { color: var(--color-danger); }
.hub-guide .sp-table tr.is-urgent { background: color-mix(in srgb, var(--color-danger) 6%, var(--color-surface)); }
@media (max-width: 1000px) { .hub-guide__grid { grid-template-columns: 1fr; } .hub-guide__grid .sp-head { position: static; } }

/* Towns */
.hub-towns { background: var(--color-paper-2); }
.hub-towns__grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: var(--space-xl) var(--space-3xl); align-items: center; }
.hub-towns__list { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-sm); }
.hub-towns__list li { display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md) var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-left: 4px solid var(--color-accent); border-radius: var(--radius); font-family: var(--font-heading); font-size: 1.15rem; text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); }
.hub-towns__list li span { display: grid; gap: 2px; line-height: 1.1; }
.hub-towns__list li small { font-family: var(--font-body); font-size: var(--fs-small); text-transform: none; letter-spacing: 0; color: var(--color-muted); }
.hub-towns__list a { color: inherit; }
.hub-towns__list svg { color: var(--color-accent-dark); flex: 0 0 auto; }
@media (max-width: 900px) { .hub-towns__grid { grid-template-columns: 1fr; } }
@media (max-width: 480px) { .hub-towns__list { grid-template-columns: 1fr; } }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--hub" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Commercial electrical room with new panels, a dry-type transformer, EMT conduit runs and spools of wire', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-text hero-copy">
      <span class="eyebrow">Homes &amp; businesses · Sandoval &amp; Bernalillo counties</span>
      <h1 class="hero-title" id="hero-title">Electrical services in <span class="text-accent">Rio Rancho</span> &amp; Albuquerque</h1>
      <p class="hero-answer">Ten electrical services from Goff Electric, for houses, shops and offices.</p>
      <div class="hero-actions">
        <button type="button" class="btn btn-primary btn-lg" data-open-estimate>Get a free estimate</button>
        <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
      </div>
      <ul class="hero-chips">
        <li><?php echo icon('clock', 16); ?>Open 24 hours, 7 days</li>
        <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
        <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
      </ul>
    </div>
  </div>
</section>

<!-- ===================== WHO IT'S FOR ===================== -->
<section class="section hub-audience slant-top" aria-labelledby="audience-title">
  <div class="container">
    <div class="section-title hub-audience__head reveal-up">
      <div>
        <span class="eyebrow-label">What We Do</span>
        <h2 id="audience-title">Which electrical services does <span class="text-accent">Goff Electric</span> offer in Rio Rancho and Albuquerque?</h2>
      </div>
      <p class="answer-block">Goff Electric offers ten electrical services in Rio Rancho, Albuquerque and four neighboring towns, split between homes and commercial buildings. Start with the residential or commercial page for the broad picture, or jump to a specific job below: panels, EV chargers, wiring, lighting, fans, outlets, inspections or an emergency call.</p>
    </div>

    <div class="services-grid">
<?php foreach ($audienceSlugs as $cardIdx => $cardSlug):
    $cardSvc  = $hubSvc[$cardSlug];
    $cardTint = ($cardIdx % 3) + 1;
    $cardUrl  = serviceUrl($cardSlug); ?>
      <article class="service-card-with-image card-tint-<?php echo $cardTint; ?> reveal-up reveal-delay-<?php echo $cardTint; ?>">
        <div class="service-card__image"><?php echo responsivePicture($cardSvc['photo'], $cardSvc['alt'], '(max-width: 640px) 100vw, (max-width: 1000px) 45vw, 260px'); ?></div>
        <div class="service-card__body">
          <div class="service-card__icon"><?php echo icon($cardSvc['icon'], 26); ?></div>
          <h3><?php echo esc($cardSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo esc($cardSvc['desc']); ?></p>
          <ul>
<?php foreach ($cardSvc['bullets'] as $cardBullet): ?>
            <li><?php echo esc($cardBullet); ?></li>
<?php endforeach; ?>
          </ul>
<?php if ($cardUrl !== ''): ?>
          <a href="<?php echo esc($cardUrl); ?>" class="service-card__cta">Learn more<span class="sr-only"> about <?php echo esc($cardSvc['name']); ?></span></a>
<?php else: ?>
          <button type="button" class="service-card__cta sp-card-btn" data-open-estimate>Get an estimate<span class="sr-only"> for <?php echo esc($cardSvc['name']); ?></span></button>
<?php endif; ?>
        </div>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== THE EIGHT JOBS ===================== -->
<section class="section texture-grain edge-parallelogram-top hub-jobs" aria-labelledby="jobs-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="sp-head reveal-up">
      <span class="eyebrow-label">Specific jobs</span>
      <h2 id="jobs-title">Which specific electrical jobs can you hire <span class="text-accent">Goff Electric</span> for?</h2>
      <p class="answer-block">You can hire Goff Electric for eight specific jobs: EV charger circuits, panel upgrades and repair, lighting, ceiling fans, outlets and switches, new wiring and rewiring, electrical inspections, and emergency calls at any hour. Each page below explains what the job involves, how it runs and what customers have said about it on Google.</p>
    </div>
    <div class="services-grid">
<?php foreach ($jobSlugs as $cardIdx => $cardSlug):
    $cardSvc  = $hubSvc[$cardSlug];
    $cardTint = ($cardIdx % 3) + 1;
    $cardUrl  = serviceUrl($cardSlug); ?>
      <article class="service-card-with-image card-tint-<?php echo $cardTint; ?> reveal-up reveal-delay-<?php echo $cardTint; ?>">
        <div class="service-card__image"><?php echo responsivePicture($cardSvc['photo'], $cardSvc['alt'], '(max-width: 560px) 100vw, (max-width: 1000px) 50vw, 300px'); ?></div>
        <div class="service-card__body">
          <div class="service-card__icon"><?php echo icon($cardSvc['icon'], 26); ?></div>
          <h3><?php echo esc($cardSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo esc($cardSvc['desc']); ?></p>
          <ul>
<?php foreach ($cardSvc['bullets'] as $cardBullet): ?>
            <li><?php echo esc($cardBullet); ?></li>
<?php endforeach; ?>
          </ul>
<?php if ($cardUrl !== ''): ?>
          <a href="<?php echo esc($cardUrl); ?>" class="service-card__cta">Learn more<span class="sr-only"> about <?php echo esc($cardSvc['name']); ?></span></a>
<?php else: ?>
          <button type="button" class="service-card__cta sp-card-btn" data-open-estimate>Get an estimate<span class="sr-only"> for <?php echo esc($cardSvc['name']); ?></span></button>
<?php endif; ?>
        </div>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== SYMPTOM GUIDE ===================== -->
<section class="section hub-guide edge-curve-top" aria-labelledby="guide-title">
  <div class="container hub-guide__grid">
    <div class="sp-head reveal-left">
      <span class="eyebrow-label">Not sure what you need?</span>
      <h2 id="guide-title">Which Goff Electric service fits the problem you are seeing?</h2>
      <p class="answer-block">The Goff Electric service you need usually follows from the symptom: tripping breakers point to the panel, warm outlets to outlets and switches, burning smells to an emergency call. Match what you see to a row, or describe it in the estimate form and Goff Electric will tell you.</p>
      <p class="sp-copy">Warning signs adapted from the questions Rio Rancho homeowners ask most. When in doubt, call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</p>
    </div>
    <div class="sp-table-wrap reveal-right">
      <table class="sp-table">
        <thead>
          <tr><th scope="col">What you are seeing</th><th scope="col">Service</th><th scope="col">What it usually means</th></tr>
        </thead>
        <tbody>
<?php foreach ($guideRows as $guideIdx => $guideRow): ?>
          <tr<?php echo $guideIdx === 1 ? ' class="is-urgent"' : ''; ?>><th scope="row"><?php echo esc($guideRow[0]); ?></th><td><?php echo serviceLink($guideRow[1], $guideRow[2]); ?></td><td><?php echo esc($guideRow[3]); ?></td></tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ===================== TOWNS ===================== -->
<section class="section hub-towns" aria-labelledby="towns-title">
  <div class="container hub-towns__grid">
    <div class="sp-head reveal-left">
      <span class="eyebrow-label">Where</span>
      <h2 id="towns-title">Where does Goff Electric provide these services?</h2>
      <p class="answer-block">Goff Electric provides every service on this page in six towns: <?php echo $areaSentence; ?>. The shop is based in Rio Rancho, in Sandoval County, and works across the Albuquerque metro on both sides of the Sandoval and Bernalillo county line, with the phone answered around the clock.</p>
    </div>
    <ul class="hub-towns__list reveal-right">
<?php foreach ($serviceAreas as $townRow): $townUrl = areaUrl($townRow['slug'], false); ?>
      <li><?php echo icon('map-pin', 18); ?><span><?php if ($townUrl !== ''): ?><a href="<?php echo esc($townUrl); ?>"><?php echo esc($townRow['name']); ?></a><?php else: ?><?php echo esc($townRow['name']); ?><?php endif; ?><small><?php echo esc($townRow['county']); ?> County</small></span></li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('zap', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">One call covers all ten</span>
      <h2 id="final-title">Ready to get your electrical project priced?</h2>
      <p>Describe the job, home or business, and Goff Electric will come back with the scope and the price at no cost.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request an estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
