<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * index.php — Goff Electric homepage (Phase 3, 2026-10-21).
 * Archetype: bold-industrial → full-bleed photo hero + photo-led section script:
 *   hero → proof strip → recent-work gallery → services → ticker → about/process → Google reviews
 *   → emergency band → FAQ → estimate section.
 * Every fact traces to build-plan.json / config.php. Facts intake did not supply are left out of the copy
 * and listed in /content-confirmations.json for the client to confirm.
 * Link integrity: service/area/hub links render only once the page exists on disk (serviceUrl, areaUrl, siteHas).
 */
$pageTitle       = 'Goff Electric | 24/7 Electrician in Rio Rancho, NM';
$pageDescription = 'Goff Electric: licensed, insured electrician in Rio Rancho, NM for panel upgrades, EV chargers, lighting, wiring and 24/7 emergency calls. Call (505) 549-9454.';
$canonicalUrl    = $siteUrl . '/';
$ogImage         = '/assets/images/og-default-v1.jpg';
$currentPage     = 'home';
$pageType        = 'home';

/* Hero — allocated hero photo (build-plan assets.recommended_hero_image = gbp-03-additional) */
$heroImage        = 'gbp-03-additional';
$heroPreloadImage = '/assets/images/' . $heroImage . '-960.avif';
$heroPreload      = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];

$phoneText = formatPhone($phone);

/* Services grid — the first 8 of the 10 config services (9+ rule), each with a real client photo.
   Photos are matched to the closest subject on disk; alt text describes what the photo shows. */
$homeServiceCards = [
    'residential-electrical' => [
        'photo'   => 'gbp-06-at_work',
        'alt'     => 'Open trench along the stucco wall of a home with new conduit run up to exterior electrical equipment beside the meter',
        'icon'    => 'house',
        'desc'    => 'Repairs, upgrades and new circuits for houses in Rio Rancho and Albuquerque.',
        'bullets' => ['Dead circuits traced and fixed', 'Remodel and addition wiring', 'Dedicated appliance circuits'],
    ],
    'commercial-electrical' => [
        'photo'   => 'gbp-01-additional',
        'alt'     => 'Commercial electrical room with new panels, a dry-type transformer, EMT conduit runs and spools of wire',
        'icon'    => 'building-2',
        'desc'    => 'Electrical rooms, panels, conduit and lighting for offices, shops and commercial buildings.',
        'bullets' => ['Electrical room build-outs', 'EMT conduit and feeders', 'Tenant power and lighting'],
    ],
    'ev-charger-installation' => [
        'photo'   => 'gbp-04-additional',
        'alt'     => 'Mini excavator digging a trench along a block wall for an underground electrical run',
        'icon'    => 'plug-zap',
        'desc'    => 'Level 2 charger circuits, sized with a load calculation on your existing panel.',
        'bullets' => ['Load calculation before install', 'Dedicated 240-volt circuit', 'Garage or exterior mounting'],
    ],
    'electrical-panel-upgrades-repair' => [
        'photo'   => 'gbp-08-at_work',
        'alt'     => 'Open commercial panelboard with breakers and color-coded conductors landed and dressed',
        'icon'    => 'gauge',
        'desc'    => 'Panel replacements, service upgrades and breaker repair when a building needs more capacity.',
        'bullets' => ['Room for new circuits', 'Fixes for tripping breakers', 'Safer, code-current equipment'],
    ],
    'lighting-installation' => [
        'photo'   => 'gbp-09-at_work',
        'alt'     => 'Ring pendant lights and recessed downlights in a two-story commercial atrium',
        'icon'    => 'lightbulb',
        'desc'    => 'Recessed cans, pendants, fixtures and exterior lights, indoors and out.',
        'bullets' => ['Recessed and pendant lighting', 'Fixture swaps and upgrades', 'Exterior and security lights'],
    ],
    'ceiling-fan-installation' => [
        'photo'   => 'gbp-11-at_work',
        'alt'     => 'Living room with a ceiling fan light kit and recessed lights in a textured ceiling',
        'icon'    => 'fan',
        'desc'    => 'New and replacement ceiling fans on fan-rated boxes, with wall controls.',
        'bullets' => ['Fan-rated box installed', 'Light kits and wall controls', 'Wobbly fans replaced'],
    ],
    'outlets-switches' => [
        'photo'   => 'gbp-12-additional',
        'alt'     => 'Electrician on a ladder hanging pendant lights above a kitchen half-wall with an outlet below',
        'icon'    => 'plug',
        'desc'    => 'Dead, warm or loose outlets repaired, GFCI protection added, new outlets installed.',
        'bullets' => ['GFCI for kitchens and baths', 'Warm outlets diagnosed', 'New outlets where needed'],
    ],
    'electrical-wiring-installation-repair' => [
        'photo'   => 'gbp-03-additional',
        'alt'     => 'Bank of parallel EMT conduit runs dropping into a wireway between electrical panels',
        'icon'    => 'cable',
        'desc'    => 'New wiring, rewiring and faulty-wire repair for homes, remodels and additions.',
        'bullets' => ['Remodel and addition rough-in', 'Faulty wiring traced and fixed', 'Older circuits rewired'],
    ],
];
$homeServices = [];
foreach ($services as $svcRow) {
    if (isset($homeServiceCards[$svcRow['slug']])) $homeServices[] = $svcRow + $homeServiceCards[$svcRow['slug']];
}
$moreServices = array_values(array_filter($services, fn($svcRow) => !isset($homeServiceCards[$svcRow['slug']])));

/* Recent-work gallery — all 8 manifest photos; captions say only what the photo shows */
$galleryItems = [
    ['img' => 'gbp-01-additional', 'tag' => 'Commercial',   'cap' => 'Electrical room build-out: new panels, a dry-type transformer and EMT conduit', 'alt' => 'Commercial electrical room with panels, a transformer, conduit runs and wire spools', 'wide' => false],
    ['img' => 'gbp-08-at_work',    'tag' => 'Panels',       'cap' => 'Panelboard mid-termination, conductors color-coded and dressed to the breakers', 'alt' => 'Open panelboard with color-coded conductors landed on the breakers', 'wide' => false],
    ['img' => 'gbp-11-at_work',    'tag' => 'Ceiling fans', 'cap' => 'Living room with a ceiling fan light kit and recessed lighting', 'alt' => 'Living room with a ceiling fan and recessed lights in the ceiling', 'wide' => true],
    ['img' => 'gbp-12-additional', 'tag' => 'Lighting',     'cap' => 'Hanging pendant lights over a kitchen half-wall', 'alt' => 'Electrician on a ladder installing pendant lights over a kitchen half-wall', 'wide' => false],
    ['img' => 'gbp-09-at_work',    'tag' => 'Lighting',     'cap' => 'Ring pendants and recessed downlights in a two-story commercial atrium', 'alt' => 'Circular pendant lights hanging in a two-story atrium with a staircase', 'wide' => false],
    ['img' => 'gbp-04-additional', 'tag' => 'Underground',  'cap' => 'Trenching along a block wall for an underground electrical run', 'alt' => 'Mini excavator trench beside a block wall under a clear New Mexico sky', 'wide' => true],
    ['img' => 'gbp-06-at_work',    'tag' => 'Residential',  'cap' => 'Conduit in an open trench, run up to new equipment beside the meter', 'alt' => 'Trench and conduit along a stucco house wall next to the electric meter', 'wide' => false],
    ['img' => 'gbp-03-additional', 'tag' => 'Wiring',       'cap' => 'Parallel EMT conduit runs dropping into a wireway and panel bank', 'alt' => 'Rows of metal conduit running down a wall into an electrical wireway', 'wide' => false],
];

/* FAQs — from the research brief plus the service-area list; visible text only (never FAQPage JSON-LD) */
$areaLinks = [];
foreach ($serviceAreas as $areaRow) {
    $areaHref = areaUrl($areaRow['slug']);
    $areaLinks[] = $areaHref !== '' ? '<a href="' . esc($areaHref) . '">' . esc($areaRow['name']) . '</a>' : esc($areaRow['name']);
}
$areaSentence = implode(', ', array_slice($areaLinks, 0, -1)) . ' and ' . end($areaLinks);

$faqs = [
    [
        'q' => 'Do I need a permit for electrical work in Rio Rancho?',
        'a' => 'Most electrical work that adds circuits, replaces a panel or changes wiring needs a permit and an inspection under the electrical code New Mexico has adopted. Check current requirements with the City of Rio Rancho, or ask Goff Electric what your project will need when you call for an estimate.',
    ],
    [
        'q' => 'What are the warning signs that I need an electrician?',
        'a' => 'Call an electrician if breakers trip often, lights flicker or dim, outlets or switches feel warm or look discolored, you smell burning, or the panel buzzes. These point to overloads or faults that can start a fire, so do not wait to have them checked.',
    ],
    [
        'q' => 'Can Goff Electric upgrade my panel or install an EV charger?',
        'a' => 'Yes. Goff Electric installs Level 2 EV chargers and upgrades and repairs electrical panels. A charger starts with a load calculation to confirm the panel can carry a dedicated circuit; if it cannot, a panel or service upgrade comes first, which can also mean coordinating with PNM. An estimate gives you the scope and cost for your property.',
    ],
    [
        'q' => 'Should I install surge protection in my Rio Rancho home?',
        'a' => 'Whole-home surge protection is worth a look in Rio Rancho, where summer monsoon storms bring frequent lightning. A surge protective device at the panel helps shield electronics, appliances and HVAC equipment. An electrician can check your panel and recommend the right device.',
    ],
    [
        'q' => 'Is Goff Electric licensed and insured?',
        'a' => 'Yes. Goff Electric is a licensed and insured New Mexico electrical contractor. New Mexico electrical contractors hold licenses issued by the state Construction Industries Division (CID), and you can look up any contractor&rsquo;s license status with CID before work starts.',
    ],
    [
        'q' => 'Which areas does Goff Electric serve?',
        'a' => 'Goff Electric is based in Rio Rancho and works across Sandoval and Bernalillo counties: ' . $areaSentence . '. Homes and businesses in all six reach the same around-the-clock phone line.',
    ],
];

/* Lead forms: p1_lead_hidden_fields('<form id>') (includes/p1-form-helpers.php) emits _next, _honey, form_location,
   consent_version/consent_page, p1_attribution_fields('<form id>') and the _ft/_js spam shield in one call.
   Form ids on this page: hero, estimate-section (the dialog in footer.php is "dialog"). */

/* Schema: head.php adds the Electrician (#organization) + WebSite nodes on the homepage; this page adds its WebPage node */
$schemaMarkup = [generateWebPageSchema($canonicalUrl, $pageTitle, $pageDescription)];

/* Google reviews (Page One feed) — decides the FAQ band color so light and dark keep alternating */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$homeReviews = p1_google_reviews($slug, ['heading' => 'What Rio Rancho and Albuquerque customers say on Google']);
$faqDark     = ($homeReviews !== '');

$servicesHub   = siteHas('/services/') ? '/services/' : '';
$emergencyUrl  = serviceUrl('24-7-emergency-electrical-service');
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<style>
/* ==========================================================================
   Homepage — Goff Electric (bold-industrial). Page-specific composition only;
   framework.css owns the shared components. Tokens only: no raw colors,
   shadows or spacing.
   ========================================================================== */

/* ---------- Hero: full-bleed job photo, slow Ken Burns, 3-stop diagonal ---------- */
.hero--goff { padding-bottom: calc(var(--space-3xl) + 3.5vw); }
.hero--goff .hero-bg picture { display: block; width: 100%; height: 100%; }
.hero--goff .hero-bg img { object-position: 50% 42%; transform-origin: 60% 40%; animation: goff-kenburns 22s var(--ease) both; }
@keyframes goff-kenburns { from { transform: scale(1.1); } to { transform: scale(1); } }
.hero--goff .hero-overlay { background: linear-gradient(105deg, rgba(var(--color-dark-rgb), .93) 0%, rgba(var(--color-dark-rgb), .8) 42%, rgba(var(--color-dark-rgb), .45) 100%); }
.hero--goff::before { content: ""; position: absolute; inset: auto -15% -45% 40%; height: 110%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side, rgba(var(--color-accent-rgb), .22), transparent 72%); }
.hero--goff .hero-text { gap: var(--space-md); }
.hero--goff .hero-text { max-width: 38rem; }
.hero--goff .hero-title { max-width: 26ch; }
.hero--goff .hero-title .text-accent { display: inline; }
.hero--goff .hero-answer { max-width: 30rem; }
.hero--goff .btn-primary { background: var(--color-accent); color: var(--color-ink); box-shadow: var(--shadow); }
.hero--goff .btn-primary:hover { background: var(--color-accent-bright); color: var(--color-ink); }
.hero--goff .hero-form-card .btn-primary { background: var(--color-primary); color: var(--color-white); }
.hero--goff .hero-form-card .btn-primary:hover { background: var(--color-dark); }
.hero--goff .hero-form-card { border-top: 4px solid var(--color-accent); }
.hero--goff .hero-form-card h2 { text-transform: uppercase; letter-spacing: .02em; }
.hero--goff .link-call strong { color: var(--color-white); }
@media (max-width: 900px) {
  .hero--goff { padding-bottom: calc(var(--space-2xl) + 3.5vw); }
  .hero--goff .hero-overlay { background: linear-gradient(180deg, rgba(var(--color-dark-rgb), .82) 0%, rgba(var(--color-dark-rgb), .88) 100%); }
}
@media (max-width: 560px) {
  .hero--goff .hero-answer { font-size: var(--fs-body); }
  .hero--goff .hero-chips { gap: var(--space-xs); margin-top: var(--space-xs); }
  .hero--goff .hero-chips li { font-size: var(--fs-small); }
}

/* ---------- Proof strip: slants up over the hero photo ---------- */
.proof-goff { margin-top: -3.5vw; z-index: 2; padding-bottom: var(--space-2xl); }
.proof-goff .grain-layer { opacity: .25; }
.proof-goff .stat-item { align-content: start; }
.proof-goff .stat-number { font-size: clamp(1.6rem, 1.2rem + 1.2vw, 2.2rem); text-transform: uppercase; }
.proof-goff .stat-number span { color: var(--color-accent-dark); }
.proof-goff .stat-label a { color: var(--color-ink-2); text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.proof-goff .stat-label a:hover { color: var(--color-ink); }

/* ---------- Recent work: dark band, full-bleed scroll-snap track ---------- */
.gallery-section { padding-bottom: var(--space-3xl); }
.gallery-head { display: grid; grid-template-columns: minmax(0, 1fr) auto; align-items: end; gap: var(--space-lg); margin-bottom: var(--space-xl); }
.gallery-head .section-title { margin-bottom: 0; }
.gallery-head .gallery-hint { color: rgba(255, 255, 255, .7); }
.gallery-head .gallery-hint svg { color: var(--color-accent-bright); }
.gallery-section .gallery-track { padding-inline: max(var(--gutter), calc((100vw - var(--container)) / 2 + var(--gutter))); scroll-padding-inline: max(var(--gutter), calc((100vw - var(--container)) / 2 + var(--gutter))); }
.gallery-section .gallery-track:focus-visible { outline-offset: calc(-1 * var(--space-xs)); }
.gallery-section .gallery-item { box-shadow: var(--shadow-lg); border: 1px solid rgba(255, 255, 255, .08); }
.gallery-section .gallery-item picture { display: block; width: 100%; height: 100%; }
.gallery-section .gallery-item:nth-child(even) { margin-top: var(--space-xl); }
.gallery-foot { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-md) var(--space-lg); margin-top: var(--space-xl); }
.gallery-foot p { margin: 0; color: rgba(255, 255, 255, .72); font-size: var(--fs-small); }
.gallery-section .floating-ring--a { top: -90px; right: -110px; }
.gallery-section .floating-ring--b { bottom: -140px; left: -120px; width: 260px; height: 260px; animation-duration: 24s; }
@media (max-width: 800px) { .gallery-head { grid-template-columns: 1fr; } .gallery-section .gallery-item:nth-child(even) { margin-top: 0; } }

/* ---------- Services: parallelogram edge over the dark gallery, staggered grid ---------- */
.services-section { background: var(--color-paper); margin-top: -2.5vw; z-index: 1; }
.services-head { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr); gap: var(--space-md) var(--space-3xl); align-items: end; max-width: none; }
.services-head .eyebrow-label, .services-head h2 { grid-column: 1; }
.services-head .hero-answer { grid-column: 2; grid-row: 1 / span 2; align-self: end; font-size: var(--fs-body); color: var(--color-ink-2); max-width: none; }
.services-head .section-subtitle, .services-head .prose { grid-column: 1 / -1; }
.services-head .prose { margin: 0; color: var(--color-muted); }
.services-section .service-card__image picture { display: block; width: 100%; height: 100%; }
.services-section .service-card__image img[src*="gbp-09"] { object-position: 50% 78%; }
.services-section .service-card__icon { color: var(--color-accent-dark); }
.services-section .service-card-with-image h3 { text-transform: uppercase; letter-spacing: .02em; }
.services-section .service-card-with-image:hover .service-card__icon { background: var(--color-accent); color: var(--color-ink); }
.service-card__cta--btn { background: none; border: 0; padding: var(--space-xs) 0 0; font: inherit; font-size: var(--fs-small); font-weight: 600; color: var(--color-primary); cursor: pointer; text-align: left; }
.service-card__cta--btn:hover { color: var(--color-accent-dark); }
@media (min-width: 1001px) {
  .services-section .services-grid > :nth-child(4n+2), .services-section .services-grid > :nth-child(4n+4) { transform: translateY(var(--space-xl)); }
  .services-section .services-grid > :nth-child(4n+2):hover, .services-section .services-grid > :nth-child(4n+4):hover { transform: translateY(calc(var(--space-xl) - 3px)); }
  .services-section .services-grid { padding-bottom: var(--space-xl); }
}
.services-more { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: var(--space-md) var(--space-xl); margin-top: var(--space-2xl); padding-top: var(--space-lg); border-top: 1px solid var(--color-line); }
.services-more p { margin: 0; color: var(--color-ink-2); }
.services-more a:not(.btn) { color: var(--color-primary); font-weight: 600; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
@media (max-width: 900px) { .services-head { grid-template-columns: 1fr; } .services-head .hero-answer { grid-column: 1; grid-row: auto; } }

/* ---------- Ticker: dark strip, amber marks ---------- */
.ticker-strip.ticker--dark { background: var(--color-dark); border-color: rgba(255, 255, 255, .08); padding-block: var(--space-md); }
.ticker--dark .ticker-track { color: rgba(255, 255, 255, .86); font-size: 1.05rem; }
.ticker--dark .ticker-track svg { color: var(--color-accent); flex: 0 0 auto; }

/* ---------- About / process: asymmetric 60/40, offset framed photo ---------- */
.about-section { background: var(--color-surface); }
.about-section .about-split { grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); align-items: start; }
.about-left { display: grid; gap: var(--space-md); }
.about-left p { margin: 0; color: var(--color-ink-2); max-width: var(--measure); }
.about-left .process-title { margin-top: var(--space-lg); font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .03em; }
.about-left .process-steps { margin-top: 0; }
.about-left .process-steps li { background: var(--color-paper); border: 1px solid var(--color-line); border-radius: var(--radius); padding: var(--space-md); }
.about-right { margin-top: var(--space-4xl); }
.about-right .frame::before { inset: calc(-1 * var(--space-lg)) var(--space-lg) var(--space-lg) calc(-1 * var(--space-lg)); }
.about-right .frame { margin-top: 0; }
.about-right .frame__img { aspect-ratio: 3 / 4; }
.about-right .frame__img picture { display: block; width: 100%; height: 100%; }
.about-stat-card { display: grid; gap: var(--space-1); max-width: 15rem; border-left: 4px solid var(--color-accent); }
.about-stat-card b { font-family: var(--font-accent); font-size: 1.5rem; line-height: 1; text-transform: uppercase; color: var(--color-ink); }
.about-stat-card span { font-size: var(--fs-small); color: var(--color-muted); }
@media (max-width: 900px) { .about-section .about-split { grid-template-columns: 1fr; } .about-right { margin-top: var(--space-lg); } }

/* ---------- Google reviews: light band ---------- */
.home-reviews { background: var(--color-paper-2); }

/* ---------- Emergency band: dark, slanted, bolt watermark ---------- */
.emergency-band { margin-top: -3.5vw; z-index: 1; }
.emergency-band .container { grid-template-columns: minmax(0, 1.3fr) minmax(0, .9fr); }
.emergency-band .eyebrow { color: var(--color-accent-bright); }
.emergency-band h2 { margin-top: var(--space-sm); max-width: 22ch; text-transform: uppercase; }
.emergency-band p { max-width: 56ch; }
.emergency-signs { list-style: none; margin: var(--space-md) 0 0; padding: 0; display: flex; flex-wrap: wrap; gap: var(--space-xs); }
.emergency-signs li { display: inline-flex; align-items: center; gap: var(--space-xs); font-size: var(--fs-small); color: var(--color-white); border: 1px solid rgba(255, 255, 255, .22); background: rgba(255, 255, 255, .06); border-radius: var(--radius-full); padding: var(--space-1) var(--space-sm); }
.emergency-signs svg { color: var(--color-accent-bright); }
.emergency-call { display: grid; gap: var(--space-sm); justify-items: start; background: rgba(255, 255, 255, .05); border: 1px solid rgba(255, 255, 255, .14); border-left: 4px solid var(--color-accent); border-radius: var(--radius-lg); padding: var(--space-xl); }
.emergency-call__label { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.emergency-call__number { font-family: var(--font-heading); font-size: clamp(1.9rem, 1.3rem + 2vw, 2.6rem); line-height: 1; color: var(--color-white); text-decoration: none; }
.emergency-call__number:hover { color: var(--color-accent-bright); }
.emergency-call .actions { margin-top: var(--space-xs); }
.emergency-call small { color: rgba(255, 255, 255, .7); font-size: var(--fs-small); }
.emergency-band .floating-accent { right: -2%; bottom: -12%; width: clamp(220px, 26vw, 380px); color: var(--color-accent); opacity: .07; }
.emergency-band .floating-accent svg { width: 100%; height: auto; }

/* ---------- FAQ: dark torn-edge band when reviews sit above it, light otherwise ---------- */
.faq-section.edge-torn-top, .estimate-section.edge-torn-top { margin-top: -18px; z-index: 1; }
.faq-section .faq-intro { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-md) var(--space-3xl); align-items: end; margin-bottom: var(--space-2xl); max-width: none; }
.faq-section .faq-intro p { margin: 0; }
.faq-section .faq summary { text-transform: none; }
.faq-section.texture-grain .faq { border-top-color: rgba(255, 255, 255, .14); }
.faq-section.texture-grain .faq summary { color: var(--color-white); }
.faq-section.texture-grain .faq summary::after { color: var(--color-accent-bright); }
.faq-section.texture-grain .faq p { color: rgba(255, 255, 255, .8); }
.faq-section.texture-grain .faq a { color: var(--color-accent-bright); }
.faq-section:not(.texture-grain) { background: var(--color-surface); }
.faq-section .faq a { color: var(--color-primary); }
@media (max-width: 800px) { .faq-section .faq-intro { grid-template-columns: 1fr; } }

/* ---------- Estimate section: torn edge, form card + next steps ---------- */
.estimate-section { background: var(--color-paper-2); }
.estimate-section .card { display: grid; gap: var(--space-md); border-top: 4px solid var(--color-accent); }
.estimate-section .card h2 { text-transform: uppercase; }
.estimate-section .card > p { margin: 0; color: var(--color-ink-2); }
.estimate-section .estimate-form .btn { margin-top: var(--space-xs); }
.estimate-aside { display: grid; gap: var(--space-md); padding-top: var(--space-lg); }
.estimate-aside h3 { text-transform: uppercase; letter-spacing: .03em; }
.estimate-aside .next-steps { margin-top: 0; }
.estimate-aside .nap { margin-top: var(--space-xs); padding-top: var(--space-lg); border-top: 1px solid var(--color-line); }
.estimate-aside .area-line { margin: 0; font-size: var(--fs-small); color: var(--color-muted); }
.estimate-aside .area-line a { color: var(--color-primary); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--goff" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Parallel EMT conduit runs feeding a wireway and electrical panels on a Goff Electric commercial job', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-grid hero-grid--form">
      <div class="hero-text">
        <span class="eyebrow">Rio Rancho, NM · Albuquerque metro</span>
        <h1 class="hero-title" id="hero-title">Your Rio Rancho electrician, <span class="text-accent">day or night</span></h1>
        <p class="hero-answer">Goff Electric wires Rio Rancho homes and businesses: panel upgrades, EV charger circuits, lighting, outlets, new wiring and repairs. Call any hour for emergency electrical work, or request a free estimate and hear back by phone or email.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('clock', 16); ?>Open 24 hours, 7 days</li>
          <li><?php echo icon('badge-check', 16); ?>Free estimates</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form">
        <h2>Get a free estimate</h2>
        <p class="hero-form-tagline">No obligation. Tell us what you need.</p>
        <form action="<?php echo esc($formAction); ?>" method="POST" class="hero-form" id="hero">
          <?php echo p1_lead_hidden_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Get my free estimate</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<!-- ===================== PROOF STRIP ===================== -->
<section class="stats-band texture-grain slant-top proof-goff" aria-label="Goff Electric at a glance">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="stats-row">
      <div class="stat-item reveal-up reveal-delay-1">
        <span class="stat-number"><?php echo esc(number_format((float) $gbpRating, 1)); ?> <span>Google</span></span>
        <span class="stat-label">Rating from <a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo (int) $gbpReviewCount; ?> reviews</a></span>
      </div>
      <div class="stat-item reveal-up reveal-delay-2">
        <span class="stat-number">Home + <span>Business</span></span>
        <span class="stat-label">Residential and commercial electrical work</span>
      </div>
      <div class="stat-item reveal-up reveal-delay-3">
        <span class="stat-number">Locally <span>Owned</span></span>
        <span class="stat-label">Based in <?php echo esc($address['city'] . ', ' . $address['state']); ?></span>
      </div>
      <div class="stat-item reveal-up reveal-delay-4">
        <span class="stat-number"><?php echo count($serviceAreas); ?> <span>Towns</span></span>
        <span class="stat-label">Sandoval and Bernalillo counties, Rio Rancho to Tijeras</span>
      </div>
    </div>
  </div>
</section>

<!-- ===================== RECENT WORK GALLERY ===================== -->
<section class="section gallery-section texture-grain" aria-labelledby="gallery-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring floating-ring--a" aria-hidden="true"></span>
  <span class="floating-ring floating-ring--b" aria-hidden="true"></span>
  <div class="container">
    <div class="gallery-head">
      <div class="section-title reveal-left">
        <span class="eyebrow">Recent Work</span>
        <h2 id="gallery-title">Switch rooms, panels and finished lighting</h2>
        <p>Recent Goff Electric jobs, from commercial electrical rooms and conduit runs to a living-room fan.</p>
      </div>
      <p class="gallery-hint reveal-right"><?php echo icon('arrow-right', 16); ?>Scroll for more</p>
    </div>
  </div>
  <div class="gallery-track" data-p1-dynamic tabindex="0" aria-label="Project photos — scroll horizontally">
<?php foreach ($galleryItems as $galItem): ?>
    <figure class="gallery-item<?php echo $galItem['wide'] ? ' gallery-item--wide' : ''; ?>">
      <?php echo responsivePicture($galItem['img'], $galItem['alt'], $galItem['wide'] ? '(max-width: 900px) 80vw, 480px' : '(max-width: 900px) 60vw, 320px'); ?>
      <figcaption><span class="gallery-item__tag"><?php echo esc($galItem['tag']); ?></span><span class="gallery-item__cap"><?php echo esc($galItem['cap']); ?></span></figcaption>
    </figure>
<?php endforeach; ?>
  </div>
  <div class="container">
    <div class="gallery-foot">
<?php if ($servicesHub !== ''): ?>
      <a class="btn btn-outline-white" href="<?php echo esc($servicesHub); ?>">See all services <?php echo icon('arrow-right', 16); ?></a>
<?php else: ?>
      <button type="button" class="btn btn-outline-white" data-open-estimate>Request an estimate</button>
<?php endif; ?>
      <p>Have a job like one of these? Describe it and Goff Electric will quote it.</p>
    </div>
  </div>
</section>

<!-- ===================== SERVICES ===================== -->
<section class="section services-section edge-parallelogram-top" aria-label="Electrical services">
  <div class="container">
    <div class="section-title services-head reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which electrical services does <span class="text-accent">Goff Electric</span> handle in <span class="text-accent">Rio Rancho</span>?</h2>
      <p class="hero-answer">Goff Electric handles residential and commercial electrical work in Rio Rancho, Albuquerque, Corrales, Bernalillo, Placitas and Tijeras. That covers panel upgrades and repair, EV charger circuits, lighting, ceiling fans, outlets and switches, new wiring, electrical inspections and emergency calls at any hour, for houses, shops and offices alike.</p>
      <span class="section-subtitle">Homes · Shops · Offices · Electrical rooms</span>
      <p class="prose">Not sure which service fits? Describe the problem in the estimate form and Goff Electric will tell you what it takes.</p>
    </div>

    <div class="services-grid">
<?php foreach ($homeServices as $cardIdx => $cardSvc):
    $cardTint = ($cardIdx % 3) + 1;
    $cardUrl  = serviceUrl($cardSvc['slug']); ?>
      <article class="service-card-with-image card-tint-<?php echo $cardTint; ?> reveal-up reveal-delay-<?php echo $cardTint; ?>">
        <div class="service-card__image"><?php echo responsivePicture($cardSvc['photo'], $cardSvc['alt'], '(max-width: 440px) 100vw, (max-width: 720px) 50vw, (max-width: 1000px) 33vw, 300px'); ?></div>
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
          <button type="button" class="service-card__cta service-card__cta--btn" data-open-estimate>Get an estimate<span class="sr-only"> for <?php echo esc($cardSvc['name']); ?></span></button>
<?php endif; ?>
        </div>
      </article>
<?php endforeach; ?>
    </div>

    <div class="services-more reveal-up">
      <p>Also from Goff Electric: <?php echo implode(' and ', array_map(fn($moreSvc) => serviceLink($moreSvc['slug'], $moreSvc['name']), $moreServices)); ?>.</p>
<?php if ($servicesHub !== ''): ?>
      <a class="btn btn-secondary" href="<?php echo esc($servicesHub); ?>">View All <?php echo count($services); ?> Services <?php echo icon('arrow-right', 16); ?></a>
<?php else: ?>
      <a class="btn btn-secondary" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 16); ?>Ask about any of the <?php echo count($services); ?> services</a>
<?php endif; ?>
    </div>
  </div>
</section>

<!-- ===================== TICKER ===================== -->
<div class="ticker-strip ticker--dark" aria-hidden="true">
  <div class="ticker-track">
<?php
$tickerItems = [
    ['zap', 'Residential electrical'],
    ['building-2', 'Commercial electrical'],
    ['plug-zap', 'EV charger installation'],
    ['gauge', 'Panel upgrades & repair'],
    ['lightbulb', 'Lighting & ceiling fans'],
    ['star', number_format((float) $gbpRating, 1) . ' on Google · ' . (int) $gbpReviewCount . ' reviews'],
    ['map-pin', 'Rio Rancho · Albuquerque · Corrales'],
    ['map-pin', 'Bernalillo · Placitas · Tijeras'],
    ['clipboard-check', 'Electrical inspections'],
    ['clock', 'Emergency calls answered 24/7'],
];
for ($tickerPass = 0; $tickerPass < 2; $tickerPass++):
    foreach ($tickerItems as $tickerItem): ?>
    <span><?php echo icon($tickerItem[0], 18); ?><?php echo esc($tickerItem[1]); ?></span>
<?php endforeach;
endfor; ?>
  </div>
</div>

<!-- ===================== ABOUT / PROCESS (asymmetric) ===================== -->
<section class="section about-section" aria-labelledby="about-title">
  <div class="container">
    <div class="about-split">
      <div class="about-left reveal-left">
        <span class="eyebrow-label">Who You're Calling</span>
        <h2 id="about-title">Who is <span class="text-accent">Goff Electric</span>?</h2>
        <p>Goff Electric is a locally owned electrical contractor in Rio Rancho, run by owner <?php echo esc($ownerName); ?>. The shop takes residential and commercial work across the Albuquerque metro, from a single dead outlet to a commercial electrical room built out with new panels, a transformer and conduit, and the phone is answered around the clock.</p>
        <p>The high desert shapes the work. Summer monsoon storms bring lightning and surges, and refrigerated air and evaporative coolers push summer loads up. That is why a new EV charger circuit starts with a load calculation on the existing panel, so you know before install day whether the panel can carry it.</p>

        <h3 class="process-title">How a Goff Electric job runs</h3>
        <ol class="process-steps">
          <li><b>Call or send the form</b><span>Describe the problem or project, day or night, at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</span></li>
          <li><b>Look and estimate</b><span>A no-cost estimate, with a load calculation when a charger or new circuit needs one.</span></li>
          <li><b>Do the work to code</b><span>Wiring installed to the electrical code New Mexico has adopted.</span></li>
          <li><b>Walk through it</b><span>You see what was done and how it works before the job is closed out.</span></li>
        </ol>
      </div>

      <div class="about-right reveal-right">
        <div class="frame">
          <div class="frame__img img-clipped"><?php echo responsivePicture('gbp-12-additional', 'Goff Electric electrician on a ladder installing pendant lights over a kitchen half-wall', '(max-width: 900px) 90vw, 440px'); ?></div>
          <div class="about-stat-card">
            <b><?php echo esc($ownerName); ?></b>
            <span>Owner, Goff Electric · <?php echo esc($address['city'] . ', ' . $address['state']); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== EMERGENCY BAND (mid-page CTA) ===================== -->
<section class="cta-banner texture-grain slant-top emergency-band" aria-labelledby="emergency-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('cloud-lightning', 380); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Power out? Breaker won't reset?</span>
      <h2 id="emergency-title">Burning smell or a buzzing panel? Call tonight, not Monday.</h2>
      <p>Warm outlets, flickering lights, a breaker that trips again right after a reset and any burning smell point to an overload or a fault that can start a fire. Goff Electric takes emergency calls 24 hours a day, 7 days a week, across Rio Rancho and Albuquerque.</p>
      <ul class="emergency-signs">
        <li><?php echo icon('alert-triangle', 16); ?>Burning smell</li>
        <li><?php echo icon('zap', 16); ?>Sparking outlet</li>
        <li><?php echo icon('gauge', 16); ?>Breaker won't reset</li>
        <li><?php echo icon('cloud-lightning', 16); ?>Storm damage</li>
      </ul>
    </div>
    <div class="emergency-call reveal-right">
      <span class="emergency-call__label">Emergency line · open now</span>
      <a class="emergency-call__number" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call now</a>
<?php if ($emergencyUrl !== ''): ?>
        <a class="btn btn-outline-white btn-lg" href="<?php echo esc($emergencyUrl); ?>">Emergency service</a>
<?php endif; ?>
      </div>
      <small>Smoke or flames? Get out and call 911 first.</small>
    </div>
  </div>
</section>

<?php if ($homeReviews !== ''): ?>
<!-- ===================== GOOGLE REVIEWS (Page One feed) ===================== -->
<section class="section home-reviews" aria-label="Google reviews"><div class="container"><?php echo $homeReviews; ?></div></section>
<?php endif; ?>

<!-- ===================== FAQ ===================== -->
<section class="section faq-section<?php echo $faqDark ? ' texture-grain edge-torn-top' : ''; ?>" aria-labelledby="faq-title">
<?php if ($faqDark): ?>
  <span class="grain-layer" aria-hidden="true"></span>
<?php endif; ?>
  <div class="container">
    <div class="section-title faq-intro reveal-up">
      <div>
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do Rio Rancho homeowners ask an electrician first?</h2>
      </div>
      <p>Permits, warning signs, panel capacity for an EV charger and surge protection come up on most first calls. Straight answers below; for anything else, call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($faqs as $faqIdx => $faqItem): ?>
      <details class="faq"<?php echo $faqIdx < 2 ? ' open' : ''; ?>>
        <summary><?php echo esc($faqItem['q']); ?></summary>
        <p><?php echo $faqItem['a']; ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== ESTIMATE SECTION ===================== -->
<section class="section estimate-section edge-torn-top" id="estimate" aria-labelledby="estimate-title">
  <div class="container estimate">
    <div class="card reveal-up">
      <span class="eyebrow-label">Get Started</span>
      <h2 id="estimate-title">Tell us about the job</h2>
      <p>Home or business, one outlet or a full panel: send the details and Goff Electric will get back to you.</p>
      <form class="estimate-form" action="<?php echo esc($formAction); ?>" method="POST" id="estimate-section">
        <?php echo p1_lead_hidden_fields('estimate-section'); ?>
        <div class="form-grid">
          <div class="field"><label for="est-name">Your name *</label><input id="est-name" type="text" name="name" autocomplete="name" required></div>
          <div class="field"><label for="est-phone">Phone *</label><input id="est-phone" type="tel" name="phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="field full"><label for="est-email">Email *</label><input id="est-email" type="email" name="email" autocomplete="email" required></div>
          <div class="field full"><label for="est-service">Service needed</label><select id="est-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <div class="field full"><label for="est-message">Project details</label><textarea id="est-message" name="message" rows="4" placeholder="What's happening, and where is the property?"></textarea></div>
        </div>
        <fieldset class="form-consent-fieldset">
          <legend class="form-consent-legend">Communication consent</legend>
          <label class="consent" for="est-email-opt-in">
            <input id="est-email-opt-in" type="checkbox" name="email_opt_in" value="yes">
            <span><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo esc($siteName); ?> about my inquiry, services, promotions and news. I can unsubscribe anytime via the link in any email or by emailing <a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a>. Message frequency varies.</span>
          </label>
          <label class="consent" for="est-sms-opt-in">
            <input id="est-sms-opt-in" type="checkbox" name="sms_opt_in" value="yes">
            <span><strong>Text messages (optional):</strong> I agree to receive text messages from <?php echo esc($siteName); ?> at the phone number I provided, including appointment reminders, service updates and offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
          </label>
          <label class="consent" for="est-terms"><input id="est-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I have read and agree to the <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and <a href="/terms/" target="_blank" rel="noopener">Terms of Service</a>. *</span></label>
        </fieldset>
        <button type="submit" class="btn btn-accent btn-block btn-lg">Send my request</button>
      </form>
    </div>

    <aside class="estimate-aside reveal-right" aria-labelledby="next-title">
      <h3 id="next-title">What happens next</h3>
      <ol class="next-steps">
        <li><strong>Your request reaches Goff Electric</strong>The form goes straight to the shop, with the service and details you entered.</li>
        <li><strong>A call back to talk it through</strong>Goff Electric calls to ask about the problem or project and sets up a look if the job needs one.</li>
        <li><strong>Your estimate, at no cost</strong>You get the scope and the price before any work starts.</li>
      </ol>
      <div class="nap">
        <div><?php echo icon('phone', 18); ?><a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a></div>
        <div><?php echo icon('mail', 18); ?><a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a></div>
        <div><?php echo icon('map-pin', 18); ?><span><?php echo esc($address['city'] . ', ' . $address['state'] . ' ' . $address['zip']); ?></span></div>
        <div><?php echo icon('clock', 18); ?><span><?php echo esc($businessHours); ?></span></div>
      </div>
      <p class="area-line">Serving <?php echo $areaSentence; ?>, <?php echo esc($address['state']); ?>.</p>
    </aside>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
