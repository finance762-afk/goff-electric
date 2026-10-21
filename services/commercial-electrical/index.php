<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/commercial-electrical/ — Goff Electric (Phase 4, 2026-10-21). Premium editorial service page.
 * Sources: build-plan.json + config.php (residential + commercial, offices/storefronts/commercial buildings, 24/7,
 * free estimates, licensed & insured, 4.9 from 42 reviews, six towns), research-brief FAQs (licensing, permits),
 * Google reviews feed (45-year construction veteran on his job site, a client who sends him statewide and refers
 * her clients, "home or business"), job photos (electrical room, transformer, EMT, panelboard, atrium lighting, trench).
 * Not supplied by intake (left out, listed in /content-confirmations.json): building types/clients served, after-hours
 * scheduling, three-phase/service sizes handled, license classification, prices, permit handling.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('commercial-electrical');
$pageTitle    = 'Commercial Electrical Rio Rancho NM | Goff Electric';
$pageDescription = 'Commercial electrician for Rio Rancho and Albuquerque businesses: electrical rooms, panels, conduit, feeders and lighting by Goff Electric. Get a free estimate.';
$canonicalUrl = $siteUrl . '/services/commercial-electrical/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = 'commercial-electrical';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTagline = 'Tell us the building, the town and what the space needs.';

$heroImage   = 'gbp-01-additional';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/commercial-electrical/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/' . $heroImage . '-960.webp');

/* Recent work strip — three commercial photos from the manifest; captions say only what the photo shows */
$comGallery = [
    ['img' => 'gbp-03-additional', 'alt' => 'Bank of parallel EMT conduit runs dropping down a wall into a wireway between electrical panels', 'cap' => 'Parallel EMT runs dropping into a wireway between panels', 'sizes' => '(max-width: 700px) 92vw, 640px'],
    ['img' => 'gbp-08-at_work',    'alt' => 'Open commercial panelboard with color-coded conductors landed on the breakers', 'cap' => 'Panelboard terminations, conductors color-coded and dressed', 'sizes' => '(max-width: 700px) 92vw, 460px'],
    ['img' => 'gbp-09-at_work',    'alt' => 'Ring pendant lights and recessed downlights in a two-story commercial atrium with a staircase', 'cap' => 'Ring pendants and downlights in a two-story atrium', 'sizes' => '(max-width: 700px) 92vw, 460px'],
];

/* FAQs — research-brief questions only (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Is Goff Electric licensed and insured for commercial electrical work?',
        'a' => 'Yes. Goff Electric is a licensed and insured New Mexico electrical contractor. Electrical contractors in New Mexico hold licenses issued by the state Construction Industries Division (CID), and a property manager or general contractor can look up any license there before awarding the work.',
    ],
    [
        'q' => 'Does commercial electrical work in Albuquerque or Rio Rancho need a permit?',
        'a' => 'Almost always. New service, panels, feeders and tenant build-out wiring are permitted and inspected work. Inside city limits the City of Albuquerque or the City of Rio Rancho handles it, and outside them the state Construction Industries Division generally does, so confirm the process for your address when you request an estimate.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Commercial electrical — page composition. Tokens only.
   ========================================================================== */
.hero--com { --sp-hero-pos: 50% 55%; }

/* Problem: paper band, slant over the hero; pull quote spans the head row */
.com-signs { background: var(--color-paper); }
.com-signs__head { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: var(--space-xl) var(--space-3xl); align-items: center; }
.com-signs .sp-pull { border-left: 0; padding-left: 0; padding-top: var(--space-md); border-top: 4px solid var(--color-accent); }
.com-signs .sp-sign--lead { background: var(--color-primary); }
@media (max-width: 900px) { .com-signs__head { grid-template-columns: 1fr; } }

/* Recent work: dark band, parallelogram edge */
.com-gallery .sp-head { max-width: 62ch; }
.com-gallery .sp-gallery-grid { min-height: 520px; }
.com-gallery .sp-gallery-item { box-shadow: var(--shadow-lg); border: 1px solid color-mix(in srgb, var(--color-white) 10%, transparent); }
.com-gallery .sp-gallery-item:first-child figcaption { font-size: var(--fs-body); }

/* What's included: white band, photo with amber offset frame */
.com-included { background: var(--color-surface); }
.com-included .sp-photo { box-shadow: var(--space-sm) var(--space-sm) 0 var(--color-accent); }
.com-included .sp-included li + li { padding-top: var(--space-sm); border-top: 1px solid var(--color-line); }

/* Expert: alt band, figure + paragraph */
.com-expert { background: var(--color-paper-2); }
.com-expert .sp-figure b { color: var(--color-primary); }

/* Process, proof, compare, FAQ rhythm */
.com-process { background: var(--color-paper); }
.com-process .sp-steps li::before { background: var(--color-accent); color: var(--color-ink); }
.com-proof .sp-review { border-top: 4px solid var(--color-accent); }
.com-compare { background: var(--color-surface); }
.com-compare .sp-table td:last-child { font-style: italic; }
.com-faq { background: var(--color-paper); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--com" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Commercial electrical room with new panels, a dry-type transformer, EMT conduit runs and spools of wire', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Businesses · Rio Rancho &amp; Albuquerque</span>
        <h1 class="hero-title" id="hero-title">Commercial electrical work in <span class="text-accent">Rio Rancho</span> &amp; Albuquerque</h1>
        <p class="hero-answer">Goff Electric wires electrical rooms, panels, conduit and lighting for businesses.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('building-2', 16); ?>Home + business work</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('clock', 16); ?>Phone answered any hour</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== PROBLEM ===================== -->
  <section class="section com-signs slant-top" aria-labelledby="signs-title">
    <div class="container">
      <div class="com-signs__head">
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">For businesses</span>
          <h2 id="signs-title">When does a commercial building in Albuquerque need an electrical contractor?</h2>
          <p class="answer-block">A commercial building needs Goff Electric whenever the space or the load changes: a tenant moves in, new equipment arrives, or the existing panels start tripping and running warm. Offices, storefronts and shop buildings across Albuquerque and Rio Rancho all hit those points eventually.</p>
        </div>
        <p class="sp-pull reveal-right">Downtime costs more than the wire. Plan the electrical early.</p>
      </div>
      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('building-2', 32); ?>
          <h3>A build-out or new tenant</h3>
          <p>New walls, new layouts and new equipment mean new circuits, receptacles and lighting, laid out before the drywall closes.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('zap', 26); ?>
          <h3>Equipment that needs more power</h3>
          <p>Compressors, ovens, kilns or a server closet can outgrow the original panel and feeders.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('gauge', 26); ?>
          <h3>Panels that trip or run hot</h3>
          <p>Repeated trips on a working floor point to overloaded circuits or failing breakers.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== RECENT WORK STRIP ===================== -->
  <section class="section sp-gallery texture-grain edge-parallelogram-top com-gallery" aria-labelledby="gallery-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="section-title sp-head reveal-up">
        <span class="eyebrow-label">Recent Work</span>
        <h2 id="gallery-title">What commercial electrical work has Goff Electric built recently?</h2>
        <p class="answer-block">Goff Electric's recent commercial work includes conduit banks feeding a wireway between panels, panelboard terminations with conductors color-coded and dressed, and pendant and recessed lighting in a two-story atrium. These are the company's own job photos, not stock images.</p>
      </div>
      <div class="sp-gallery-grid" data-p1-dynamic>
<?php foreach ($comGallery as $comItem): ?>
        <figure class="sp-gallery-item reveal-scale">
          <?php echo responsivePicture($comItem['img'], $comItem['alt'], $comItem['sizes']); ?>
          <figcaption><?php echo esc($comItem['cap']); ?></figcaption>
        </figure>
<?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===================== WHAT'S INCLUDED ===================== -->
  <section class="section com-included" aria-labelledby="included-title">
    <div class="container sp-split">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Scope of work</span>
          <h2 id="included-title">What does Goff Electric's commercial electrical service cover?</h2>
          <p class="answer-block">Goff Electric's commercial electrical service covers the power side of a building from the electrical room out: panels and transformers, EMT conduit and feeders, tenant receptacles and circuits, and interior and exterior lighting. It also covers repairs when something on a working floor fails.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Electrical rooms.</b> Panelboards, a dry-type transformer of the kind that steps building voltage down for receptacles and lighting, and the wireways between them.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>EMT conduit and feeders.</b> Exposed runs set straight and parallel, like the conduit bank in the photos.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Underground runs.</b> Trenching across a lot to a detached steel building or shop, with the feeder in conduit below grade.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Tenant power.</b> Receptacles and dedicated circuits laid out for desks, counters and equipment.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Lighting.</b> <?php echo serviceLink('lighting-installation', 'Commercial pendant and recessed lighting'); ?>, from a lobby to a two-story atrium.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Panels and repairs.</b> <?php echo serviceLink('electrical-panel-upgrades-repair', 'Panel replacements and breaker repair'); ?> when a space outgrows what it has.</span></li>
        </ul>
      </div>
      <figure class="sp-photo sp-photo--tall reveal-right">
        <?php echo responsivePicture('gbp-04-additional', 'Mini excavator trench across a gravel lot toward a steel outbuilding for an underground electrical run', '(max-width: 900px) 90vw, 440px'); ?>
        <figcaption>Trenching across a lot toward a steel building for an underground run</figcaption>
      </figure>
    </div>
  </section>

  <!-- ===================== EXPERT POSITIONING ===================== -->
  <section class="section com-expert edge-curve-top" aria-labelledby="expert-title">
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b>Home + Biz</b>
        <span>Residential and commercial, one contractor</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why do contractors and business owners bring Goff Electric onto commercial jobs?</h2>
        <p class="answer-block">Contractors and business owners bring Goff Electric onto commercial jobs because owner Garrett Goff does professional work on a shared job site and gets the call for the next project. Their Google reviews say so in their own words, including one from a 45-year construction veteran.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('hard-hat', 22); ?><div><b>Trusted by the trades</b><span>A reviewer with over 45 years in the construction industry wrote that Garrett did a professional job on his job site and would be his call for the next project.</span></div></li>
          <li><?php echo icon('map', 22); ?><div><b>Statewide when you need it</b><span>One long-time customer wrote that he has travelled all over New Mexico to do jobs for her, and that she sends her own clients to him.</span></div></li>
          <li><?php echo icon('clock', 22); ?><div><b>A phone that answers after close</b><span>When a circuit fails at 9 p.m. on a Friday, the Goff Electric line is answered, so a business is not waiting for Monday.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== PROCESS (sticky storytelling) ===================== -->
  <section class="section com-process" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does a commercial electrical project with Goff Electric work?</h2>
        <p class="answer-block">A commercial electrical project with Goff Electric moves from a walk of the space to a no-cost estimate, then installation alongside the other trades, and ends with every circuit energized, tested and identified at the panel. Bring drawings if you have them; a description of the space works too.</p>
        <p><a class="btn btn-secondary" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 16); ?>Call <?php echo esc($phoneText); ?></a></p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Walk the space</h3><p>The building, the town, the equipment going in and the layout. Plans or a tenant drawing speed this up.</p></li>
        <li class="reveal-up"><h3>Load and layout at the estimate</h3><p>Garrett looks at the existing service and panels and prices the conduit, feeders, circuits and fixtures the space needs, at no cost.</p></li>
        <li class="reveal-up"><h3>Install on the job site</h3><p>Panels set, conduit run, wire pulled and terminated, working around the general contractor and the other trades.</p></li>
        <li class="reveal-up"><h3>Energize and label</h3><p>Circuits are powered and tested, and each one is identified on the panel directory before the space is handed over.</p></li>
      </ol>
    </div>
  </section>

<?php $spProof = spReviews('job site|clients|construction|travell?ed|home or business', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF: matched Google reviews ===================== -->
  <section class="section texture-grain slant-top com-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do builders and business customers say about Goff Electric?</h2>
        <p class="answer-block">Builders and business customers say Goff Electric is dependable, competent and professional on a job site, and one has used the company for years. These Google reviews mention job sites, clients or business work, shown word for word.</p>
      </div>
      <?php echo $spProof; ?>
      <div class="sp-proof-foot">
        <a class="btn btn-outline-white" href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read all <?php echo (int) $gbpReviewCount; ?> Google reviews <?php echo icon('external-link', 16); ?></a>
        <p><?php echo esc(number_format((float) $gbpRating, 1)); ?> stars on Google from <?php echo (int) $gbpReviewCount; ?> reviews.</p>
      </div>
    </div>
  </section>
<?php endif; ?>

  <!-- ===================== COMPARISON ===================== -->
  <section class="section com-compare edge-curve-top" aria-labelledby="compare-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Before you award the work</span>
        <h2 id="compare-title">What should a business check before hiring a commercial electrician?</h2>
        <p class="answer-block">A business should check a commercial electrician's state license, insurance, comparable work and after-hours availability before awarding a job. The table shows where Goff Electric stands on each, next to the question worth asking every bidder in Albuquerque or Rio Rancho.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <thead>
            <tr><th scope="col">What to check</th><th scope="col" class="is-us">Goff Electric</th><th scope="col">Ask every bidder</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">State license</th><td class="is-us">New Mexico electrical contractor license through CID</td><td>"What is your CID license number?"</td></tr>
            <tr><th scope="row">Insurance</th><td class="is-us">Carries insurance; ask for the details at the estimate</td><td>"Can you send a certificate of insurance before you start?"</td></tr>
            <tr><th scope="row">Comparable work</th><td class="is-us">Electrical rooms, conduit banks, panelboards and atrium lighting in the photos above</td><td>"Can I see photos of jobs like mine?"</td></tr>
            <tr><th scope="row">After-hours failures</th><td class="is-us">Phone answered nights and weekends</td><td>"Who picks up if power fails after close?"</td></tr>
            <tr><th scope="row">Estimate</th><td class="is-us">No cost</td><td>"Is there a charge to bid?"</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq com-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do business owners ask Goff Electric before a commercial job?</h2>
        <p class="answer-block">Business owners ask Goff Electric two things first: whether the company holds a New Mexico license, and whether the job needs a permit. Short answers are below; if you are also weighing an <?php echo serviceLink('electrical-inspections', 'electrical inspection of the building'); ?>, or want <a href="/services/">every Goff Electric service</a>, call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>.</p>
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

</article>

<?php echo spRelated(
    ['electrical-panel-upgrades-repair', 'lighting-installation', 'electrical-inspections'],
    'What other electrical services do <span class="text-accent">Albuquerque</span> businesses need?',
    'Albuquerque and Rio Rancho businesses most often add a panel upgrade when new equipment outgrows the service, new interior or exterior lighting during a remodel, and an electrical inspection when buying, leasing or reopening a building. Each service has its own page with the details.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final com-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('building-2', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Opening, expanding or fixing?</span>
      <h2 id="final-title">Ready to price the electrical for your building?</h2>
      <p>Send the address, the town and what the space needs. Goff Electric will walk it and give you the scope and the number before any work starts.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
