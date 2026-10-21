<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/ceiling-fan-installation/ — Goff Electric (Phase 4, 2026-10-21). Premium editorial service page.
 * Sources: build-plan.json + config.php (new and replacement ceiling fans, fan-rated boxes, wall controls; 6 service
 * towns; 24/7; free estimates; licensed & insured; 4.9 from 42 reviews), homepage card (light kits, wobbly fans replaced),
 * Google reviews feed (fixture and lighting work — no review names a ceiling fan, and the copy says so).
 * General code facts (fan-supporting boxes, sloped-ceiling canopies, 3-wire switch legs) phrased generally.
 * Not supplied by intake (left out, listed in /content-confirmations.json): prices, fan supply, attic access limits.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('ceiling-fan-installation');
$pageTitle    = 'Ceiling Fan Installation Rio Rancho NM | Goff Electric';
$pageDescription = 'Ceiling fan installation and replacement in Rio Rancho and Albuquerque, NM: fan-rated boxes, light kits and wall controls by Goff Electric. Get a free estimate.';
$canonicalUrl = $siteUrl . '/services/ceiling-fan-installation/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = 'ceiling-fan-installation';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTagline = 'Tell us the room, the ceiling height and what is up there now.';

$heroImage   = 'gbp-11-at_work';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/ceiling-fan-installation/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/' . $heroImage . '-960.webp');

/* FAQs — research-brief questions reworded for fans (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Is a wobbling fan or a warm fan switch something to worry about?',
        'a' => 'A slow wobble is usually balance or a loose mount, but a fan that shifts on its box, or a wall switch or control that feels warm, is worth a call. Warm switches and loose connections are among the warning signs that point to a fault, and a fan hanging from a box that was never rated for it can work loose over time.',
    ],
    [
        'q' => 'Do I need a permit to add a ceiling fan in Rio Rancho?',
        'a' => 'Replacing a fan where one already hangs is usually simple. Running new wiring to a room that never had a ceiling box is the kind of work that can need a permit and inspection under the adopted electrical code. Check with the City of Rio Rancho, the City of Albuquerque or your county for your address, and ask Goff Electric at the estimate.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Ceiling fan installation — page composition. Tokens only.
   ========================================================================== */
.hero--fan { --sp-hero-pos: 50% 22%; }

/* Signs: paper, slanted over the hero; pull quote stacked above the signs */
.fan-signs { background: var(--color-paper); }
.fan-signs .sp-head { max-width: 60ch; }
.fan-signs .sp-pull { margin-top: var(--space-xl); max-width: 30ch; }
.fan-signs .sp-sign--lead { background: linear-gradient(200deg, var(--color-primary) 0%, var(--color-dark) 100%); }
.fan-signs .sp-sign--lead svg { animation: fan-spin 9s linear infinite; }
@keyframes fan-spin { to { transform: rotate(360deg); } }

/* Scenario table: white band, parallelogram edge, wide first column */
.fan-cases { background: var(--color-surface); }
.fan-cases .sp-table tbody th { width: 30%; }
.fan-cases .sp-table td:nth-child(3) { font-weight: 600; color: var(--color-ink); }
.fan-cases__note { margin: var(--space-lg) 0 0; max-width: var(--measure); color: var(--color-ink-2); font-size: var(--fs-small); }

/* Expert band: dark, torn edge, figure to the right on desktop */
.fan-expert .sp-expert { grid-template-columns: minmax(0, 1.4fr) minmax(0, .8fr); }
.fan-expert .sp-expert > :first-child { order: 2; }
.fan-expert .sp-figure b { color: var(--color-accent); }
.fan-expert .stat-watermark { left: var(--space-xl); right: auto; top: auto; bottom: 0; color: var(--color-accent); }
@media (max-width: 900px) { .fan-expert .sp-expert { grid-template-columns: 1fr; } .fan-expert .sp-expert > :first-child { order: 0; } }

/* What's included: paper band, single tall photo with an accent frame */
.fan-included { background: var(--color-paper); }
.fan-included .sp-photo { max-width: 24rem; justify-self: center; box-shadow: var(--shadow-lg), calc(-1 * var(--space-md)) var(--space-md) 0 var(--color-accent); }
.fan-included .sp-photo img { object-position: 50% 20%; }
.fan-included .sp-copy { margin-top: var(--space-lg); }

/* Process on white; proof dark; FAQ paper */
.fan-process { background: var(--color-surface); }
.fan-process .sp-steps li { background: var(--color-paper); }
.fan-faq { background: var(--color-paper); }
.fan-final h2 { max-width: 20ch; }
@media (prefers-reduced-motion: reduce) { .fan-signs .sp-sign--lead svg { animation: none; } }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--fan" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Living room with a ceiling fan light kit and recessed lights in a textured ceiling', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">New &amp; replacement fans · Rio Rancho &amp; Albuquerque</span>
        <h1 class="hero-title" id="hero-title">Ceiling fan installation in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric hangs new and replacement ceiling fans on fan-rated boxes.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('fan', 16); ?>Fan-rated boxes</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== PROBLEM ===================== -->
  <section class="section fan-signs slant-top" aria-labelledby="signs-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Is it time?</span>
        <h2 id="signs-title">When should a Rio Rancho home get a new or replacement ceiling fan?</h2>
        <p class="answer-block">A Rio Rancho home should get a new ceiling fan when a room stays stuffy even with the cooler running, and a replacement when the old fan wobbles, hums or stops responding to its controls. Goff Electric installs both, and checks that the ceiling box can actually carry the fan.</p>
      </div>
      <p class="sp-pull reveal-left">A fan is a spinning weight on your ceiling. The box above it matters.</p>

      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('fan', 32); ?>
          <h3>Summer rooms that never cool</h3>
          <p>From June into September, a fan moving air across a bedroom or living room helps an evaporative cooler or refrigerated air do its job, especially in upstairs rooms that hold heat.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('alert-triangle', 26); ?>
          <h3>A wobble that keeps getting worse</h3>
          <p>Balancing kits fix blades. They do not fix a fan hanging from a light-fixture box that was never meant to hold it.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('lightbulb', 26); ?>
          <h3>A light where a fan should be</h3>
          <p>Swapping a center light for a fan with a light kit gives you both, if the box and switch wiring allow it.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== SCENARIO TABLE ===================== -->
  <section class="section fan-cases edge-parallelogram-top" aria-labelledby="cases-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Three kinds of fan job</span>
        <h2 id="cases-title">What changes between replacing a fan, swapping a light for a fan, and adding one from scratch?</h2>
        <p class="answer-block">The difference between fan jobs is what is already in the ceiling. Replacing an old fan on a fan-rated box is the simplest; turning a light into a fan means checking or replacing the box; a room with no ceiling wiring needs a new box, wire and switch, which Goff Electric plans at the estimate.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <thead>
            <tr><th scope="col">Situation</th><th scope="col">What has to happen</th><th scope="col">Typical scope</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Replacing an existing fan</th><td>Take down the old fan, confirm the box is listed for fan support, mount and balance the new one</td><td>Smallest job</td></tr>
            <tr><th scope="row">Light fixture becomes a fan</th><td>Check whether the light box can carry a fan; if not, a fan-rated box or brace goes in from below</td><td>Moderate</td></tr>
            <tr><th scope="row">Separate wall controls for fan and light</th><td>An extra conductor between switch and ceiling (a 3-wire switch leg) or a fan-rated wall control</td><td>Depends on the wall</td></tr>
            <tr><th scope="row">New location, no wiring</th><td>New fan-rated box, wire fished from a circuit with room for it, a new wall switch</td><td>Largest job</td></tr>
          </tbody>
        </table>
      </div>
      <p class="fan-cases__note reveal-up">Vaulted and sloped ceilings in Rio Rancho and Albuquerque homes also need a downrod of the right length and a canopy rated for the slope so the blades clear the ceiling.</p>
    </div>
  </section>

  <!-- ===================== EXPERT POSITIONING ===================== -->
  <section class="section texture-grain edge-torn-top fan-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <span class="stat-watermark" aria-hidden="true"><?php echo icon('fan', 150); ?></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-right">
        <b><?php echo count($serviceAreas); ?> towns</b>
        <span>Rio Rancho to Tijeras, across Sandoval and Bernalillo counties</span>
      </div>
      <div class="reveal-left">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why call Goff Electric for a ceiling fan instead of a handyman?</h2>
        <p class="answer-block">Goff Electric treats a ceiling fan installation as electrical work first: the box, the support and the switch wiring are checked before the fan goes up. A handyman can hang blades; an electrician tells you whether the box and circuit above them are fit for a moving load.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('shield-check', 22); ?><div><b>Support checked, not assumed</b><span>Every fan goes on a box listed for fan support, added from below when the old one is a light-only box.</span></div></li>
          <li><?php echo icon('wrench', 22); ?><div><b>Controls that work the way you want</b><span>Light kits, separate fan and light switches, or a wall control in place of the pull chains.</span></div></li>
          <li><?php echo icon('map-pin', 22); ?><div><b>Across the whole metro</b><span>Rio Rancho, Albuquerque, Corrales, Bernalillo, Placitas and Tijeras, from the same phone number.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== WHAT'S INCLUDED ===================== -->
  <section class="section fan-included" aria-labelledby="included-title">
    <div class="container sp-split">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Scope of work</span>
          <h2 id="included-title">What does Goff Electric's ceiling fan installation include?</h2>
          <p class="answer-block">Goff Electric's ceiling fan installation includes removing the old fixture, confirming or installing a fan-rated box, assembling and hanging the fan, wiring the light kit and controls, and balancing it so it runs quietly. You can supply the fan you picked, or ask what will fit the room and ceiling.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Old fixture out.</b> The existing fan or light comes down and the connections in the box are checked for heat damage or loose splices.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Fan-rated box.</b> Kept if it is listed for a fan, replaced or braced if it is not.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Downrod and canopy.</b> Sized to the ceiling height and slope, with blade clearance checked.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Light kit and controls.</b> Wired to pull chains, a wall switch, a separate fan and light switch, or a remote.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Balanced and tested.</b> Run on every speed and in reverse for winter, with the wobble checked before the ladder comes down.</span></li>
        </ul>
        <p class="sp-copy reveal-up">Pairing a fan with new cans in the same ceiling? See <?php echo serviceLink('lighting-installation', 'recessed and pendant lighting installation'); ?>. Rooms with no ceiling wiring at all are handled as <?php echo serviceLink('electrical-wiring-installation-repair', 'new wiring work'); ?>.</p>
      </div>
      <figure class="sp-photo sp-photo--tall sp-photo--offset reveal-right">
        <?php echo responsivePicture('gbp-12-additional', 'Electrician on a ladder working at a ceiling box over a kitchen half-wall, with pendant lights hung on either side', '(max-width: 900px) 90vw, 380px'); ?>
        <figcaption>Ceiling work from a ladder, box by box</figcaption>
      </figure>
    </div>
  </section>

  <!-- ===================== PROCESS ===================== -->
  <section class="section fan-process" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does a ceiling fan install with Goff Electric go?</h2>
        <p class="answer-block">A ceiling fan install with Goff Electric goes in three steps: a look at the ceiling box and switch to see what the room already has, the box, wiring and fan going in, then a test on every speed and control with you. A straight replacement is the shortest version of that.</p>
        <p><a class="btn btn-secondary" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 16); ?>Call <?php echo esc($phoneText); ?></a></p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Look at what is up there</h3><p>The ceiling box, the switch on the wall and the circuit feeding them decide whether this is a swap or a bigger job. You hear which before work is booked.</p></li>
        <li class="reveal-up"><h3>Box, wire, fan</h3><p>A fan-rated box or brace goes in if needed, any extra conductor for separate controls is run, and the fan is assembled and hung.</p></li>
        <li class="reveal-up"><h3>Spin it up with you</h3><p>Every speed, the reverse switch, the light kit and the wall control are tested, and the blades are balanced before the job is closed out.</p></li>
      </ol>
    </div>
  </section>

<?php $spProof = spReviews('pendant|recessed|fixtures', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF ===================== -->
  <section class="section texture-grain slant-top fan-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do Goff Electric customers say about ceiling work?</h2>
        <p class="answer-block">Goff Electric customers describe ceiling work done carefully and on schedule. None of the Google reviews so far names a ceiling fan, so these are the reviews about fixture and lighting jobs, the closest match, quoted as written.</p>
      </div>
      <?php echo $spProof; ?>
      <div class="sp-proof-foot">
        <a class="btn btn-outline-white" href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read all <?php echo (int) $gbpReviewCount; ?> Google reviews <?php echo icon('external-link', 16); ?></a>
        <p><?php echo esc(number_format((float) $gbpRating, 1)); ?> stars on Google from <?php echo (int) $gbpReviewCount; ?> reviews.</p>
      </div>
    </div>
  </section>
<?php endif; ?>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq fan-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do homeowners ask before a ceiling fan install?</h2>
        <p class="answer-block">Homeowners usually ask Goff Electric whether a wobbling fan or warm switch is a warning sign, and whether adding a fan needs a permit. Short answers are below; for anything else call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a> or look through <a href="/services/">all Goff Electric services</a>.</p>
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
    ['lighting-installation', 'outlets-switches', 'electrical-wiring-installation-repair'],
    'What other work do people book with a <span class="text-accent">ceiling fan</span> install?',
    'People booking a ceiling fan install with Goff Electric often add recessed or pendant lighting in the same room, new outlets or switches where the furniture actually sits, or new wiring when the room never had a ceiling box, so one visit covers the whole room instead of three separate trips.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final fan-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('fan', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Hot room, still air?</span>
      <h2 id="final-title">Ready for a ceiling fan that stays put?</h2>
      <p>Tell Goff Electric the room, the ceiling height and what hangs there now. You will get the scope and price before anything comes down, at no cost.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
