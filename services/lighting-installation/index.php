<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/lighting-installation/ — Goff Electric (Phase 4, 2026-10-21). Premium editorial service page.
 * Sources: build-plan.json + config.php (indoor/outdoor lighting, recessed, fixtures, exterior lights; 24/7; free estimates;
 * licensed & insured; 4.9 from 42 reviews), Google reviews feed (pendant lights + recessed cans, whole-home fixtures,
 * patio outlet and switch), manifest photos (atrium ring pendants, kitchen pendants, living-room recessed lights).
 * General public facts: New Mexico Night Sky Protection Act (1999) on outdoor fixtures — phrased as "confirm locally".
 * Not supplied by intake (left out, listed in /content-confirmations.json): prices, fixture supply, smart/dimmer brands.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('lighting-installation');
$pageTitle    = 'Lighting Installation Rio Rancho NM | Goff Electric';
$pageDescription = 'Recessed, pendant and exterior lighting installation in Rio Rancho and Albuquerque, NM by Goff Electric, a licensed and insured electrician. Free estimates.';
$canonicalUrl = $siteUrl . '/services/lighting-installation/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = 'lighting-installation';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTagline = 'Tell us the room, the fixtures you have in mind and the ceiling height.';

$heroImage   = 'gbp-09-at_work';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/lighting-installation/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/' . $heroImage . '-960.webp');

/* FAQs — research-brief questions that fit lighting (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'My lights flicker or dim when something turns on. Do I need an electrician?',
        'a' => 'Yes, have it checked. Lights that flicker or dim, especially when the air conditioner, a hot tub heater or a microwave kicks on, can point to a loose connection or an overloaded circuit, and either one can heat up wiring. Goff Electric traces the cause before swapping fixtures, because a new light on a bad connection will flicker too.',
    ],
    [
        'q' => 'Do I need a permit to add new lighting in Rio Rancho?',
        'a' => 'Swapping a fixture on an existing box usually is not the same as adding circuits, which typically needs a permit and inspection under the adopted electrical code. Requirements differ between the City of Rio Rancho, the City of Albuquerque and Sandoval or Bernalillo County, so confirm with the office for your address and ask Goff Electric what your lighting project will need.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Lighting installation — page composition. Tokens only.
   ========================================================================== */
.hero--lit { --sp-hero-pos: 50% 30%; }

/* Expert band leads the article: dark, slanted over the hero, bulb watermark */
.lit-expert .stat-watermark { top: var(--space-xl); right: var(--space-xl); color: var(--color-accent); }
.lit-expert .sp-figure b { font-size: clamp(3rem, 2rem + 4vw, 5.5rem); }
.lit-expert .sp-figure { border-top-color: var(--color-accent-bright); }

/* Signs: paper band, pull quote centred above a 3-up bento */
.lit-signs { background: var(--color-paper); }
.lit-signs__intro { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-xl) var(--space-3xl); align-items: center; }
.lit-signs .sp-pull { border-left-color: var(--color-secondary); }
.lit-signs .sp-sign--lead { background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-dark-alt) 100%); }
@media (max-width: 900px) { .lit-signs__intro { grid-template-columns: 1fr; } }

/* What's included: white band, curved top, two staggered photos on the left */
.lit-included { background: var(--color-surface); }
.lit-included .sp-photo--tall { aspect-ratio: 3 / 4; }
.lit-included .sp-photo:first-child { box-shadow: var(--shadow-lg), 0 0 0 6px var(--color-paper); }
.lit-included .sp-photo:first-child img { object-position: 50% 35%; }
.lit-included .sp-copy { margin-top: var(--space-lg); }

/* Fixture table: paper-2, first column dark labels */
.lit-types { background: var(--color-paper-2); }
.lit-types .sp-table tbody th { border-left: 3px solid var(--color-accent); }
.lit-types .sp-table td:last-child { color: var(--color-ink); font-weight: 500; }

/* Night-sky callout beside the table */
.lit-sky { display: grid; grid-template-columns: auto minmax(0, 1fr); gap: var(--space-md); margin-top: var(--space-xl); padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-dark); color: color-mix(in srgb, var(--color-white) 84%, transparent); max-width: 52rem; }
.lit-sky svg { color: var(--color-accent); }
.lit-sky b { display: block; color: var(--color-white); font-family: var(--font-heading); text-transform: uppercase; letter-spacing: .02em; margin-bottom: var(--space-1); }
.lit-sky p { margin: 0; font-size: var(--fs-small); }

/* Process on paper, proof dark with torn edge, FAQ white */
.lit-process { background: var(--color-paper); }
.lit-process .sp-steps li::before { background: var(--color-accent); color: var(--color-ink); }
.lit-proof .sp-review::after { color: var(--color-accent-bright); }
.lit-faq { background: var(--color-surface); }
.lit-final .floating-accent { bottom: -8%; }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--lit" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Ring pendant lights and recessed downlights hanging in a two-story commercial atrium with a staircase', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Indoor &amp; outdoor lighting · Rio Rancho &amp; Albuquerque</span>
        <h1 class="hero-title" id="hero-title">Lighting installation in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric installs recessed, pendant and exterior lighting for homes and businesses.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('lightbulb', 16); ?>Recessed &amp; pendants</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== EXPERT POSITIONING ===================== -->
  <section class="section texture-grain slant-top lit-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <span class="stat-watermark" aria-hidden="true"><?php echo icon('lightbulb', 150); ?></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b>Home + Business</b>
        <span>Kitchens, living rooms, atriums and storefronts</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why hire Goff Electric for lighting instead of hanging fixtures yourself?</h2>
        <p class="answer-block">Goff Electric handles lighting installation from the box and the circuit up, not just the fixture you see. That matters in a kitchen getting three new pendants, and it matters in a two-story commercial atrium like the one in the photo above, where every ring pendant and downlight has to land level and on the right circuit.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('layers', 22); ?><div><b>Residential and commercial ceilings</b><span>Goff Electric works in houses and in commercial buildings, so heavy fixtures, high ceilings and long switch runs are routine rather than a first attempt.</span></div></li>
          <li><?php echo icon('users', 22); ?><div><b>Garrett on the job</b><span>Google reviewers name owner Garrett Goff as the electrician who hung their pendant lights and cut in their recessed cans.</span></div></li>
          <li><?php echo icon('clock', 22); ?><div><b>A phone answered around the clock</b><span>If a fixture you installed yourself starts buzzing or smelling hot, the Goff Electric line is staffed day and night.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== PROBLEM: when lighting needs an electrician ===================== -->
  <section class="section lit-signs" aria-labelledby="signs-title">
    <div class="container">
      <div class="lit-signs__intro">
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Is it time?</span>
          <h2 id="signs-title">When does a lighting project in Rio Rancho need an electrician?</h2>
          <p class="answer-block">A lighting project needs an electrician once it goes beyond swapping a fixture on an existing box. New recessed cans, pendants over an island, an added switch or exterior lights on a block wall all mean new wiring, new boxes or a new circuit, and Goff Electric plans that before anything gets cut.</p>
        </div>
        <p class="sp-pull reveal-right">A fixture is ten minutes. Where the wire comes from is the real job.</p>
      </div>

      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('lightbulb', 32); ?>
          <h3>One dim ceiling light per room</h3>
          <p>Plenty of bedrooms and living rooms in the metro still have a single center fixture. Recessed cans or a pendant run need new boxes and a switch plan, not a brighter bulb.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('home', 26); ?>
          <h3>Textured or vaulted ceilings</h3>
          <p>Knockdown texture and sloped ceilings change where cans can go and how pendants hang. Patching texture after a bad cut shows for years.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('sun', 26); ?>
          <h3>Dark yard, bright desert days</h3>
          <p>Exterior and security lights that run on dusk-to-dawn sensors or motion controls save leaving a porch light burning all night.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== WHAT'S INCLUDED ===================== -->
  <section class="section lit-included edge-curve-top" aria-labelledby="included-title">
    <div class="container sp-split sp-split--flip">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Scope of work</span>
          <h2 id="included-title">What does Goff Electric's lighting installation cover?</h2>
          <p class="answer-block">Goff Electric's lighting installation covers layout, boxes, wiring, switching and hanging the fixtures, indoors and out. You can supply the fixtures you picked or talk through options; either way the electrical side is planned so the lights land where they look right and run on the right switch.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Recessed cans.</b> Layout across the ceiling, cut-ins through drywall and texture, and wiring the run back to a switch or dimmer.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Pendants.</b> Over an island, a half-wall or a dining table, hung at an even height, like the pendants going up in the kitchen photo.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Fixture swaps and upgrades.</b> Old fixtures out, new ones mounted on a box rated for their weight.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Exterior and security lighting.</b> Wall packs, porch and garage lights, and sensor-controlled lights for driveways and side yards.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Switching that makes sense.</b> Three-way switches at both ends of a hall, dimmers on the cans, and switches placed where you walk in.</span></li>
        </ul>
        <p class="sp-copy reveal-up">Adding a fan in the same room? Book it with the lights through <?php echo serviceLink('ceiling-fan-installation', 'ceiling fan installation'); ?>, and if the new layout needs more plugs, add <?php echo serviceLink('outlets-switches', 'new outlets and switches'); ?> to the same visit.</p>
      </div>
      <div class="sp-photos reveal-left">
        <figure class="sp-photo sp-photo--tall">
          <?php echo responsivePicture('gbp-12-additional', 'Goff Electric electrician on a ladder hanging three pendant lights over a kitchen half-wall', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 260px'); ?>
          <figcaption>Pendants going up over a kitchen half-wall</figcaption>
        </figure>
        <figure class="sp-photo sp-photo--tall">
          <?php echo responsivePicture('gbp-11-at_work', 'Living room with recessed downlights and a ceiling fan light kit in a textured ceiling', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 260px'); ?>
          <figcaption>Recessed downlights in a textured living-room ceiling</figcaption>
        </figure>
      </div>
    </div>
  </section>

  <!-- ===================== FIXTURE TYPES TABLE ===================== -->
  <section class="section lit-types" aria-labelledby="types-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Fixture by fixture</span>
        <h2 id="types-title">Which lighting jobs need a new box or a new circuit?</h2>
        <p class="answer-block">Most lighting jobs that add fixtures need new boxes, and larger ones can need a new circuit; straight fixture swaps usually need neither. Goff Electric checks the existing wiring and the load on the circuit before recommending either, so a kitchen full of new cans does not trip the breaker it shares with the microwave.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <thead>
            <tr><th scope="col">Lighting job</th><th scope="col">What is involved</th><th scope="col">New box?</th><th scope="col">New circuit?</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Fixture swap</th><td>Remove the old fixture, check the box and connections, mount the new one</td><td>Only if the old box cannot carry the weight</td><td>No</td></tr>
            <tr><th scope="row">Recessed cans</th><td>Layout, cut-ins, fishing wire between cans, a switch or dimmer</td><td>Yes, one housing per light</td><td>Sometimes, for a large layout</td></tr>
            <tr><th scope="row">Pendants</th><td>Even spacing and height over the island or counter, box placement, a switch leg</td><td>Usually</td><td>Rarely</td></tr>
            <tr><th scope="row">Exterior and security</th><td>Weather-rated boxes and fixtures, sensors or timers, routing through stucco or block</td><td>Usually</td><td>Sometimes, for long yard runs</td></tr>
          </tbody>
        </table>
      </div>
      <div class="lit-sky reveal-up">
        <?php echo icon('mountain', 28); ?>
        <div>
          <b>Outdoor lights and New Mexico's dark skies</b>
          <p>New Mexico's Night Sky Protection Act (1999) sets rules for outdoor lighting fixtures, and semi-rural places like Corrales and Placitas value a dark sky. Fully shielded fixtures that point down light the driveway without lighting the neighbors. Confirm the current requirements for your address before choosing exterior fixtures.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== PROCESS ===================== -->
  <section class="section lit-process" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does a Goff Electric lighting install go from plan to finished room?</h2>
        <p class="answer-block">A Goff Electric lighting install goes in four steps: walk the room and mark where each light should land, check the circuit and switching, install the boxes and fixtures, then turn everything on with you. Recessed and pendant layouts are agreed before the first hole is cut.</p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Mark the layout</h3><p>Where the cans line up, how high the pendants hang over an island, which wall the switches belong on. Ceiling joists and texture decide the final spots.</p></li>
        <li class="reveal-up"><h3>Check the circuit</h3><p>The existing circuit is checked for capacity and condition. If it already feeds the kitchen counters or a bathroom, the new lights may get their own.</p></li>
        <li class="reveal-up"><h3>Boxes, wire, fixtures</h3><p>Housings and boxes go in, wire is fished to the switch locations, and fixtures are mounted level and secure.</p></li>
        <li class="reveal-up"><h3>Lights on, together</h3><p>Every switch and dimmer is tested in front of you, and exterior sensors are aimed at the driveway or gate you care about.</p></li>
      </ol>
    </div>
  </section>

<?php $spProof = spReviews('pendant|recessed|fixtures', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF ===================== -->
  <section class="section texture-grain edge-torn-top lit-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do customers say about Goff Electric's lighting work?</h2>
        <p class="answer-block">Customers who had Goff Electric install lighting mention pendant lights, recessed cans and whole-home fixture jobs, and say they would hire Garrett again for the next project. These Google reviews mention fixture and lighting work, quoted as written.</p>
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
  <section class="section sp-faq lit-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do people ask Goff Electric before a lighting project?</h2>
        <p class="answer-block">People planning lighting usually ask Goff Electric two things: whether flickering lights mean a deeper problem, and whether new lighting needs a permit. Both answers are below. For anything else call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>, or see <a href="/services/">the full list of Goff Electric services</a>.</p>
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
    ['ceiling-fan-installation', 'outlets-switches', 'residential-electrical'],
    'What else do <span class="text-accent">Rio Rancho</span> homeowners add during a lighting project?',
    'Rio Rancho homeowners redoing their lighting often add a ceiling fan in the same room, move or add outlets and switches to suit the new layout, or fold the work into a larger residential electrical project such as a remodel, so the ceiling only gets opened once.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final lit-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('lightbulb', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Planning new lights?</span>
      <h2 id="final-title">Ready to light up a room in Rio Rancho or Albuquerque?</h2>
      <p>Send the room, the fixtures you like and a photo of the ceiling if you have one. Goff Electric will plan the layout and the wiring and give you the scope and price at no cost.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
