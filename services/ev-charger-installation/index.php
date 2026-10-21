<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/ev-charger-installation/ — Goff Electric (Phase 4, 2026-10-21). Premium editorial service page.
 * Sources: build-plan.json + config.php (Level 2, load calculation, dedicated circuit, 24/7, free estimates, licensed &
 * insured, 4.9 from 42 reviews, PNM coordination per the homepage FAQ), Google reviews feed (EV installs in Albuquerque),
 * U.S. DOE Alternative Fuels Data Center for Level 1 / Level 2 charging rates (general, not a client claim).
 * Not supplied by intake (left out, listed in /content-confirmations.json): price range, permit handling, brands installed.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('ev-charger-installation');
$pageTitle    = 'EV Charger Installation Rio Rancho NM | Goff Electric';
$pageDescription = 'Level 2 EV charger installation in Rio Rancho and Albuquerque, NM: a load calculation on your panel, then a dedicated 240-volt circuit. Get a free estimate.';
$canonicalUrl = $siteUrl . '/services/ev-charger-installation/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = 'ev-charger-installation';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTagline = 'Tell us your vehicle, your panel size if you know it, and where you park.';

$heroImage   = 'gbp-04-additional';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/ev-charger-installation/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/' . $heroImage . '-960.webp');

/* FAQs — research-brief questions only (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Can Goff Electric install an EV charger if my panel is already full?',
        'a' => 'Often, yes, but the load calculation decides how. If the panel has the capacity but no open breaker spaces, circuits can sometimes be rearranged; if the capacity is not there, a ' . serviceLink('electrical-panel-upgrades-repair', 'panel or service upgrade') . ' comes first, which can mean coordinating with PNM. Either way you hear the plan and the price before work starts.',
    ],
    [
        'q' => 'Do I need a permit to install an EV charger in Rio Rancho?',
        'a' => 'A new 240-volt circuit for a charger is the kind of work that normally needs an electrical permit and inspection. Rules differ between the City of Rio Rancho, the City of Albuquerque and Sandoval or Bernalillo County, so confirm with the office that covers your address, and ask Goff Electric what your install will need when you get your estimate.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   EV charger installation — page composition. Tokens only.
   ========================================================================== */
.hero--ev { --sp-hero-pos: 50% 62%; }

/* Signs band sits on paper with a slanted top over the hero */
.ev-signs { background: var(--color-paper); }
.ev-signs .sp-head { max-width: 58ch; }
.ev-signs__top { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr); gap: var(--space-xl) var(--space-3xl); align-items: end; }
.ev-signs__top .sp-pull { justify-self: end; }
@media (max-width: 900px) { .ev-signs__top { grid-template-columns: 1fr; } .ev-signs__top .sp-pull { justify-self: start; } }

/* Expert band: dark, parallelogram edge, plug watermark */
.ev-expert .stat-watermark { top: auto; bottom: -1rem; right: var(--space-xl); font-size: clamp(6rem, 12vw, 11rem); color: var(--color-accent); }
.ev-expert .sp-figure b small { font-size: .38em; letter-spacing: .04em; }

/* What's included: white band, tall photo offset against the list */
.ev-included { background: var(--color-surface); }
.ev-included .sp-photo--tall { max-width: 26rem; justify-self: end; }
.ev-included .sp-photo::before { content: ""; position: absolute; inset: 0; z-index: 1; pointer-events: none; box-shadow: inset 0 0 0 1px color-mix(in srgb, var(--color-white) 12%, transparent); border-radius: inherit; }
.ev-included .sp-photo figcaption { z-index: 2; }
.ev-note { margin: var(--space-lg) 0 0; padding: var(--space-md) var(--space-lg); border-radius: var(--radius); background: var(--color-paper-2); border-left: 4px solid var(--color-secondary); font-size: var(--fs-small); color: var(--color-ink-2); max-width: var(--measure); }

/* Level 1 vs Level 2 table: highlight the Level 2 column */
.ev-levels { background: var(--color-paper-2); }
.ev-levels .sp-table td:nth-child(3), .ev-levels .sp-table th:nth-child(3) { background: color-mix(in srgb, var(--color-accent) 9%, var(--color-surface)); color: var(--color-ink); }
.ev-levels .sp-table thead th:nth-child(3) { background: var(--color-dark); color: var(--color-accent-bright); }
.ev-levels__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.6fr); gap: var(--space-xl) var(--space-3xl); align-items: start; }
@media (max-width: 1000px) { .ev-levels__grid { grid-template-columns: 1fr; } }

/* Process + reviews + compare + FAQ rhythm */
.ev-process { background: var(--color-paper); }
.ev-proof .sp-head { max-width: 60ch; }
.ev-compare { background: var(--color-surface); }
.ev-faq { background: var(--color-paper); }
.ev-final .actions { align-items: center; }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--ev" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Mini excavator digging a trench across a gravel lot toward a steel outbuilding for an underground electrical run', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Level 2 charging · Rio Rancho &amp; Albuquerque</span>
        <h1 class="hero-title" id="hero-title">EV charger installation in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric installs Level 2 home EV chargers, sized by a load calculation first.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('gauge', 16); ?>Load calculation first</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== PROBLEM: when Level 2 is worth it ===================== -->
  <section class="section ev-signs slant-top" aria-labelledby="signs-title">
    <div class="container">
      <div class="ev-signs__top">
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Is it time?</span>
          <h2 id="signs-title">When is a Level 2 charger worth it for a Rio Rancho driver?</h2>
          <p class="answer-block">A Level 2 charger is worth it once a standard 120-volt outlet stops refilling the battery overnight. For most Rio Rancho drivers commuting into Albuquerque on NM 528 or I-25 every day, a dedicated 240-volt circuit turns an overnight top-up into a full charge.</p>
        </div>
        <p class="sp-pull reveal-right">The charger is the easy part. The panel decides the job.</p>
      </div>

      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('plug-zap', 32); ?>
          <h3>Mornings start below full</h3>
          <p>A Level 1 cord on a household outlet adds only a few miles of range per hour. Park late, leave early, and the gap shows up on the dash every morning.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('car', 26); ?>
          <h3>A second EV in the garage</h3>
          <p>Two cars sharing one slow outlet means someone always waits. A Level 2 circuit can be sized for the household's next car, not just this one.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('sun', 26); ?>
          <h3>Summer loads on an older panel</h3>
          <p>Refrigerated air, a hot tub and an electric range already draw heavily in July. A charger has to fit alongside them, which is why the load calculation comes first.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== EXPERT POSITIONING ===================== -->
  <section class="section texture-grain edge-parallelogram-top ev-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <span class="stat-watermark" aria-hidden="true"><?php echo icon('plug-zap', 160); ?></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b><?php echo esc(number_format((float) $gbpRating, 1)); ?><small> / 5</small></b>
        <span>Google rating · <a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo (int) $gbpReviewCount; ?> reviews</a></span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why do Albuquerque EV owners call Goff Electric for charger installs?</h2>
        <p class="answer-block">Albuquerque EV owners call Goff Electric because owner Garrett Goff sizes the circuit to the panel before anything is mounted. One Albuquerque customer had Goff Electric install an EV charger and then kept calling for other electrical updates and corrections.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('gauge', 22); ?><div><b>The panel is checked, not assumed</b><span>Every install starts with a load calculation on your existing service, so a charger never lands on a panel that cannot carry it.</span></div></li>
          <li><?php echo icon('users', 22); ?><div><b>The owner does the work</b><span>Google reviewers name Garrett on the job by name, from the estimate visit through the finished circuit.</span></div></li>
          <li><?php echo icon('house', 22); ?><div><b>Chargers as part of whole-home jobs</b><span>One reviewer's project combined fixtures, temporary power, a new service and an EV charger, so larger rewiring and a charger can be planned together.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== WHAT'S INCLUDED ===================== -->
  <section class="section ev-included" aria-labelledby="included-title">
    <div class="container sp-split">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Scope of work</span>
          <h2 id="included-title">What does a Goff Electric EV charger installation include?</h2>
          <p class="answer-block">A Goff Electric EV charger installation includes the load calculation, a dedicated 240-volt circuit from your panel to the parking spot, the breaker, and mounting and testing the charger. Long runs to a detached garage or shop can include an underground feeder.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Load calculation.</b> Your existing loads, from air conditioning to the range and any hot tub, are added up against the panel's rating before a breaker size is chosen.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Dedicated circuit.</b> A 240-volt circuit that serves the charger alone, sized to the charger's continuous current.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Hardwired or plug-in.</b> A wall unit wired directly, or a heavy-duty receptacle for a plug-in charger, depending on the equipment you choose.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>The route to the parking spot.</b> Through the garage wall, along the exterior in conduit, or trenched underground to a detached building, like the run in the photo.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Testing and a walkthrough.</b> The charger is powered up and tested with you before the job is closed out.</span></li>
        </ul>
        <p class="ev-note reveal-up">Already need more panel space for other projects? Pair the charger with an <?php echo serviceLink('electrical-panel-upgrades-repair', 'electrical panel upgrade'); ?> so both happen in one visit, or see <?php echo serviceLink('electrical-wiring-installation-repair', 'underground feeder and wiring work'); ?> for detached garages and shops.</p>
      </div>
      <figure class="sp-photo sp-photo--tall sp-photo--offset reveal-right">
        <?php echo responsivePicture('gbp-06-at_work', 'New electrical equipment and conduit mounted beside a home electric meter, with the conduit dropping into an open trench along the stucco wall', '(max-width: 900px) 90vw, 420px'); ?>
        <figcaption>Exterior equipment beside the meter, conduit run below grade along the wall</figcaption>
      </figure>
    </div>
  </section>

  <!-- ===================== LEVEL 1 vs LEVEL 2 ===================== -->
  <section class="section ev-levels" aria-labelledby="levels-title">
    <div class="container ev-levels__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow-label">Charging options</span>
        <h2 id="levels-title">Which is right for your home: Level 1 or Level 2 charging?</h2>
        <p class="answer-block">Level 1 charging uses an ordinary 120-volt outlet and suits short daily drives. Level 2 charging needs a dedicated 240-volt circuit and refills most batteries overnight, which is why it is the install most Rio Rancho and Albuquerque EV owners ask for.</p>
        <p class="sp-copy">Charging rates are the U.S. Department of Energy's general ranges; your car's onboard charger sets the real number.</p>
      </div>
      <div class="sp-table-wrap reveal-right">
        <table class="sp-table">
          <caption>Range-per-hour figures: U.S. Department of Energy, Alternative Fuels Data Center.</caption>
          <thead>
            <tr><th scope="col">What changes</th><th scope="col">Level 1</th><th scope="col">Level 2</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Voltage</th><td>120 volts</td><td>240 volts</td></tr>
            <tr><th scope="row">Where it plugs in</th><td>An existing household outlet</td><td>A dedicated circuit run from the panel</td></tr>
            <tr><th scope="row">Range added per hour</th><td>About 2 to 5 miles</td><td>About 10 to 20 miles</td></tr>
            <tr><th scope="row">Panel impact</th><td>Usually none</td><td>Needs a load calculation and breaker space</td></tr>
            <tr><th scope="row">Electrician needed?</th><td>Only if the outlet is faulty</td><td>Yes — new circuit and mounting</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===================== PROCESS (sticky storytelling) ===================== -->
  <section class="section ev-process" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does an EV charger install with Goff Electric work, start to finish?</h2>
        <p class="answer-block">An EV charger install with Goff Electric runs in four steps: you describe the car and the parking spot, the panel gets a load calculation at a no-cost estimate, the circuit goes in, and the charger is tested with you before close-out.</p>
        <p><a class="btn btn-secondary" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 16); ?>Call <?php echo esc($phoneText); ?></a></p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Tell us the car and the spot</h3><p>Call or use the form. The vehicle, the charger you have or want, and where you park decide the length and route of the circuit.</p></li>
        <li class="reveal-up"><h3>Load calculation at the estimate</h3><p>Garrett looks at the panel, totals what the house already draws, and tells you whether the charger fits as-is or needs a panel upgrade first. The estimate costs nothing.</p></li>
        <li class="reveal-up"><h3>Run the dedicated circuit</h3><p>Breaker, wire sized to the charger, and the route agreed at the estimate: inside the garage, in exterior conduit, or underground to an outbuilding.</p></li>
        <li class="reveal-up"><h3>Power up and walk through</h3><p>The charger is mounted or plugged in, tested on your vehicle where possible, and you see how it is protected at the panel.</p></li>
      </ol>
    </div>
  </section>

<?php $spProof = spReviews('\bEV\b|electric vehicle|charger', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF: matched Google reviews ===================== -->
  <section class="section texture-grain slant-top ev-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do Goff Electric EV charger customers say?</h2>
        <p class="answer-block">Goff Electric EV charger customers describe an electrician who is quick to respond and honest about the work, and say Goff Electric is who they will call for the next electrical job too. These reviews mention an EV charger, word for word from Google.</p>
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
  <section class="section ev-compare edge-curve-top" aria-labelledby="compare-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Before you hire</span>
        <h2 id="compare-title">How is a load-calculated charger install different from just adding a breaker?</h2>
        <p class="answer-block">A load-calculated charger install sizes the circuit to what your panel can actually carry, while simply adding a breaker assumes there is capacity. On a panel that already serves summer cooling, a range and a hot tub, that assumption is how breakers start tripping.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <thead>
            <tr><th scope="col">Question</th><th scope="col" class="is-us">Goff Electric install</th><th scope="col">Breaker-and-go install</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Is the panel checked?</th><td class="is-us">Load calculation before the breaker size is picked</td><td>Breaker added wherever a space is open</td></tr>
            <tr><th scope="row">Who does the work?</th><td class="is-us">A New Mexico licensed, insured electrical contractor</td><td>Sometimes a handyman or the charger buyer</td></tr>
            <tr><th scope="row">What if the panel is short?</th><td class="is-us">You are told before work starts and given the upgrade path</td><td>Found out later, when breakers trip</td></tr>
            <tr><th scope="row">What does the estimate cost?</th><td class="is-us">Nothing</td><td>Varies</td></tr>
            <tr><th scope="row">Problem at 10 p.m.?</th><td class="is-us">The Goff Electric phone is answered around the clock</td><td>Wait for office hours</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq ev-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do customers ask before an EV charger install?</h2>
        <p class="answer-block">Customers usually ask two things before an EV charger install: whether their panel can take it, and whether the job needs a permit. Here are straight answers, and for anything else call Goff Electric at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>, or browse <a href="/services/">every Goff Electric service</a>.</p>
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
    ['electrical-panel-upgrades-repair', 'electrical-wiring-installation-repair', 'residential-electrical'],
    'What other electrical work do EV owners in <span class="text-accent">Rio Rancho</span> pair with a charger?',
    'EV owners in Rio Rancho most often pair a charger with a panel upgrade when the load calculation comes up short, with new wiring or an underground feeder for a detached garage, and with other home circuits being added at the same visit.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final ev-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('plug-zap', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">New EV in the driveway?</span>
      <h2 id="final-title">Ready to charge at home in Rio Rancho or Albuquerque?</h2>
      <p>Send the car, the panel size if you know it, and where you park. Goff Electric will run the load calculation and give you the scope and price at no cost.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
