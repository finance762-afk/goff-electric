<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/residential-electrical/ — Goff Electric (Phase 4, 2026-10-21). Premium editorial service page.
 * Sources: build-plan.json + config.php (residential + commercial, 24/7, free estimates, licensed & insured, 4.9 from
 * 42 reviews, six towns, owner Garrett Goff), research-brief FAQs (permits, surge protection), Google reviews feed
 * (hot tub / swim spa / jacuzzi hookups, kitchen-bath-outside plugs, patio outlet, crew member Rick, Corrales couple
 * told no work was needed). Code items are general NEC requirements, phrased "under the code New Mexico has adopted".
 * Not supplied by intake (left out, listed in /content-confirmations.json): prices, hot tubs as a listed service,
 * permit handling, crew size, surge-protector installs.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('residential-electrical');
$pageTitle    = 'Residential Electrical Rio Rancho NM | Goff Electric';
$pageDescription = 'Home electrician in Rio Rancho and Albuquerque, NM: hot tub circuits, kitchen and bath outlets, new circuits and repairs by Goff Electric. Get a free estimate.';
$canonicalUrl = $siteUrl . '/services/residential-electrical/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = 'residential-electrical';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTagline = 'Say what is going on at the house, or what you are adding, and the town.';

$heroImage   = 'gbp-06-at_work';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/residential-electrical/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/' . $heroImage . '-960.webp');

/* FAQs — research-brief questions only (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Do I need a permit for electrical work on my Rio Rancho house?',
        'a' => 'Usually, if the work adds a circuit, changes wiring or replaces the panel. A hot tub feed or a new kitchen circuit falls in that group; swapping a like-for-like fixture often does not. The City of Rio Rancho, the City of Albuquerque and the two counties each set their own process, so check with the office for your address and ask Goff Electric what your job will need.',
    ],
    [
        'q' => 'Should a Rio Rancho home have whole-house surge protection?',
        'a' => 'It is worth considering here. Summer monsoon storms bring frequent lightning to Sandoval and Bernalillo counties, and a surge protective device at the panel helps shield refrigerated air units, appliances and electronics. Ask about it during the estimate visit and Goff Electric can look at your panel and say what fits.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Residential electrical — page composition. Tokens only.
   ========================================================================== */
.hero--res { --sp-hero-pos: 50% 40%; }

/* Signs: paper band, slant over the hero, quote set beside the bento */
.res-signs { background: var(--color-paper); }
.res-signs__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.5fr); gap: var(--space-xl) var(--space-3xl); align-items: start; }
.res-signs__grid .sp-signs { margin-top: 0; }
.res-signs .sp-pull { margin-top: var(--space-xl); font-size: clamp(1.3rem, 1rem + 1.4vw, 1.9rem); }
.res-signs .sp-sign--lead { min-height: 13rem; }
@media (max-width: 1000px) { .res-signs__grid { grid-template-columns: 1fr; } }

/* What's included: white band, staggered photo pair on the left */
.res-included { background: var(--color-surface); }
.res-included .sp-photos .sp-photo { aspect-ratio: 3 / 4; }
.res-included .sp-photos .sp-photo:nth-child(2) { aspect-ratio: 4 / 3; align-self: end; }
.res-included .sp-included li { padding-bottom: var(--space-sm); border-bottom: 1px dashed var(--color-line); }

/* Home jobs table: alt band, first column dark-ink labels with an amber rule */
.res-jobs { background: var(--color-paper-2); }
.res-jobs .sp-table tbody th { border-left: 4px solid var(--color-accent); }
.res-jobs .sp-table td:last-child { color: var(--color-ink); font-weight: 500; }

/* Proof: dark torn band */
.res-proof.edge-torn-top { margin-top: -18px; z-index: 1; }
.res-proof .sp-review:first-child { transform: rotate(-.6deg); }
.res-proof .sp-review:last-child { transform: rotate(.5deg); }

/* Expert: light variant, figure set in a dark tile */
.res-expert { background: var(--color-surface); }
.res-expert .sp-figure { padding: var(--space-xl); border-top: 0; border-left: 4px solid var(--color-accent); border-radius: var(--radius-lg); background: var(--color-dark); }
.res-expert .sp-figure b { color: var(--color-white); }
.res-expert .sp-figure span { color: var(--color-accent-bright); }

/* Process, compare, FAQ rhythm */
.res-process { background: var(--color-paper); }
.res-process .sp-steps li:nth-child(even) { margin-left: var(--space-xl); }
.res-compare { background: var(--color-paper-2); }
.res-faq { background: var(--color-surface); }
@media (max-width: 900px) { .res-process .sp-steps li:nth-child(even) { margin-left: 0; } .res-proof .sp-review { transform: none !important; } }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--res" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Gray electrical equipment and conduit mounted beside the electric meter on a stucco house wall, with an open trench along the foundation', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Home electrical · Rio Rancho &amp; Albuquerque</span>
        <h1 class="hero-title" id="hero-title">Residential electrical work in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric handles home repairs, new circuits and hot tub power across the metro.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('house', 16); ?>Homes in 6 towns</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== PROBLEM: warning signs ===================== -->
  <section class="section res-signs slant-top" aria-labelledby="signs-title">
    <div class="container res-signs__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow-label">At the house</span>
        <h2 id="signs-title">When does a Rio Rancho home need an electrician instead of a reset?</h2>
        <p class="answer-block">A Rio Rancho home needs Goff Electric when a problem comes back after you reset it: a breaker that trips again, lights that dim when the refrigerated air kicks on, or an outlet that feels warm. Each points to an overload or a loose connection, and those start fires.</p>
        <p class="sp-pull">Sometimes the honest answer is that the house is fine.</p>
      </div>
      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('alert-triangle', 32); ?>
          <h3>Burning smell or a buzzing panel</h3>
          <p>Stop using the circuit and call. Heat at a breaker or a connection is the warning that matters most, at any hour.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('gauge', 26); ?>
          <h3>Breakers that trip again</h3>
          <p>A breaker that will not stay on in July is often a circuit carrying more than it was sized for.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('plug', 26); ?>
          <h3>Warm or discolored outlets</h3>
          <p>Scorch marks or a cover plate that feels warm mean a failing device or a loose wire behind it.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== WHAT'S INCLUDED ===================== -->
  <section class="section res-included" aria-labelledby="included-title">
    <div class="container sp-split sp-split--flip">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Scope of work</span>
          <h2 id="included-title">What residential electrical work does Goff Electric do?</h2>
          <p class="answer-block">Goff Electric does residential electrical work from single dead outlets to whole-house projects: troubleshooting, new circuits, hot tub and swim spa power, kitchen, bath and patio receptacles, lighting and remodel wiring. Homes in Rio Rancho, Albuquerque, Corrales, Bernalillo, Placitas and Tijeras all reach the same phone line, at any hour.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Hot tubs, swim spas and jacuzzis.</b> The 240-volt feed, the disconnect and the hookup, timed so power is ready when the tub arrives. One Google reviewer needed a swim spa powered on short notice and wrote that Goff Electric came the same day, with no upcharge for the late call.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Plugs room by room.</b> Bedroom, bathroom, kitchen and outside receptacles repaired, replaced or added, with <?php echo serviceLink('outlets-switches', 'GFCI protection and outlet repair'); ?> where the code calls for it.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>New and dedicated circuits.</b> For a shop tool, a freezer in the garage or an appliance that keeps tripping a shared breaker.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Lighting inside and out.</b> Pendants over a kitchen half-wall, like the job in the photo, plus recessed cans and patio lights. See <?php echo serviceLink('lighting-installation', 'pendant and recessed lighting installs'); ?>.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Troubleshooting.</b> Dead circuits, flicker and nuisance trips traced to the cause instead of guessed at.</span></li>
        </ul>
      </div>
      <div class="sp-photos reveal-left">
        <figure class="sp-photo">
          <?php echo responsivePicture('gbp-12-additional', 'Electrician on a ladder hanging pendant lights over a kitchen half-wall, with a duplex outlet below', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 260px'); ?>
          <figcaption>Kitchen pendants going up over a half-wall</figcaption>
        </figure>
        <figure class="sp-photo">
          <?php echo responsivePicture('gbp-11-at_work', 'Living room with a ceiling fan light kit and recessed lights in a textured ceiling', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 260px'); ?>
          <figcaption>Ceiling fan and recessed lights in a living room</figcaption>
        </figure>
      </div>
    </div>
  </section>

  <!-- ===================== HOME JOBS TABLE ===================== -->
  <section class="section res-jobs" aria-labelledby="jobs-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">What the code asks for</span>
        <h2 id="jobs-title">What does each common home electrical job involve?</h2>
        <p class="answer-block">Each common home electrical job carries its own requirements: a hot tub needs a 240-volt circuit, a disconnect and ground-fault protection, while kitchen and bath receptacles need GFCI protection. The table lists what Goff Electric plans for on the jobs Rio Rancho homeowners ask about most.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <caption>General requirements under the electrical code New Mexico has adopted. Confirm specifics for your address with the City of Rio Rancho, the City of Albuquerque or your county.</caption>
          <thead>
            <tr><th scope="col">Job</th><th scope="col">What it involves</th><th scope="col">Why it matters</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Hot tub or swim spa</th><td>A 240-volt circuit from the panel, a disconnect within sight of the tub kept at least five feet away, GFCI protection</td><td>Water and electricity together; the disconnect lets service work happen safely</td></tr>
            <tr><th scope="row">Kitchen and bath outlets</th><td>GFCI protection on countertop and bathroom receptacles</td><td>Cuts power in a fraction of a second if current leaks to ground</td></tr>
            <tr><th scope="row">Patio and exterior outlets</th><td>Weather-resistant GFCI receptacles with in-use covers, often a switch for string lights</td><td>Sun, monsoon rain and dust are hard on exposed devices</td></tr>
            <tr><th scope="row">New appliance circuit</th><td>A dedicated breaker and wire sized to the appliance, checked against panel capacity</td><td>Stops nuisance trips on shared circuits</td></tr>
            <tr><th scope="row">Remodel or addition</th><td>Circuits roughed in before drywall, with arc-fault protection on most new living-area circuits</td><td>Wiring is easiest and cheapest to get right while walls are open</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

<?php $spProof = spReviews('hot tub|jacuzzi|swim spa|plugs|outlet|recessed', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF: matched Google reviews ===================== -->
  <section class="section texture-grain edge-torn-top res-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do homeowners say about Goff Electric's residential work?</h2>
        <p class="answer-block">Homeowners describe Goff Electric's residential work as professional, efficient and honest about the options, and hot tub hookups come up again and again. These are the most recent Google reviews that mention a hot tub, a spa or the outlets in a home, shown word for word.</p>
      </div>
      <?php echo $spProof; ?>
      <div class="sp-proof-foot">
        <a class="btn btn-outline-white" href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read all <?php echo (int) $gbpReviewCount; ?> Google reviews <?php echo icon('external-link', 16); ?></a>
        <p><?php echo esc(number_format((float) $gbpRating, 1)); ?> stars on Google from <?php echo (int) $gbpReviewCount; ?> reviews.</p>
      </div>
    </div>
  </section>
<?php endif; ?>

  <!-- ===================== EXPERT POSITIONING ===================== -->
  <section class="section res-expert" aria-labelledby="expert-title">
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b><?php echo count($serviceAreas); ?> towns</b>
        <span>Rio Rancho to Tijeras · Sandoval &amp; Bernalillo counties</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why do Rio Rancho homeowners keep calling Goff Electric back?</h2>
        <p class="answer-block">Rio Rancho homeowners call Goff Electric back because owner Garrett Goff explains the options and says plainly when work is not needed. Reviewers in Albuquerque and Corrales describe hiring him for one job, then calling again for the next one, and passing his name to neighbors.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('message-square', 22); ?><div><b>Options, not orders</b><span>A hot tub owner wrote that Garrett laid out choices for the power install instead of only telling him what he needed.</span></div></li>
          <li><?php echo icon('thumbs-up', 22); ?><div><b>No work sold that you don't need</b><span>A Corrales couple called to hire Goff Electric and were told the setup they already had was right, so there was nothing to buy.</span></div></li>
          <li><?php echo icon('users', 22); ?><div><b>Names you'll know</b><span>Reviews name Garrett Goff and Rick on the job, from a breaker panel upgrade to the 220 outlet for a new hot tub.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== PROCESS (sticky storytelling) ===================== -->
  <section class="section res-process" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does a home electrical job with Goff Electric run?</h2>
        <p class="answer-block">A home electrical job with Goff Electric runs in four steps: you describe the problem or the project, Garrett looks at the panel and the route at a no-cost estimate, the work is done on the date that suits your schedule or delivery, and everything is tested with you.</p>
        <p><a class="btn btn-secondary" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 16); ?>Call <?php echo esc($phoneText); ?></a></p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Describe the house and the job</h3><p>What stopped working, or what you are adding, plus the town. A tub delivery date or a remodel schedule helps plan the visit.</p></li>
        <li class="reveal-up"><h3>A look at the panel and the route</h3><p>Garrett checks breaker space and capacity, and how wire will reach the spot: through the attic, along the stucco in conduit, or in a trench like the one in the photo above.</p></li>
        <li class="reveal-up"><h3>Work done around your dates</h3><p>One reviewer's jacuzzi circuit was finished in time for the tub's arrival; for another, Garrett came back after delivery to set everything up.</p></li>
        <li class="reveal-up"><h3>Test and walk through</h3><p>Circuits are powered and tested in front of you, and you see which breaker controls what before the job is closed out.</p></li>
      </ol>
    </div>
  </section>

  <!-- ===================== COMPARISON ===================== -->
  <section class="section res-compare edge-wave-top" aria-labelledby="compare-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Before you hire</span>
        <h2 id="compare-title">Why hire an electrical contractor for a hot tub circuit instead of a handyman?</h2>
        <p class="answer-block">A hot tub circuit from Goff Electric is planned around your panel's capacity, a code-placed disconnect and ground-fault protection, while a handyman hookup often skips one of the three. New Mexico electrical contractors are licensed through the state Construction Industries Division, and you can look one up before work starts.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <thead>
            <tr><th scope="col">Question</th><th scope="col" class="is-us">Goff Electric</th><th scope="col">Unlicensed hookup</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Is the panel big enough?</th><td class="is-us">Checked first; a panel upgrade is raised before the tub arrives, not after</td><td>Found out when the breaker trips</td></tr>
            <tr><th scope="row">Disconnect and GFCI</th><td class="is-us">Placed and protected the way the code requires</td><td>Sometimes left out or mounted too close to the water</td></tr>
            <tr><th scope="row">Who is accountable?</th><td class="is-us">A New Mexico electrical contractor you can look up with CID</td><td>No license to check</td></tr>
            <tr><th scope="row">What does the estimate cost?</th><td class="is-us">Nothing</td><td>Varies</td></tr>
            <tr><th scope="row">After delivery day</th><td class="is-us">Reviewers describe Garrett returning to set the tub up</td><td>Often a one-visit job</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq res-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do homeowners ask Goff Electric before a residential job?</h2>
        <p class="answer-block">Homeowners most often ask Goff Electric whether their job needs a permit and whether surge protection makes sense in a monsoon climate. Short answers are below; for a <?php echo serviceLink('electrical-panel-upgrades-repair', 'breaker panel upgrade'); ?> or anything else, call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a> or browse <a href="/services/">all Goff Electric services</a>.</p>
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
    ['outlets-switches', 'electrical-panel-upgrades-repair', 'lighting-installation'],
    'What other services do <span class="text-accent">Rio Rancho</span> homeowners book alongside home electrical work?',
    'Rio Rancho homeowners most often pair residential electrical work with outlet and switch repairs, a panel upgrade when a hot tub or new circuit needs the room, and new lighting while an electrician is already at the house. Each has its own page with the details.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final res-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('house', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Something not right at home?</span>
      <h2 id="final-title">Need an electrician at your house in Rio Rancho or Albuquerque?</h2>
      <p>Describe the problem or the project and when you need it done. Goff Electric will tell you what it takes and what it costs before any work starts.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request an estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
