<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/rio-rancho/ — Goff Electric home base (Phase 6, 2026-10-21).
 * Angle: the home town. A city built on mail-order mesa lots, mostly since incorporation in 1981, split between city
 * permitting and the unincorporated Estates. Conditions emphasis: spring wind + wind-blown sandy soils, monsoon lightning.
 *
 * SOURCES (researched 2026-10-21):
 *   https://en.wikipedia.org/wiki/Rio_Rancho,_New_Mexico          ZIPs 87124/87144/87174, elevation 5,509 ft, 2020 census 104,046,
 *                                                                 mostly Sandoval County (small part in Bernalillo), Enchanted Hills,
 *                                                                 City Centre, Rio Rancho HS + V. Sue Cleveland HS, NM 528, US 550
 *   https://www.rrnm.gov/337                                      city elevation 5,679 ft; AMREP bought 55,000 acres in 1961; 10,000
 *                                                                 residents + incorporation 1981; Cabezon and Mariposa PIDs
 *   https://en.wikipedia.org/wiki/Amrep_Corporation               75,000+ lots sold by mail 1961-1977, little built in the 1960s
 *   https://www.ose.nm.gov/Planning/RWP/Regions/12_MRG/2004/App12-09-Population-Yesterday-Today.pdf   51,765 residents in 2001
 *   https://www.abqjournal.com/business/from-family-friendly-options-to-luxury-living-here-are-5-neighborhoods-to-know-about-if-youre-moving-to-rio-rancho/687618
 *                                                                 Northern Meadows (northwest, near the Events Center), Mariposa
 *   https://www.rrnm.gov/DocumentCenter/View/82389                Star Heights
 *   https://en.wikipedia.org/wiki/Rio_Rancho_Events_Center        name restored in 2020
 *   https://phs.org/rust-medical-center/about                     Presbyterian Rust Medical Center, Unser Blvd SE
 *   https://hsc.unm.edu/medicine/departments/emergency-medicine/_about/facilities/sandoval-regional-mdeical.html   UNM Sandoval Regional, City Center
 *   https://en.wikipedia.org/wiki/New_Mexico_State_Road_347       Paseo del Volcan = NM 347, Unser Blvd to US 550
 *   https://phzmapi.org/87124.json , https://phzmapi.org/87144.json   2023 USDA zone 7b
 *   https://www.sandovalcountynm.gov/wp-content/uploads/2017/06/Appendix_B.pdf   Grieta/Clovis fine sandy loams, Sheppard loamy
 *                                                                 fine sands formed from wind-blown sand
 *   https://www.weather.gov/abq/prepawaremonsoonhome              NWS monsoon season June 15 - September 30; lightning
 *   https://www.weather.gov/abq/features_highwind                 April and May are the windiest months
 *   https://www.pnm.com/need                                      PNM serves Rio Rancho
 *   https://www.rrnm.gov/77/Building-Division                     city Building Division issues electrical permits, 2020 NEC
 *   https://sandovalcountynm.gov/?p=1024                          unincorporated Sandoval County (incl. Rio Rancho Estates CDP):
 *                                                                 state Construction Industries Division after county zoning
 *   https://en.wikipedia.org/wiki/Rio_Rancho_Estates,_New_Mexico  Estates CDP is separate from the city; listed at 6,942 ft
 *   https://www.abqjournal.com/business/movie-plot-continues-to-affect-sandoval-county/716591   Estates largely vacant, dirt roads
 * ELEVATION is a range on purpose: Wikipedia says 5,509 ft, the city says 5,679 ft, the Estates CDP is listed at 6,942 ft.
 * LEFT OUT (unverifiable): Vista Hills, Cabezon Park, "caliche", aluminum-wiring era, typical construction method.
 * Company claims come only from config.php / build-plan.json (based in Rio Rancho 87124, open around the clock, licensed & insured per the
 * client's site, no-cost estimates, 4.9 from 42 reviews, owner Garrett Goff). No claims about past work in any neighborhood.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.php';

$area         = apArea('rio-rancho');
$town         = $area['name'];
$pageTitle    = 'Electrician in Rio Rancho, NM | Goff Electric | Open 24/7';
$pageDescription = 'Goff Electric is a Rio Rancho electrician based in 87124: panel upgrades, EV chargers, hot tub circuits, lighting and 24/7 emergency calls. Get a free estimate.';
$canonicalUrl = $siteUrl . '/service-areas/rio-rancho/';
$currentPage  = 'areas';
$pageType     = 'city';
$citySlug     = 'rio-rancho';
$heroFormTitle   = 'Free estimate in Rio Rancho';
$heroFormTagline = 'Tell us the job and your neighborhood. Garrett will call you back.';

$heroImage   = 'gbp-06-at_work';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$ogImage     = '/assets/images/' . $heroImage . '-960.webp';
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Service Areas', 'url' => '/service-areas/'],
    ['name' => $town, 'url' => '/service-areas/rio-rancho/'],
];
$schemaMarkup = apSchema(
    ['name' => $town, 'county' => 'Sandoval', 'sameAs' => ['https://en.wikipedia.org/wiki/Rio_Rancho,_New_Mexico', 'https://www.rrnm.gov/']],
    $canonicalUrl, $pageTitle, $pageDescription, $crumbs, $ogImage
);

/* FAQs — visible text only (never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Who issues electrical permits in Rio Rancho?',
        'a' => 'Inside Rio Rancho city limits, electrical permits and inspections come from the City of Rio Rancho Building Division, part of Development Services, which enforces the 2020 National Electrical Code. The unincorporated Rio Rancho Estates is different: after Sandoval County zoning sign-off, permits go through the state Construction Industries Division. Ask Goff Electric which applies to your address at the estimate.',
    ],
    [
        'q' => 'Is the power out, or is it just my house?',
        'a' => 'If neighbors are dark too, the outage is on PNM\'s side, and PNM is who to call. If only your house, or only part of it, has lost power, the problem is usually at your panel, a breaker or your service wiring, and that is a job for an electrician. Goff Electric answers ' . '<a href="tel:' . esc($phoneRaw) . '">' . esc($phoneText) . '</a>' . ' around the clock.',
    ],
    [
        'q' => 'Can Goff Electric work on a lot in the Rio Rancho Estates?',
        'a' => 'Yes. Estates jobs are planned around what is actually at the lot: how far the nearest PNM line is, whether there is a well pump to feed, and the distance from the meter to the house or shop. Those distances set the wire size and the trenching, so they are measured at the estimate visit before a price is given.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<?php echo apStyles(); ?>
<style>
/* ==========================================================================
   Rio Rancho — page composition. Tokens only.
   ========================================================================== */
.hero--rr { --sp-hero-pos: 50% 55%; }
.hero--rr .hero-chips li:first-child { border-color: color-mix(in srgb, var(--color-accent) 60%, transparent); }

/* Local story on paper, slanted over the hero */
.rr-local { background: var(--color-paper); }
.rr-local .sp-head { max-width: 60ch; }
.rr-growth { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-sm); margin: var(--space-lg) 0 0; padding: 0; list-style: none; }
.rr-growth li { display: grid; gap: var(--space-1); padding: var(--space-md); border-radius: var(--radius); background: var(--color-dark); color: color-mix(in srgb, var(--color-white) 78%, transparent); font-size: var(--fs-small); }
.rr-growth b { font-family: var(--font-accent); font-size: clamp(1.6rem, 1.2rem + 1.4vw, 2.3rem); line-height: 1; color: var(--color-accent); letter-spacing: .01em; }
@media (max-width: 560px) { .rr-growth { grid-template-columns: 1fr; } }

/* Conditions bento on paper-2 */
.rr-conditions { background: var(--color-paper-2); }
.rr-conditions .sp-sign--lead { background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-primary) 100%); }

/* City vs Estates table */
.rr-split { background: var(--color-surface); }
.rr-split__grid { display: grid; grid-template-columns: minmax(0, .85fr) minmax(0, 1.6fr); gap: var(--space-xl) var(--space-3xl); align-items: start; }
.rr-split .sp-table td:nth-child(2) { background: color-mix(in srgb, var(--color-accent) 7%, var(--color-surface)); }
@media (max-width: 1000px) { .rr-split__grid { grid-template-columns: 1fr; } }

/* Neighborhood chips */
.rr-hoods { list-style: none; margin: var(--space-lg) 0 0; padding: 0; display: flex; flex-wrap: wrap; gap: var(--space-xs); }
.rr-hoods li { padding: var(--space-xs) var(--space-md); border-radius: var(--radius-full); border: 1px solid var(--color-line); background: var(--color-paper); font-family: var(--font-heading); font-size: 1.05rem; text-transform: uppercase; letter-spacing: .03em; color: var(--color-ink); }
.rr-hoods li small { font-family: var(--font-body); text-transform: none; letter-spacing: 0; color: var(--color-muted); font-size: var(--font-size-xs); margin-left: var(--space-1); }

/* Services + expert + faq rhythm */
.rr-services { background: var(--color-paper); }
.rr-expert .stat-watermark { top: auto; bottom: -1.5rem; right: var(--space-xl); color: var(--color-accent); }
.rr-faq { background: var(--color-paper-2); }
.rr-nearby { background: var(--color-surface); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--area hero--rr" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'New electrical equipment and conduit mounted beside a home electric meter on a stucco wall, with an open trench along the foundation', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Home base · Sandoval County</span>
        <h1 class="hero-title" id="hero-title">Electrician in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric is Rio Rancho's own electrician, answering the phone day and night.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('map-pin', 16); ?>Based in Rio Rancho</li>
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
  <section class="section rr-local slant-top" aria-labelledby="local-title">
    <div class="container ap-local__grid">
      <div>
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Rio Rancho, up close</span>
          <h2 id="local-title">What makes electrical work in Rio Rancho different from older cities?</h2>
          <p class="answer-block">Electrical work in Rio Rancho is mostly about capacity, not decay. Most Rio Rancho homes went up after the city incorporated in 1981, so the usual job is fitting a hot tub, an EV charger or more cooling onto a panel that was sized for a smaller house.</p>
        </div>
        <div class="ap-prose reveal-up">
          <p>Goff Electric is a licensed and insured New Mexico electrical contractor based in Rio Rancho, ZIP 87124, serving the rest of Sandoval and Bernalillo counties from here. Rio Rancho is the home town, and the city's own history explains much of the work. AMREP bought 55,000 acres of mesa in 1961 and sold lots by mail order for the next sixteen years, but few houses were built in the 1960s. The city had about 10,000 residents when it incorporated in 1981, about 51,800 in 2001 and 104,046 at the 2020 census.</p>
          <p>That growth curve means the typical Rio Rancho house is decades younger than its counterpart in Albuquerque's Northeast Heights. What changes is how it is used. A panel that carried a 1990s or 2000s house comfortably now has to share with refrigerated air, a hot tub on the patio and, more and more, a car charging in the garage overnight. Goff Electric starts those jobs with a load calculation on your existing panel rather than adding a breaker and hoping.</p>
          <p>The city also stretches a long way. From Enchanted Hills and Northern Meadows in the north to Cabezon, Mariposa and the newer streets around City Centre and UNM Sandoval Regional Medical Center, a Rio Rancho call can mean a stucco house on a city lot, a shop on a larger parcel, or a bare lot in the unincorporated Rio Rancho Estates where the first question is how far away the nearest PNM line is. If you searched for an electrician near me in Rio Rancho, that range is the reason Goff Electric asks for your neighborhood when you call.</p>
          <p>Getting around is straightforward from a Rio Rancho base: NM 528, Unser Boulevard, Southern Boulevard and Paseo del Volcan (NM 347) out toward US 550 cover most of the city. Being based here also means an emergency call at 2 a.m. starts from inside the city, not from across the river.</p>
        </div>
        <ul class="rr-growth reveal-up" aria-label="Rio Rancho population over time">
          <li><b>1981</b>Incorporated with about 10,000 residents</li>
          <li><b>2001</b>About 51,800 residents</li>
          <li><b>104,046</b>Residents at the 2020 census</li>
        </ul>
      </div>
      <aside class="ap-glance reveal-right" aria-labelledby="glance-title">
        <h3 id="glance-title">Rio Rancho at a glance</h3>
        <?php echo apFacts([
            ['County', 'Sandoval (a small part lies in Bernalillo County)'],
            ['ZIP codes', '87124, 87144, 87174'],
            ['Elevation', 'About 5,500–5,700 ft at the city\'s reference points; higher on the western mesa'],
            ['Plant zone', 'USDA 7b (2023 map)'],
            ['Electric utility', 'PNM'],
            ['Permits', 'City Building Division inside city limits; state CID in the unincorporated Estates'],
            ['Monsoon', 'June 15 – September 30 (National Weather Service)'],
        ], 'Sources: City of Rio Rancho, U.S. Census 2020, NWS Albuquerque, USDA 2023 hardiness map.'); ?>
      </aside>
    </div>
  </section>

  <!-- ===================== CONDITIONS ===================== -->
  <section class="section rr-conditions" aria-labelledby="conditions-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Mesa conditions</span>
        <h2 id="conditions-title">How does the Rio Rancho climate affect a home's electrical system?</h2>
        <p class="answer-block">The Rio Rancho climate affects a home's electrical system in three ways: spring wind drives fine sand into exterior equipment, monsoon thunderstorms bring lightning and surges, and summer cooling pushes panels to their limit. Goff Electric plans exterior work and panel sizing around all three.</p>
      </div>
      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('cloud-lightning', 32); ?>
          <h3>Monsoon lightning, June to September</h3>
          <p>The National Weather Service counts monsoon season from June 15 to September 30 and names lightning one of New Mexico's leading weather killers. Nearby strikes send surges down service lines, which is why whole-home surge protection at the panel is worth asking about on the mesa.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('wind', 26); ?>
          <h3>Wind and blowing sand</h3>
          <p>April and May are the windiest months, and Rio Rancho's soils are fine sandy loams formed from wind-blown sand. Exterior disconnects, outlets and fixtures need covers that close and gaskets that seal.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('sun', 26); ?>
          <h3>Summer cooling loads</h3>
          <p>Refrigerated air running all afternoon is the biggest draw on most panels in July. Add a hot tub or a charger and the load calculation decides whether the panel can carry it.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== SERVICES ===================== -->
  <section class="section rr-services ap-services edge-curve-top" aria-labelledby="services-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="services-title">Which electrical services does Goff Electric offer in <span class="text-accent">Rio Rancho</span>?</h2>
        <p class="answer-block">Goff Electric offers all ten of its electrical services in Rio Rancho, for houses and commercial buildings. The three below are the ones the city's newer, bigger-load homes call for most: home circuits such as hot tub hookups, Level 2 EV charger installs, and panel upgrades when the existing panel runs out of room.</p>
      </div>
      <?php echo apServices(
          ['residential-electrical', 'ev-charger-installation', 'electrical-panel-upgrades-repair'],
          [
              'residential-electrical'           => 'Hot tub and swim spa circuits, new outlets and repairs for Rio Rancho houses old and new.',
              'ev-charger-installation'          => 'A dedicated 240-volt circuit for drivers commuting from Rio Rancho into Albuquerque, sized by a load calculation.',
              'electrical-panel-upgrades-repair' => 'More breaker space and capacity when cooling, a hot tub and a charger outgrow the original panel.',
          ],
          $town
      ); ?>
    </div>
  </section>

  <!-- ===================== CITY vs ESTATES ===================== -->
  <section class="section rr-split" aria-labelledby="split-title">
    <div class="container rr-split__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow-label">City or Estates?</span>
        <h2 id="split-title">Is a Rio Rancho Estates job handled differently from one inside city limits?</h2>
        <p class="answer-block">A Rio Rancho Estates job is handled differently in two ways: the permit comes from the state Construction Industries Division instead of the City, and the lot may not have power, a well or a paved road yet. Inside city limits, the City Building Division issues the permit.</p>
        <ul class="rr-hoods" aria-label="Rio Rancho neighborhoods">
          <li>Enchanted Hills</li>
          <li>Northern Meadows</li>
          <li>Cabezon</li>
          <li>Mariposa</li>
          <li>Star Heights</li>
          <li>City Centre</li>
          <li>Rio Rancho Estates <small>unincorporated</small></li>
        </ul>
      </div>
      <div class="sp-table-wrap reveal-right">
        <table class="sp-table">
          <caption>Permit routes per the City of Rio Rancho Building Division and Sandoval County. Confirm your address before work starts.</caption>
          <thead>
            <tr><th scope="col">What changes</th><th scope="col">Inside Rio Rancho city limits</th><th scope="col">Unincorporated Rio Rancho Estates</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Electrical permit</th><td>City Building Division, Development Services</td><td>State Construction Industries Division, after county zoning</td></tr>
            <tr><th scope="row">Code in force</th><td>2020 National Electrical Code</td><td>Code adopted by the state</td></tr>
            <tr><th scope="row">Power at the lot</th><td>Service already in place</td><td>Can mean extending service from the nearest PNM line</td></tr>
            <tr><th scope="row">Common first job</th><td>Panel space, hot tub or EV circuit</td><td>New service, meter base and feeders to a house, shop or well</td></tr>
            <tr><th scope="row">Access</th><td>Paved streets</td><td>Dirt roads in much of the Estates</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===================== WHY GOFF ELECTRIC ===================== -->
  <section class="section texture-grain edge-parallelogram-top rr-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <span class="stat-watermark" aria-hidden="true"><?php echo icon('house', 160); ?></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b>87124</b>
        <span>Goff Electric's home ZIP</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why hire a Rio Rancho-based electrician instead of one from across the metro?</h2>
        <p class="answer-block">Hiring a Rio Rancho-based electrician means the person giving your estimate lives with the same mesa wind, monsoon storms and permit office you do. Goff Electric is owned and run by Garrett Goff from Rio Rancho, and the phone is answered around the clock.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('users', 22); ?><div><b>The owner does the estimate</b><span>Google reviewers name Garrett on the job, from the first visit through the finished circuit.</span></div></li>
          <li><?php echo icon('gauge', 22); ?><div><b>Load calculation before new circuits</b><span>Hot tubs, chargers and added cooling are checked against what your panel can carry before a breaker is chosen.</span></div></li>
          <li><?php echo icon('shield-check', 22); ?><div><b>Licensed and insured</b><span>A New Mexico licensed and insured electrical contractor, with the scope and price given before any work starts.</span></div></li>
          <li><?php echo icon('star', 22); ?><div><b><?php echo esc(number_format((float) $gbpRating, 1)); ?> stars from <?php echo (int) $gbpReviewCount; ?> Google reviews</b><span><a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read them on Google</a>, word for word.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq rr-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do Rio Rancho homeowners ask before calling an electrician?</h2>
        <p class="answer-block">Rio Rancho homeowners usually ask who issues the permit, whether an outage is PNM's problem or theirs, and whether Goff Electric works out in the Estates. Here are straight answers; for anything else, call Goff Electric at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</p>
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
  <section class="section section--tight rr-nearby" aria-labelledby="nearby-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Also served</span>
        <h2 id="nearby-title">Which towns near Rio Rancho does Goff Electric also serve?</h2>
        <p class="answer-block">From its Rio Rancho base, Goff Electric also serves Albuquerque across the river, Corrales and Bernalillo along the Rio Grande valley, Placitas in the Sandia foothills, and Tijeras in the East Mountains, with the same phone line in every town.</p>
      </div>
      <?php echo apNearby('rio-rancho', ['albuquerque' => 'Bernalillo County', 'corrales' => 'Next door, below the mesa', 'bernalillo' => 'Sandoval County seat', 'placitas' => 'Sandia foothills', 'tijeras' => 'East Mountains']); ?>
      <p class="last-updated">Last Updated: <?php echo date('F Y'); ?></p>
    </div>
  </section>

</article>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('zap', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Rio Rancho, day or night</span>
      <h2 id="final-title">Get a free estimate in Rio Rancho</h2>
      <p>Tell Goff Electric the job and the neighborhood. You get the scope and the price before any work starts, and the phone is answered day and night if it cannot wait.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request my estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
