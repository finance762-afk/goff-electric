<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/24-7-emergency-electrical-service/ — Goff Electric (Phase 4, 2026-10-21). Speed-to-call service page:
 * type hero (no photo — the phone number is the hero), "what to do right now" steps straight after it.
 * Sources: build-plan.json + config.php (round-the-clock hours and emergency service per business_hours, licensed & insured, 4.9 from
 * 42 reviews, six towns), research-brief FAQs (surge protection, licensing), Google reviews feed (cut power line
 * isolated after 7 p.m. and reported to the power company; a short three other electricians missed; "super fast",
 * "rapid response"). Safety steps are general guidance; PNM named as the utility for most of the metro.
 * Not supplied by intake (left out, listed in /content-confirmations.json): response time, after-hours rates,
 * generator/temporary power, which utilities' territories are covered.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('24-7-emergency-electrical-service');
$pageTitle    = '24/7 Emergency Electrician Rio Rancho NM | Goff Electric';
$pageDescription = 'Emergency electrician for Rio Rancho and Albuquerque, NM, at any hour: power loss, breakers that will not reset, burning smells and storm damage. Goff Electric.';
$canonicalUrl = $siteUrl . '/services/24-7-emergency-electrical-service/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = '24-7-emergency-electrical-service';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTitle   = 'Not urgent? Request a visit.';
$heroFormTagline = 'For sparks, smoke or no power, call the number instead.';
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/24-7-emergency-electrical-service/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/gbp-08-at_work-960.webp');

/* FAQs — research-brief questions only (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'Should I add surge protection after a monsoon storm damages my electronics?',
        'a' => 'It is worth asking about. Summer monsoon storms bring frequent lightning to Rio Rancho and Albuquerque, and a surge protective device at the panel helps shield appliances, refrigerated air equipment and electronics from the next one. After a storm call, Goff Electric can check the panel and tell you what would fit.',
    ],
    [
        'q' => 'Is Goff Electric licensed and insured for emergency repairs?',
        'a' => 'Yes. Goff Electric holds a New Mexico electrical contractor license and carries insurance, and emergency calls are handled by the same company that does its scheduled work. New Mexico electrical contractors hold licenses issued by the state Construction Industries Division, where any license can be looked up.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Emergency electrical — page composition. Tokens only.
   ========================================================================== */
/* Type hero: no photo, brushed dark gradient, faint bolt watermark, the number up front */
.hero--emergency { background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-primary-deep) 60%, var(--color-dark-alt) 100%); }
.emg-mark { position: absolute; z-index: -1; right: -4%; top: 12%; width: clamp(260px, 36vw, 520px); color: var(--color-accent); opacity: .07; pointer-events: none; }
.emg-mark svg { width: 100%; height: auto; }
.emg-number { display: inline-flex; align-items: center; gap: var(--space-sm); font-family: var(--font-heading); font-size: clamp(1.9rem, 1.3rem + 2.2vw, 2.8rem); line-height: 1; color: var(--color-white); text-decoration: none; }
.emg-number svg { color: var(--color-accent); }
.emg-number:hover { color: var(--color-accent-bright); }
.hero--emergency .emg-live { display: inline-flex; align-items: center; gap: var(--space-xs); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.hero--emergency .emg-live::before { content: ""; width: var(--space-xs); height: var(--space-xs); border-radius: var(--radius-full); background: var(--color-success); box-shadow: 0 0 0 4px color-mix(in srgb, var(--color-success) 30%, transparent); }
.hero--emergency .hero-chips li { background: color-mix(in srgb, var(--color-white) 8%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.hero--emergency .text-accent { color: var(--color-accent-bright); }
.hero--emergency .hero-chips svg { color: var(--color-accent-bright); }
.hero--emergency .hero-answer { color: color-mix(in srgb, var(--color-white) 85%, transparent); }
@media (max-width: 560px) { .emg-number { font-size: 1.75rem; } .emg-mark { top: auto; bottom: -10%; } }

/* Right now: paper band over the hero, numbered action cards */
.emg-now { background: var(--color-paper); }
.emg-now__list { list-style: none; counter-reset: emg; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-md); }
.emg-now__list li { counter-increment: emg; position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-xl) var(--space-lg) var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-top: 4px solid var(--color-danger); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); }
.emg-now__list li::before { content: counter(emg); position: absolute; top: var(--space-sm); right: var(--space-md); font-family: var(--font-accent); font-size: 2.2rem; line-height: 1; color: var(--color-line); }
.emg-now__list b { font-family: var(--font-heading); font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); }
.emg-now__list span { font-size: var(--fs-small); color: var(--color-ink-2); }
.emg-now__list li:nth-child(n+3) { border-top-color: var(--color-accent); }
@media (max-width: 1000px) { .emg-now__list { grid-template-columns: 1fr 1fr; } }
@media (max-width: 560px) { .emg-now__list { grid-template-columns: 1fr; } }

/* Signs: white band; Proof: dark torn band; Expert: paper */
.emg-signs { background: var(--color-surface); }
.emg-signs .sp-sign--lead { background: linear-gradient(160deg, var(--color-dark), var(--color-primary-deep)); }
.emg-proof.edge-torn-top { margin-top: -18px; z-index: 1; }
.emg-expert { background: var(--color-paper); }
.emg-expert .sp-figure b { color: var(--color-accent-dark); }

/* What happens on a call: white, photo framed left */
.emg-call { background: var(--color-surface); }
.emg-call .sp-photo { aspect-ratio: 4 / 5; max-width: 26rem; }

/* Who to call table, process, FAQ */
.emg-who { background: var(--color-paper-2); }
.emg-who .sp-table td:nth-child(2) { font-weight: 600; color: var(--color-ink); white-space: nowrap; }
.emg-process { background: var(--color-paper); }
.emg-faq { background: var(--color-surface); }
</style>

<!-- ===================== HERO (type: the phone number is the hero) ===================== -->
<section class="hero hero--type hero--interior hero--service hero--emergency" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <span class="emg-mark" aria-hidden="true"><?php echo icon('zap', 520); ?></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="emg-live">Emergency line open now</span>
        <h1 class="hero-title" id="hero-title">24/7 emergency electrician in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric answers emergency electrical calls day and night across the metro.</p>
        <a class="emg-number" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 30); ?><?php echo esc($phoneText); ?></a>
        <div class="hero-actions">
          <a class="btn btn-primary btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call now</a>
          <button type="button" class="btn btn-outline-white btn-lg hero-form-open" data-open-estimate>Request a visit</button>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('clock', 16); ?>Nights &amp; weekends</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('star', 16); ?><?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google · <?php echo (int) $gbpReviewCount; ?> reviews</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== RIGHT NOW: safety steps ===================== -->
  <section class="section emg-now slant-top" aria-labelledby="now-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Before you do anything else</span>
        <h2 id="now-title">What should you do right now during an electrical emergency?</h2>
        <p class="answer-block">During an electrical emergency, get people safe first, then call Goff Electric at <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>. Smoke or flames mean 911 before anyone else, and a dark street means the utility, not an electrician. These four steps cover the calls that come in most.</p>
      </div>
      <ol class="emg-now__list">
        <li class="reveal-up reveal-delay-1"><b>Smoke, flames or a hot panel</b><span>Get everyone out and call 911. Do not open the panel or try to reset anything.</span></li>
        <li class="reveal-up reveal-delay-2"><b>Sparking or scorched outlet</b><span>If you can reach the panel safely with dry hands, switch that circuit's breaker off. Then call.</span></li>
        <li class="reveal-up reveal-delay-3"><b>Breaker trips again</b><span>Leave it off. Resetting a breaker over and over forces current back into whatever fault tripped it.</span></li>
        <li class="reveal-up reveal-delay-4"><b>Whole street is dark</b><span>That is a utility outage. Report it to PNM, the utility for most of the metro, and stay well clear of any downed line.</span></li>
      </ol>
    </div>
  </section>

  <!-- ===================== PROBLEM: what can't wait ===================== -->
  <section class="section emg-signs" aria-labelledby="signs-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Can it wait?</span>
        <h2 id="signs-title">Which electrical problems can't wait until morning?</h2>
        <p class="answer-block">Electrical problems that can't wait are the ones that produce heat or leave part of a house without safe power: a burning smell, a buzzing panel, half the house dead, or damage after a storm. Goff Electric takes those calls at night and on weekends across Rio Rancho and Albuquerque.</p>
      </div>
      <p class="sp-pull reveal-left">If it smells hot, it is not a tomorrow problem.</p>
      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('flame', 32); ?>
          <h3>Burning smell or a buzzing panel</h3>
          <p>Heat at a connection, a breaker or the panel itself is how electrical fires start. Turn off what you safely can and call.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('home', 26); ?>
          <h3>Half the house dead</h3>
          <p>Some rooms out while others work, or lights going bright and dim together, can point to a failing connection at the service.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('cloud-lightning', 26); ?>
          <h3>Monsoon storm damage</h3>
          <p>From roughly July through September, lightning and wind across Sandoval and Bernalillo counties leave tripped mains, fried devices and damaged service masts.</p>
        </div>
      </div>
    </div>
  </section>

<?php $spProof = spReviews('power line|shortage|super fast', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF: matched Google reviews ===================== -->
  <section class="section texture-grain edge-torn-top emg-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do customers say about Goff Electric's emergency calls?</h2>
        <p class="answer-block">Customers say Goff Electric showed up when other electricians couldn't, stayed until the fault was found, and fixed it fast at a fair price. These Google reviews describe a cut power line, a short three other electricians missed and a panel problem, shown word for word.</p>
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
  <section class="section emg-expert" aria-labelledby="expert-title">
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b>24/7</b>
        <span>One phone line · <?php echo count($serviceAreas); ?> towns, Rio Rancho to Tijeras</span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why call Goff Electric when the power fails after hours?</h2>
        <p class="answer-block">Call Goff Electric after hours because owner Garrett Goff keeps working a fault until he finds it, even when it turns out not to be yours. When a cable crew cut one homeowner's power line, Garrett came after 7 p.m. and traced the problem to the utility side.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('search', 22); ?><div><b>Finds what others missed</b><span>One reviewer had three other electricians out for a short before Goff Electric found it.</span></div></li>
          <li><?php echo icon('route', 22); ?><div><b>Knows where your side ends</b><span>On that cut-line call, Garrett spent over an hour isolating the fault, found it was off the property, and called the power company to report it.</span></div></li>
          <li><?php echo icon('phone', 22); ?><div><b>Answers when others don't</b><span>That homeowner had tried several electricians who could not come the same day before he reached Goff Electric.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== WHAT HAPPENS ON A CALL ===================== -->
  <section class="section emg-call edge-curve-top" aria-labelledby="included-title">
    <div class="container sp-split sp-split--flip">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">On site</span>
          <h2 id="included-title">What does Goff Electric do on an emergency electrical call?</h2>
          <p class="answer-block">On an emergency electrical call, Goff Electric finds the fault, makes the circuit or the house safe, and then repairs it on the spot or explains the permanent fix. If the problem is on the utility side, you are told so and the utility gets the report.</p>
        </div>
        <ul class="sp-included reveal-up">
          <li><?php echo icon('check-circle', 20); ?><span><b>Trace the fault.</b> Panel, breakers, connections and the circuit run, until the cause is found instead of guessed.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Make it safe.</b> The damaged circuit is isolated so the rest of the house or business can run.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Repair what can be repaired now.</b> A failed breaker, a burned device or a loose termination is replaced on the visit when the parts allow.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Plan the bigger fix.</b> If a panel is failing, you get the options for <?php echo serviceLink('electrical-panel-upgrades-repair', 'panel repair or replacement'); ?>; damaged runs lead to <?php echo serviceLink('electrical-wiring-installation-repair', 'wiring repair'); ?>.</span></li>
          <li><?php echo icon('check-circle', 20); ?><span><b>Report utility-side problems.</b> Faults at the line or the transformer go to the power company, as they did on the cut-line call above.</span></li>
        </ul>
      </div>
      <figure class="sp-photo reveal-left">
        <?php echo responsivePicture('gbp-08-at_work', 'Open panelboard with breakers and color-coded conductors landed on them', '(max-width: 900px) 90vw, 420px'); ?>
        <figcaption>An opened panelboard: breakers and the conductors landed on them</figcaption>
      </figure>
    </div>
  </section>

  <!-- ===================== WHO TO CALL (comparison table) ===================== -->
  <section class="section emg-who" aria-labelledby="who-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Electrician or utility?</span>
        <h2 id="who-title">Is it an electrician problem or a PNM problem?</h2>
        <p class="answer-block">It is an electrician problem when the fault is on your side of the meter and a PNM problem when the street, the line or the transformer is involved. If only your house is dark while neighbors have lights, check the main breaker, then call Goff Electric to trace it.</p>
      </div>
      <div class="sp-table-wrap reveal-up">
        <table class="sp-table">
          <caption>General guidance. Report outages and downed lines to your utility (PNM for most of Rio Rancho and Albuquerque).</caption>
          <thead>
            <tr><th scope="col">What you see</th><th scope="col">Call first</th><th scope="col" class="is-us">What Goff Electric does</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Whole street or block dark</th><td>The utility</td><td class="is-us">Nothing needed, unless your power does not come back when the neighbors' does</td></tr>
            <tr><th scope="row">Only your house dark</th><td>Main breaker, then Goff Electric</td><td class="is-us">Traces whether the fault is in the house, at the meter base or on the utility side</td></tr>
            <tr><th scope="row">One room or circuit dead</th><td>Goff Electric</td><td class="is-us">Finds the failed breaker, device or loose connection</td></tr>
            <tr><th scope="row">Burning smell or smoke</th><td>911, then Goff Electric</td><td class="is-us">Finds the overheated connection once the scene is safe</td></tr>
            <tr><th scope="row">Line down in the yard</th><td>911 and the utility</td><td class="is-us">Repairs damage on your side once the utility has made the line safe</td></tr>
            <tr><th scope="row">After a lightning strike</th><td>Goff Electric</td><td class="is-us">Checks the panel, breakers and damaged devices</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===================== PROCESS (sticky storytelling) ===================== -->
  <section class="section emg-process edge-wave-top" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does an emergency call with Goff Electric work?</h2>
        <p class="answer-block">An emergency call with Goff Electric starts on the phone, not the web form: you describe what you see, smell or hear, the fault is found and made safe on site, and it is either repaired on the visit or priced as a follow-up job. Nights and weekends included.</p>
        <p><a class="btn btn-secondary" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 16); ?>Call <?php echo esc($phoneText); ?></a></p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Call, don't type</h3><p>For anything urgent the phone is faster than the form. The line is answered at any hour.</p></li>
        <li class="reveal-up"><h3>Answer a few questions</h3><p>One circuit or the whole house? Do the neighbors have power? Any smell or heat? The answers sort an electrician call from a utility call.</p></li>
        <li class="reveal-up"><h3>Find it and make it safe</h3><p>On site, the fault is isolated so the rest of the building can run while the cause is traced.</p></li>
        <li class="reveal-up"><h3>Fix now or plan the fix</h3><p>Small failures are repaired on the visit; a failing panel or damaged run gets a clear scope and price before more work starts.</p></li>
      </ol>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section class="section sp-faq emg-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do people ask Goff Electric after an electrical emergency?</h2>
        <p class="answer-block">After an electrical emergency, people ask Goff Electric how to protect the house from the next storm and whether the company is licensed. Short answers are below; for <?php echo serviceLink('outlets-switches', 'scorched or dead outlets'); ?> or anything else, see <a href="/services/">all Goff Electric services</a>.</p>
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
    ['electrical-panel-upgrades-repair', 'electrical-wiring-installation-repair', 'outlets-switches'],
    'What repairs usually follow an emergency call in <span class="text-accent">Rio Rancho</span>?',
    'After an emergency call in Rio Rancho or Albuquerque, the follow-up work is usually a panel repair or replacement, rewiring a damaged or overheated run, or replacing outlets and switches that failed. Each of those services has its own page explaining what the job involves.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final emg-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('cloud-lightning', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Power out? Breaker won't reset?</span>
      <h2 id="final-title">Need an electrician tonight in Rio Rancho or Albuquerque?</h2>
      <p>Call Goff Electric and describe what you see. If it can wait, send the details instead and you will get a call back to set up a visit.</p>
      <small>Smoke or flames? Get out and call 911 first.</small>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc($phoneText); ?></a>
      <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Request a visit</button>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
