<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/electrical-wiring-installation-repair/ — Goff Electric (Phase 4, 2026-10-21). Premium editorial service page.
 * Sources: build-plan.json + config.php (new wiring, rewiring, faulty-wire repair for homes, renovations and additions;
 * 24/7; free estimates; licensed & insured; 6 service towns), research-brief FAQs (warning signs, permits), Google reviews
 * feed (a short three other electricians missed; whole-home wiring with temporary power and new service; plugs in bedroom,
 * bathroom, kitchen and outside; options explained on a power install; neighbor referral and repeat projects),
 * manifest photos (EMT conduit into a wireway, trench to a steel outbuilding, conduit trenched up to equipment at a meter).
 * The review signed "Gary Goff" shares the owner's surname and is deliberately not quoted or matched here.
 * Not supplied by intake (left out, listed in /content-confirmations.json): price ranges, permit handling, aluminum-wiring
 * or knob-and-tube work, trenching done in-house vs. subcontracted.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('electrical-wiring-installation-repair');
$pageTitle    = 'Electrical Wiring & Repair Rio Rancho NM | Goff Electric';
$pageDescription = 'Electrical wiring installation and repair in Rio Rancho and Albuquerque, NM: shorts traced, rewiring, additions and underground feeders. Free estimates.';
$canonicalUrl = $siteUrl . '/services/electrical-wiring-installation-repair/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = 'electrical-wiring-installation-repair';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTagline = 'What stopped working, or what needs power that does not have it yet?';

$heroImage   = 'gbp-03-additional';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/electrical-wiring-installation-repair/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/' . $heroImage . '-960.webp');

/* FAQs — research-brief questions only, reworded conversationally (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Which wiring problems mean I should stop and call an electrician?',
        'a' => 'Call if breakers trip often, lights flicker or dim, an outlet or switch feels warm or looks discolored, you smell burning, or the panel buzzes. Those point to overloads or failing connections that can start a fire. Switch the affected circuit off if you can do it safely and do not wait to have it checked.',
    ],
    [
        'q' => 'Does adding a circuit or rewiring a room need a permit in Rio Rancho?',
        'a' => 'Work that adds circuits or changes wiring normally needs an electrical permit and an inspection under the code New Mexico has adopted. The City of Rio Rancho, the City of Albuquerque and Sandoval and Bernalillo counties each run their own permit office, so confirm with the one for your address before the walls get closed up.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Wiring installation & repair — page composition. Tokens only.
   ========================================================================== */
.hero--wir { --sp-hero-pos: 50% 35%; }

/* Fault signs: white band slanted over the hero, lead card on the right */
.wir-signs { background: var(--color-surface); }
.wir-signs .sp-head { max-width: 60ch; }
.wir-signs .sp-signs { direction: rtl; }
.wir-signs .sp-signs > * { direction: ltr; }
.wir-signs .sp-sign:not(.sp-sign--lead) { background: var(--color-paper); }
.wir-signs .sp-pull { margin-top: var(--space-xl); max-width: 30ch; }

/* Proof comes early on this page: dark band, parallelogram edge, wide first review */
.wir-proof .sp-head { max-width: 64ch; }
.wir-proof .sp-reviews { grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr) minmax(0, 1fr); }
@media (max-width: 1000px) { .wir-proof .sp-reviews { grid-template-columns: 1fr; } }

/* Scope: paper band, staggered photo pair on the left */
.wir-scope { background: var(--color-paper); }
.wir-walls { margin: var(--space-xl) 0 0; padding: var(--space-lg); background: var(--color-dark); border-radius: var(--radius-lg); color: var(--color-white); box-shadow: var(--shadow); }
.wir-walls h3 { color: var(--color-white); font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .02em; margin-bottom: var(--space-xs); }
.wir-walls h3 svg { color: var(--color-accent); vertical-align: -3px; margin-right: var(--space-2); }
.wir-walls p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 82%, transparent); }
.wir-walls p a:not(.btn) { color: var(--color-accent-bright); }
.wir-scope .sp-photos .sp-photo:nth-child(2) { border-top: 4px solid var(--color-accent); }

/* Repair / rewire / new table: alt band with a wave edge */
.wir-options { background: var(--color-paper-2); }
.wir-options .sp-table tbody tr:nth-child(even) > * { background: color-mix(in srgb, var(--color-paper-2) 45%, var(--color-surface)); }
.wir-options .sp-table thead th + th { border-left: 3px solid var(--color-accent); }

/* Expert band: dark, torn edge, towns figure */
.wir-expert.edge-torn-top { margin-top: -18px; z-index: 1; }
.wir-expert .stat-watermark { top: auto; bottom: -1.5rem; right: var(--space-xl); color: var(--color-accent); }

/* Process on paper, FAQ on white */
.wir-process { background: var(--color-paper); }
.wir-process .sp-steps li:last-child { border-color: var(--color-accent); }
.wir-faq { background: var(--color-surface); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--wir" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Bank of parallel EMT conduit runs dropping down a wall into a wireway between electrical panels', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">New circuits · rewiring · fault repair</span>
        <h1 class="hero-title" id="hero-title">Electrical wiring installation &amp; repair in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric runs new wiring and tracks down wiring faults in homes and shops.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('search', 16); ?>Shorts traced to the source</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('badge-check', 16); ?>Free estimates</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== PROBLEM: fault signs ===================== -->
  <section class="section wir-signs slant-top" aria-labelledby="signs-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Signs of a wiring fault</span>
        <h2 id="signs-title">What wiring problems send Rio Rancho homeowners looking for an electrician?</h2>
        <p class="answer-block">Goff Electric's wiring calls usually start with a dead circuit, a breaker that trips with little plugged in, or lights flickering along one run. Each one means a fault somewhere between the panel and the last device on the circuit, and the repair starts with finding exactly where it is.</p>
      </div>

      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('search', 32); ?>
          <h3>A short nobody could find</h3>
          <p>When a breaker trips the moment it is reset, the short is somewhere on that circuit: a nicked wire behind drywall, a crushed cable in the attic, a failed splice in a box. Finding it means testing the run section by section.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('plug', 26); ?>
          <h3>Half a room went dark</h3>
          <p>Several outlets dead at once usually trace back to one loose connection upstream, not to every outlet failing on the same day.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('flame', 26); ?>
          <h3>A hot smell with no visible cause</h3>
          <p>Heat at a connection can scorch the insulation inside a box long before anything shows on the wall. Turn that circuit off and call.</p>
        </div>
      </div>
      <p class="sp-pull reveal-up">The fault is rarely where the symptom shows up.</p>
    </div>
  </section>

<?php $spProof = spReviews('shortage|whole home|outside plugs', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF: matched Google reviews (early on this page) ===================== -->
  <section class="section texture-grain edge-parallelogram-top wir-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">How did Goff Electric find a short that three other electricians missed?</h2>
        <p class="answer-block">Goff Electric found a short circuit that three other electricians had come out for and missed, according to that customer's Google review. The same customer now calls Garrett the most competent electrician they know, and other reviewers describe a whole-home wiring job and new plugs in a bedroom, bathroom, kitchen and outdoors.</p>
      </div>
      <?php echo $spProof; ?>
      <div class="sp-proof-foot">
        <a class="btn btn-outline-white" href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read all <?php echo (int) $gbpReviewCount; ?> Google reviews <?php echo icon('external-link', 16); ?></a>
        <p><?php echo esc(number_format((float) $gbpRating, 1)); ?> stars on Google from <?php echo (int) $gbpReviewCount; ?> reviews.</p>
      </div>
    </div>
  </section>
<?php endif; ?>

  <!-- ===================== SCOPE ===================== -->
  <section class="section wir-scope" aria-labelledby="scope-title">
    <div class="container sp-split sp-split--flip">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Scope of work</span>
          <h2 id="scope-title">What wiring work does Goff Electric install and repair?</h2>
          <p class="answer-block">Goff Electric installs new circuits, rewires older runs and repairs damaged wiring in homes, additions, remodels and detached shops. That includes feeders trenched underground to garages and outbuildings, like the run in the photo, and conduit along stucco and block walls where wire cannot be fished inside.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Fault tracing and repair.</b> Shorts, open neutrals, loose splices and damaged cable found and fixed.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>New circuits.</b> Dedicated runs for appliances, hot tubs and shop equipment, sized to the load.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Remodel and addition rough-in.</b> Boxes, cable and circuits laid out before drywall, then the devices and fixtures after.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Rewiring.</b> Old or damaged runs replaced one circuit or one room at a time.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Underground feeders.</b> Trenched runs to detached garages, shops and outbuildings, at the depth the code sets for the wiring method used.</span></li>
        </ul>
        <div class="wir-walls reveal-up">
          <h3><?php echo icon('house', 20); ?>Stucco, block and big lots</h3>
          <p>Many metro homes are stucco over wood framing, and yard walls are usually CMU block. Wire can be fished through framing, but block and finished stucco often mean surface conduit instead. On larger lots in Rio Rancho, Corrales and Placitas, the shop or garage often sits well away from the house and is fed underground. If the new circuits push past what the house can carry, the next step is a <?php echo serviceLink('electrical-panel-upgrades-repair', 'panel upgrade'); ?>; for single dead or warm devices, see <?php echo serviceLink('outlets-switches', 'outlet and switch repair'); ?>.</p>
        </div>
      </div>
      <div class="sp-photos">
        <figure class="sp-photo sp-photo--tall reveal-up">
          <?php echo responsivePicture('gbp-04-additional', 'Mini excavator digging a trench across a gravel lot toward a steel outbuilding for an underground electrical run', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 300px'); ?>
          <figcaption>Trenching an underground run toward a steel outbuilding</figcaption>
        </figure>
        <figure class="sp-photo sp-photo--tall reveal-up reveal-delay-2">
          <?php echo responsivePicture('gbp-06-at_work', 'Conduit rising out of an open trench along a stucco wall to new equipment beside the home electric meter', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 300px'); ?>
          <figcaption>Conduit up from the trench to equipment at the meter</figcaption>
        </figure>
      </div>
    </div>
  </section>

  <!-- ===================== OPTIONS TABLE ===================== -->
  <section class="section wir-options edge-wave-top" aria-labelledby="options-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Repair, rewire or new</span>
        <h2 id="options-title">Repair, rewire or run new wiring: which job does your house need?</h2>
        <p class="answer-block">Goff Electric repairs wiring when one fault explains the problem and rewires when a whole run is old or damaged. New wiring is for circuits that do not exist yet, such as an addition, a hot tub or a shop, and testing at the estimate tells you which of the three applies.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <caption>New circuits and rewiring normally need an electrical permit — confirm with the City of Rio Rancho, the City of Albuquerque or your county.</caption>
          <thead>
            <tr><th scope="col">What changes</th><th scope="col">Repair</th><th scope="col">Rewire</th><th scope="col">New wiring</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Typical signs</th><td>One dead or tripping circuit; scorching at one box</td><td>Brittle or damaged insulation along a run; repeat faults</td><td>A room, appliance or building with no circuit for it</td></tr>
            <tr><th scope="row">Scope</th><td>Find the fault; fix the splice, device or section</td><td>Replace the run from the panel to its devices</td><td>Lay out, pull and terminate a circuit from the panel</td></tr>
            <tr><th scope="row">Walls opened</th><td>Usually only at the fault</td><td>Access points, or surface conduit instead</td><td>Open framing in a remodel, or conduit and trench outside</td></tr>
            <tr><th scope="row">Panel impact</th><td>None</td><td>Sometimes new breakers</td><td>Needs breaker space and spare capacity</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===================== EXPERT POSITIONING ===================== -->
  <section class="section texture-grain edge-torn-top wir-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <span class="stat-watermark" aria-hidden="true"><?php echo icon('cable', 150); ?></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b><?php echo count($serviceAreas); ?> towns</b>
        <span>Rio Rancho to Tijeras, Sandoval and Bernalillo counties</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why do Rio Rancho and Albuquerque customers call Goff Electric for wiring?</h2>
        <p class="answer-block">Rio Rancho and Albuquerque customers call Goff Electric for wiring because owner Garrett Goff does the troubleshooting and explains the options before work starts. One reviewer wrote that Garrett laid out choices for a power install instead of only saying what was needed; another, referred by a neighbor, brought Garrett back for a second set of projects.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('search', 22); ?><div><b>Test first, open walls second</b><span>Circuits are narrowed down by testing before drywall or stucco is cut, which keeps patching small.</span></div></li>
          <li><?php echo icon('route', 22); ?><div><b>Inside the wall or outside it</b><span>Fished through framing where possible, run in conduit on block and stucco where it is not, trenched underground to outbuildings.</span></div></li>
          <li><?php echo icon('clock', 22); ?><div><b>A hot smell at midnight</b><span>The Goff Electric line is answered 24 hours a day, so a circuit that starts smelling hot does not have to wait for morning.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== PROCESS (sticky storytelling) ===================== -->
  <section class="section wir-process" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does Goff Electric track down and fix a wiring fault?</h2>
        <p class="answer-block">Goff Electric tracks down a wiring fault by starting at the symptom and testing back toward the panel until the failed point is found. You hear the cause and the repair price before anything is opened beyond what testing needs, and the circuit is proven before the job closes.</p>
        <p><a class="btn btn-secondary" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 16); ?>Call <?php echo esc($phoneText); ?></a></p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Tell us what stopped working</h3><p>Which outlets or lights are out, what was running when the breaker tripped, and whether anything smelled hot or looked scorched.</p></li>
        <li class="reveal-up"><h3>Test the circuit</h3><p>Devices and connections on the circuit are checked back toward the panel to narrow the fault down to one box or one section of cable.</p></li>
        <li class="reveal-up"><h3>Repair or reroute</h3><p>The failed splice, device or cable section is replaced. Where a run is damaged along its length, a new one is pulled or set in conduit.</p></li>
        <li class="reveal-up"><h3>Prove it</h3><p>The circuit is switched back on and tested with its normal load, and you are shown what failed and why.</p></li>
      </ol>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq wir-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do customers ask Goff Electric before wiring work starts?</h2>
        <p class="answer-block">Customers ask Goff Electric two things before wiring work starts: which symptoms are serious enough to stop and call, and whether the job needs a permit. Short answers are below. For anything else, call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a> or look through <a href="/services/">the full list of Goff Electric services</a>.</p>
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
    ['electrical-panel-upgrades-repair', 'outlets-switches', 'ev-charger-installation'],
    'What other work comes up alongside wiring jobs in <span class="text-accent">Rio Rancho</span>?',
    'Wiring jobs in Rio Rancho tend to bring three other services along: a panel upgrade when new circuits need more capacity, outlet and switch work once the runs are sound, and an EV charger circuit when the garage or a detached shop is already getting new wire.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final wir-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('cable', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Dead circuit or new run?</span>
      <h2 id="final-title">Need a wiring fault found, or a new circuit run?</h2>
      <p>Tell Goff Electric what stopped working, or what needs power, and where the property is. You will get the cause or the scope, and the price, before work begins.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
