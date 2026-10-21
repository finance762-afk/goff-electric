<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/albuquerque/ — Goff Electric (Phase 6, 2026-10-21).
 * Angle: the big city across the river, read by the age of its neighborhoods (valley → Northeast Heights → Westside →
 * foothills), and the city-vs-county permit split. Conditions emphasis: swamp-cooler-to-refrigerated-air conversions,
 * spring wind, lightning that strikes miles from the rain. Westside neighborhoods nearest Rio Rancho named first.
 *
 * SOURCES (researched 2026-10-21):
 *   https://en.wikipedia.org/wiki/Albuquerque,_New_Mexico       2020 census 564,559; elevation ~4,900 ft at the river to 6,700+ ft
 *                                                               in the foothills (same article also gives 4,949 / 6,165 ft); Old Town
 *                                                               founded 1706; railroad 1880; incorporated 1891; Northeast Heights boom
 *                                                               late 1950s (Kirtland AFB, Sandia Labs); spring wind 20-30 mph late
 *                                                               March-April; 278 sunny days; Coors Blvd, Paseo del Norte, I-25, I-40
 *   https://www.albuquerquehomesonline.com/Albuquerque/ventana-ranch   Ventana Ranch begun 1996, 87114
 *   https://www.albuquerquehomesonline.com/Albuquerque/taylor-ranch    Taylor Ranch, 87120 (building from the 1970s — real-estate source)
 *   https://www.cabq.gov/office-of-neighborhood-coordination/documents/recognized-neighborhood-associations.pdf   Taylor Ranch NA
 *   https://www.cabq.gov/council/documents/precincts_and_associations_map.pdf   Volcano Cliffs
 *   https://en.wikipedia.org/wiki/Paradise_Hills,_New_Mexico    Paradise Hills: unincorporated, surrounded by the city
 *   https://en.wikipedia.org/wiki/North_Valley,_New_Mexico      North Valley: unincorporated
 *   https://en.wikipedia.org/wiki/Sandia_Heights,_New_Mexico    Sandia Heights: unincorporated, 87122
 *   https://en.wikipedia.org/wiki/Los_Ranchos_de_Albuquerque,_New_Mexico   separate village, incorporated 1958
 *   https://designworkshop.com/projects/high-desert.html        High Desert master-planned foothills community
 *   https://www.nps.gov/petr/index.htm                          Petroglyph National Monument HQ, Unser Blvd NW, 87120
 *   https://en.wikipedia.org/wiki/New_Mexico_State_Road_45      Cottonwood Mall (1996) on the Coors Bypass
 *   https://phzmapi.org/87114.json (also 87120, 87121, 87122, 87111)   2023 USDA zone 7b
 *   https://www.weather.gov/abq/prepawaremonsoonlightning       lightning is NM's top weather killer; strikes up to 10 miles from rain
 *   https://insideclimatenews.org/?p=94811                      swamp coolers popular in Albuquerque; homeowners switching to refrigerated air
 *   https://www.sec.gov/Archives/edgar/data/81023/000008102323000006/pnmforms-35152023.htm   PNM serves Albuquerque
 *   https://www.cabq.gov/planning/building-safety-division/permits   city electrical permits via Building Safety Division / ABQ-PLAN
 *   https://www.bernco.gov/planning/building-services/electrical-2/   unincorporated Bernalillo County: county Planning & Development
 *                                                               Services issues electrical permits (2020 NEC + 2020 NM electrical code)
 * ELEVATION is a range on purpose: the city's figure is 5,312 ft, the valley ~4,950 ft, the Sandia foothills 6,165-6,700+ ft.
 * LEFT OUT (unverifiable or general only): swamp-cooler share of homes, panel brands/two-prong wiring tied to Albuquerque
 * (kept as general guidance for homes of that age), Los Ranchos permit route, Alameda Blvd, foothills hardiness zone.
 * REVIEW: the Google review shown is matched live from the feed by the word "Albuquerque" (spReviews) — never hard-coded.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.php';

$area         = apArea('albuquerque');
$town         = $area['name'];
$pageTitle    = 'Albuquerque Electrician | Panels, EV & 24/7 | Goff Electric';
$pageDescription = 'Albuquerque electrician for Westside, Northeast Heights and valley homes and businesses: panels, EV chargers, 24/7 emergencies. Call Goff Electric any hour.';
$canonicalUrl = $siteUrl . '/service-areas/albuquerque/';
$currentPage  = 'areas';
$pageType     = 'city';
$citySlug     = 'albuquerque';
$heroFormTitle   = 'Free estimate in Albuquerque';
$heroFormTagline = 'Tell us the job and your side of town. Garrett will call you back.';

$heroImage   = 'gbp-09-at_work';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$ogImage     = '/assets/images/' . $heroImage . '-960.webp';
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Service Areas', 'url' => '/service-areas/'],
    ['name' => $town, 'url' => '/service-areas/albuquerque/'],
];
$schemaMarkup = apSchema(
    ['name' => $town, 'county' => 'Bernalillo', 'sameAs' => ['https://en.wikipedia.org/wiki/Albuquerque,_New_Mexico', 'https://www.cabq.gov/']],
    $canonicalUrl, $pageTitle, $pageDescription, $crumbs, $ogImage
);

/* Neighborhood eras — dates from the sources above; the electrical notes are general guidance for homes of that age */
$eras = [
    ['Old Town and the valley', 'Old Town founded 1706; railroad era from 1880', 'Adobe and older frame homes. Additions and decades of changes mean the wiring is rarely one age; an inspection before new circuits is worth it.'],
    ['Northeast Heights', 'Housing boom from the late 1950s', 'Mid-century houses can still have two-prong outlets with no ground and original panels with little spare capacity. Panel upgrades and grounded, GFCI-protected outlets are the usual fixes.'],
    ['Westside: Taylor Ranch, Paradise Hills, Ventana Ranch', 'Taylor Ranch built up from the 1970s; Ventana Ranch begun 1996', 'Younger homes and the closest Albuquerque neighborhoods to Goff Electric\'s Rio Rancho base. Work is mostly capacity: chargers, hot tubs, added cooling.'],
    ['Foothills: High Desert, Sandia Heights', 'Master-planned and unincorporated foothill areas', 'Higher, windier lots and long runs to detached garages, casitas and exterior lighting.'],
];

/* FAQs — visible text only (never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Who issues electrical permits in Albuquerque?',
        'a' => 'Inside Albuquerque city limits, electrical permits come from the City of Albuquerque Planning Department\'s Building Safety Division, applied for through ABQ-PLAN. Unincorporated areas such as the North Valley, Sandia Heights and Paradise Hills are permitted by Bernalillo County Planning &amp; Development Services instead. Los Ranchos de Albuquerque is its own village, so check with the village there.',
    ],
    [
        'q' => 'Can I switch from a swamp cooler to refrigerated air without a new panel?',
        'a' => 'Sometimes. An evaporative cooler draws far less power than a refrigerated air system, so the switch adds a large new load. A load calculation on your panel shows whether there is room for the new circuit or whether an ' . serviceLink('electrical-panel-upgrades-repair', 'electrical panel upgrade') . ' has to come first. Goff Electric does that calculation at the estimate visit.',
    ],
    [
        'q' => 'Do you answer emergency calls in Albuquerque at night?',
        'a' => 'Yes. Goff Electric\'s phone is answered around the clock, every day, including for Albuquerque. If you need an emergency electrician near me in Albuquerque for a burning smell, sparking or a breaker that will not reset, call ' . '<a href="tel:' . esc($phoneRaw) . '">' . esc($phoneText) . '</a>' . '. If you see smoke or flames, get out and call 911 first. See <a href="' . esc(serviceUrl('24-7-emergency-electrical-service') ?: '/contact/') . '">24/7 emergency electrical service</a>.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<?php echo apStyles(); ?>
<style>
/* ==========================================================================
   Albuquerque — page composition. Tokens only.
   ========================================================================== */
.hero--abq { --sp-hero-pos: 50% 35%; }

/* Local story: white band, prose + glance */
.abq-local { background: var(--color-surface); }
.abq-local .ap-glance { background: var(--color-paper); }

/* Eras: numbered timeline cards on a dark band */
.abq-eras .sp-head { max-width: 62ch; }
.abq-eras__list { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-md); counter-reset: abq-era; position: relative; }
.abq-eras__list::before { content: ""; position: absolute; top: 22px; left: var(--space-lg); right: var(--space-lg); height: 2px; background: linear-gradient(90deg, var(--color-accent), color-mix(in srgb, var(--color-accent) 20%, transparent)); }
.abq-eras__list li { counter-increment: abq-era; position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: calc(var(--space-2xl) + var(--space-sm)) var(--space-lg) var(--space-lg); background: color-mix(in srgb, var(--color-white) 6%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 12%, transparent); border-radius: var(--radius-lg); }
.abq-eras__list li::before { content: counter(abq-era, decimal-leading-zero); position: absolute; top: 0; left: var(--space-lg); display: grid; place-items: center; width: 44px; height: 44px; border-radius: var(--radius-full); background: var(--color-accent); color: var(--color-ink); font-family: var(--font-accent); font-weight: 700; }
.abq-eras__list h3 { color: var(--color-white); text-transform: uppercase; letter-spacing: .02em; font-size: var(--fs-h3); }
.abq-eras__list .abq-era__when { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-accent-bright); }
.abq-eras__list p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.abq-eras__note { margin: var(--space-lg) 0 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 66%, transparent); max-width: var(--measure); }
@media (max-width: 1100px) { .abq-eras__list { grid-template-columns: 1fr 1fr; } .abq-eras__list::before { display: none; } }
@media (max-width: 620px) { .abq-eras__list { grid-template-columns: 1fr; } }

/* Conditions: split with photo */
.abq-conditions { background: var(--color-paper); }
.abq-conditions .sp-photo { aspect-ratio: 4 / 5; max-width: 28rem; }
.abq-cond-list { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-md); }
.abq-cond-list li { display: grid; grid-template-columns: 44px minmax(0, 1fr); gap: var(--space-md); align-items: start; padding: var(--space-md) var(--space-lg); background: var(--color-surface); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.abq-cond-list svg { color: var(--color-accent-dark); }
.abq-cond-list b { display: block; font-family: var(--font-heading); text-transform: uppercase; letter-spacing: .02em; font-size: 1.15rem; color: var(--color-ink); }
.abq-cond-list span { font-size: var(--fs-small); color: var(--color-ink-2); }

/* Permits table + review */
.abq-permits { background: var(--color-surface); }
.abq-permits .sp-table td:nth-child(2) { background: color-mix(in srgb, var(--color-accent) 7%, var(--color-surface)); }
.abq-review { background: var(--color-paper-2); }
.abq-review .sp-reviews { grid-template-columns: minmax(0, 46rem); }
.abq-services { background: var(--color-paper); }
.abq-faq { background: var(--color-surface); }
.abq-nearby { background: var(--color-paper-2); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--area hero--abq" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Ring pendant lights and recessed downlights in a two-story commercial atrium', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Homes &amp; businesses · Bernalillo County</span>
        <h1 class="hero-title" id="hero-title">Electrician in <span class="text-accent">Albuquerque</span>, NM</h1>
        <p class="hero-answer">Goff Electric crosses the river from Rio Rancho for Albuquerque homes and businesses.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('building-2', 16); ?>Residential &amp; commercial</li>
          <li><?php echo icon('clock', 16); ?>Open 24 hours, 7 days</li>
          <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== LOCAL STORY ===================== -->
  <section class="section abq-local slant-top" aria-labelledby="local-title">
    <div class="container ap-local__grid">
      <div>
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Albuquerque, by neighborhood</span>
          <h2 id="local-title">What should Albuquerque homeowners know before hiring an electrician?</h2>
          <p class="answer-block">Albuquerque homeowners should know that the age of their neighborhood shapes the job. A Northeast Heights house from the late-1950s boom raises different electrical questions than a Ventana Ranch home from the 2000s, and the permit office depends on whether the address is inside city limits.</p>
        </div>
        <div class="ap-prose reveal-up">
          <p>Goff Electric is a licensed and insured New Mexico electrical contractor based in Rio Rancho, serving Albuquerque and the rest of Sandoval and Bernalillo counties. Albuquerque is the largest city on that list, with 564,559 residents at the 2020 census, and it has been building for more than three centuries: Old Town dates to 1706, the railroad arrived in 1880, and the Northeast Heights filled in after Kirtland Air Force Base and Sandia National Laboratories brought a wave of new families in the late 1950s.</p>
          <p>The Westside is where Albuquerque meets Goff Electric's home base. Taylor Ranch, Volcano Cliffs and Ventana Ranch sit along Coors Boulevard, Unser Boulevard and Paseo del Norte, between the Rio Grande and Petroglyph National Monument, a short drive from Rio Rancho. Paradise Hills, often counted as part of the Westside, is technically unincorporated county land surrounded by the city, which matters when the permit is pulled.</p>
          <p>Across the river the jobs change with the decade the house went up. Mid-century Heights homes are where ungrounded two-prong outlets and full original panels turn up. Westside homes are more often about adding load. In the foothills, High Desert and Sandia Heights homes sit higher, from about 6,165 feet up, with longer runs to garages, casitas and exterior lights. Goff Electric takes commercial work anywhere in the city too, from offices to shop buildings.</p>
          <p>Albuquerque's climate adds its own list. Spring wind of 20 to 30 miles an hour in late March and April, about 278 sunny days a year, and monsoon storms that the National Weather Service warns can throw lightning ten miles from the rain all show up at the panel, the meter and every exterior fixture.</p>
        </div>
      </div>
      <aside class="ap-glance reveal-right" aria-labelledby="glance-title">
        <h3 id="glance-title">Albuquerque at a glance</h3>
        <?php echo apFacts([
            ['County', 'Bernalillo'],
            ['Westside ZIPs', '87114 (Ventana Ranch, Paradise Hills) · 87120 (Taylor Ranch)'],
            ['Elevation', 'About 4,950 ft at the Rio Grande to 6,700+ ft in the Sandia foothills'],
            ['Plant zone', 'USDA 7b (2023 map) in 87114, 87120, 87111, 87122'],
            ['Electric utility', 'PNM'],
            ['Permits', 'City Building Safety Division (ABQ-PLAN); Bernalillo County for unincorporated areas'],
            ['Population', '564,559 (2020 census)'],
        ], 'Sources: U.S. Census 2020, City of Albuquerque, Bernalillo County, NWS Albuquerque, USDA 2023 hardiness map.'); ?>
      </aside>
    </div>
  </section>

  <!-- ===================== ERAS ===================== -->
  <section class="section texture-grain edge-wave-top abq-eras" aria-labelledby="eras-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Four Albuquerques</span>
        <h2 id="eras-title">How does the age of an Albuquerque neighborhood change the electrical work?</h2>
        <p class="answer-block">The age of an Albuquerque neighborhood changes what an electrician looks for first: older valley and Northeast Heights homes get checked for grounding and panel capacity, while newer Westside and foothill homes are usually about adding load for chargers, hot tubs and cooling.</p>
      </div>
      <ol class="abq-eras__list">
<?php foreach ($eras as $eraRow): ?>
        <li class="reveal-up">
          <span class="abq-era__when"><?php echo esc($eraRow[1]); ?></span>
          <h3><?php echo esc($eraRow[0]); ?></h3>
          <p><?php echo esc($eraRow[2]); ?></p>
        </li>
<?php endforeach; ?>
      </ol>
      <p class="abq-eras__note">Dates come from the City of Albuquerque and public records. The electrical notes describe what is common in houses of each age, not a finding about any particular home. An inspection tells you what your house actually has.</p>
    </div>
  </section>

  <!-- ===================== CONDITIONS ===================== -->
  <section class="section abq-conditions" aria-labelledby="conditions-title">
    <div class="container sp-split">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">High-desert loads</span>
          <h2 id="conditions-title">Which Albuquerque conditions put the most strain on a home's wiring?</h2>
          <p class="answer-block">The Albuquerque conditions that put the most strain on a home's wiring are summer cooling, monsoon lightning and spring wind. Cooling is the one that has changed most, as more Albuquerque homeowners trade evaporative coolers for refrigerated air that needs a much bigger circuit.</p>
        </div>
        <ul class="abq-cond-list">
          <li class="reveal-up"><?php echo icon('sun', 28); ?><div><b>Swamp cooler to refrigerated air</b><span>Evaporative coolers have long been a popular way to cool Albuquerque homes, and more owners are switching to refrigerated air. The new system needs its own 240-volt circuit and room in the panel.</span></div></li>
          <li class="reveal-up"><?php echo icon('cloud-lightning', 28); ?><div><b>Lightning miles from the storm</b><span>The National Weather Service warns that lightning can strike ten miles from the rain. Whole-home surge protection at the panel guards appliances, HVAC controls and electronics.</span></div></li>
          <li class="reveal-up"><?php echo icon('wind', 28); ?><div><b>Spring wind</b><span>Late March and April bring sustained wind. Weatherproof covers, sealed exterior boxes and secure fixture mounts keep dust and water out of exterior circuits.</span></div></li>
        </ul>
      </div>
      <figure class="sp-photo sp-photo--offset reveal-right">
        <?php echo responsivePicture('gbp-08-at_work', 'Open panelboard with breakers and color-coded conductors landed and dressed', '(max-width: 900px) 90vw, 440px'); ?>
        <figcaption>A panel with every conductor landed and labeled, the starting point for any new load</figcaption>
      </figure>
    </div>
  </section>

  <!-- ===================== SERVICES ===================== -->
  <section class="section abq-services ap-services edge-curve-top" aria-labelledby="services-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="services-title">Which Goff Electric services are available in <span class="text-accent">Albuquerque</span>?</h2>
        <p class="answer-block">Every Goff Electric service is available in Albuquerque, for homes and commercial buildings alike. The three below match the city best: panel upgrades for mid-century and cooling-heavy homes, commercial electrical work for offices and shops, and Level 2 EV charger installation.</p>
      </div>
      <?php echo apServices(
          ['electrical-panel-upgrades-repair', 'commercial-electrical', 'ev-charger-installation'],
          [
              'electrical-panel-upgrades-repair' => 'Room and capacity for refrigerated air, a hot tub or a charger, plus replacement of tired original panels.',
              'commercial-electrical'            => 'Panels, conduit, feeders and lighting for Albuquerque offices, storefronts and shop buildings.',
              'ev-charger-installation'          => 'Level 2 circuits for Albuquerque garages and driveways, sized by a load calculation first.',
          ],
          $town
      ); ?>
    </div>
  </section>

  <!-- ===================== PERMITS ===================== -->
  <section class="section abq-permits" aria-labelledby="permits-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">City or county?</span>
        <h2 id="permits-title">Does an Albuquerque address get its electrical permit from the city or the county?</h2>
        <p class="answer-block">An Albuquerque address gets its electrical permit from the City of Albuquerque only when it is inside city limits. Several neighborhoods with Albuquerque mailing addresses, including the North Valley, Sandia Heights and Paradise Hills, are unincorporated, and Bernalillo County issues their permits.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <caption>Per the City of Albuquerque Building Safety Division and Bernalillo County Planning &amp; Development Services. Confirm your parcel before work starts.</caption>
          <thead>
            <tr><th scope="col">Where the property is</th><th scope="col">Inside Albuquerque city limits</th><th scope="col">Unincorporated Bernalillo County</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Examples</th><td>Taylor Ranch, Ventana Ranch, Volcano Cliffs, Nob Hill, Northeast Heights, Old Town</td><td>North Valley, Sandia Heights, Paradise Hills</td></tr>
            <tr><th scope="row">Who issues the permit</th><td>Planning Department, Building Safety Division</td><td>County Planning &amp; Development Services</td></tr>
            <tr><th scope="row">How it is applied for</th><td>ABQ-PLAN online portal</td><td>County Accela portal</td></tr>
            <tr><th scope="row">What it covers</th><td>New circuits, panel replacements, service changes</td><td>The same, under the 2020 NEC and New Mexico electrical code</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

<?php $abqProof = spReviews('Albuquerque', 2); if ($abqProof !== ''): ?>
  <!-- ===================== PROOF: Google reviews that mention Albuquerque ===================== -->
  <section class="section abq-review slant-top" aria-labelledby="proof-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do Albuquerque customers say about Goff Electric?</h2>
        <p class="answer-block">Albuquerque customers describe Goff Electric as honest, quick to respond and reliable, and one said Garrett will be their electrician for as long as they live in Albuquerque. The review below mentions Albuquerque by name and is quoted word for word from Google.</p>
      </div>
      <?php echo $abqProof; ?>
      <div class="sp-proof-foot">
        <a class="btn btn-secondary" href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read all <?php echo (int) $gbpReviewCount; ?> Google reviews <?php echo icon('external-link', 16); ?></a>
      </div>
    </div>
  </section>
<?php endif; ?>

  <!-- ===================== WHY GOFF ELECTRIC ===================== -->
  <section class="section texture-grain edge-parallelogram-top abq-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b><?php echo esc(number_format((float) $gbpRating, 1)); ?><small> / 5</small></b>
        <span>Google rating · <a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo (int) $gbpReviewCount; ?> reviews</a></span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why do Albuquerque homeowners and businesses choose a Rio Rancho electrician?</h2>
        <p class="answer-block">Albuquerque homeowners and businesses choose Goff Electric because the owner, Garrett Goff, gives the estimate himself, explains the options, and keeps the phone line open around the clock. Goff Electric is licensed and insured in New Mexico and handles residential and commercial work.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('clipboard-check', 22); ?><div><b>Options, not one price</b><span>Where a job can be done more than one way, you hear the choices and what each means for the house and the budget.</span></div></li>
          <li><?php echo icon('building-2', 22); ?><div><b>Homes and commercial buildings</b><span>From a Heights kitchen to an electrical room with new panels and conduit, one contractor and one phone number.</span></div></li>
          <li><?php echo icon('clock', 22); ?><div><b>One phone line, day and night</b><span>Power trouble at night in Albuquerque reaches the same number as a daytime estimate request.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq abq-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do Albuquerque customers ask before booking an electrician?</h2>
        <p class="answer-block">Albuquerque customers usually ask about permits, about switching from a swamp cooler to refrigerated air, and about night-time emergencies. Here are straight answers; for anything else, call Goff Electric at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</p>
      </div>
      <div class="faq-grid">
<?php foreach ($faqs as $faqIdx => $faqItem): ?>
        <details class="faq"<?php echo $faqIdx === 0 ? ' open' : ''; ?>>
          <summary><?php echo esc($faqItem['q']); ?></summary>
          <p><?php echo $faqItem['a']; ?></p>
        </details>
<?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===================== NEARBY ===================== -->
  <section class="section section--tight abq-nearby" aria-labelledby="nearby-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Also served</span>
        <h2 id="nearby-title">Which other towns around Albuquerque does Goff Electric serve?</h2>
        <p class="answer-block">Around Albuquerque, Goff Electric also serves Rio Rancho, its home base on the mesa to the northwest, Corrales and Bernalillo up the Rio Grande valley, Placitas below the north end of the Sandias, and Tijeras east through the canyon on I-40.</p>
      </div>
      <?php echo apNearby('albuquerque', ['rio-rancho' => 'Home base, northwest', 'corrales' => 'Up the river, west bank', 'bernalillo' => 'North on I-25', 'placitas' => 'North end of the Sandias', 'tijeras' => 'East on I-40']); ?>
      <p class="last-updated">Last Updated: <?php echo date('F Y'); ?></p>
    </div>
  </section>

</article>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('building-2', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Albuquerque, day or night</span>
      <h2 id="final-title">Get a free estimate in Albuquerque</h2>
      <p>Tell Goff Electric the job and which side of town you are on. You get the scope and the price before any work starts, at no cost.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request my estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
