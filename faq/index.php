<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /faq/ — Goff Electric (Phase 5, 2026-10-21). DIRECTORY + index.php; linked from the footer "Company" column and the
 * mobile menu (both gate on siteHas('/faq/')).
 * 20 questions in four categories: General → [CTA band] → Services → Pricing → Process → closing CTA. Visible FAQ text
 * only — never FAQPage JSON-LD (QA blocker since 2026-10-20); the page is a WebPage + BreadcrumbList.
 * Sources: build-plan.json + config.php, research-brief FAQs (permits, warning signs, surge, licensing, panel/EV), the
 * service pages' facts (load calculation, fan-rated boxes, 240-volt hot tub circuits) and Google reviews (hot tub and swim
 * spa hookups, no late-notice upcharge on one same-day job). No prices, response times or permit handling are claimed:
 * intake did not supply them (see /content-confirmations.json).
 */
$pageTitle       = 'Rio Rancho Electrician FAQ | Costs & Permits | Goff Electric';
$pageDescription = 'Answers from Goff Electric, Rio Rancho electrician: service areas, licensing, EV chargers, panel upgrades, hot tubs, free estimates, permits and emergencies.';
$canonicalUrl    = $siteUrl . '/faq/';
$currentPage     = 'faq';
$pageType        = 'faq';

$phoneText = formatPhone($phone);
$phoneLink = '<a href="tel:' . esc($phoneRaw) . '">' . esc($phoneText) . '</a>';
$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'FAQ', 'url' => '/faq/'],
];

$areaLinks = [];
foreach ($serviceAreas as $areaRow) {
    $areaHref = areaUrl($areaRow['slug']);
    $areaLinks[] = $areaHref !== '' ? '<a href="' . esc($areaHref) . '">' . esc($areaRow['name']) . '</a>' : esc($areaRow['name']);
}
$areaSentence = implode(', ', array_slice($areaLinks, 0, -1)) . ' and ' . end($areaLinks);

$serviceList = [];
foreach ($services as $svcRow) $serviceList[] = serviceLink($svcRow['slug'], $svcRow['name']);
$aboutLink = siteHas('/about/') ? '<a href="/about/">About page</a>' : 'About page';

/* Answers: HTML allowed (links); every fact traces to config.php, the research brief or a service page */
$faqCats = [
    'general' => [
        'eyebrow' => 'General',
        'title'   => 'What should you know about <span class="text-accent">Goff Electric</span> before you call?',
        'answer'  => 'Goff Electric is a licensed, insured electrical contractor based in Rio Rancho, owned by Garrett Goff, open 24 hours and serving six towns in Sandoval and Bernalillo counties.',
        'items'   => [
            ['q' => 'Who is Goff Electric?', 'a' => 'Goff Electric is a locally owned electrical contractor based in Rio Rancho, New Mexico, run by owner Garrett Goff. It handles residential and commercial electrical work across the Albuquerque metro and is rated ' . number_format((float) $gbpRating, 1) . ' on Google from ' . (int) $gbpReviewCount . ' reviews. There is more on the ' . $aboutLink . '.'],
            ['q' => 'Which areas does Goff Electric serve?', 'a' => 'Goff Electric serves ' . $areaSentence . ', in Sandoval and Bernalillo counties. If your address is near those towns but not on the list, call ' . $phoneLink . ' and ask.'],
            ['q' => 'Is Goff Electric licensed and insured?', 'a' => 'Yes. Goff Electric is a licensed and insured New Mexico electrical contractor. The state Construction Industries Division licenses electrical contractors and offers a public license lookup' . (!empty($licenseNumber) ? '; Goff Electric\'s license number is ' . esc($licenseNumber) . '.' : '; ask for the license number when you call.')],
            ['q' => 'Is Goff Electric really open 24 hours?', 'a' => 'Yes. The Goff Electric phone line is open 24 hours a day, 7 days a week, for problems like a power loss, a breaker that will not reset, a burning smell or sparking. Call ' . $phoneLink . '.'],
            ['q' => 'Does Goff Electric work on homes or businesses?', 'a' => 'Both. ' . serviceLink('residential-electrical', 'Residential work') . ' covers repairs, new circuits, lighting, fans, outlets and panels. ' . serviceLink('commercial-electrical', 'Commercial work') . ' covers electrical rooms, panels, conduit, feeders and tenant power and lighting for offices, shops and other buildings.'],
        ],
    ],
    'services' => [
        'eyebrow' => 'Services',
        'title'   => 'Which electrical jobs does <span class="text-accent">Goff Electric</span> take on?',
        'answer'  => 'Goff Electric handles ' . count($services) . ' kinds of electrical work, from EV chargers and panel upgrades to ceiling fans, hot tub circuits and safety inspections. The questions below cover the ones Rio Rancho homeowners ask about most.',
        'items'   => [
            ['q' => 'What electrical services does Goff Electric offer?', 'a' => 'Goff Electric offers ' . implode(', ', array_slice($serviceList, 0, -1)) . ' and ' . end($serviceList) . '.'],
            ['q' => 'Can Goff Electric install a Level 2 EV charger at my house?', 'a' => 'Yes. Goff Electric installs ' . serviceLink('ev-charger-installation', 'Level 2 EV chargers') . ' on a dedicated 240-volt circuit. Every install starts with a load calculation to confirm your panel can carry the charger; if it cannot, a panel or service upgrade comes first.'],
            ['q' => 'How do I know if I need a panel upgrade?', 'a' => 'Common signs are breakers that trip again right after a reset, no open slots for a new circuit, a panel that buzzes or feels warm, or a big new load such as an EV charger, hot tub or refrigerated air. Goff Electric can look at the panel during a free estimate and tell you whether a ' . serviceLink('electrical-panel-upgrades-repair', 'panel repair or upgrade') . ' fits.'],
            ['q' => 'Can Goff Electric wire a hot tub or swim spa?', 'a' => 'Yes. A hot tub or swim spa needs its own 240-volt circuit with a disconnect and ground-fault protection, ready before delivery day. Several Goff Electric Google reviews describe hot tub and swim spa hookups, part of its ' . serviceLink('residential-electrical', 'residential electrical work') . '.'],
            ['q' => 'Can a ceiling fan go where a light fixture is now?', 'a' => 'Usually, but the ceiling box has to be rated to carry a fan, and many light-fixture boxes are not. Goff Electric checks the box and installs a fan-rated one when needed. See ' . serviceLink('ceiling-fan-installation', 'ceiling fan installation') . ' for vaulted ceilings and wall controls.'],
            ['q' => 'What does an electrical inspection cover?', 'a' => 'A Goff Electric ' . serviceLink('electrical-inspections', 'electrical inspection') . ' looks at the panel and breakers, tests outlets for problems like warm or dead receptacles and checks visible wiring, then gives you a clear list of what needs attention. Buyers, homeowners and businesses book one before a purchase, before a remodel or when something seems off.'],
            ['q' => 'Should my Rio Rancho home have whole-house surge protection?', 'a' => 'It is worth considering. Summer monsoon storms bring frequent lightning to the Rio Rancho area, and a surge protective device at the panel helps shield electronics, appliances and HVAC equipment. Ask about it at your estimate and Goff Electric can look at your panel and say what fits.'],
        ],
    ],
    'pricing' => [
        'eyebrow' => 'Pricing',
        'title'   => 'How does <span class="text-accent">pricing</span> work with Goff Electric?',
        'answer'  => 'Goff Electric gives free estimates and prices each job after looking at it, so you know the cost before any work starts. What drives the number is the panel, the distance the wire runs and how hard it is to reach.',
        'items'   => [
            ['q' => 'Are Goff Electric estimates free?', 'a' => 'Yes. Goff Electric estimates are free, so you know what the job takes and what it costs before any work starts. Request one with the form on this page or call ' . $phoneLink . '.'],
            ['q' => 'How much does a panel upgrade or EV charger install cost in Rio Rancho?', 'a' => 'It depends on the house. The price turns on your panel\'s size and condition, how far the new circuit runs from the panel, and whether the utility service has to change. Goff Electric quotes each job after seeing it, at no charge, rather than guessing a number over the phone.'],
            ['q' => 'What affects the price of electrical work?', 'a' => 'The main factors are the length and size of the wire run, whether the panel has room for the new load, how easy the route is (open attic, finished walls or a trench across the yard), the fixtures or equipment you choose, and any permit and inspection the job needs.'],
            ['q' => 'Is there an extra charge for after-hours or emergency calls?', 'a' => 'Ask when you call, before you book the visit. One Google reviewer who needed a swim spa wired on short notice wrote that there was no upcharge for the late notice.'],
        ],
    ],
    'process' => [
        'eyebrow' => 'Process',
        'title'   => 'What happens from your first call to the finished job?',
        'answer'  => 'You call or send the form, Goff Electric looks at the job and gives a free estimate, the work is done to the electrical code New Mexico has adopted, and you get a walkthrough before it is closed out.',
        'items'   => [
            ['q' => 'What happens after I request an estimate?', 'a' => 'Goff Electric receives your request by email and calls or emails you back to ask questions and set up the free estimate. For a power loss, a burning smell or sparking, call ' . $phoneLink . ' instead of using the form.'],
            ['q' => 'Do I need a permit for electrical work in Rio Rancho?', 'a' => 'Most electrical work that adds circuits, replaces a panel or changes wiring needs a permit and an inspection under the electrical code New Mexico has adopted. Check current requirements with the City of Rio Rancho or the office for your address, and ask Goff Electric what your project will need.'],
            ['q' => 'What should I do before an electrician arrives in an emergency?', 'a' => 'If there is smoke or fire, get everyone out and call 911 first. If an outlet or switch is sparking or smells hot, turn that circuit off at the breaker if you can do it safely, and stop resetting a breaker that trips right away. If the whole street is dark, report it to your utility (PNM serves most of the metro). Then call Goff Electric. The ' . serviceLink('24-7-emergency-electrical-service', 'emergency service page') . ' has more.'],
            ['q' => 'What are the warning signs that I need an electrician?', 'a' => 'Call an electrician if breakers trip often, lights flicker or dim, outlets or switches feel warm or look discolored, you smell burning, or the panel buzzes. These point to overloads or faults that can start a fire, so do not wait to have them checked.'],
        ],
    ],
];
$faqTotal = 0;
foreach ($faqCats as $catRow) $faqTotal += count($catRow['items']);

/* Schema: WebPage + BreadcrumbList only — FAQ text stays visible, never FAQPage JSON-LD */
$faqPage = generateWebPageSchema($canonicalUrl, $pageTitle, $pageDescription);
$faqPage['breadcrumb'] = ['@id' => $canonicalUrl . '#breadcrumb'];
$faqPage['speakable']  = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
$faqCrumbs = generateBreadcrumbSchema($crumbs);
$faqCrumbs['@id'] = $canonicalUrl . '#breadcrumb';
$schemaMarkup = [$faqPage, $faqCrumbs];

/* Mid-page estimate band (includes/cta-band.php) */
$ctaBandEyebrow = 'Question not answered?';
$ctaBandTitle   = 'Ask Goff Electric directly';
$ctaBandText    = 'Send your question with the service and town. Goff Electric will get back to you, and the estimate is free.';

/* Renders one category's accordion list */
function faqList(array $items, int $openFirst = 1): string {
    $out = '';
    foreach ($items as $fqIdx => $fqItem) {
        $out .= '<details class="faq"' . ($fqIdx < $openFirst ? ' open' : '') . '><summary>' . esc($fqItem['q']) . '</summary><p>' . $fqItem['a'] . '</p></details>';
    }
    return $out;
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ==========================================================================
   FAQ — Goff Electric. Page composition only; tokens only.
   ========================================================================== */
/* Hero: type-led, oversized "?" watermark, category jump chips */
.hero--faq { padding-bottom: calc(var(--space-3xl) + 3.5vw); background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 130%); }
.hero--faq::before { content: ""; position: absolute; inset: auto -12% -55% 48%; height: 120%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side, rgba(var(--color-accent-rgb), .2), transparent 72%); }
.hero--faq::after { content: "?"; position: absolute; right: 4%; top: 50%; transform: translateY(-42%); z-index: -1; font-family: var(--font-heading); font-size: clamp(12rem, 8rem + 16vw, 26rem); line-height: 1; color: var(--color-accent); opacity: .08; pointer-events: none; }
.hero--faq .grain { z-index: -1; opacity: .3; }
.hero--faq .hero-text { max-width: 42rem; }
.hero--faq .hero-title { max-width: 26ch; }
.hero--faq .text-accent { color: var(--color-accent-bright); }
.hero--faq .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.hero--faq .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.hero--faq .link-call svg { color: var(--color-accent-bright); }
.hero--faq .link-call strong { color: var(--color-white); }
.faq-crumbs { margin: 0; color: color-mix(in srgb, var(--color-white) 72%, transparent); }
.faq-crumbs ol { display: flex; flex-wrap: wrap; align-items: center; gap: 0 var(--space-xs); list-style: none; margin: 0; padding: 0; }
.faq-crumbs li + li::before { content: "/"; margin-right: var(--space-xs); opacity: .5; }
.faq-crumbs a { color: inherit; }
.faq-crumbs [aria-current] { color: var(--color-white); }
.faq-jump { display: flex; flex-wrap: wrap; gap: var(--space-xs); margin: var(--space-xs) 0 0; padding: 0; list-style: none; }
.faq-jump a { display: inline-flex; align-items: center; gap: var(--space-xs); min-height: 44px; padding: 0 var(--space-md); border: 1px solid color-mix(in srgb, var(--color-white) 26%, transparent); border-radius: var(--radius-full); background: color-mix(in srgb, var(--color-white) 7%, transparent); color: var(--color-white); font-weight: 600; font-size: var(--fs-small); text-decoration: none; transition: background-color var(--transition), border-color var(--transition); }
.faq-jump a:hover { background: var(--color-accent); border-color: var(--color-accent); color: var(--color-ink); }
.faq-jump b { font-family: var(--font-accent); color: var(--color-accent-bright); }
.faq-jump a:hover b { color: var(--color-ink); }

/* Shared category head + accordion polish */
.fq-cat { scroll-margin-top: var(--nav-height); }
.fq-head { display: grid; gap: var(--space-sm); margin-bottom: var(--space-xl); max-width: 62ch; }
.fq-head .answer-block { margin: 0; }
.fq-count { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.fq-cat .faq summary { text-transform: none; font-size: 1.08rem; }
.fq-cat .faq p { max-width: 64ch; }
.fq-cat .faq p a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.fq-cat .faq[open] summary { color: var(--color-accent-dark); }

/* General: paper band slants over the hero; photo + head left, accordion right */
.fq-general { background: var(--color-paper); margin-top: -3.5vw; z-index: 1; }
.fq-general__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.3fr); gap: var(--space-2xl) var(--space-4xl); align-items: start; }
.fq-general__photo { position: relative; margin: 0; }
.fq-general__photo .img-arch { aspect-ratio: 4 / 5; box-shadow: var(--shadow-lg); max-width: 26rem; }
.fq-general__photo picture { display: block; width: 100%; height: 100%; }
.fq-general__photo img { width: 100%; height: 100%; object-fit: cover; }
.fq-general__photo figcaption { margin-top: var(--space-sm); font-size: var(--fs-small); color: var(--color-muted); max-width: 26rem; }
@media (max-width: 900px) { .fq-general__grid { grid-template-columns: 1fr; } .fq-general__photo .img-arch { max-width: 20rem; } }

/* Services: white band, wave edge, two-column accordion under a wide head */
.fq-services { background: var(--color-surface); }
.fq-services .fq-head { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-md) var(--space-3xl); align-items: end; max-width: none; }
.fq-services .faq-grid { gap: 0 var(--space-3xl); }
.fq-services .faq { padding-left: var(--space-md); border-left: 3px solid transparent; transition: border-color var(--transition); }
.fq-services .faq[open] { border-left-color: var(--color-accent); }
@media (max-width: 900px) { .fq-services .fq-head { grid-template-columns: 1fr; } }

/* Pricing: dark torn-edge band, sticky head left, accordion + cost-factor card right */
.fq-pricing { margin-top: -18px; z-index: 1; }
.fq-pricing__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.4fr); gap: var(--space-2xl) var(--space-4xl); align-items: start; }
.fq-pricing .fq-head { position: sticky; top: calc(var(--nav-height) + var(--space-lg)); }
.fq-pricing .fq-count { color: var(--color-accent-bright); }
.fq-pricing .faq { border-top-color: color-mix(in srgb, var(--color-white) 14%, transparent); }
.fq-pricing .faq summary { color: var(--color-white); }
.fq-pricing .faq[open] summary { color: var(--color-accent-bright); }
.fq-pricing .faq summary::after { color: var(--color-accent-bright); }
.fq-pricing .faq p { color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.fq-pricing .faq p a { color: var(--color-accent-bright); }
.fq-factors { list-style: none; margin: var(--space-xl) 0 0; padding: var(--space-lg); display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-sm) var(--space-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); border-left: 4px solid var(--color-accent); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 5%, transparent); }
.fq-factors li { display: flex; gap: var(--space-xs); align-items: flex-start; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 86%, transparent); }
.fq-factors svg { color: var(--color-accent-bright); flex: 0 0 auto; margin-top: var(--space-1); }
.fq-pricing .floating-ring { bottom: calc(-1 * var(--space-4xl)); left: calc(-1 * var(--space-4xl)); }
@media (max-width: 900px) { .fq-pricing__grid { grid-template-columns: 1fr; } .fq-pricing .fq-head { position: static; } }
@media (max-width: 560px) { .fq-factors { grid-template-columns: 1fr; } }

/* Process: paper band, slant, numbered question cards in two columns */
.fq-process { background: var(--color-paper-2); }
.fq-process__list { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-md); counter-reset: fq-step; }
.fq-process .faq { counter-increment: fq-step; position: relative; padding: var(--space-lg) var(--space-lg) var(--space-lg) calc(var(--space-lg) + var(--space-3xl)); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); }
.fq-process .faq::before { content: counter(fq-step, decimal-leading-zero); position: absolute; left: var(--space-lg); top: var(--space-lg); font-family: var(--font-accent); font-size: 1.6rem; line-height: 1; color: var(--color-accent-dark); }
.fq-process .faq[open] { box-shadow: var(--shadow); border-color: color-mix(in srgb, var(--color-accent) 45%, var(--color-line)); }
@media (max-width: 800px) { .fq-process__list { grid-template-columns: 1fr; } }

/* Closing CTA */
.fq-final { margin-top: -3.5vw; z-index: 1; }
.fq-final h2 { text-transform: uppercase; max-width: 22ch; }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--interior hero--faq" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-text hero-copy">
      <nav class="breadcrumb faq-crumbs" aria-label="Breadcrumb"><ol><li><a href="/">Home</a></li><li><span aria-current="page">FAQ</span></li></ol></nav>
      <span class="eyebrow">Rio Rancho electrician · <?php echo (int) $faqTotal; ?> answers</span>
      <h1 class="hero-title" id="hero-title">Rio Rancho electrician FAQ: <span class="text-accent">Goff Electric</span></h1>
      <p class="hero-answer">Straight answers on service areas, licensing, EV chargers, panels, free estimates, permits and emergencies from Goff Electric in Rio Rancho, NM.</p>
      <ul class="faq-jump" aria-label="Jump to a category">
<?php foreach ($faqCats as $catId => $catRow): ?>
        <li><a href="#<?php echo esc($catId); ?>"><?php echo esc($catRow['eyebrow']); ?> <b><?php echo count($catRow['items']); ?></b></a></li>
<?php endforeach; ?>
      </ul>
      <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>Need an answer now? <strong><?php echo esc($phoneText); ?></strong>, 24/7</span></a>
    </div>
  </div>
</section>

<!-- ===================== GENERAL ===================== -->
<?php $catRow = $faqCats['general']; ?>
<section class="section fq-cat fq-general slant-top" id="general" aria-labelledby="general-title">
  <div class="container fq-general__grid">
    <div>
      <div class="fq-head reveal-left">
        <span class="eyebrow-label"><?php echo esc($catRow['eyebrow']); ?></span>
        <h2 id="general-title"><?php echo $catRow['title']; ?></h2>
        <p class="answer-block"><?php echo $catRow['answer']; ?></p>
        <span class="fq-count"><?php echo count($catRow['items']); ?> questions</span>
      </div>
      <figure class="fq-general__photo reveal-up">
        <div class="img-arch"><?php echo responsivePicture('gbp-11-at_work', 'Living room with a ceiling fan light kit and recessed lights in a textured ceiling', '(max-width: 900px) 20rem, 26rem'); ?></div>
        <figcaption>A living-room ceiling fan with recessed lights, wired by Goff Electric.</figcaption>
      </figure>
    </div>
    <div class="reveal-right"><?php echo faqList($catRow['items'], 2); ?></div>
  </div>
</section>

<!-- ===================== MID-PAGE ESTIMATE BAND ===================== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php'; ?>

<!-- ===================== SERVICES ===================== -->
<?php $catRow = $faqCats['services']; ?>
<section class="section fq-cat fq-services edge-wave-top" id="services" aria-labelledby="services-title">
  <div class="container">
    <div class="fq-head reveal-up">
      <div>
        <span class="eyebrow-label"><?php echo esc($catRow['eyebrow']); ?></span>
        <h2 id="services-title"><?php echo $catRow['title']; ?></h2>
      </div>
      <p class="answer-block"><?php echo $catRow['answer']; ?></p>
    </div>
    <div class="faq-grid">
      <div class="reveal-left"><?php echo faqList(array_slice($catRow['items'], 0, 4)); ?></div>
      <div class="reveal-right"><?php echo faqList(array_slice($catRow['items'], 4), 0); ?></div>
    </div>
  </div>
</section>

<!-- ===================== PRICING ===================== -->
<?php $catRow = $faqCats['pricing']; ?>
<section class="section fq-cat fq-pricing texture-grain edge-torn-top" id="pricing" aria-labelledby="pricing-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container fq-pricing__grid">
    <div class="fq-head reveal-left">
      <span class="eyebrow"><?php echo esc($catRow['eyebrow']); ?></span>
      <h2 id="pricing-title"><?php echo $catRow['title']; ?></h2>
      <p class="answer-block"><?php echo $catRow['answer']; ?></p>
      <span class="fq-count"><?php echo count($catRow['items']); ?> questions</span>
    </div>
    <div class="reveal-right">
      <?php echo faqList($catRow['items']); ?>
      <ul class="fq-factors" aria-label="What moves the price of an electrical job">
        <li><?php echo icon('ruler', 18); ?>Length and size of the wire run</li>
        <li><?php echo icon('gauge', 18); ?>Room left in the panel</li>
        <li><?php echo icon('hammer', 18); ?>Access: attic, finished walls, trenching</li>
        <li><?php echo icon('lightbulb', 18); ?>Fixtures and equipment you choose</li>
        <li><?php echo icon('clipboard-check', 18); ?>Permit and inspection, where required</li>
        <li><?php echo icon('zap', 18); ?>Whether the utility service changes</li>
      </ul>
    </div>
  </div>
</section>

<!-- ===================== PROCESS ===================== -->
<?php $catRow = $faqCats['process']; ?>
<section class="section fq-cat fq-process slant-top" id="process" aria-labelledby="process-title">
  <div class="container">
    <div class="fq-head reveal-up">
      <span class="eyebrow-label"><?php echo esc($catRow['eyebrow']); ?></span>
      <h2 id="process-title"><?php echo $catRow['title']; ?></h2>
      <p class="answer-block"><?php echo $catRow['answer']; ?></p>
    </div>
    <div class="fq-process__list">
<?php foreach ($catRow['items'] as $fqIdx => $fqItem): ?>
      <details class="faq reveal-up reveal-delay-<?php echo ($fqIdx % 2) + 1; ?>"<?php echo $fqIdx === 0 ? ' open' : ''; ?>><summary><?php echo esc($fqItem['q']); ?></summary><p><?php echo $fqItem['a']; ?></p></details>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== CLOSING CTA ===================== -->
<section class="closing-cta texture-grain slant-top fq-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Still have a question?</span>
      <h2 id="final-title">Want a straight answer about your own house or building?</h2>
      <p>Call the 24/7 line or request a free estimate. Goff Electric will look at the job and tell you what it takes and what it costs before any work starts.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request an estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
