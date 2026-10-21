<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/bernalillo/ — Goff Electric (Phase 6, 2026-10-21). The TOWN of Bernalillo (Sandoval County seat), not Bernalillo County.
 * Angle: one of New Mexico's oldest towns, county seat, historic adobe on Camino del Pueblo, a river-valley floodplain, and a
 * permit path that runs through the state CID. Conditions emphasis: floodplain + older buildings rather than wind/mesa.
 *
 * SOURCES (researched 2026-10-21):
 *   https://en.wikipedia.org/wiki/Bernalillo,_New_Mexico         ZIP 87004; elevation 5,050 ft (older revision 5,052 ft); 2020 census
 *                                                               8,977; Sandoval County seat since the county was created in 1903;
 *                                                               east bank of the Rio Grande; Bernalillo High School
 *   https://epqs.nationalmap.gov/v1/json                        USGS point elevations in town: 5,049-5,058 ft valley floor, ~5,087 ft
 *                                                               at the foot of the east slope
 *   https://phzmapi.org/87004.json ; https://www.plantmaps.com/en/clim/c/us/new-mexico/bernalillo/climate-data   2023 USDA zone 7b
 *   https://www.tobnm.gov/visitors/history_of_bernalilo/        founded 1695 (Town); Camino del Pueblo = El Camino Real, Route 66 and
 *                                                               Old State Highway 85
 *   https://en.wikipedia.org/wiki/Abenicio_Salazar_Historic_District   National Register 1980; 13 contributing buildings, 1874-1922, adobe
 *   https://en.wikipedia.org/wiki/Our_Lady_of_Sorrows_Church_(Bernalillo,_New_Mexico)   1857 adobe church, National Register 1977
 *   https://en.wikipedia.org/wiki/Coronado_Historic_Site ; https://www.nps.gov/places/kuaua-ruins-coronado-historic-site.htm   Kuaua Pueblo,
 *                                                               west bank, dedicated 1940
 *   https://riometro.org/188/Downtown-Bernalillo ; https://riometro.org/209/Sandoval-County-US-550   Rail Runner stations (2007, 2006)
 *   https://sandovalcountynm.gov/?p=140                         Sandoval County Administration Building, 1500 Idalia Rd
 *   https://www.pnm.com/documents/d/pnm.com/6th-revised-rule-no-0   PNM serves the Town of Bernalillo (Albuquerque Metro Division)
 *   https://tobnm.gov/departments/planning_zoning/              CID issues building permits, trades permits and all inspections on behalf
 *                                                               of the Town; Town Planning & Zoning does zoning + floodplain review first
 *                                                               (505-771-7118)
 *   https://www.nmlegis.gov/Sessions/09%20Regular/memorials/senate/SM018.html   2008 FEMA maps put ~1,632 acres of town in Zone A
 *                                                               floodplain because spoil-bank levees were not certified
 * ELEVATION is a range on purpose: 5,050 vs 5,052 ft in two Wikipedia revisions; USGS points 5,049-5,087 ft.
 * LEFT OUT (unverifiable or wrong): incorporation year, the New Mexico Wine Festival (ended 2014), a high water table, town-specific
 * wind/monsoon claims, "US 550 commercial corridor", newer subdivisions, Santa Ana Star Casino (pueblo land, not town).
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.php';

$area         = apArea('bernalillo');
$town         = $area['name'];
$pageTitle    = 'Electrician in Bernalillo, NM | Open 24/7 | Goff Electric';
$pageDescription = 'Electrician for the Town of Bernalillo, NM: inspections for older adobe buildings, commercial work, panel upgrades, 24/7 calls. Call Goff Electric any hour.';
$canonicalUrl = $siteUrl . '/service-areas/bernalillo/';
$currentPage  = 'areas';
$pageType     = 'city';
$citySlug     = 'bernalillo';
$heroFormTitle   = 'Free estimate in Bernalillo';
$heroFormTagline = 'Home or business, old building or new. Tell us what you need.';

$heroImage   = 'gbp-03-additional';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$ogImage     = '/assets/images/' . $heroImage . '-960.webp';
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Service Areas', 'url' => '/service-areas/'],
    ['name' => $town, 'url' => '/service-areas/bernalillo/'],
];
$schemaMarkup = apSchema(
    ['name' => $town, 'county' => 'Sandoval', 'sameAs' => ['https://en.wikipedia.org/wiki/Bernalillo,_New_Mexico', 'https://www.tobnm.gov/']],
    $canonicalUrl, $pageTitle, $pageDescription, $crumbs, $ogImage
);

/* Permit path — per the Town of Bernalillo Planning & Zoning page */
$permitSteps = [
    ['Town zoning and floodplain review', 'Town of Bernalillo Planning & Zoning checks zoning and, where the parcel is in the mapped floodplain, floodplain requirements, and signs off first.'],
    ['State permit from CID', 'The New Mexico Construction Industries Division issues the electrical (trades) permit on the Town\'s behalf.'],
    ['CID inspection', 'CID also carries out the inspections. The work is closed out once it passes.'],
];

/* FAQs — visible text only (never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Who inspects electrical work in the Town of Bernalillo?',
        'a' => 'The state Construction Industries Division (CID). According to the Town, CID issues building and trades permits and carries out all inspections on the Town\'s behalf, after Town Planning &amp; Zoning has reviewed zoning and floodplain requirements. Goff Electric can walk you through what your project needs at the estimate visit.',
    ],
    [
        'q' => 'Is this page about the town or Bernalillo County?',
        'a' => 'The town. The Town of Bernalillo is the county seat of Sandoval County, north of Rio Rancho on I-25 and US 550. Bernalillo County is a different county, the one Albuquerque is in. Goff Electric serves both; see the <a href="' . esc(areaUrl('albuquerque') ?: '/service-areas/') . '">Albuquerque page</a> for Bernalillo County.',
    ],
    [
        'q' => 'Can older adobe buildings in Bernalillo get new wiring?',
        'a' => 'Yes, though adobe changes how it is done. Thick earthen walls are not hollow, so new circuits are usually run on the surface in conduit or raceway, or routed through ceilings and floors, rather than fished inside the wall. An ' . serviceLink('electrical-inspections', 'electrical inspection') . ' first shows what the building already has.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<?php echo apStyles(); ?>
<style>
/* ==========================================================================
   Bernalillo — page composition. Tokens only.
   ========================================================================== */
.hero--bern { --sp-hero-pos: 50% 45%; }

/* Local story: surface band, glance card on the LEFT this time */
.bern-local { background: var(--color-surface); }
.bern-local .ap-local__grid { grid-template-columns: minmax(0, .85fr) minmax(0, 1.35fr); }
.bern-local .ap-glance { background: var(--color-paper); border-top-color: var(--color-primary); }
@media (max-width: 960px) { .bern-local .ap-local__grid { grid-template-columns: 1fr; } .bern-local .ap-local__grid > aside { order: 2; } }

/* Historic dates: big numerals strip */
.bern-dates { background: var(--color-paper); }
.bern-dates__row { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.bern-dates__row li { display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-bottom: 4px solid var(--color-accent); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.bern-dates__row li:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.bern-dates__row b { font-family: var(--font-accent); font-size: clamp(2.2rem, 1.6rem + 2vw, 3.2rem); line-height: .9; color: var(--color-ink); }
.bern-dates__row h3 { font-size: 1.1rem; text-transform: uppercase; letter-spacing: .02em; }
.bern-dates__row p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 1000px) { .bern-dates__row { grid-template-columns: 1fr 1fr; } }
@media (max-width: 560px) { .bern-dates__row { grid-template-columns: 1fr; } }

/* Permit path: dark band, horizontal steps */
.bern-permit__steps { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); counter-reset: bern-step; }
.bern-permit__steps li { counter-increment: bern-step; position: relative; display: grid; gap: var(--space-xs); padding: var(--space-xl) var(--space-lg) var(--space-lg); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 6%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); }
.bern-permit__steps li::before { content: "Step " counter(bern-step); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.bern-permit__steps li:not(:last-child)::after { content: ""; position: absolute; top: 50%; right: calc(-1 * var(--space-md)); width: var(--space-md); height: 2px; background: var(--color-accent); }
.bern-permit__steps h3 { color: var(--color-white); text-transform: uppercase; letter-spacing: .02em; font-size: var(--fs-h3); }
.bern-permit__steps p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.bern-permit__note { margin: var(--space-lg) 0 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 70%, transparent); }
.bern-permit__note a { color: var(--color-accent-bright); }
@media (max-width: 900px) { .bern-permit__steps { grid-template-columns: 1fr; } .bern-permit__steps li::after { display: none; } }

/* Floodplain split */
.bern-flood { background: var(--color-paper-2); }
.bern-flood .sp-photo { aspect-ratio: 3 / 4; max-width: 24rem; justify-self: end; }
.bern-services { background: var(--color-surface); }
.bern-faq { background: var(--color-paper); }
.bern-nearby { background: var(--color-surface); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--area hero--bern" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Bank of parallel EMT conduit runs dropping into a wireway between electrical panels', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Town of Bernalillo · Sandoval County seat</span>
        <h1 class="hero-title" id="hero-title">Electrician in <span class="text-accent">Bernalillo</span>, NM</h1>
        <p class="hero-answer">Goff Electric works on homes, historic buildings and businesses across the Town of Bernalillo.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('landmark', 16); ?>Historic &amp; new buildings</li>
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
  <section class="section bern-local slant-top" aria-labelledby="local-title">
    <div class="container ap-local__grid">
      <aside class="ap-glance reveal-left" aria-labelledby="glance-title">
        <h3 id="glance-title">Bernalillo at a glance</h3>
        <?php echo apFacts([
            ['Town of', 'Bernalillo, Sandoval County seat since 1903'],
            ['ZIP code', '87004'],
            ['Elevation', 'About 5,050–5,100 ft on the valley floor'],
            ['Plant zone', 'USDA 7b (2023 map)'],
            ['Electric utility', 'PNM'],
            ['Permits', 'State CID, after Town zoning and floodplain review'],
            ['Population', '8,977 (2020 census)'],
        ], 'Sources: Town of Bernalillo, U.S. Census 2020, USGS, USDA 2023 hardiness map.'); ?>
      </aside>
      <div>
        <div class="sp-head reveal-right">
          <span class="eyebrow-label">Bernalillo, up close</span>
          <h2 id="local-title">What should Bernalillo property owners know about electrical work in town?</h2>
          <p class="answer-block">Bernalillo property owners should know three things: the town has some of the oldest buildings in the metro, part of it sits in a mapped river floodplain, and electrical permits and inspections come from the state Construction Industries Division rather than a town building department.</p>
        </div>
        <div class="ap-prose reveal-up">
          <p>Goff Electric is a licensed and insured New Mexico electrical contractor based in Rio Rancho, serving the Town of Bernalillo along with the rest of Sandoval and Bernalillo counties. The town sits on the east bank of the Rio Grande, north of Rio Rancho where I-25 meets US 550, and it has been the Sandoval County seat since the county was created in 1903. The Town dates its founding to 1695.</p>
          <p>That history is still standing. Camino del Pueblo, the town's main street, is the same road as El Camino Real, Route 66 and Old State Highway 85. Along it, the Abenicio Salazar Historic District holds thirteen buildings from 1874 to 1922, many of them large adobes, and Our Lady of Sorrows keeps its 1857 adobe church next to the newer one. Buildings that old were wired long after they went up, so an inspection is the right first step before adding load.</p>
          <p>The river matters too. In 2008, federal flood maps placed about 1,632 acres of the town in a Zone A floodplain because the spoil-bank levees had not been certified. For a property in that zone, the Town reviews floodplain requirements before work starts, and where a panel, disconnect or exterior outlet goes is worth thinking through with the electrician.</p>
          <p>Town residents, offices near the Sandoval County Administration Building on Idalia Road, and shops along Camino del Pueblo all reach the same number. If you need an electrician near me in Bernalillo, Goff Electric is a short drive up NM 528 or US 550 from Rio Rancho.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== HISTORIC DATES ===================== -->
  <section class="section bern-dates" aria-labelledby="dates-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Old town, new loads</span>
        <h2 id="dates-title">How old are the buildings an electrician meets in Bernalillo?</h2>
        <p class="answer-block">An electrician in Bernalillo meets buildings from the 1850s through today. The town's National Register landmarks include an 1857 adobe church and a historic district of buildings from 1874 to 1922, and newer homes and businesses fill in around them.</p>
      </div>
      <ul class="bern-dates__row">
        <li class="reveal-up"><b>1695</b><h3>Founding</h3><p>The year the Town of Bernalillo gives for its founding.</p></li>
        <li class="reveal-up reveal-delay-1"><b>1857</b><h3>Our Lady of Sorrows</h3><p>The original adobe church, on the National Register since 1977.</p></li>
        <li class="reveal-up reveal-delay-2"><b>1874–1922</b><h3>Abenicio Salazar District</h3><p>Thirteen contributing buildings on Camino del Pueblo, listed in 1980.</p></li>
        <li class="reveal-up reveal-delay-3"><b>2006–07</b><h3>Rail Runner arrives</h3><p>Two stations: Sandoval County–US 550 and Downtown Bernalillo.</p></li>
      </ul>
    </div>
  </section>

  <!-- ===================== PERMIT PATH ===================== -->
  <section class="section texture-grain edge-parallelogram-top bern-permit" aria-labelledby="permit-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">The permit path</span>
        <h2 id="permit-title">How does an electrical permit work in the Town of Bernalillo?</h2>
        <p class="answer-block">An electrical permit in the Town of Bernalillo takes three steps: Town Planning &amp; Zoning reviews zoning and any floodplain requirements, the state Construction Industries Division issues the permit, and CID inspects the finished work.</p>
      </div>
      <ol class="bern-permit__steps">
<?php foreach ($permitSteps as $stepRow): ?>
        <li class="reveal-up"><h3><?php echo esc($stepRow[0]); ?></h3><p><?php echo esc($stepRow[1]); ?></p></li>
<?php endforeach; ?>
      </ol>
      <p class="bern-permit__note">Per the Town of Bernalillo Planning &amp; Zoning department, <a href="tel:+15057717118">(505) 771-7118</a>. Requirements change; confirm for your parcel before work starts.</p>
    </div>
  </section>

  <!-- ===================== FLOODPLAIN ===================== -->
  <section class="section bern-flood" aria-labelledby="flood-title">
    <div class="container sp-split">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">On the river</span>
          <h2 id="flood-title">What changes for electrical work on a Bernalillo floodplain parcel?</h2>
          <p class="answer-block">Electrical work on a Bernalillo floodplain parcel adds a Town floodplain review before the permit and calls for care over where equipment sits. Panels, disconnects, meters and exterior outlets are placed to stay clear of standing water, with ground-fault protection where the code requires it.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Check the map first.</b> Whether a parcel is in the mapped floodplain decides whether the Town's floodplain review applies.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Mount equipment with water in mind.</b> Exterior panels and disconnects go where runoff does not collect.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Protect outdoor circuits.</b> GFCI protection and covers rated for wet locations on patio, yard and outbuilding outlets.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>After high water, inspect before re-energizing.</b> Equipment that has been wet should be checked by an electrician before the power goes back on.</span></li>
        </ul>
      </div>
      <figure class="sp-photo sp-photo--offset reveal-right">
        <?php echo responsivePicture('gbp-01-additional', 'Commercial electrical room with new panels, a dry-type transformer, EMT conduit runs and spools of wire', '(max-width: 900px) 90vw, 380px'); ?>
        <figcaption>Panels and conduit set at working height in a commercial electrical room</figcaption>
      </figure>
    </div>
  </section>

  <!-- ===================== SERVICES ===================== -->
  <section class="section bern-services ap-services edge-curve-top" aria-labelledby="services-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="services-title">Which electrical services can Bernalillo homes and businesses get from <span class="text-accent">Goff Electric</span>?</h2>
        <p class="answer-block">Bernalillo homes and businesses can get every Goff Electric service. For a town this old with a busy county-seat downtown, three stand out: electrical inspections for older buildings, commercial electrical work for offices and shops, and panel upgrades when an older panel needs more room.</p>
      </div>
      <?php echo apServices(
          ['electrical-inspections', 'commercial-electrical', 'electrical-panel-upgrades-repair'],
          [
              'electrical-inspections'           => 'A clear read on the wiring in older Bernalillo buildings before new load or a sale.',
              'commercial-electrical'            => 'Power, panels and lighting for Bernalillo offices and shops, from downtown to the edge of town.',
              'electrical-panel-upgrades-repair' => 'A safer, roomier panel when an older Bernalillo house or building has run out of capacity.',
          ],
          $town
      ); ?>
    </div>
  </section>

  <!-- ===================== WHY GOFF ELECTRIC ===================== -->
  <section class="section texture-grain slant-top bern-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b><?php echo esc(number_format((float) $gbpRating, 1)); ?><small> / 5</small></b>
        <span>Google rating · <a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo (int) $gbpReviewCount; ?> reviews</a></span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why choose Goff Electric for a job in Bernalillo?</h2>
        <p class="answer-block">Choose Goff Electric for a job in Bernalillo because one licensed, insured contractor handles houses, historic buildings and commercial spaces, the owner gives the estimate himself, and the phone is answered around the clock.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('search', 22); ?><div><b>The real fault, not a reset</b><span>One Google reviewer had three other electricians miss a short before Goff Electric found it.</span></div></li>
          <li><?php echo icon('building-2', 22); ?><div><b>Residential and commercial</b><span>From a family home to an electrical room with new panels, transformer and conduit.</span></div></li>
          <li><?php echo icon('shield-check', 22); ?><div><b>Licensed and insured</b><span>The scope and price are in front of you before any work starts.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq bern-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do Bernalillo customers ask about electrical work?</h2>
        <p class="answer-block">Bernalillo customers usually ask who inspects the work, whether this page means the town or the county, and how older adobe buildings get rewired. Here are straight answers; for anything else, call Goff Electric at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</p>
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
  <section class="section section--tight bern-nearby" aria-labelledby="nearby-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Also served</span>
        <h2 id="nearby-title">Which towns near Bernalillo does Goff Electric serve?</h2>
        <p class="answer-block">Near Bernalillo, Goff Electric serves Placitas just east on NM 165, Rio Rancho and Corrales to the southwest, Albuquerque to the south on I-25, and Tijeras in the East Mountains.</p>
      </div>
      <?php echo apNearby('bernalillo', ['rio-rancho' => 'Home base, southwest', 'albuquerque' => 'South on I-25', 'corrales' => 'Downriver, west bank', 'placitas' => 'East on NM 165', 'tijeras' => 'East Mountains']); ?>
      <p class="last-updated">Last Updated: <?php echo date('F Y'); ?></p>
    </div>
  </section>

</article>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('landmark', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Bernalillo, day or night</span>
      <h2 id="final-title">Get a free estimate in Bernalillo</h2>
      <p>Tell Goff Electric about the building, its age if you know it, and what you need powered. You get the scope and the price before any work starts.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request my estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
