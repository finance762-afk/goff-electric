<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/outlets-switches/ — Goff Electric (Phase 4, 2026-10-21). Premium editorial service page.
 * Sources: build-plan.json + config.php (dead, warm or loose outlets, faulty switches, GFCI, new outlets; 24/7; free
 * estimates; licensed & insured; 4.9 from 42 reviews), research brief (warning signs, surge protection, permits),
 * Google reviews feed (patio outlet and switch for Christmas lights, bedroom/bath/kitchen/outside plugs, a panel and outlet
 * issue fixed, a 220 outlet for a hot tub). GFCI/AFCI locations are general code guidance, confirmed per house.
 * Not supplied by intake (left out, listed in /content-confirmations.json): prices, device brands, whole-home surge installs.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('outlets-switches');
$pageTitle    = 'Outlets & Switches in Rio Rancho, NM | Goff Electric';
$pageDescription = 'Dead, warm or loose outlets and switches repaired, GFCI protection added and new outlets installed in Rio Rancho and Albuquerque, NM. Get a free estimate today.';
$canonicalUrl = $siteUrl . '/services/outlets-switches/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = 'outlets-switches';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTagline = 'Tell us which outlets or switches, and what they are doing.';

$heroImage   = 'gbp-12-additional';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/outlets-switches/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/' . $heroImage . '-960.webp');

/* FAQs — research-brief questions that fit outlets (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Should I add surge protection when I replace outlets in my Rio Rancho home?',
        'a' => 'It is worth considering. Summer monsoon storms bring frequent lightning to Rio Rancho, and plug-in surge strips only protect what is plugged into them. A whole-home surge protective device at the panel covers appliances and HVAC equipment as well; an electrician can look at your panel and recommend the right device for it.',
    ],
    [
        'q' => 'Do I need a permit to add new outlets in Rio Rancho?',
        'a' => 'Replacing a worn outlet or switch on the same circuit is routine repair. Adding outlets on a new circuit is the kind of work that usually needs a permit and inspection under the adopted electrical code. Rules differ between the City of Rio Rancho, the City of Albuquerque and the counties, so confirm for your address and ask Goff Electric at the estimate.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Outlets & switches — page composition. Tokens only.
   ========================================================================== */
.hero--out { --sp-hero-pos: 50% 88%; }

/* Warning signs: paper, slanted; danger-tinted lead card */
.out-signs { background: var(--color-paper); }
.out-signs__top { display: grid; grid-template-columns: minmax(0, 1.15fr) minmax(0, .85fr); gap: var(--space-xl) var(--space-3xl); align-items: end; }
.out-signs .sp-pull { border-left-color: var(--color-danger); }
.out-signs .sp-sign--lead { background: linear-gradient(150deg, var(--color-dark) 0%, color-mix(in srgb, var(--color-danger) 30%, var(--color-dark)) 100%); border-color: transparent; }
.out-signs .sp-sign--lead svg { color: var(--color-accent-bright); }
.out-signs .sp-sign--lead small { display: block; margin-top: var(--space-xs); font-size: var(--fs-small); color: var(--color-accent-bright); }
@media (max-width: 900px) { .out-signs__top { grid-template-columns: 1fr; } }

/* Expert band: dark with a curved top */
.out-expert .sp-figure b { color: var(--color-accent); }
.out-expert .stat-watermark { top: var(--space-2xl); color: var(--color-accent); }

/* What's included: white band, two photos stacked with an offset */
.out-included { background: var(--color-surface); }
.out-included .sp-photos .sp-photo:first-child { aspect-ratio: 4 / 3; }
.out-included .sp-photos .sp-photo:nth-child(2) { aspect-ratio: 3 / 4; }
.out-included .sp-photos .sp-photo:nth-child(2) img { object-position: 50% 60%; }
.out-quote { margin: var(--space-lg) 0 0; padding: var(--space-md) var(--space-lg); border-radius: var(--radius); background: var(--color-card-tint-3); border-left: 4px solid var(--color-accent); max-width: var(--measure); color: var(--color-ink-2); font-size: var(--fs-small); }

/* GFCI / AFCI table: paper-2, wave edge, check marks in accent */
.out-code { background: var(--color-paper-2); }
.out-code .sp-table td { text-align: center; }
.out-code .sp-table td:first-of-type, .out-code .sp-table td:last-child { text-align: left; }
.out-code .sp-table td svg { color: var(--color-accent-dark); vertical-align: middle; }
.out-code .sp-table .out-no { color: var(--color-muted); }
.out-code__foot { margin: var(--space-md) 0 0; max-width: var(--measure); font-size: var(--fs-small); color: var(--color-muted); }

/* Process paper; proof dark; FAQ white */
.out-process { background: var(--color-paper); }
.out-process .sp-steps::before { background: linear-gradient(var(--color-danger), var(--color-accent)); }
.out-faq { background: var(--color-surface); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--out" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Kitchen half-wall with a duplex outlet below while an electrician hangs pendant lights from a ladder', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Outlets, switches &amp; GFCI · Rio Rancho &amp; Albuquerque</span>
        <h1 class="hero-title" id="hero-title">Outlet and switch repair in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric fixes dead, warm and loose outlets and switches, and adds new ones.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('plug', 16); ?>GFCI &amp; new outlets</li>
          <li><?php echo icon('clock', 16); ?>Open 24 hours, 7 days</li>
          <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== PROBLEM: warning signs ===================== -->
  <section class="section out-signs slant-top" aria-labelledby="signs-title">
    <div class="container">
      <div class="out-signs__top">
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Warning signs</span>
          <h2 id="signs-title">When is a bad outlet or switch more than a nuisance?</h2>
          <p class="answer-block">A bad outlet or switch is more than a nuisance when it feels warm, looks scorched or discolored, smells like burning plastic, or sparks when you plug in. Those signs point to a loose connection or an overload, and Goff Electric treats them as a fire risk rather than a weekend project.</p>
        </div>
        <p class="sp-pull reveal-right">A warm outlet is the wiring telling you something.</p>
      </div>

      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('flame', 32); ?>
          <h3>Warm, discolored or smelling hot</h3>
          <p>Stop using it and turn off its breaker. Heat at an outlet or switch comes from resistance at a loose or damaged connection, and it does not fix itself.</p>
          <small>Smoke or flames? Get out and call 911 first.</small>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('plug', 26); ?>
          <h3>Dead outlets on a live circuit</h3>
          <p>Half a room goes dark and no breaker is tripped. Often it is a tripped GFCI somewhere else, sometimes a failed backstab connection behind the plate.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('zap', 26); ?>
          <h3>Plugs that fall out</h3>
          <p>Worn contacts that no longer grip a plug arc every time something is bumped. Replacing the device is a small job compared to what arcing can start.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== EXPERT POSITIONING ===================== -->
  <section class="section texture-grain edge-curve-top out-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <span class="stat-watermark" aria-hidden="true"><?php echo icon('plug', 150); ?></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b>24/7</b>
        <span>Phone answered day and night</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why call Goff Electric about outlets and switches rather than swapping them yourself?</h2>
        <p class="answer-block">Goff Electric finds out why an outlet or switch failed before replacing it, so the new device is not sitting on the same loose connection or overloaded circuit. One Google reviewer wrote that Garrett found the issue with their panel and an outlet and fixed it quickly at a fair price.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('search', 22); ?><div><b>The cause, not just the cover plate</b><span>A scorched outlet can trace back to the panel, a shared circuit or a splice in another box. The device gets replaced once the cause is known.</span></div></li>
          <li><?php echo icon('house', 22); ?><div><b>Room by room, inside and out</b><span>Reviewers describe bedroom, bathroom, kitchen and outside plugs done in one project, and a patio outlet with its own switch.</span></div></li>
          <li><?php echo icon('alert-triangle', 22); ?><div><b>Someone answers at 11 p.m.</b><span>A hot or sparking outlet does not wait for office hours, and neither does the Goff Electric phone.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== WHAT'S INCLUDED ===================== -->
  <section class="section out-included" aria-labelledby="included-title">
    <div class="container sp-split">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Scope of work</span>
          <h2 id="included-title">What outlet and switch work does Goff Electric handle?</h2>
          <p class="answer-block">Goff Electric handles outlet and switch repair, replacement and new installation: dead and warm outlets traced and fixed, GFCI protection added where water is near, new outlets where the furniture actually sits, and dedicated 240-volt receptacles for equipment such as a hot tub or a large tool.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Repairs.</b> Dead, loose, warm or scorched outlets and switches diagnosed, with the connection behind them fixed, not just the face.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>GFCI protection.</b> Added at kitchens, baths, garages, laundry areas and outdoor outlets, by GFCI outlet or breaker.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>New outlets and switches.</b> Where a desk, a TV wall or a patio needs power, including switched exterior outlets for seasonal lights.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>240-volt receptacles.</b> A dedicated circuit and receptacle for a hot tub, welder, dryer or range.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Device upgrades.</b> Dimmers, USB-charging outlets, three-way switches and smart switches, when the box and wiring suit them.</span></li>
        </ul>
        <p class="out-quote reveal-up">One Google reviewer had Goff Electric run the lines for a new hot tub, then come back after delivery to set it up, and add an outlet and switch on the patio for Christmas lights. Seasonal power like that is a small job to add while an electrician is already there.</p>
      </div>
      <div class="sp-photos reveal-right">
        <figure class="sp-photo">
          <?php echo responsivePicture('gbp-11-at_work', 'Living room with recessed lights and a ceiling fan, the kind of room where outlets and switches get moved to fit the furniture', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 260px'); ?>
          <figcaption>Living room: switches, cans and a fan on one plan</figcaption>
        </figure>
        <figure class="sp-photo">
          <?php echo responsivePicture('gbp-06-at_work', 'Exterior electrical equipment and conduit beside a home electric meter, with an open trench along the stucco wall', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 260px'); ?>
          <figcaption>Exterior equipment beside the meter, conduit run below grade</figcaption>
        </figure>
      </div>
    </div>
  </section>

  <!-- ===================== GFCI / AFCI TABLE ===================== -->
  <section class="section out-code edge-wave-top" aria-labelledby="code-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Protection by room</span>
        <h2 id="code-title">Where do outlets need GFCI or AFCI protection?</h2>
        <p class="answer-block">Outlets near water need GFCI protection, and outlets in most living spaces need AFCI protection under recent editions of the electrical code New Mexico has adopted. Older Rio Rancho and Albuquerque homes often predate those rules, so Goff Electric checks what your house has and what an update should add.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <thead>
            <tr><th scope="col">Location</th><th scope="col">GFCI</th><th scope="col">AFCI</th><th scope="col">Why it matters</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Bathrooms</th><td><?php echo icon('check', 18); ?><span class="sr-only">Yes</span></td><td><span class="out-no">Varies</span></td><td>Water and hair dryers at the same counter</td></tr>
            <tr><th scope="row">Kitchen countertops</th><td><?php echo icon('check', 18); ?><span class="sr-only">Yes</span></td><td><?php echo icon('check', 18); ?><span class="sr-only">Yes</span></td><td>Sinks, kettles and heavy appliance loads</td></tr>
            <tr><th scope="row">Garages and outdoors</th><td><?php echo icon('check', 18); ?><span class="sr-only">Yes</span></td><td><span class="out-no">Usually not</span></td><td>Damp floors, monsoon rain, outdoor cords</td></tr>
            <tr><th scope="row">Laundry areas</th><td><?php echo icon('check', 18); ?><span class="sr-only">Yes</span></td><td><?php echo icon('check', 18); ?><span class="sr-only">Yes</span></td><td>Washer water next to a heavy dryer load</td></tr>
            <tr><th scope="row">Within 6 ft of any other sink</th><td><?php echo icon('check', 18); ?><span class="sr-only">Yes</span></td><td><span class="out-no">Depends on the room</span></td><td>Wet bars, utility sinks, outdoor kitchens</td></tr>
            <tr><th scope="row">Bedrooms, living and family rooms</th><td><span class="out-no">No</span></td><td><?php echo icon('check', 18); ?><span class="sr-only">Yes</span></td><td>Damaged cords and loose connections behind furniture</td></tr>
          </tbody>
        </table>
      </div>
      <p class="out-code__foot">General guidance only. Requirements depend on the code edition in force when the work is done and on your local jurisdiction; your electrician confirms what applies to your house.</p>
    </div>
  </section>

  <!-- ===================== PROCESS ===================== -->
  <section class="section out-process" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does Goff Electric fix a dead or warm outlet?</h2>
        <p class="answer-block">Goff Electric fixes a dead or warm outlet by first making it safe, then tracing the circuit to the actual fault, then repairing the connection or device and testing every outlet on that circuit. The point is that the problem stays fixed, not that a new cover plate goes on.</p>
        <p class="sp-copy">Several outlets dead at once, or a breaker that will not reset? That can be a <?php echo serviceLink('24-7-emergency-electrical-service', 'call for emergency electrical service'); ?>. For a whole-house look at aging outlets, ask about <?php echo serviceLink('electrical-inspections', 'an electrical inspection'); ?>.</p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Make it safe</h3><p>Power to the affected circuit is shut off and the outlet or switch is opened up to look for heat damage.</p></li>
        <li class="reveal-up"><h3>Trace the circuit</h3><p>Upstream outlets, GFCIs that may have tripped, and the breaker are checked until the actual fault turns up.</p></li>
        <li class="reveal-up"><h3>Repair the connection</h3><p>Damaged wire ends are cut back, connections are remade, and worn or scorched devices are replaced, with GFCI added where it belongs.</p></li>
        <li class="reveal-up"><h3>Test the whole run</h3><p>Every outlet on the circuit is tested, not just the one that failed, before the job is closed out.</p></li>
      </ol>
    </div>
  </section>

<?php $spProof = spReviews('plugs|outlet|switch', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF ===================== -->
  <section class="section texture-grain slant-top out-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do customers say about Goff Electric's outlet and switch work?</h2>
        <p class="answer-block">Customers who had Goff Electric work on outlets and switches mention plugs fixed in bedrooms, bathrooms, kitchens and outside, a patio outlet and switch, and a problem outlet found and fixed fast at a fair price. These Google reviews mention outlets, plugs or switches, quoted as written.</p>
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
  <section class="section sp-faq out-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do Rio Rancho homeowners ask about outlets and surge protection?</h2>
        <p class="answer-block">Rio Rancho homeowners ask Goff Electric whether new outlets should come with surge protection, given monsoon lightning, and whether adding outlets needs a permit. Both answers are below; call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a> for anything else, or browse <a href="/services/">every service Goff Electric offers</a>.</p>
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
    ['residential-electrical', 'electrical-inspections', '24-7-emergency-electrical-service'],
    'What other help do people need when an <span class="text-accent">outlet</span> goes bad?',
    'When an outlet goes bad, people often need more than the one device: broader residential electrical repairs on the same circuit, an electrical inspection to check the rest of an older house, or emergency service when a whole run of outlets goes dead or a breaker refuses to reset late at night.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final out-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('plug', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Outlet acting up?</span>
      <h2 id="final-title">Need an outlet or switch looked at in Rio Rancho or Albuquerque?</h2>
      <p>Tell Goff Electric which outlets or switches and what they are doing. If one is warm, smells hot or sparks, turn off its breaker and call now instead of filling in the form.</p>
      <small>Smoke or flames? Get out and call 911 first.</small>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
