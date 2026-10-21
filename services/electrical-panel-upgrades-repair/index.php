<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/electrical-panel-upgrades-repair/ — Goff Electric (Phase 4, 2026-10-21). Premium editorial service page.
 * Sources: build-plan.json + config.php (panel replacement, service upgrades, breaker repair; 24/7; free estimates; licensed &
 * insured; 4.9 from 42 reviews; PNM coordination per the homepage FAQ), research-brief FAQs (panel/EV, surge protection,
 * permits), Google reviews feed (new panel, breaker panel upgrade + 220 outlet for a hot tub with Garrett and Rick,
 * panel + outlet diagnosis, new service), public history (AMREP began developing Rio Rancho in 1961).
 * Not supplied by intake (left out, listed in /content-confirmations.json): price ranges, permit handling, surge-protector
 * installs, panel brands carried, typical outage length on swap day.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('electrical-panel-upgrades-repair');
$pageTitle    = 'Panel Upgrades & Repair Rio Rancho NM | Goff Electric';
$pageDescription = 'Electrical panel upgrades and breaker repair in Rio Rancho and Albuquerque, NM: older 100-amp panels, tripping breakers, new service. Get a free estimate.';
$canonicalUrl = $siteUrl . '/services/electrical-panel-upgrades-repair/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = 'electrical-panel-upgrades-repair';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTagline = 'What is the panel doing? Tripping, buzzing, full, or too small for a new load?';

$heroImage   = 'gbp-08-at_work';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/electrical-panel-upgrades-repair/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/' . $heroImage . '-960.webp');

/* FAQs — research-brief questions only, reworded conversationally (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Will my panel need an upgrade before I add an EV charger or a hot tub?',
        'a' => 'Not always. A load calculation compares what the house already draws with the panel and service rating. If there is capacity, the new circuit goes in as-is; if not, the panel or the service is upgraded first. See ' . serviceLink('ev-charger-installation', 'how Goff Electric sizes an EV charger circuit') . ' for the charger side of that decision.',
    ],
    [
        'q' => 'Should I add surge protection when my panel is replaced?',
        'a' => 'It is worth asking about. Summer monsoon storms bring frequent lightning to Rio Rancho and Albuquerque, and a whole-home surge protective device mounted at the panel helps shield electronics, appliances and HVAC equipment. Swap day, with the panel already open, is a practical time to talk it through.',
    ],
    [
        'q' => 'Does a panel replacement in Rio Rancho need a permit?',
        'a' => 'Replacing a panel or upgrading a service normally needs an electrical permit and an inspection under the code New Mexico has adopted, and a service upgrade also involves PNM. Requirements differ between the City of Rio Rancho, the City of Albuquerque and Sandoval and Bernalillo counties, so confirm with the office for your address.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Panel upgrades & repair — page composition. Tokens only.
   ========================================================================== */
.hero--pnl { --sp-hero-pos: 50% 55%; }

/* Warning signs: paper band, slanted over the hero, three equal cards under a split head */
.pnl-signs { background: var(--color-paper); }
.pnl-signs__top { display: grid; grid-template-columns: minmax(0, 1.15fr) minmax(0, .85fr); gap: var(--space-xl) var(--space-3xl); align-items: center; }
.pnl-signs .sp-pull { font-size: clamp(1.3rem, .95rem + 1.6vw, 2rem); }
.pnl-signs .sp-sign { border-top: 4px solid var(--color-accent); }
.pnl-signs .sp-sign:nth-child(2) { transform: translateY(var(--space-lg)); }
.pnl-signs .sp-sign:nth-child(2):hover { transform: translateY(calc(var(--space-lg) - 3px)); }
@media (max-width: 900px) { .pnl-signs__top { grid-template-columns: 1fr; } .pnl-signs .sp-sign:nth-child(2), .pnl-signs .sp-sign:nth-child(2):hover { transform: none; } }

/* Options table: white band, column heads in the accent face */
.pnl-options { background: var(--color-surface); }
.pnl-options .sp-head { max-width: 64ch; }
.pnl-options .sp-table thead th:not(:first-child) { border-left: 1px solid var(--color-line); }
.pnl-options .sp-table td { border-left: 1px solid var(--color-line); }
.pnl-options .sp-table thead th:last-child { background: var(--color-dark); color: var(--color-accent-bright); }
.pnl-options .sp-table td:last-child { background: color-mix(in srgb, var(--color-accent) 8%, var(--color-surface)); color: var(--color-ink); }

/* Expert band: dark, torn edge, big 24/7 figure */
.pnl-expert.edge-torn-top { margin-top: -18px; z-index: 1; }
.pnl-expert .sp-figure { border-top-color: var(--color-accent-bright); }
.pnl-expert .floating-ring { top: -110px; left: -120px; }

/* Scope: alt band, list beside a staggered photo pair */
.pnl-scope { background: var(--color-paper-2); }
.pnl-scope .sp-split { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); }
.pnl-history { margin-top: var(--space-xl); padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.pnl-history h3 { font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .02em; margin-bottom: var(--space-xs); }
.pnl-history p { margin: 0; color: var(--color-ink-2); font-size: var(--fs-small); }
.pnl-history p + p { margin-top: var(--space-sm); }
.pnl-scope .sp-photos .sp-photo:first-child { border-bottom: 4px solid var(--color-accent); }

/* Process on white with a curved top; proof dark; FAQ paper */
.pnl-process { background: var(--color-surface); }
.pnl-process .sp-steps li { background: var(--color-paper); }
.pnl-proof .sp-head { max-width: 62ch; }
.pnl-faq { background: var(--color-paper); }
.pnl-faq .faq-grid { grid-template-columns: 1fr; max-width: 62rem; }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--pnl" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Open panelboard with rows of breakers and color-coded conductors landed and dressed to each breaker', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Breakers · panels · service upgrades</span>
        <h1 class="hero-title" id="hero-title">Electrical panel upgrades &amp; repair in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric repairs and upgrades breaker panels for homes and businesses.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('gauge', 16); ?>Home + business panels</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('badge-check', 16); ?>Free estimates</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== PROBLEM: warning signs ===================== -->
  <section class="section pnl-signs slant-top" aria-labelledby="signs-title">
    <div class="container">
      <div class="pnl-signs__top">
        <div class="sp-head reveal-left">
          <span class="eyebrow-label">Warning signs</span>
          <h2 id="signs-title">How can you tell a Rio Rancho electrical panel needs repair or an upgrade?</h2>
          <p class="answer-block">A Rio Rancho panel needs Goff Electric's attention when breakers trip often, lights dim as the air conditioning kicks on, or the panel buzzes or runs warm. Running out of breaker spaces for a new circuit is the other common signal, and any of these means the panel is at or past its limit.</p>
        </div>
        <p class="sp-pull reveal-right">A breaker that trips is doing its job. One that trips every week is telling you something.</p>
      </div>

      <div class="sp-signs">
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('zap', 26); ?>
          <h3>Breakers that won't stay on</h3>
          <p>A breaker that drops every time the dryer and the refrigerated air run together is either an overloaded circuit or a breaker that has worn out. Both are fixable once someone finds which one it is.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('flame', 26); ?>
          <h3>Heat, buzzing or a scorched smell</h3>
          <p>A panel cover warm to the touch, a hum from inside, or discoloring around one breaker points to a loose or failing connection. Treat it as urgent, and switch that breaker off if you can do it safely.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-3">
          <?php echo icon('layers', 26); ?>
          <h3>No room for the next project</h3>
          <p>Hot tub, EV charger, shop or addition: when every breaker space is filled and the main is already near its rating, the next circuit needs a panel or service upgrade first.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== OPTIONS TABLE ===================== -->
  <section class="section pnl-options" aria-labelledby="options-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Repair or replace</span>
        <h2 id="options-title">Does your home need a panel repair, a new panel or a full service upgrade?</h2>
        <p class="answer-block">Goff Electric matches the fix to the fault: repair a breaker or connection, replace a worn-out or full panel, or upgrade the whole service for more amps. Which one applies comes from opening the panel and adding up what the house actually draws, not from a guess over the phone.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <caption>Permit rules differ between the City of Rio Rancho, the City of Albuquerque and Sandoval and Bernalillo counties — confirm with the office for your address.</caption>
          <thead>
            <tr><th scope="col">What changes</th><th scope="col">Panel repair</th><th scope="col">Panel replacement</th><th scope="col">Service upgrade</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">What it fixes</th><td>One failed breaker, a loose lug or a damaged bus connection</td><td>An aged, damaged or completely full panel</td><td>A building that needs more amps than its service delivers</td></tr>
            <tr><th scope="row">Typical trigger</th><td>One circuit trips or runs warm</td><td>No spaces left, corrosion, or a panel brand widely flagged for replacement</td><td>Adding a hot tub, EV charger, shop or refrigerated air to a 100–150 amp service</td></tr>
            <tr><th scope="row">Amperage after</th><td>Unchanged</td><td>Usually unchanged</td><td>Increased, commonly to 200 amps</td></tr>
            <tr><th scope="row">Who is involved</th><td>Goff Electric</td><td>Goff Electric; power is off while the panel is swapped</td><td>Goff Electric and PNM, which disconnects and reconnects the utility feed</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===================== EXPERT POSITIONING ===================== -->
  <section class="section texture-grain edge-torn-top pnl-expert" aria-labelledby="expert-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <span class="floating-ring" aria-hidden="true"></span>
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b>24/7</b>
        <span>Phone answered every day, all night</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why do Rio Rancho homeowners trust Goff Electric with panel work?</h2>
        <p class="answer-block">Rio Rancho homeowners trust Goff Electric with panel work because owner Garrett Goff finds the actual cause before recommending a new panel. Google reviewers describe a new panel installed with great service, a panel and outlet problem diagnosed and fixed at a fair price, and a breaker panel upgrade done with a 220-volt hot tub circuit.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('users', 22); ?><div><b>Names you will see on the job</b><span>Reviews name Garrett Goff and, on one breaker panel upgrade, Rick as the people who did the work.</span></div></li>
          <li><?php echo icon('gauge', 22); ?><div><b>Capacity math before a bigger box</b><span>The panel's rating is checked against everything the building runs. Sometimes the answer is a repair, not a replacement.</span></div></li>
          <li><?php echo icon('cloud-lightning', 22); ?><div><b>Monsoon season in mind</b><span>Lightning season arrives every summer. With the panel open anyway, it is a good moment to ask about whole-home surge protection.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== SCOPE: what happens on an upgrade ===================== -->
  <section class="section pnl-scope" aria-labelledby="scope-title">
    <div class="container sp-split">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Scope of work</span>
          <h2 id="scope-title">What happens during a Goff Electric panel upgrade?</h2>
          <p class="answer-block">A Goff Electric panel upgrade replaces the breaker panel, moves every existing circuit into the new one and labels them. When the service size changes too, the meter base and service entrance conductors are updated and PNM handles the utility feed. Power is off while the panel is swapped, and you know the plan beforehand.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>The old panel, inspected.</b> Brand, condition, amperage, grounding and bonding, and any heat damage around the breakers.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>A load calculation.</b> What the building draws today plus what you plan to add, from a hot tub to a shop.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>New panel and breakers.</b> Sized for the load, with spare spaces, and arc-fault or ground-fault breakers where the code New Mexico has adopted calls for them.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Circuits landed and labeled.</b> Every existing circuit moved over and identified on the directory, so the right breaker is easy to find later.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Utility coordination.</b> When amperage goes up, the disconnect and reconnect are lined up with PNM.</span></li>
        </ul>
        <div class="pnl-history reveal-up">
          <h3>Why so many Rio Rancho panels are due</h3>
          <p>AMREP began developing Rio Rancho in 1961, and the city grew fast through the 1970s, '80s and '90s. Plenty of houses from those decades still have their original 100- or 150-amp panels, sized before refrigerated air, hot tubs and EV chargers were common.</p>
          <p>Some older brands, such as Federal Pacific Stab-Lok and Zinsco, are widely flagged by electricians and home inspectors for replacement. If you are not sure what is in your wall, an <?php echo serviceLink('electrical-inspections', 'electrical safety inspection'); ?> answers that before you spend anything on a new panel.</p>
        </div>
      </div>
      <div class="sp-photos">
        <figure class="sp-photo sp-photo--tall reveal-up">
          <?php echo responsivePicture('gbp-01-additional', 'Commercial electrical room with new panels, a dry-type transformer and EMT conduit runs', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 300px'); ?>
          <figcaption>New panels and a transformer in a commercial electrical room</figcaption>
        </figure>
        <figure class="sp-photo sp-photo--tall reveal-up reveal-delay-2">
          <?php echo responsivePicture('gbp-06-at_work', 'Electrical equipment and conduit mounted on a stucco wall beside the home electric meter', '(max-width: 560px) 90vw, (max-width: 900px) 45vw, 300px'); ?>
          <figcaption>Equipment beside a home's meter, conduit run below grade</figcaption>
        </figure>
      </div>
    </div>
  </section>

  <!-- ===================== PROCESS (sticky storytelling) ===================== -->
  <section class="section pnl-process edge-curve-top" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does a Goff Electric panel replacement run from first call to power back on?</h2>
        <p class="answer-block">A Goff Electric panel replacement runs in four steps, from the first call to every circuit tested with the power back on. You describe the symptoms, the panel is inspected at a no-cost estimate, the swap happens on a day set with you, and nothing is closed up until each breaker is checked.</p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Describe what the panel is doing</h3><p>Which breakers trip, what was running, any heat, smell or noise. A photo of the label inside the panel door helps; the brand and amperage are printed there.</p></li>
        <li class="reveal-up"><h3>Inspection and load numbers</h3><p>The panel is opened and checked and the load is added up. You hear whether a repair will do or a new panel or service makes more sense, and what it costs, before anything is scheduled.</p></li>
        <li class="reveal-up"><h3>Swap day</h3><p>Power is shut off, the old panel comes out, the new one goes in, and circuits are landed and labeled. If the service size changes, PNM is lined up for the disconnect and reconnect.</p></li>
        <li class="reveal-up"><h3>Power on and test</h3><p>Each circuit is energized and checked, and you are shown the new breaker layout before the cover goes back on.</p></li>
      </ol>
    </div>
  </section>

<?php $spProof = spReviews('panel|breaker|new service', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF: matched Google reviews ===================== -->
  <section class="section texture-grain slant-top pnl-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do customers say about Goff Electric panel upgrades and repairs?</h2>
        <p class="answer-block">Customers describe Goff Electric panel work as quick and fairly priced, from a brand-new panel to a breaker panel upgrade done alongside a hot tub circuit. One reviewer said Garrett got them on his schedule fast, found the problem with their panel and an outlet, and fixed it at a fair price. These are their words, from Google.</p>
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
  <section class="section sp-faq pnl-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do homeowners ask Goff Electric about their panels?</h2>
        <p class="answer-block">Homeowners usually ask Goff Electric three panel questions before a job. Does a new charger or hot tub force an upgrade, does surge protection belong in the new panel, and does the work need a permit? Answers are below; for anything else, call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a> or browse <a href="/services/">all Goff Electric services</a>.</p>
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
    ['ev-charger-installation', 'electrical-inspections', '24-7-emergency-electrical-service'],
    'What other services go with a panel upgrade in <span class="text-accent">Rio Rancho</span>?',
    'A panel upgrade in Rio Rancho usually happens because of something else: an EV charger the old panel could not carry, an inspection that turned up a worn-out box, or a breaker that failed at night and needed an emergency call. These three services are the ones most often tied to panel work.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final pnl-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('gauge', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Panel tripping, full or too small?</span>
      <h2 id="final-title">Is your panel ready for what your home runs now?</h2>
      <p>Send the symptoms, or a photo of the panel label, and Goff Electric will check it and give you the options and the price before any work starts.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
