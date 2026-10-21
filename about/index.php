<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /about/ — Goff Electric (Phase 5, 2026-10-21).
 * Section script: photo hero → who we are (image stack) → CTA band (mid-page form, v6.3 placement) → how a job is
 * treated + who shows up → milestones from the Google record (dark timeline) → credentials → closing CTA.
 * Sources: build-plan.json + config.php (owner Garrett Goff, Rio Rancho base, six towns, residential + commercial,
 * license/insurance status and free estimates per the client's current site, open 24/7 per GBP, 4.9 from 42 reviews) and the
 * Page One Google reviews feed (paraphrased with month/year — crew member Rick, the Corrales couple, the short three
 * electricians missed, the cut service line traced after 7 p.m., a long-time customer's "travelled all over the state").
 * Not supplied (left out, listed in /content-confirmations.json): founding year, license number, insurance details,
 * crew size, Garrett's background.
 */
$pageTitle       = 'About Goff Electric | Licensed Electrician in Rio Rancho, NM';
$pageDescription = 'Meet Goff Electric, the locally owned Rio Rancho electrician run by Garrett Goff: homes and businesses, open 24/7, rated 4.9 on Google from 42 reviews.';
$canonicalUrl    = $siteUrl . '/about/';
$ogImage         = '/assets/images/gbp-12-additional-960.webp';
$currentPage     = 'about';
$pageType        = 'about';

$heroImage   = 'gbp-04-additional';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'About', 'url' => '/about/'],
];

$areaLinks = [];
foreach ($serviceAreas as $areaRow) {
    $areaHref = areaUrl($areaRow['slug']);
    $areaLinks[] = $areaHref !== '' ? '<a href="' . esc($areaHref) . '">' . esc($areaRow['name']) . '</a>' : esc($areaRow['name']);
}
$areaSentence = implode(', ', array_slice($areaLinks, 0, -1)) . ' and ' . end($areaLinks);

/* How a job is treated — each value is backed by a real Google review (paraphrased, month/year from the feed) */
$values = [
    [
        'icon'  => 'handshake',
        'title' => 'A straight answer, even when it is "you don\'t need us"',
        'text'  => 'Goff Electric tells you what the problem is and what it takes before any work starts. If nothing needs fixing, you hear that too.',
        'proof' => 'A Corrales couple called to hire Goff Electric and were told what they already had was fine. <span>Google review · October 2024</span>',
    ],
    [
        'icon'  => 'clipboard-list',
        'title' => 'Options, not one take-it-or-leave-it price',
        'text'  => 'Where a job can be done more than one way, you get the choices and what each one means for your house and your budget.',
        'proof' => 'A hot tub owner wrote that Garrett laid out options for the power install instead of only telling him what he needed. <span>Google review · June 2025</span>',
    ],
    [
        'icon'  => 'search',
        'title' => 'Find the actual fault',
        'text'  => 'Resetting a breaker is not a repair. Goff Electric traces the problem to where it starts, including when that turns out to be the utility\'s side.',
        'proof' => 'One customer had three other electricians miss a short before Goff Electric found it. <span>Google review · April 2024</span>',
    ],
    [
        'icon'  => 'check-circle',
        'title' => 'Finish the whole job',
        'text'  => 'The job is done when it works the way you need it to, not when the last wire is landed.',
        'proof' => 'After a hot tub was delivered, Garrett came back to set it up and added a patio outlet and switch for holiday lights. <span>Google review · May 2024</span>',
    ],
];

/* Milestones from the Google record — paraphrased, dated by the review */
$milestones = [
    ['when' => 'April 2024',    'tag' => 'Troubleshooting', 'title' => 'The short three electricians missed',          'text' => 'A homeowner had three other electricians come out for a short before Goff Electric found it.'],
    ['when' => 'April 2024',    'tag' => 'Whole home',      'title' => 'Fixtures, new service, temporary power, EV charger', 'text' => 'One customer describes a whole-home job: fixtures, temporary power, a new service and an electric vehicle charger, with the crew showing up as scheduled.'],
    ['when' => 'May 2024',      'tag' => 'Same day',        'title' => 'A swim spa wired on short notice',               'text' => 'A swim spa owner reports a same-day visit with no charge for the late notice, plus a trip to fetch a replacement hose so the spa could be filled.'],
    ['when' => 'June 2024',     'tag' => 'After hours',     'title' => 'A cut service line, traced after 7 p.m.',        'text' => 'A street crew cut the power line to a house. Goff Electric arrived after another job, spent over an hour isolating the fault, found it off the property and called the power company.'],
    ['when' => 'October 2024',  'tag' => 'Corrales',        'title' => 'Told the truth: no work needed',                 'text' => 'A Corrales couple called to hire Goff Electric and were told their existing setup was already right.'],
    ['when' => 'April 2025',    'tag' => 'Panels',          'title' => 'Panel upgrade and a 220-volt hot tub outlet',     'text' => 'A customer had the breaker panel upgraded and a 220-volt outlet run for a new hot tub by Garrett Goff and Rick.'],
    ['when' => 'December 2025', 'tag' => 'Albuquerque',     'title' => 'EV charger for a long-term customer',            'text' => 'An Albuquerque customer had Goff Electric install an EV charger alongside other electrical updates, and calls it their electrician for as long as they live there.'],
];

/* Credentials — only what intake, the client's current site and the GBP listing support */
$credentials = [
    ['icon' => 'shield-check', 'title' => 'State contractor license', 'text' => 'State electrical contractor license, checkable in the CID public lookup.' . (!empty($licenseNumber) ? ' License ' . $licenseNumber . '.' : '')],
    ['icon' => 'badge-check',  'title' => 'Insured',                            'text' => 'Carries insurance on home and business jobs.'],
    ['icon' => 'star',         'title' => number_format((float) $gbpRating, 1) . ' on Google', 'text' => 'From ' . (int) $gbpReviewCount . ' reviews on the Goff Electric Google Business Profile.', 'href' => $gbpMapsUrl],
    ['icon' => 'clock',        'title' => 'Open 24 hours, 7 days',              'text' => 'Emergency calls answered day and night, per the Google listing.'],
    ['icon' => 'clipboard-check', 'title' => 'Free estimates',                  'text' => 'No charge to find out what the job takes and what it costs.'],
    ['icon' => 'building-2',   'title' => 'Homes and businesses',               'text' => 'Residential circuits and repairs through commercial electrical rooms.'],
];

/* Schema: AboutPage (about → #organization) + BreadcrumbList. head.php never repeats the LocalBusiness node off the homepage. */
$aboutPage = generateWebPageSchema($canonicalUrl, $pageTitle, $pageDescription);
$aboutPage['@type']      = 'AboutPage';
$aboutPage['mainEntity'] = ['@id' => rtrim($siteUrl, '/') . '/#organization'];
$aboutPage['breadcrumb'] = ['@id' => $canonicalUrl . '#breadcrumb'];
$aboutPage['speakable']  = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
$aboutCrumbs = generateBreadcrumbSchema($crumbs);
$aboutCrumbs['@id'] = $canonicalUrl . '#breadcrumb';
$schemaMarkup = [$aboutPage, $aboutCrumbs];

/* Mid-page estimate band (includes/cta-band.php) */
$ctaBandEyebrow = 'Talk to the owner';
$ctaBandTitle   = 'Get a free estimate from Goff Electric';
$ctaBandText    = 'Say what is going on and the town. Goff Electric will tell you what it takes and what it costs before any work starts.';
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ==========================================================================
   About — Goff Electric. Page composition only; tokens only.
   ========================================================================== */
/* Hero: high-desert trench photo, diagonal overlay, amber glow lower right */
.hero--about { padding-bottom: calc(clamp(2.5rem, 5vw, 3.5rem) + 3.5vw); }
.hero--about .hero-bg picture { display: block; width: 100%; height: 100%; }
.hero--about .hero-bg img { object-position: 50% 30%; }
.hero--about .hero-overlay { background: linear-gradient(105deg, rgba(var(--color-dark-rgb), .95) 0%, rgba(var(--color-dark-rgb), .84) 48%, rgba(var(--color-dark-rgb), .5) 100%); }
.hero--about::before { content: ""; position: absolute; inset: auto -12% -50% 45%; height: 115%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side, rgba(var(--color-accent-rgb), .2), transparent 72%); }
.hero--about .hero-text { max-width: 40rem; }
.hero--about .hero-title { max-width: 26ch; }
.hero--about .hero-answer { max-width: 34rem; }
.hero--about .btn-primary { background: var(--color-accent); color: var(--color-ink); box-shadow: var(--shadow); }
.hero--about .btn-primary:hover { background: var(--color-accent-bright); color: var(--color-ink); }
.hero--about .link-call strong { color: var(--color-white); }
.about-crumbs { margin: 0 0 var(--space-lg); color: color-mix(in srgb, var(--color-white) 74%, transparent); }
.about-crumbs ol { display: flex; flex-wrap: wrap; align-items: center; gap: 0 var(--space-xs); list-style: none; margin: 0; padding: 0; }
.about-crumbs li + li::before { content: "/"; margin-right: var(--space-xs); opacity: .5; }
.about-crumbs a { color: inherit; }
.about-crumbs [aria-current] { color: var(--color-white); }
@media (max-width: 900px) { .hero--about .hero-overlay { background: linear-gradient(180deg, rgba(var(--color-dark-rgb), .84) 0%, rgba(var(--color-dark-rgb), .9) 100%); } }
@media (max-width: 560px) { .hero--about .hero-answer { font-size: var(--fs-body); } .hero--about .hero-chips li { font-size: var(--fs-small); } }

/* Who we are: paper band slants up over the hero; copy 55 / stacked photos 45 */
.ab-story { background: var(--color-paper); margin-top: -3.5vw; z-index: 1; }
.ab-story__grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: var(--space-2xl) var(--space-4xl); align-items: start; }
.ab-story__copy { display: grid; gap: var(--space-md); }
.ab-story__copy h2 { max-width: 20ch; }
.ab-story__copy p { margin: 0; color: var(--color-ink-2); max-width: var(--measure); }
.ab-story__copy p a { color: var(--color-primary); font-weight: 600; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.ab-story .answer-block { margin: 0; }
.ab-quote { margin: var(--space-sm) 0 0; padding: var(--space-md) 0 0 var(--space-lg); border-left: 4px solid var(--color-accent); font-family: var(--font-heading); font-size: clamp(1.25rem, 1rem + 1vw, 1.6rem); line-height: 1.2; text-transform: uppercase; color: var(--color-ink); max-width: 28ch; }
.ab-quote cite { display: block; margin-top: var(--space-xs); font-family: var(--font-body); font-size: var(--fs-small); font-style: normal; text-transform: none; color: var(--color-muted); }
.ab-stack { position: relative; padding: 0 0 var(--space-4xl) var(--space-xl); }
.ab-stack::before { content: ""; position: absolute; inset: calc(-1 * var(--space-lg)) var(--space-2xl) var(--space-3xl) 0; border: 2px solid var(--color-accent); border-radius: var(--radius-lg); opacity: .55; }
.ab-stack .about-image-primary { aspect-ratio: 3 / 4; }
.ab-stack .about-image-primary picture, .ab-stack .about-image-secondary picture { display: block; width: 100%; height: 100%; }
.ab-stack .about-image-primary img, .ab-stack .about-image-secondary img { width: 100%; height: 100%; object-fit: cover; }
.ab-stack .about-image-secondary { aspect-ratio: 1; bottom: 0; right: calc(-1 * var(--space-md)); width: 46%; }
.ab-stack__tag { position: absolute; z-index: 3; left: 0; bottom: var(--space-xl); display: grid; gap: var(--space-1); padding: var(--space-sm) var(--space-md); background: var(--color-dark); color: var(--color-white); border-radius: var(--radius); box-shadow: var(--shadow-lg); }
.ab-stack__tag b { font-family: var(--font-accent); font-size: 1.4rem; line-height: 1; text-transform: uppercase; color: var(--color-accent-bright); }
.ab-stack__tag span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }
@media (max-width: 900px) { .ab-story__grid { grid-template-columns: 1fr; } .ab-stack { max-width: 30rem; } }

/* Values: white band, wave edge, 2x2 tinted cards + team column */
.ab-values { background: var(--color-surface); }
.ab-values__head { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-md) var(--space-3xl); align-items: end; max-width: none; }
.ab-values__head .answer-block { margin: 0; }
.ab-values__layout { display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: var(--space-xl); align-items: start; }
.ab-values__grid { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-md); }
.ab-value { display: grid; gap: var(--space-sm); align-content: start; padding: var(--space-lg); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.ab-value:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.ab-value__icon { width: var(--space-10); height: var(--space-10); display: grid; place-items: center; border-radius: var(--radius); background: var(--color-dark); color: var(--color-accent); }
.ab-value h3 { text-transform: uppercase; letter-spacing: .02em; }
.ab-value > p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.ab-value__proof { margin: 0; padding-top: var(--space-sm); border-top: 1px dashed var(--color-line); font-size: var(--fs-small); color: var(--color-ink); }
.ab-value__proof span { display: block; margin-top: var(--space-1); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-accent-dark); }
.ab-team { position: sticky; top: calc(var(--nav-height) + var(--space-lg)); display: grid; gap: var(--space-md); padding: var(--space-lg); background: var(--color-dark); color: var(--color-white); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
.ab-team h3 { color: var(--color-white); text-transform: uppercase; letter-spacing: .03em; }
.ab-team > p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.ab-person { display: grid; grid-template-columns: var(--space-12) minmax(0, 1fr); gap: var(--space-sm); align-items: center; padding-top: var(--space-md); border-top: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); }
.ab-person__mono { width: var(--space-12); height: var(--space-12); display: grid; place-items: center; border-radius: var(--radius-full); background: var(--color-accent); color: var(--color-ink); font-family: var(--font-heading); font-size: 1.3rem; }
.ab-person b { display: block; font-family: var(--font-heading); font-size: 1.15rem; text-transform: uppercase; letter-spacing: .02em; }
.ab-person span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 74%, transparent); }
.ab-team .btn { justify-self: start; }
@media (max-width: 1000px) { .ab-values__layout, .ab-values__head { grid-template-columns: 1fr; } .ab-team { position: static; } }
@media (max-width: 640px) { .ab-values__grid { grid-template-columns: 1fr; } }

/* Milestones: dark torn-edge band, horizontal rail on desktop, vertical timeline on mobile */
.ab-record { margin-top: -18px; z-index: 1; }
.ab-record__head { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-md) var(--space-3xl); align-items: end; max-width: none; margin-bottom: var(--space-2xl); }
.ab-record__head p { margin: 0; }
.ab-record .timeline { border-left-color: color-mix(in srgb, var(--color-white) 18%, transparent); margin: 0; }
.ab-record .timeline > li { display: grid; gap: var(--space-xs); align-content: start; }
.ab-record .timeline time { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.ab-record .timeline h3 { font-size: 1.1rem; text-transform: uppercase; letter-spacing: .02em; }
.ab-record .timeline p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.ab-record__tag { justify-self: start; font-size: var(--font-size-xs); font-weight: 600; padding: var(--space-1) var(--space-xs); border: 1px solid color-mix(in srgb, var(--color-white) 22%, transparent); border-radius: var(--radius-full); color: color-mix(in srgb, var(--color-white) 86%, transparent); }
.ab-record .timeline > li.ab-record__now { align-content: center; gap: var(--space-xs); padding: var(--space-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); border-left: 4px solid var(--color-accent); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 5%, transparent); }
.ab-record .timeline > li.ab-record__now::before { background: var(--color-white); }
.ab-record__now b { font-family: var(--font-heading); font-size: clamp(2rem, 1.4rem + 2vw, 3rem); line-height: 1; color: var(--color-white); }
.ab-record__now span { font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.ab-record__now a { color: var(--color-accent-bright); }
.ab-record .floating-ring { top: calc(-1 * var(--space-4xl)); right: calc(-1 * var(--space-4xl)); }
@media (min-width: 1001px) {
  /* rows of four on a rail: each item carries its own top rule + node */
  .ab-record .timeline { grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-2xl) var(--space-lg); padding-left: 0; border-left: 0; }
  .ab-record .timeline > li { padding-top: var(--space-lg); border-top: 2px solid color-mix(in srgb, var(--color-white) 18%, transparent); }
  .ab-record .timeline > li::before { left: 0; top: -1px; transform: translateY(-50%); }
  .ab-record .timeline > li.ab-record__now { border-top: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); }
}
@media (max-width: 1000px) { .ab-record__head { grid-template-columns: 1fr; } }

/* Credentials: paper band, slant, 3x2 tinted grid beside a clipped commercial photo */
.ab-creds { background: var(--color-paper); }
.ab-creds__grid { display: grid; grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); gap: var(--space-2xl) var(--space-3xl); align-items: start; }
.ab-creds .sp-head, .ab-creds__head { display: grid; gap: var(--space-sm); margin-bottom: var(--space-xl); max-width: 62ch; }
.ab-creds__head .answer-block { margin: 0; }
.ab-creds__list { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-sm); }
.ab-cred { display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-md); border: 1px solid var(--color-line); border-radius: var(--radius); }
.ab-cred svg { color: var(--color-accent-dark); }
.ab-cred b { font-family: var(--font-heading); font-size: 1.05rem; text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); }
.ab-cred span { font-size: var(--fs-small); color: var(--color-ink-2); }
.ab-cred a { color: inherit; }
.ab-creds__photo { position: relative; margin: 0; }
.ab-creds__photo .img-clipped { aspect-ratio: 4 / 5; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); }
.ab-creds__photo picture { display: block; width: 100%; height: 100%; }
.ab-creds__photo img { width: 100%; height: 100%; object-fit: cover; }
.ab-creds__photo figcaption { margin-top: var(--space-sm); font-size: var(--fs-small); color: var(--color-muted); }
@media (max-width: 1000px) { .ab-creds__grid { grid-template-columns: 1fr; } .ab-creds__photo { max-width: 28rem; } }
@media (max-width: 640px) { .ab-creds__list { grid-template-columns: 1fr 1fr; } }
@media (max-width: 420px) { .ab-creds__list { grid-template-columns: 1fr; } }

/* Closing CTA */
.ab-final { margin-top: -3.5vw; z-index: 1; }
.ab-final h2 { text-transform: uppercase; max-width: 22ch; }
.ab-final .actions .btn-accent { box-shadow: var(--shadow); }
.ab-final .floating-accent { right: -2%; bottom: -14%; width: clamp(200px, 24vw, 340px); color: var(--color-accent); }
.ab-final .floating-accent svg { width: 100%; height: auto; }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--about" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Trench dug along a block wall toward a steel outbuilding for an underground electrical run, mountains on the horizon', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb about-crumbs" aria-label="Breadcrumb"><ol><li><a href="/">Home</a></li><li><span aria-current="page">About</span></li></ol></nav>
    <div class="hero-text hero-copy">
      <span class="eyebrow">Locally owned · Rio Rancho, NM</span>
      <h1 class="hero-title" id="hero-title">About <span class="text-accent">Goff Electric</span> in Rio Rancho, NM</h1>
      <p class="hero-answer">Goff Electric is a locally owned electrical contractor in Rio Rancho, run by Garrett Goff and serving six towns around Albuquerque.</p>
      <div class="hero-actions">
        <a class="btn btn-primary btn-lg" href="#estimate" data-open-estimate>Get a free estimate</a>
        <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
      </div>
      <ul class="hero-chips">
        <li><?php echo icon('users', 16); ?>Owner Garrett Goff</li>
        <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
        <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
      </ul>
    </div>
  </div>
</section>

<!-- ===================== WHO WE ARE ===================== -->
<section class="section ab-story slant-top" aria-labelledby="story-title">
  <div class="container ab-story__grid">
    <div class="ab-story__copy reveal-left">
      <span class="eyebrow-label">Who You're Calling</span>
      <h2 id="story-title">Who is <span class="text-accent">Goff Electric</span>?</h2>
      <p class="answer-block">Goff Electric is a residential and commercial electrical contractor based in Rio Rancho, New Mexico, and owned by Garrett Goff. It works across Sandoval and Bernalillo counties on homes and businesses, and answers its phone 24 hours a day, seven days a week.</p>
      <p>Goff Electric serves <?php echo $areaSentence; ?>. The work runs from a single outlet on a patio to <?php echo serviceLink('commercial-electrical', 'commercial electrical rooms'); ?> with new panels, a transformer and long runs of conduit, and it includes the calls nobody plans for: a dead circuit, a breaker that will not reset, or a <?php echo serviceLink('24-7-emergency-electrical-service', 'late-night emergency'); ?>.</p>
      <p>Read the <?php echo (int) $gbpReviewCount; ?> Google reviews and one name keeps coming up: Garrett. The person who looks at the job and prices it is usually the person who comes back to do it. Customers describe hot tub and swim spa circuits, <?php echo serviceLink('electrical-panel-upgrades-repair', 'breaker panel upgrades'); ?>, pendant lights and recessed cans, <?php echo serviceLink('ev-charger-installation', 'EV chargers'); ?> and a short that three other electricians could not find.</p>
      <blockquote class="ab-quote">"He has travelled all over the state to do jobs for us."<cite>A long-time customer, Google review, June 2025</cite></blockquote>
    </div>
    <div class="ab-stack reveal-right">
      <div class="about-image-primary img-reveal"><?php echo responsivePicture('gbp-12-additional', 'Goff Electric electrician on a blue ladder hanging pendant lights above a kitchen half-wall', '(max-width: 900px) 90vw, 440px'); ?></div>
      <div class="about-image-secondary"><?php echo responsivePicture('gbp-08-at_work', 'Open panelboard with breakers and color-coded conductors landed and dressed', '(max-width: 900px) 42vw, 220px'); ?></div>
      <p class="ab-stack__tag"><b>Homes + Business</b><span>Residential and commercial work</span></p>
    </div>
  </div>
</section>

<!-- ===================== MID-PAGE ESTIMATE BAND ===================== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php'; ?>

<!-- ===================== VALUES + TEAM ===================== -->
<section class="section ab-values edge-wave-top" aria-labelledby="values-title">
  <div class="container">
    <div class="section-title ab-values__head reveal-up">
      <div>
        <span class="eyebrow-label">How We Work</span>
        <h2 id="values-title">How does <span class="text-accent">Goff Electric</span> handle a job?</h2>
      </div>
      <p class="answer-block">Goff Electric handles a job by explaining the problem first, giving options where there are any, tracing faults to their source and finishing the whole task. Each point below is backed by something a customer wrote in a Google review.</p>
    </div>
    <div class="ab-values__layout">
      <div class="ab-values__grid">
<?php foreach ($values as $valIdx => $valItem): $valTint = ($valIdx % 3) + 1; ?>
        <article class="ab-value card-tint-<?php echo $valTint; ?> reveal-up reveal-delay-<?php echo $valTint; ?>">
          <span class="ab-value__icon"><?php echo icon($valItem['icon'], 22); ?></span>
          <h3><?php echo esc($valItem['title']); ?></h3>
          <p><?php echo esc($valItem['text']); ?></p>
          <p class="ab-value__proof"><?php echo $valItem['proof']; ?></p>
        </article>
<?php endforeach; ?>
      </div>
      <aside class="ab-team reveal-right" aria-labelledby="team-title">
        <h3 id="team-title">Who shows up at your door?</h3>
        <p>Goff Electric is owner-run. Most reviews name Garrett Goff as the electrician who gave the estimate and did the work.</p>
        <div class="ab-person">
          <span class="ab-person__mono" aria-hidden="true">GG</span>
          <div><b>Garrett Goff</b><span>Owner and electrician</span></div>
        </div>
        <div class="ab-person">
          <span class="ab-person__mono" aria-hidden="true">R</span>
          <div><b>Rick</b><span>Named by a customer working alongside Garrett on a panel upgrade and hot tub outlet</span></div>
        </div>
        <a class="btn btn-accent" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc($phoneText); ?></a>
      </aside>
    </div>
  </div>
</section>

<!-- ===================== MILESTONES (Google record) ===================== -->
<section class="section ab-record texture-grain edge-torn-top" aria-labelledby="record-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container-wide">
    <div class="section-title ab-record__head reveal-up">
      <div>
        <span class="eyebrow">Milestones</span>
        <h2 id="record-title">What does Goff Electric's Google record show?</h2>
      </div>
      <p>Goff Electric's Google reviews trace the company job by job. These are some of the milestones customers describe, dated by their review, from a short nobody else could find to EV chargers in Albuquerque.</p>
    </div>
    <ol class="timeline">
<?php foreach ($milestones as $msIdx => $msItem): ?>
      <li class="reveal-up reveal-delay-<?php echo ($msIdx % 4) + 1; ?>">
        <time><?php echo esc($msItem['when']); ?></time>
        <h3><?php echo esc($msItem['title']); ?></h3>
        <p><?php echo esc($msItem['text']); ?></p>
        <span class="ab-record__tag"><?php echo esc($msItem['tag']); ?></span>
      </li>
<?php endforeach; ?>
      <li class="ab-record__now reveal-up reveal-delay-4">
        <time>Today</time>
        <b><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google</b>
        <span>From <?php echo (int) $gbpReviewCount; ?> reviews. <a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read them on Google</a>.</span>
      </li>
    </ol>
  </div>
</section>

<!-- ===================== CREDENTIALS ===================== -->
<section class="section ab-creds slant-top" aria-labelledby="creds-title">
  <div class="container ab-creds__grid">
    <div>
      <div class="ab-creds__head reveal-left">
        <span class="eyebrow-label">Credentials</span>
        <h2 id="creds-title">Is Goff Electric licensed and insured?</h2>
        <p class="answer-block">Yes. Goff Electric is a licensed and insured New Mexico electrical contractor. New Mexico licenses electrical contractors through the Construction Industries Division of the Regulation and Licensing Department, which offers a public license lookup<?php echo !empty($licenseNumber) ? '; Goff Electric\'s license number is ' . esc($licenseNumber) : '; ask Goff Electric for its license number when you call'; ?>.</p>
      </div>
      <ul class="ab-creds__list">
<?php foreach ($credentials as $credIdx => $credItem): ?>
        <li class="ab-cred card-tint-<?php echo ($credIdx % 3) + 1; ?> reveal-up reveal-delay-<?php echo ($credIdx % 3) + 1; ?>">
          <?php echo icon($credItem['icon'], 22); ?>
          <b><?php echo !empty($credItem['href']) ? '<a href="' . esc($credItem['href']) . '" target="_blank" rel="noopener">' . esc($credItem['title']) . '</a>' : esc($credItem['title']); ?></b>
          <span><?php echo esc($credItem['text']); ?></span>
        </li>
<?php endforeach; ?>
      </ul>
    </div>
    <figure class="ab-creds__photo reveal-right">
      <div class="img-clipped"><?php echo responsivePicture('gbp-01-additional', 'Commercial electrical room with new panels, a dry-type transformer, EMT conduit runs and spools of wire', '(max-width: 1000px) 90vw, 420px'); ?></div>
      <figcaption>A Goff Electric commercial electrical room: new panels, a dry-type transformer and EMT conduit.</figcaption>
    </figure>
  </div>
</section>

<!-- ===================== CLOSING CTA ===================== -->
<section class="closing-cta texture-grain slant-top ab-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('zap', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Day or night</span>
      <h2 id="final-title">Need an electrician in Rio Rancho or Albuquerque?</h2>
      <p>Call the 24/7 line or send the estimate form. Goff Electric will tell you what the job takes and what it costs before any work starts.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request an estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
<?php if (siteHas('/contact/')): ?>
      <a class="btn btn-outline-white btn-lg" href="/contact/">All contact options</a>
<?php endif; ?>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
