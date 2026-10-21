<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/tijeras/ — Goff Electric (Phase 6, 2026-10-21).
 * Angle: the canyon village and gateway to the East Mountains. The coldest zone on the list (7a), canyon wind, snow and ice,
 * New Mexico's largest wildland-urban interface, wells and septic, and outage planning. Village vs unincorporated permit split.
 *
 * SOURCES (researched 2026-10-21):
 *   https://en.wikipedia.org/wiki/Tijeras,_New_Mexico            ZIP 87059; village elevation 6,382 ft; 2020 census 465; at the junction
 *                                                               of Tijeras and Cedro canyons; I-40 Exit 175, old Route 66 (NM 333), NM 337;
 *                                                               Route 66 "musical road" (2014)
 *   https://en.wikipedia.org/wiki/Carnuel,_New_Mexico            5,807 ft (mouth of the canyon)
 *   https://en.wikipedia.org/wiki/Cedar_Crest,_New_Mexico        6,779 ft; borders the village to the north
 *   https://en.wikipedia.org/wiki/Sandia_Park,_New_Mexico        ~7,071 ft
 *   https://en.wikipedia.org/wiki/Chilili,_New_Mexico ; https://en.wikipedia.org/wiki/Zuzax,_New_Mexico   nearby unincorporated places
 *   https://www.fs.usda.gov/r03/cibola/recreation/sandia-rd-manzanita-mountains   Manzanitas ~6,000 to 7,767 ft (Cedro Peak)
 *   https://phzmapi.org/87059.json                              2023 USDA zone 7a
 *   https://en.wikipedia.org/wiki/Turquoise_Trail               NM 14 / Turquoise Trail starts at NM 333 in Tijeras
 *   https://fs.usda.gov/r03/cibola/offices/sandia-ranger-district   Sandia Ranger District office, 11776 Hwy 337, in Tijeras
 *   https://www.visitalbuquerque.org/listing/tijeras-pueblo-archaeological-site/4624/   Tijeras Pueblo, 1300s-1400s, National Register 2005
 *   https://www.tijerasnm.gov/our-heritage/                     Santo Niño Church (~1912, National Register, village-owned); ~10 buildings
 *                                                               older than 1945; incorporated 1973
 *   https://www.weather.gov/media/abq/Briefings/Annual2020_Top5.pdf   east winds funnel through Tijeras Canyon; 89 mph gust at the Sandia
 *                                                               Tram in the strongest 2020 event
 *   https://www.kob.com/new-mexico/snow-winds-continue-their-trek-through-new-mexico/   more snow and icy roads in the East Mountains
 *   https://cswcd1.specialdistrict.org/bernalillo-county-cwpp   East Mountains = NM's largest WUI community, ~25,000 residents
 *   https://www.kob.com/news/top-news/pnm-to-implement-public-safety-power-shutoff-in-east-mountains/   PNM planned its first-ever
 *                                                               wildfire power shutoff in the East Mountains (Mar 2025, ~10,000 customers),
 *                                                               then called it off
 *   https://ngwa.confex.com/ngwa/2016hwqsw/webprogram/Paper10759.html   ~53% of East Mountain residents rely on domestic wells
 *   https://pubs.usgs.gov/of/1995/0385/report.pdf               most homes in unincorporated East Mountains on septic
 *   https://aca-prod.accela.com/bernco/Default.aspx             unincorporated Bernalillo County issues electrical permits (Accela)
 * ELEVATION is a range on purpose: village 6,382 ft; the area runs from ~5,800 ft at Carnuel to 7,000+ ft in Sandia Park.
 * LEFT OUT (unverifiable): who issues electrical permits INSIDE the village (do not name an agency — confirm with the village,
 * 505-281-1220), cement plant / A. Montoya Elementary inside limits, manufactured-home share, propane, piñon-juniper near lines.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.php';

$area         = apArea('tijeras');
$town         = $area['name'];
$pageTitle    = 'Electrician in Tijeras, NM | East Mountains 24/7 | Goff Electric';
$pageDescription = 'Tijeras and East Mountains electrician: storm and outage calls any hour, panel upgrades, surge protection and outdoor circuits built for canyon wind and snow.';
$canonicalUrl = $siteUrl . '/service-areas/tijeras/';
$currentPage  = 'areas';
$pageType     = 'city';
$citySlug     = 'tijeras';
$heroFormTitle   = 'Free estimate in Tijeras';
$heroFormTagline = 'Village or East Mountains, tell us the job and the road.';

$heroImage   = 'gbp-08-at_work';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$ogImage     = '/assets/images/' . $heroImage . '-960.webp';
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Service Areas', 'url' => '/service-areas/'],
    ['name' => $town, 'url' => '/service-areas/tijeras/'],
];
$schemaMarkup = apSchema(
    ['name' => $town, 'county' => 'Bernalillo', 'sameAs' => ['https://en.wikipedia.org/wiki/Tijeras,_New_Mexico', 'https://www.tijerasnm.gov/']],
    $canonicalUrl, $pageTitle, $pageDescription, $crumbs, $ogImage
);

/* Elevation ladder — village plus nearby East Mountain communities (Wikipedia figures) */
$ladder = [
    ['Sandia Park', 7071],
    ['Chilili', 6841],
    ['Cedar Crest', 6779],
    ['Zuzax', 6585],
    ['Village of Tijeras', 6382],
    ['Carnuel', 5807],
];

/* FAQs — visible text only (never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'What should I do if PNM shuts off power in the East Mountains for fire danger?',
        'a' => 'Plan ahead. PNM scheduled its first-ever wildfire safety shutoff in the East Mountains in March 2025, for about 10,000 customers, before calling it off. Know how you will keep a well pump, medical equipment or a freezer running, and never back-feed a generator through a dryer or range outlet. If the power comes back and part of the house does not, call Goff Electric at ' . esc($phoneText) . '.',
    ],
    [
        'q' => 'Who issues electrical permits in Tijeras and the East Mountains?',
        'a' => 'In the unincorporated East Mountains, including Cedar Crest, Sandia Park and Chilili, Bernalillo County issues electrical permits through its online Accela portal. Inside the Village of Tijeras itself, confirm the permit route with the village at (505) 281-1220 before work starts. Goff Electric can tell you what your project needs at the estimate.',
    ],
    [
        'q' => 'Does Goff Electric come up to Tijeras for emergencies?',
        'a' => 'Yes. Goff Electric\'s phone is answered around the clock, every day, for Tijeras and the East Mountains too. For a burning smell, sparking or a breaker that will not reset, call. For a line down in the road or across your property, stay clear and call PNM first. See <a href="' . esc(serviceUrl('24-7-emergency-electrical-service') ?: '/contact/') . '">24/7 emergency electrical service</a>.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<?php echo apStyles(); ?>
<style>
/* ==========================================================================
   Tijeras — page composition. Tokens only.
   ========================================================================== */
.hero--tijeras { --sp-hero-pos: 50% 40%; }

/* Local story: surface band */
.tij-local { background: var(--color-surface); }

/* Elevation ladder: horizontal bars */
.tij-ladder { background: var(--color-paper); }
.tij-ladder__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.4fr); gap: var(--space-xl) var(--space-3xl); align-items: center; }
.tij-bars { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-xs); }
.tij-bars li { display: grid; grid-template-columns: minmax(0, 11rem) minmax(0, 1fr) auto; gap: var(--space-sm); align-items: center; font-size: var(--fs-small); color: var(--color-ink-2); }
.tij-bars b { font-family: var(--font-heading); text-transform: uppercase; letter-spacing: .02em; font-size: 1.05rem; color: var(--color-ink); }
.tij-bars .tij-bar { height: 14px; border-radius: var(--radius-full); background: var(--color-line); overflow: hidden; }
.tij-bars .tij-bar span { display: block; height: 100%; width: var(--w); border-radius: inherit; background: linear-gradient(90deg, var(--color-secondary), var(--color-primary)); }
.tij-bars .is-village .tij-bar span { background: linear-gradient(90deg, var(--color-accent-dark), var(--color-accent)); }
.tij-bars .is-village b { color: var(--color-accent-dark); }
.tij-bars small { font-family: var(--font-accent); letter-spacing: .06em; font-size: .9rem; color: var(--color-ink); }
.tij-ladder__note { margin: var(--space-sm) 0 0; font-size: var(--font-size-xs); color: var(--color-muted); }
@media (max-width: 960px) { .tij-ladder__grid { grid-template-columns: 1fr; } }
@media (max-width: 520px) { .tij-bars li { grid-template-columns: 1fr auto; } .tij-bars .tij-bar { grid-column: 1 / -1; grid-row: 2; } }

/* Mountain conditions: dark band, three columns with top rules */
.tij-cond__grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-xl); }
.tij-cond__grid > div { display: grid; gap: var(--space-xs); align-content: start; padding-top: var(--space-lg); border-top: 3px solid var(--color-accent); }
.tij-cond__grid svg { color: var(--color-accent); }
.tij-cond__grid h3 { color: var(--color-white); text-transform: uppercase; letter-spacing: .02em; font-size: var(--fs-h3); }
.tij-cond__grid p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
@media (max-width: 900px) { .tij-cond__grid { grid-template-columns: 1fr; } }

/* Outage checklist */
.tij-outage { background: var(--color-paper-2); }
.tij-outage .sp-photo { aspect-ratio: 3 / 4; max-width: 24rem; }
.tij-services { background: var(--color-surface); }
.tij-faq { background: var(--color-paper); }
.tij-nearby { background: var(--color-surface); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--area hero--tijeras" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Open panelboard with breakers and color-coded conductors landed and dressed', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Tijeras Canyon · East Mountains</span>
        <h1 class="hero-title" id="hero-title">Electrician in <span class="text-accent">Tijeras</span>, NM</h1>
        <p class="hero-answer">Goff Electric serves Tijeras and the East Mountains, storm and fire season included.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('snowflake', 16); ?>Mountain-weather work</li>
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
  <section class="section tij-local slant-top" aria-labelledby="local-title">
    <div class="container ap-local__grid">
      <div>
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Tijeras, up close</span>
          <h2 id="local-title">How is electrical work in Tijeras different from work in Albuquerque?</h2>
          <p class="answer-block">Electrical work in Tijeras is different because it is mountain work. At about 6,400 feet in a wind-funneling canyon, Tijeras gets more snow, harder freezes and stronger gusts than Albuquerque, and it sits at the edge of New Mexico's largest wildland-urban interface, where fire-season outages are a real possibility.</p>
        </div>
        <div class="ap-prose reveal-up">
          <p>Goff Electric is a licensed and insured New Mexico electrical contractor based in Rio Rancho, serving the Village of Tijeras and the surrounding East Mountains along with the rest of Bernalillo and Sandoval counties. Tijeras is small, 465 residents at the 2020 census, and incorporated in 1973, but it sits where everything in the East Mountains meets: Tijeras and Cedro canyons, I-40 at Exit 175, old Route 66, NM 337 heading south and NM 14, the Turquoise Trail, heading north.</p>
          <p>The village is also old ground. Tijeras Pueblo, occupied in the 1300s and 1400s, sits behind the Forest Service's Sandia Ranger District office on NM 337, and the village-owned Santo Niño Church dates to about 1912. A handful of buildings in the village predate 1945, alongside homes of every age since.</p>
          <p>The mountains drive the electrical work. The 2023 USDA map puts ZIP 87059 in zone 7a, half a zone colder than Albuquerque and Rio Rancho. The National Weather Service tracks east winds that funnel through Tijeras Canyon; in the strongest 2020 event a gust hit 89 miles an hour at the Sandia Tram. Snow and icy roads come more often than in the city. About half of East Mountain residents rely on private wells and most homes in the unincorporated areas are on septic, so a well pump that keeps running through a cold snap matters.</p>
          <p>Then there is fire. The East Mountains are New Mexico's largest wildland-urban interface community, about 25,000 people, and in March 2025 PNM scheduled its first-ever wildfire safety shutoff here before calling it off. If you are looking for an electrician near me in Tijeras before the next red-flag season, or after a storm, Goff Electric answers the phone around the clock.</p>
        </div>
      </div>
      <aside class="ap-glance reveal-right" aria-labelledby="glance-title">
        <h3 id="glance-title">Tijeras at a glance</h3>
        <?php echo apFacts([
            ['County', 'Bernalillo'],
            ['ZIP code', '87059'],
            ['Elevation', 'Village about 6,380 ft; the East Mountains run from about 5,800 ft to above 7,000 ft'],
            ['Plant zone', 'USDA 7a (2023 map), colder than Albuquerque\'s 7b'],
            ['Electric utility', 'PNM'],
            ['Permits', 'Bernalillo County in the unincorporated East Mountains; confirm with the village inside Tijeras'],
            ['Population', '465 (2020 census)'],
        ], 'Sources: Village of Tijeras, U.S. Census 2020, NWS Albuquerque, Bernalillo County, USDA 2023 hardiness map.'); ?>
      </aside>
    </div>
  </section>

  <!-- ===================== ELEVATION LADDER ===================== -->
  <section class="section tij-ladder" aria-labelledby="ladder-title">
    <div class="container tij-ladder__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow-label">Up the canyon</span>
        <h2 id="ladder-title">How high are Tijeras and the East Mountain communities around it?</h2>
        <p class="answer-block">Tijeras and the East Mountain communities around it sit between about 5,800 and 7,100 feet. The village itself is at about 6,380 feet, Carnuel at the canyon mouth is lowest, and Sandia Park, up NM 14, is highest of the nearby places.</p>
      </div>
      <div class="reveal-right">
        <ul class="tij-bars" aria-label="Elevation of Tijeras and nearby East Mountain communities, in feet">
<?php $ladderMax = 7200; foreach ($ladder as $ladderRow): ?>
          <li<?php echo $ladderRow[0] === 'Village of Tijeras' ? ' class="is-village"' : ''; ?>><b><?php echo esc($ladderRow[0]); ?></b><span class="tij-bar"><span style="--w: <?php echo round(($ladderRow[1] - 5000) / ($ladderMax - 5000) * 100); ?>%"></span></span><small><?php echo number_format($ladderRow[1]); ?> ft</small></li>
<?php endforeach; ?>
        </ul>
        <p class="tij-ladder__note">Single-point elevations from Wikipedia/GNIS; each community spans a range. Bars start at 5,000 ft.</p>
      </div>
    </div>
  </section>

  <!-- ===================== MOUNTAIN CONDITIONS ===================== -->
  <section class="section texture-grain edge-wave-top tij-cond" aria-labelledby="cond-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Wind, snow, fire</span>
        <h2 id="cond-title">What does East Mountain weather do to a home's electrical system?</h2>
        <p class="answer-block">East Mountain weather works on a home's electrical system from the outside in: canyon wind strains overhead service drops and masts, snow and ice load exterior equipment and keep well houses cold, and fire season can bring utility shutoffs that leave a house dark for hours.</p>
      </div>
      <div class="tij-cond__grid">
        <div class="reveal-up"><?php echo icon('wind', 30); ?><h3>Canyon wind</h3><p>East winds funnel through Tijeras Canyon. A service mast, meter base or exterior fixture that is loose in a breeze will not survive a gust, so mounting and strapping get checked.</p></div>
        <div class="reveal-up reveal-delay-1"><?php echo icon('snowflake', 30); ?><h3>Snow and hard freezes</h3><p>Zone 7a winters mean covers that seal, outdoor outlets with ground-fault protection, and a dependable circuit to the well house so the pump keeps running.</p></div>
        <div class="reveal-up reveal-delay-2"><?php echo icon('flame', 30); ?><h3>Fire-season outages</h3><p>In New Mexico's largest wildland-urban interface, a planned shutoff is possible. Surge protection at the panel helps when the power comes back on.</p></div>
      </div>
    </div>
  </section>

  <!-- ===================== OUTAGE CHECKLIST ===================== -->
  <section class="section tij-outage" aria-labelledby="outage-title">
    <div class="container sp-split sp-split--flip">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Before the lights go out</span>
          <h2 id="outage-title">How can a Tijeras home get ready for a long power outage?</h2>
          <p class="answer-block">A Tijeras home gets ready for a long power outage by knowing which circuits matter most, usually the well pump, the furnace controls, the refrigerator and any medical equipment, and by making sure the panel and service can be safely shut off and brought back.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Label the panel.</b> In the dark, you should be able to find the well pump and furnace breakers without guessing.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Never back-feed.</b> A generator plugged into a dryer or range outlet can energize the utility line and hurt a lineworker. Use a properly installed transfer method.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Protect against the restart.</b> Whole-home surge protection at the panel guards electronics and appliances when power returns.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Check what did not come back.</b> If the street has power and part of your house does not, that is a breaker, connection or panel problem, and an electrician call.</span></li>
        </ul>
      </div>
      <figure class="sp-photo reveal-left">
        <?php echo responsivePicture('gbp-06-at_work', 'New electrical equipment and conduit mounted beside a home electric meter on a stucco wall', '(max-width: 900px) 90vw, 380px'); ?>
        <figcaption>Exterior equipment mounted and strapped beside the meter</figcaption>
      </figure>
    </div>
  </section>

  <!-- ===================== SERVICES ===================== -->
  <section class="section tij-services ap-services edge-curve-top" aria-labelledby="services-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="services-title">What electrical services does Goff Electric offer in <span class="text-accent">Tijeras</span>?</h2>
        <p class="answer-block">Goff Electric offers all of its electrical services in Tijeras and the East Mountains. The three that matter most up the canyon are round-the-clock emergency calls for storm and outage trouble, panel upgrades and repair for older or overloaded panels, and outdoor outlets and switches built for snow and wind.</p>
      </div>
      <?php echo apServices(
          ['24-7-emergency-electrical-service', 'electrical-panel-upgrades-repair', 'outlets-switches'],
          [
              '24-7-emergency-electrical-service' => 'Storm damage, partial outages and dead circuits in Tijeras and the East Mountains, any hour.',
              'electrical-panel-upgrades-repair'  => 'A safer, better-labeled panel with surge protection, ready for outages and restarts.',
              'outlets-switches'                  => 'GFCI-protected outdoor outlets with covers that seal against East Mountain snow and wind.',
          ],
          $town
      ); ?>
    </div>
  </section>

  <!-- ===================== WHY GOFF ELECTRIC ===================== -->
  <section class="section texture-grain edge-parallelogram-top tij-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b>24/7</b>
        <span>Phone answered day and night</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why call Goff Electric for a job in Tijeras?</h2>
        <p class="answer-block">Call Goff Electric for a job in Tijeras because the phone is answered at any hour, owner Garrett Goff finds the actual fault instead of resetting a breaker and leaving, and every estimate is free. Goff Electric is licensed and insured in New Mexico.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('search', 22); ?><div><b>Finds the real problem</b><span>A Google reviewer's cut service line was traced after 7 p.m. and turned out to be on the utility's side, which Garrett reported to the power company.</span></div></li>
          <li><?php echo icon('shield-check', 22); ?><div><b>Licensed and insured</b><span>A New Mexico licensed, insured electrical contractor, for homes and commercial buildings.</span></div></li>
          <li><?php echo icon('star', 22); ?><div><b><?php echo esc(number_format((float) $gbpRating, 1)); ?> stars from <?php echo (int) $gbpReviewCount; ?> Google reviews</b><span><a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read them on Google</a>.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq tij-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do Tijeras and East Mountain residents ask about electrical work?</h2>
        <p class="answer-block">Tijeras and East Mountain residents usually ask about fire-season power shutoffs, who issues the permit, and whether an electrician will come up the canyon in an emergency. Here are straight answers; for anything else, call Goff Electric at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</p>
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
  <section class="section section--tight tij-nearby" aria-labelledby="nearby-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Also served</span>
        <h2 id="nearby-title">Which other towns does Goff Electric serve from Tijeras to Rio Rancho?</h2>
        <p class="answer-block">Between Tijeras and its Rio Rancho base, Goff Electric serves Albuquerque west down the canyon on I-40, Corrales and Bernalillo along the Rio Grande, and Placitas on the north side of the Sandia Mountains.</p>
      </div>
      <?php echo apNearby('tijeras', ['rio-rancho' => 'Home base, northwest', 'albuquerque' => 'West on I-40', 'corrales' => 'West bank of the Rio Grande', 'bernalillo' => 'North on I-25', 'placitas' => 'North side of the Sandias']); ?>
      <p class="last-updated">Last Updated: <?php echo date('F Y'); ?></p>
    </div>
  </section>

</article>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('snowflake', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Tijeras, day or night</span>
      <h2 id="final-title">Get a free estimate in Tijeras</h2>
      <p>Tell Goff Electric the job and your road, in the village or anywhere in the East Mountains. You get the scope and the price before any work starts, and the phone is answered day and night.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request my estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
