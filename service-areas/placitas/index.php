<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/placitas/ — Goff Electric (Phase 6, 2026-10-21).
 * Angle: unincorporated foothill community at the north end of the Sandias. Rock instead of sand, wells with uneven yields,
 * subdivision-by-subdivision differences (underground utilities, community water vs private wells), wildfire + lightning.
 *
 * SOURCES (researched 2026-10-21):
 *   https://en.wikipedia.org/wiki/Placitas,_Sandoval_County,_New_Mexico   ZIP 87043; CDP elevation 5,955 ft; 2020 census 5,041;
 *                                                               Las Placitas Presbyterian Church founded 1894
 *   https://en-us.topographic-map.com/map-2wd2rr/Placitas/      area 5,607-7,251 ft (average 6,115 ft)
 *   https://media.cocorahs.org/wys/2015-2016/NM/NM-SN-45-wys-2015-2016.html   station ~6,093 ft; 11.5 in of snow, Dec 2015
 *   https://phzmapi.org/87043.json                              2023 USDA zone 7b at the ZIP center point
 *   https://albuquerquehomesonline.com/subdivision/AnasaziMeadows   Anasazi Meadows: underground utilities
 *   https://albuquerquehomesonline.com/DiamonTailPhaseIi-Subdivision   Diamond Tail: gated, ~900 acres, underground utilities
 *   https://www.acrevalue.com/land-for-sale-near-me/0-1st-mesa-court-placitas-nm-87043/b1bd5ac3-8669-4468-a7f8-22c413792904/
 *                                                               Sundance Mesa: underground utilities, septic, borders BLM land
 *   https://albuquerquehomesonline.com/PlacitasHomesteads-Subdivision   Placitas Homesteads
 *   https://albuquerquehomesonline.com/subdivision/TheOverlook  The Overlook: private wells
 *   https://albuquerquehomesonline.com/LasHuertasAcres-Subdivision   Las Huertas Acres
 *   https://www.fs.usda.gov/r03/cibola/recreation/sandia-man-cave-trailhead-trail-72 ; https://en.wikipedia.org/wiki/Sandia_Cave
 *                                                               NM 165, Las Huertas Canyon, Sandia Man Cave (National Historic Landmark 1961)
 *   https://cabq.gov/parksandrecreation/open-space/lands/sandoval-county-open-space   Placitas Open Space, 560 acres, City of Albuquerque
 *   https://www.newmexicomagazine.org/blog/post/best-things-to-do-in-placitas-new-mexico/   ~150 free-roaming horses on BLM land
 *   https://www.blm.gov/announcement/public-land-order-no-7940-placitas-area-withdrawal-new-mexico   PLO 7940, 4,212.98 acres
 *   https://nmlegis.gov/handouts/LGC%20100324%20Item%201%20San%20Antonio%20de%20las%20Huertas.pdf   land grant 1767, 21 families
 *   https://groundworksnm.org/nonprofit-directory/nonprofit/4533   Placitas Community Library, 453 NM 165, building since 2009
 *   https://profession.americangeosciences.org/collections/publications/environmental-awareness-series/geologic-maps/groundwater-new-mexico
 *                                                               granite, gneiss, limestone, sandstone, Placitas fault zone; domestic wells
 *                                                               common, yields vary, some have gone dry
 *   https://www.sandovalcountynm.gov/departments/planning-zoning/ ; https://www.rld.nm.gov/uploads/FileLinks/49cda9a3a6f04aa9a169e9301ea1ebfc/2020_10_20_Homeowner_Respons_Permit_Form.pdf
 *                                                               unincorporated Sandoval County: county zoning review, then CID permits
 *                                                               (separate electrical permit)
 *   https://sandovalsignpost.com/?p=1695752                     county emergency manager: "Placitas Corridor" high wildfire risk
 *   https://www.kob.com/new-mexico/crews-respond-to-lightning-caused-fire-in-sandia-mountains/   lightning-caused fire just south of Placitas
 *   https://www.positiveenergysolar.com/blog/new-mexico-utility-provider-pnm-not-allowing-som/   PNM Placitas feeder (secondary source)
 * ELEVATION is a range on purpose: CDP 5,955 ft vs area 5,607-7,251 ft. Hardiness zone stated for the ZIP center only.
 * LEFT OUT (unverifiable): Placitas West, Puesta del Sol, Cedar Creek, Ranchos de Placitas, "Crest of Montezuma", any co-op service
 * area, propane, "colder than the valley". Utility stated as PNM with "confirm on your bill".
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.php';

$area         = apArea('placitas');
$town         = $area['name'];
$pageTitle    = 'Electrician in Placitas, NM | Foothill Homes | Goff Electric';
$pageDescription = 'Placitas electrician for foothill homes from Diamond Tail to Las Huertas: underground runs in rocky ground, well circuits, EV chargers and 24/7 calls.';
$canonicalUrl = $siteUrl . '/service-areas/placitas/';
$currentPage  = 'areas';
$pageType     = 'city';
$citySlug     = 'placitas';
$heroFormTitle   = 'Free estimate in Placitas';
$heroFormTagline = 'Tell us the job and your subdivision or road. Garrett will call you back.';

$heroImage   = 'gbp-11-at_work';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$ogImage     = '/assets/images/' . $heroImage . '-960.webp';
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Service Areas', 'url' => '/service-areas/'],
    ['name' => $town, 'url' => '/service-areas/placitas/'],
];
$schemaMarkup = apSchema(
    ['name' => $town, 'county' => 'Sandoval', 'type' => 'Place', 'sameAs' => ['https://en.wikipedia.org/wiki/Placitas,_Sandoval_County,_New_Mexico']],
    $canonicalUrl, $pageTitle, $pageDescription, $crumbs, $ogImage
);

/* Subdivisions — what public listings record, and what that means for electrical work */
$subdivisions = [
    ['Diamond Tail', 'Gated, about 900 acres, underground utilities', 'Buried service lines: a fault is located and dug to, not spotted on a pole.'],
    ['Sundance Mesa', 'Underground utilities, septic, next to BLM land', 'Long buried runs and exterior equipment that faces open land and wind.'],
    ['Anasazi Meadows', 'Underground utilities', 'Additions and outbuildings tie into a buried service, so routes get planned around it.'],
    ['The Overlook', 'Private wells', 'The well pump is part of the house\'s electrical load and needs a reliable circuit.'],
    ['Placitas Homesteads · Las Huertas Acres', 'Larger rural parcels', 'Distance from the meter to a shop or well sets the wire size and trench.'],
];

/* FAQs — visible text only (never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Who issues electrical permits in Placitas?',
        'a' => 'Placitas is unincorporated Sandoval County, so after the county reviews zoning, the electrical permit comes from the state Construction Industries Division, which issues electrical permits separately from building permits. Goff Electric can tell you at the estimate whether your project needs one.',
    ],
    [
        'q' => 'Why does trenching cost more in some parts of Placitas?',
        'a' => 'Because the ground is rock in places. The Placitas area sits on granite, gneiss, limestone and sandstone cut by the Placitas fault zone, so a trench that is easy in valley sand can mean breaking rock in the foothills. Goff Electric looks at the route at the estimate visit before pricing it.',
    ],
    [
        'q' => 'Is my Placitas home on PNM?',
        'a' => 'PNM serves Placitas, but some rural parts of Sandoval County are on an electric cooperative instead, so check the utility name on your bill. It matters for outages: if the lines are down or your whole street is dark, call your utility first, and call Goff Electric for anything on your side of the meter.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<?php echo apStyles(); ?>
<style>
/* ==========================================================================
   Placitas — page composition. Tokens only.
   ========================================================================== */
.hero--placitas { --sp-hero-pos: 50% 50%; }

/* Local story on paper-2 with an elevation gauge in the glance card */
.pla-local { background: var(--color-paper-2); }
.pla-gauge { position: relative; height: 12px; margin: var(--space-sm) 0 var(--space-xs); border-radius: var(--radius-full); background: linear-gradient(90deg, var(--color-secondary), var(--color-accent)); }
.pla-gauge span { position: absolute; top: 50%; left: 18%; width: 18px; height: 18px; translate: -50% -50%; border-radius: var(--radius-full); background: var(--color-surface); border: 4px solid var(--color-primary); box-shadow: var(--shadow-sm); }
.pla-gauge-labels { display: flex; justify-content: space-between; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .1em; text-transform: uppercase; color: var(--color-muted); }

/* Ground conditions: bento on surface */
.pla-ground { background: var(--color-surface); }
.pla-ground .sp-sign--lead { background: linear-gradient(200deg, var(--color-primary) 0%, var(--color-dark) 70%); }

/* Subdivision table: dark band */
.pla-subs .sp-table-wrap { border-color: color-mix(in srgb, var(--color-white) 14%, transparent); }
.pla-subs .sp-table tbody th { color: var(--color-ink); }
.pla-subs .sp-table td:last-child { color: var(--color-ink); }
.pla-subs__note { margin: var(--space-md) 0 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 70%, transparent); max-width: var(--measure); }

/* Landmarks: pill cloud */
.pla-places { background: var(--color-paper); }
.pla-places__list { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: var(--space-sm); }
.pla-places__list li { display: grid; gap: var(--space-1); padding: var(--space-md) var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.pla-places__list b { font-family: var(--font-heading); font-size: 1.15rem; text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); }
.pla-places__list span { font-size: var(--fs-small); color: var(--color-ink-2); }

.pla-services { background: var(--color-paper-2); }
.pla-faq { background: var(--color-surface); }
.pla-nearby { background: var(--color-paper); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--area hero--placitas" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Living room with a ceiling fan light kit and recessed lights in a textured ceiling', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Sandia foothills · NM 165</span>
        <h1 class="hero-title" id="hero-title">Electrician in <span class="text-accent">Placitas</span>, NM</h1>
        <p class="hero-answer">Goff Electric handles Placitas foothill homes, from trenches in rock to well circuits.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('mountain', 16); ?>Foothill properties</li>
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
  <section class="section pla-local slant-top" aria-labelledby="local-title">
    <div class="container ap-local__grid">
      <div>
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Placitas, up close</span>
          <h2 id="local-title">What makes Placitas electrical work different from work in the valley?</h2>
          <p class="answer-block">Placitas electrical work is different because the ground, the water and the lines are different. Placitas homes sit on rock rather than valley sand, many depend on wells, several subdivisions have buried utilities, and the whole corridor is rated a high wildfire risk.</p>
        </div>
        <div class="ap-prose reveal-up">
          <p>Goff Electric is a licensed and insured New Mexico electrical contractor based in Rio Rancho, serving Placitas along with the rest of Sandoval and Bernalillo counties. Placitas is an unincorporated community of 5,041 people (2020 census) spread along NM 165 east of Bernalillo, below the north end of the Sandia Mountains. Its roots go back to the San Antonio de las Huertas land grant of 1767, made to 21 families; the Las Placitas Presbyterian Church followed in 1894.</p>
          <p>Today Placitas is a patchwork of subdivisions and rural parcels, and each one is wired a little differently. Diamond Tail, Sundance Mesa and Anasazi Meadows were built with underground utilities. The Overlook relies on private wells. Placitas Homesteads and Las Huertas Acres hold larger lots where a shop or well house can sit far from the meter. A job in one can look nothing like a job a mile away, which is why Goff Electric asks for your subdivision or road when you call.</p>
          <p>The ground is the other difference. Geologists map granite, gneiss, limestone and sandstone here, broken up by the Placitas fault zone, and that is what a trench for a new feeder runs into. The same geology makes well yields uneven across the area, and some wells have gone dry, so a well pump's circuit is worth getting right the first time.</p>
          <p>Weather adds the rest. Sandoval County's emergency manager rates the Placitas Corridor a high wildfire risk because of wind and dry fuel, and lightning has started fires in the Sandias just to the south. If you are searching for an electrician near me in Placitas after a storm, Goff Electric's phone is answered around the clock.</p>
        </div>
      </div>
      <aside class="ap-glance reveal-right" aria-labelledby="glance-title">
        <h3 id="glance-title">Placitas at a glance</h3>
        <div class="pla-gauge" aria-hidden="true"><span></span></div>
        <div class="pla-gauge-labels" aria-hidden="true"><span>5,600 ft</span><span>7,200 ft</span></div>
        <?php echo apFacts([
            ['Status', 'Unincorporated Sandoval County'],
            ['ZIP code', '87043'],
            ['Elevation', 'About 5,600–7,200 ft; the community center point sits near 5,950 ft'],
            ['Plant zone', 'USDA 7b at the ZIP center (2023 map)'],
            ['Electric utility', 'PNM (confirm on your bill)'],
            ['Permits', 'State CID, after Sandoval County zoning review'],
            ['Population', '5,041 (2020 census)'],
        ], 'Sources: U.S. Census 2020, Sandoval County, American Geosciences Institute, USDA 2023 hardiness map.'); ?>
      </aside>
    </div>
  </section>

  <!-- ===================== GROUND & WEATHER ===================== -->
  <section class="section pla-ground" aria-labelledby="ground-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Rock, wells, fire</span>
        <h2 id="ground-title">What do Placitas rock, wells and wildfire risk mean for a home's electrical system?</h2>
        <p class="answer-block">For a home's electrical system, Placitas rock means harder trenching for underground runs, wells mean the pump circuit is critical to the household, and wildfire and lightning risk mean surge protection and clear, well-kept exterior equipment matter more than they do in town.</p>
      </div>
      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('mountain', 32); ?>
          <h3>Trenching through rock</h3>
          <p>Granite, gneiss and limestone under the foothills turn a routine trench into a dig that has to be planned. Routes to a shop, casita or well house are walked at the estimate so the price reflects the ground.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('droplets', 26); ?>
          <h3>The well comes first</h3>
          <p>Where the water comes from a private well, the pump's circuit, breaker and wiring to the well house keep the whole home running.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('flame', 26); ?>
          <h3>Fire and lightning</h3>
          <p>A high-risk wildfire corridor and summer lightning make surge protection and sound, sealed exterior equipment worth the attention.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== SUBDIVISIONS ===================== -->
  <section class="section texture-grain edge-torn-top pla-subs" aria-labelledby="subs-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Subdivision by subdivision</span>
        <h2 id="subs-title">How does electrical work change from one Placitas subdivision to the next?</h2>
        <p class="answer-block">Electrical work changes from one Placitas subdivision to the next because the utilities do. Some subdivisions were built with buried service lines and community water, others rely on private wells and larger parcels, and each setup changes how a fault is found and how new circuits are routed.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <thead>
            <tr><th scope="col">Subdivision</th><th scope="col">What public listings record</th><th scope="col">What it means for electrical work</th></tr>
          </thead>
          <tbody>
<?php foreach ($subdivisions as $subRow): ?>
            <tr><th scope="row"><?php echo esc($subRow[0]); ?></th><td><?php echo esc($subRow[1]); ?></td><td><?php echo esc($subRow[2]); ?></td></tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="pla-subs__note">Subdivision details come from public real-estate listings and can vary lot by lot. Goff Electric confirms what is actually at your property when it visits.</p>
    </div>
  </section>

  <!-- ===================== SERVICES ===================== -->
  <section class="section pla-services ap-services" aria-labelledby="services-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="services-title">Which Goff Electric services do Placitas homeowners use?</h2>
        <p class="answer-block">Placitas homeowners can use every Goff Electric service. The three that fit foothill properties best are new wiring and underground feeders, home circuits from well pumps to hot tubs, and Level 2 EV chargers for the drive down NM 165 and I-25 into Albuquerque.</p>
      </div>
      <?php echo apServices(
          ['electrical-wiring-installation-repair', 'residential-electrical', 'ev-charger-installation'],
          [
              'electrical-wiring-installation-repair' => 'Underground feeders planned around Placitas rock, to shops, casitas and well houses.',
              'residential-electrical'                => 'Home circuits for Placitas houses, from the well pump to a hot tub on the portal.',
              'ev-charger-installation'               => 'A Level 2 circuit for the commute from Placitas down NM 165 and I-25, sized by a load calculation.',
          ],
          $town
      ); ?>
    </div>
  </section>

  <!-- ===================== PLACES ===================== -->
  <section class="section pla-places edge-curve-top" aria-labelledby="places-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Around Placitas</span>
        <h2 id="places-title">Where in Placitas does Goff Electric work?</h2>
        <p class="answer-block">Goff Electric works throughout Placitas, ZIP 87043, from the subdivisions off NM 165 near I-25 up toward Las Huertas Canyon and the Cibola National Forest. These are the landmarks that frame the community.</p>
      </div>
      <ul class="pla-places__list">
        <li class="reveal-up"><b>Las Huertas Canyon &amp; Sandia Man Cave</b><span>Up NM 165 into the Cibola National Forest; the cave is a National Historic Landmark (1961).</span></li>
        <li class="reveal-up reveal-delay-1"><b>Placitas Open Space</b><span>560 acres managed by the City of Albuquerque, including part of Las Huertas Creek.</span></li>
        <li class="reveal-up reveal-delay-2"><b>BLM Placitas Area</b><span>4,213 acres of public land withdrawn under Public Land Order 7940, home to free-roaming horses.</span></li>
        <li class="reveal-up"><b>Placitas Community Library</b><span>On NM 165, in its current building since 2009.</span></li>
        <li class="reveal-up reveal-delay-1"><b>Las Placitas Presbyterian Church</b><span>Founded in 1894.</span></li>
        <li class="reveal-up reveal-delay-2"><b>San Antonio de las Huertas grant</b><span>The 1767 land grant at the root of the community.</span></li>
      </ul>
    </div>
  </section>

  <!-- ===================== WHY GOFF ELECTRIC ===================== -->
  <section class="section texture-grain slant-top pla-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b><?php echo esc(number_format((float) $gbpRating, 1)); ?><small> / 5</small></b>
        <span>Google rating · <a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo (int) $gbpReviewCount; ?> reviews</a></span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why do Placitas homeowners hire Goff Electric?</h2>
        <p class="answer-block">Placitas homeowners hire Goff Electric for a licensed, insured contractor who looks at the property before quoting, explains the options, and answers the phone at any hour. Owner Garrett Goff does the estimate himself, and it costs nothing.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('route', 22); ?><div><b>Routes walked, not guessed</b><span>Underground runs are priced after the route and the ground have been looked at.</span></div></li>
          <li><?php echo icon('clipboard-check', 22); ?><div><b>Options explained</b><span>A Google reviewer wrote that Garrett laid out the options, with pros and cons, instead of only telling him what he needed.</span></div></li>
          <li><?php echo icon('clock', 22); ?><div><b>24/7 phone line</b><span>Storm damage at night reaches the same number as a daytime estimate.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq pla-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do Placitas homeowners ask about electrical work?</h2>
        <p class="answer-block">Placitas homeowners usually ask who issues the permit, why trenching costs vary, and which utility serves them. Here are straight answers; for anything else, call Goff Electric at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</p>
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
  <section class="section section--tight pla-nearby" aria-labelledby="nearby-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Also served</span>
        <h2 id="nearby-title">Which towns near Placitas does Goff Electric serve?</h2>
        <p class="answer-block">Near Placitas, Goff Electric serves Bernalillo just west at the bottom of NM 165, Rio Rancho and Corrales across the river, Albuquerque to the south, and Tijeras on the other side of the Sandia Mountains.</p>
      </div>
      <?php echo apNearby('placitas', ['rio-rancho' => 'Home base, across the river', 'albuquerque' => 'South on I-25', 'corrales' => 'West bank of the Rio Grande', 'bernalillo' => 'West on NM 165', 'tijeras' => 'Other side of the Sandias']); ?>
      <p class="last-updated">Last Updated: <?php echo date('F Y'); ?></p>
    </div>
  </section>

</article>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('mountain', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Placitas, day or night</span>
      <h2 id="final-title">Get a free estimate in Placitas</h2>
      <p>Tell Goff Electric the job, your subdivision or road, and whether the house is on a well. The route gets looked at for free, and you get the scope and price before any work starts.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request my estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
