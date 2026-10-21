<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/corrales/ — Goff Electric (Phase 6, 2026-10-21).
 * Angle: the acre-lot village between Rio Rancho's escarpment and the Rio Grande. Long runs to outbuildings, private
 * wells, cottonwoods over the lines, monsoon runoff from the sandhills. Landmarks along Corrales Road (NM 448).
 *
 * SOURCES (researched 2026-10-21):
 *   https://en.wikipedia.org/wiki/Corrales,_New_Mexico           ZIP 87048; elevation 5,036 ft; 2020 census 8,493; village government
 *                                                               incorporated 1971; rural farming/ranching past, cottonwoods, acequias;
 *                                                               much of the village has no central water or sewer (private wells, septic)
 *   https://media.cocorahs.org/wys/2018-2019/NM/NM-SN-18-wys-2018-2019.html   station at 5,013 ft
 *   https://usclimatedata.com/map/usnm0079                      5,000 ft
 *   https://albuquerquehomesonline.com/RioRancho/corrales-north  Corrales North ~100 ft above Corrales Road
 *   https://plantmaps.com/en/clim/f/us/new-mexico/corrales/climate-data   2023 USDA zone 7b
 *   https://en.wikipedia.org/wiki/New_Mexico_State_Road_448     Corrales Road = NM 448, 13 miles
 *   https://corralescomment.com/2021/04/13/2021-april-10-issue-take-over-of-corrales-road-presented-at-april-20-council/   paved 1946
 *   https://nm-corrales.civicplus.com/212/Corrales-Bosque-Preserve   Bosque Preserve, Corrales Siphon to Alameda Blvd bridge
 *   https://npgallery.nps.gov/AssetDetail/NRIS/80002570         Old San Ysidro Church, adobe 1868, National Register 1980
 *   https://cabq.gov/artsculture/albuquerque-museum/casa-san-ysidro   Casa San Ysidro (Albuquerque Museum), c. 1875
 *   https://markets.farmland.org/market/corrales-growers-market/   Corrales Growers' Market
 *   https://www.rrobserver.com/news/38th-annual-corrales-harvest-festival-set-sept-30-and-oct-1/194112   Harvest Festival, late Sept, since 1985
 *   https://corralescomment.com/2026/04/23/corrales-irrigation-deliveries-suspended-as-rio-grande-levels-drop/   Corrales Main Canal
 *   https://corralescomment.com/2024/07/12/village-to-hold-special-appeal-hearing-on-1-acre-lot-rule/   1-acre minimum lot since 1971
 *   https://corralescomment.com/2024/11/07/thousands-of-corralenos-without-power/   Nov 2024: 4,074 PNM customers out after
 *                                                               snow-loaded trees fell into power lines (PNM is the utility)
 *   https://corralescomment.com/2021/08/10/2021-august-07-issue-monsoon-rains-wash-out-roads-but-weeds-thrive/   July 2021 monsoon
 *                                                               washouts below the escarpment, Camino Arco Iris to West Meadowlark;
 *                                                               runoff from the "sandhills"
 *   https://www.rrobserver.com/corrales/meadowlark-moves-forward-in-rr-as-corrales-bit-comes-to-an-end/206052   Meadowlark Lane, Loma Larga
 *   https://corralescomment.com/2021/12/21/12-18-21-more-turnover-as-village-inspector-leaves/   Village P&Z has a building inspector
 * ELEVATION is a range on purpose: 5,000 / 5,013 / 5,036 ft on the valley floor depending on source; higher toward the escarpment.
 * LEFT OUT (unverifiable): who issues electrical permits in the village (do NOT name an agency — confirm with Corrales P&Z / CID),
 * horse properties, dirt roads, pueblo-style homes, a 2-acre zone, sandy soils on the west side.
 * REVIEW: the Google review shown is matched live from the feed by the word "Corrales" (spReviews) — never hard-coded.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.php';

$area         = apArea('corrales');
$town         = $area['name'];
$pageTitle    = 'Electrician in Corrales, NM | Acre Lots | Goff Electric';
$pageDescription = 'Corrales electrician for acre-lot homes: underground feeders to shops and barns, well-house circuits, inspections, 24/7 calls. Call Goff Electric any hour.';
$canonicalUrl = $siteUrl . '/service-areas/corrales/';
$currentPage  = 'areas';
$pageType     = 'city';
$citySlug     = 'corrales';
$heroFormTitle   = 'Free estimate in Corrales';
$heroFormTagline = 'Tell us the job, and how far the building is from the meter if you know.';

$heroImage   = 'gbp-04-additional';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$ogImage     = '/assets/images/' . $heroImage . '-960.webp';
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Service Areas', 'url' => '/service-areas/'],
    ['name' => $town, 'url' => '/service-areas/corrales/'],
];
$schemaMarkup = apSchema(
    ['name' => $town, 'county' => 'Sandoval', 'type' => 'City', 'sameAs' => ['https://en.wikipedia.org/wiki/Corrales,_New_Mexico']],
    $canonicalUrl, $pageTitle, $pageDescription, $crumbs, $ogImage
);

/* Along Corrales Road — verified landmarks only */
$landmarks = [
    ['Old San Ysidro Church', 'Adobe, built in 1868, on the National Register since 1980.'],
    ['Casa San Ysidro', 'The Albuquerque Museum\'s historic house, built around 1875.'],
    ['Corrales Bosque Preserve', 'Cottonwood forest along the Rio Grande, from the Corrales Siphon to the Alameda bridge.'],
    ['Corrales Main Canal', 'The acequia system that still irrigates village fields.'],
    ['Corrales Growers\' Market', 'The village farmers market.'],
    ['Harvest Festival', 'Every late September since 1985.'],
];

/* FAQs — visible text only (never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'How far can power run from the meter to a barn or shop in Corrales?',
        'a' => 'As far as the property needs, but distance changes the wire. On a long run the conductors are sized up so the voltage at the far end stays usable, and the feeder is usually trenched underground in conduit. Goff Electric measures the run at the estimate visit and prices the trench, the wire and the panel at the building together.',
    ],
    [
        'q' => 'Who do I call when a tree takes down the line to my house?',
        'a' => 'Stay well away from any downed line and call PNM first; the line from the pole to your house is theirs. Once PNM has made it safe, damage on your side, such as a torn mast, a pulled meter base or a dead panel, is electrician work. Goff Electric answers ' . '<a href="tel:' . esc($phoneRaw) . '">' . esc($phoneText) . '</a>' . ' around the clock for exactly that.',
    ],
    [
        'q' => 'Do I need a permit for electrical work in Corrales?',
        'a' => 'Work that adds circuits, replaces a panel or runs a new feeder normally needs a permit and inspection under the electrical code New Mexico has adopted. The Village of Corrales has its own Planning and Zoning department, so confirm the permit route for your address with the Village, and ask Goff Electric what your job will need at the estimate.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<?php echo apStyles(); ?>
<style>
/* ==========================================================================
   Corrales — page composition. Tokens only.
   ========================================================================== */
.hero--corrales { --sp-hero-pos: 50% 60%; }

/* Local story: paper band, photo pair beside the prose */
.cor-local { background: var(--color-paper); }
.cor-local__grid { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, .9fr); gap: var(--space-2xl) var(--space-3xl); align-items: start; }
.cor-local__side { display: grid; gap: var(--space-lg); }
.cor-local .sp-photo { aspect-ratio: 4 / 3; }
@media (max-width: 960px) { .cor-local__grid { grid-template-columns: 1fr; } }

/* Acre-lot plan: dark band with a drawn "property line" */
.cor-lot .sp-head { max-width: 62ch; }
.cor-lot__grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0; border: 1px dashed color-mix(in srgb, var(--color-accent) 55%, transparent); border-radius: var(--radius-lg); }
.cor-lot__grid > div { display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-xl) var(--space-lg); border-right: 1px dashed color-mix(in srgb, var(--color-white) 16%, transparent); }
.cor-lot__grid > div:last-child { border-right: 0; }
.cor-lot__grid svg { color: var(--color-accent); }
.cor-lot__grid h3 { color: var(--color-white); text-transform: uppercase; letter-spacing: .02em; font-size: var(--fs-h3); }
.cor-lot__grid p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.cor-lot__grid .cor-lot__tag { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
@media (max-width: 1000px) { .cor-lot__grid { grid-template-columns: 1fr 1fr; } .cor-lot__grid > div:nth-child(2) { border-right: 0; } .cor-lot__grid > div:nth-child(-n+2) { border-bottom: 1px dashed color-mix(in srgb, var(--color-white) 16%, transparent); } }
@media (max-width: 600px) { .cor-lot__grid { grid-template-columns: 1fr; } .cor-lot__grid > div { border-right: 0; border-bottom: 1px dashed color-mix(in srgb, var(--color-white) 16%, transparent); } .cor-lot__grid > div:last-child { border-bottom: 0; } }

/* Landmarks along Corrales Road: a "road" line with stops */
.cor-road { background: var(--color-surface); }
.cor-road__list { list-style: none; margin: 0; padding: 0 0 0 var(--space-xl); display: grid; gap: var(--space-md); position: relative; max-width: 52rem; }
.cor-road__list::before { content: ""; position: absolute; left: 9px; top: var(--space-xs); bottom: var(--space-xs); width: 4px; border-radius: var(--radius-full); background: repeating-linear-gradient(180deg, var(--color-accent) 0 14px, transparent 14px 24px); }
.cor-road__list li { position: relative; display: grid; grid-template-columns: minmax(0, 15rem) minmax(0, 1fr); gap: var(--space-xs) var(--space-lg); align-items: baseline; }
.cor-road__list li::before { content: ""; position: absolute; left: calc(-1 * var(--space-xl) + 3px); top: .45em; width: 16px; height: 16px; border-radius: var(--radius-full); background: var(--color-surface); border: 4px solid var(--color-primary); }
.cor-road__list b { font-family: var(--font-heading); font-size: 1.2rem; text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); }
.cor-road__list span { font-size: var(--fs-small); color: var(--color-ink-2); }
@media (max-width: 640px) { .cor-road__list li { grid-template-columns: 1fr; } }

.cor-services { background: var(--color-paper-2); }
.cor-review { background: var(--color-paper); }
.cor-review .sp-reviews { grid-template-columns: minmax(0, 46rem); }
.cor-faq { background: var(--color-surface); }
.cor-nearby { background: var(--color-paper-2); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--area hero--corrales" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Mini excavator digging a trench across a gravel lot toward a steel outbuilding for an underground electrical run', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Village of Corrales · Sandoval County</span>
        <h1 class="hero-title" id="hero-title">Electrician in <span class="text-accent">Corrales</span>, NM</h1>
        <p class="hero-answer">Goff Electric wires Corrales acre lots, from the meter out to the back fence.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('route', 16); ?>Next door in Rio Rancho</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== LOCAL STORY ===================== -->
  <section class="section cor-local slant-top" aria-labelledby="local-title">
    <div class="container cor-local__grid">
      <div>
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Corrales, up close</span>
          <h2 id="local-title">Why is electrical work in Corrales different from work in a subdivision?</h2>
          <p class="answer-block">Electrical work in Corrales is different because Corrales lots are big. The village has required at least one acre per home since 1971, so power often has to travel a long way: from the meter to the house, then on to a shop, a barn, a casita or a well.</p>
        </div>
        <div class="ap-prose reveal-up">
          <p>Goff Electric is a licensed and insured New Mexico electrical contractor based in Rio Rancho, serving Corrales from just up the escarpment, along with the rest of Sandoval and Bernalillo counties. Corrales is a village of 8,493 people (2020 census) strung along Corrales Road, NM 448, between Rio Rancho's mesa and the Rio Grande, and it has kept its farming character on purpose. Its one-acre minimum lot rule dates to 1971, the year the current village government was incorporated.</p>
          <p>That acreage is what shapes Corrales electrical work. A detached shop, a barn or a guest house can sit well back from the meter, and the feeder to it has to be sized for the distance and buried in conduit. Much of the village has no central water or sewer, so many homes run on a private well and pump, and that pump needs a reliable circuit of its own. The 1868 adobe San Ysidro church and newer houses off Loma Larga and Meadowlark Lane sit a few minutes apart, and the homes in between were built across many decades.</p>
          <p>Then there are the trees. The cottonwoods that make the Corrales Bosque Preserve worth walking also grow over service lines. In November 2024, snow-loaded trees fell into lines and left 4,074 PNM customers in Corrales without power. Summer brings the other hazard: in July 2021, monsoon runoff off the sandhills washed out roads below the escarpment between Camino Arco Iris and West Meadowlark, which is a good reason to keep exterior panels, disconnects and well-house equipment up off the ground.</p>
          <p>If you are looking for an electrician near me in Corrales, Goff Electric is close by. The crew comes down from Rio Rancho, and the same phone line answers day and night.</p>
        </div>
      </div>
      <div class="cor-local__side">
        <aside class="ap-glance reveal-right" aria-labelledby="glance-title">
          <h3 id="glance-title">Corrales at a glance</h3>
          <?php echo apFacts([
              ['County', 'Sandoval'],
              ['ZIP code', '87048'],
              ['Elevation', 'About 5,000–5,040 ft on the valley floor, rising toward the western escarpment'],
              ['Plant zone', 'USDA 7b (2023 map)'],
              ['Electric utility', 'PNM'],
              ['Water', 'Much of the village on private wells and septic'],
              ['Minimum lot', 'One acre (village rule since 1971)'],
          ], 'Sources: Village of Corrales, U.S. Census 2020, Corrales Comment, USDA 2023 hardiness map.'); ?>
        </aside>
        <figure class="sp-photo reveal-right">
          <?php echo responsivePicture('gbp-06-at_work', 'New electrical equipment and conduit beside a home electric meter, with the conduit dropping into an open trench along the wall', '(max-width: 960px) 90vw, 440px'); ?>
          <figcaption>Conduit leaving the meter for an underground run</figcaption>
        </figure>
      </div>
    </div>
  </section>

  <!-- ===================== THE ACRE LOT ===================== -->
  <section class="section texture-grain edge-torn-top cor-lot" aria-labelledby="lot-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Meter to back fence</span>
        <h2 id="lot-title">What does an electrician plan for on a Corrales acre lot?</h2>
        <p class="answer-block">On a Corrales acre lot, an electrician plans for four things the average subdivision house never has: long feeders to outbuildings, a well pump, trees over the service drop, and storm runoff. Each one changes the wire size, the route or where equipment gets mounted.</p>
      </div>
      <div class="cor-lot__grid reveal-up">
        <div><span class="cor-lot__tag">Distance</span><?php echo icon('cable', 30); ?><h3>Feeders to outbuildings</h3><p>Shops, barns and casitas set back from the house get an underground feeder in conduit, with the conductors sized up so the far end still gets full voltage.</p></div>
        <div><span class="cor-lot__tag">Water</span><?php echo icon('droplets', 30); ?><h3>The well pump</h3><p>No pump, no water. A well on its own properly sized circuit, with protected wiring to the well house, keeps the house running.</p></div>
        <div><span class="cor-lot__tag">Trees</span><?php echo icon('trees', 30); ?><h3>Cottonwoods over the line</h3><p>When a limb tears down the service mast or meter base, PNM handles the pole side and an electrician repairs and re-secures yours.</p></div>
        <div><span class="cor-lot__tag">Runoff</span><?php echo icon('waves', 30); ?><h3>Monsoon water</h3><p>Exterior panels, disconnects and outlets placed above where runoff collects, with GFCI protection and covers rated for wet locations.</p></div>
      </div>
    </div>
  </section>

  <!-- ===================== SERVICES ===================== -->
  <section class="section cor-services ap-services" aria-labelledby="services-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="services-title">What electrical services does Goff Electric provide in <span class="text-accent">Corrales</span>?</h2>
        <p class="answer-block">Goff Electric provides its full list of electrical services in Corrales. The three that fit village properties best are new wiring and underground feeders for outbuildings, residential circuits from well houses to hot tubs, and electrical inspections for older homes or a property you are thinking of buying.</p>
      </div>
      <?php echo apServices(
          ['electrical-wiring-installation-repair', 'residential-electrical', 'electrical-inspections'],
          [
              'electrical-wiring-installation-repair' => 'Underground feeders trenched to shops, barns, casitas and well houses across a Corrales acre.',
              'residential-electrical'                => 'Home circuits for Corrales houses, from a hot tub on the patio to a dedicated well-pump circuit.',
              'electrical-inspections'                => 'A clear look at the panel and wiring of an older Corrales home, or one you are about to buy.',
          ],
          $town
      ); ?>
    </div>
  </section>

  <!-- ===================== LANDMARKS ===================== -->
  <section class="section cor-road edge-curve-top" aria-labelledby="road-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Along NM 448</span>
        <h2 id="road-title">Where in Corrales does Goff Electric work?</h2>
        <p class="answer-block">Goff Electric works anywhere in the Village of Corrales, ZIP 87048, from the north end near Rio Rancho down Corrales Road to the Alameda bridge, and from the escarpment streets to the bosque. These are the landmarks along the way.</p>
      </div>
      <ol class="cor-road__list reveal-up">
<?php foreach ($landmarks as $lmRow): ?>
        <li><b><?php echo esc($lmRow[0]); ?></b><span><?php echo esc($lmRow[1]); ?></span></li>
<?php endforeach; ?>
      </ol>
    </div>
  </section>

<?php $corProof = spReviews('Corrales', 2); if ($corProof !== ''): ?>
  <!-- ===================== PROOF: Google review that mentions Corrales ===================== -->
  <section class="section cor-review slant-top" aria-labelledby="proof-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do Corrales customers say about Goff Electric?</h2>
        <p class="answer-block">Corrales customers say Goff Electric is honest even when honesty means no job: one Corrales couple called to hire Goff Electric and was told what they already had was fine. Their review is quoted word for word from Google below.</p>
      </div>
      <?php echo $corProof; ?>
      <div class="sp-proof-foot">
        <a class="btn btn-secondary" href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read all <?php echo (int) $gbpReviewCount; ?> Google reviews <?php echo icon('external-link', 16); ?></a>
      </div>
    </div>
  </section>
<?php endif; ?>

  <!-- ===================== WHY GOFF ELECTRIC ===================== -->
  <section class="section texture-grain edge-parallelogram-top cor-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b>24/7</b>
        <span>Phone answered day and night</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why do Corrales property owners call Goff Electric?</h2>
        <p class="answer-block">Corrales property owners call Goff Electric because it is close, it answers at any hour, and owner Garrett Goff tells you plainly what a job needs, including when it needs nothing. Goff Electric is licensed and insured in New Mexico and gives free estimates.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('route', 22); ?><div><b>Just up the hill</b><span>Based in Rio Rancho, directly above the village on the mesa.</span></div></li>
          <li><?php echo icon('gauge', 22); ?><div><b>Runs measured, not guessed</b><span>Feeder length and load are measured at the estimate, so the wire is sized for the distance.</span></div></li>
          <li><?php echo icon('star', 22); ?><div><b><?php echo esc(number_format((float) $gbpRating, 1)); ?> stars from <?php echo (int) $gbpReviewCount; ?> Google reviews</b><span><a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read them on Google</a>.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq cor-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do Corrales homeowners ask about electrical work?</h2>
        <p class="answer-block">Corrales homeowners usually ask how far power can run to an outbuilding, who handles a line a tree has taken down, and whether a permit is needed. Here are straight answers; for anything else, call Goff Electric at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</p>
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
  <section class="section section--tight cor-nearby" aria-labelledby="nearby-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Also served</span>
        <h2 id="nearby-title">Which towns near Corrales does Goff Electric serve?</h2>
        <p class="answer-block">Near Corrales, Goff Electric serves Rio Rancho on the mesa above the village, Albuquerque across the Alameda bridge, and Bernalillo upriver, plus Placitas and Tijeras on the far side of the Sandias.</p>
      </div>
      <?php echo apNearby('corrales', ['rio-rancho' => 'On the mesa above', 'albuquerque' => 'South, over the Alameda bridge', 'bernalillo' => 'Upriver, east bank', 'placitas' => 'Sandia foothills', 'tijeras' => 'East Mountains']); ?>
      <p class="last-updated">Last Updated: <?php echo date('F Y'); ?></p>
    </div>
  </section>

</article>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('trees', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Corrales, day or night</span>
      <h2 id="final-title">Get a free estimate in Corrales</h2>
      <p>Tell Goff Electric what you want powered and roughly how far it is from the meter. The run gets measured at no cost, and you get the scope and price before any digging starts.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request my estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
