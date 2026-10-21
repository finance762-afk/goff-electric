<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/electrical-inspections/ — Goff Electric (Phase 4, 2026-10-21). Premium editorial service page.
 * Sources: build-plan.json + config.php (electrical safety inspections for homeowners, buyers and businesses with a clear
 * account of what needs attention; licensed & insured; free estimates; 4.9 from 42 reviews; 6 service towns),
 * research-brief FAQs (warning signs; licensing through the NM Construction Industries Division), Google reviews feed
 * (Corrales couple told they did not need an electrician; a short three other electricians missed; options laid out
 * instead of a single answer), public history (AMREP began developing Rio Rancho in 1961).
 * Deliberately NOT claimed (listed in /content-confirmations.json): written report format, certified home-inspector status,
 * insurance 4-point / lender-accepted reports, inspection price, typical visit length.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.php';

$svc          = spService('electrical-inspections');
$pageTitle    = 'Electrical Inspections Rio Rancho NM | Goff Electric';
$pageDescription = 'Electrical safety inspections in Rio Rancho and Albuquerque, NM for owners, buyers and businesses: panel, breakers, outlets, wiring. Book with Goff Electric.';
$canonicalUrl = $siteUrl . '/services/electrical-inspections/';
$currentPage  = 'services';
$pageType     = 'service';
$serviceSlug  = 'electrical-inspections';
$dialogService   = $svc['name'];
$heroFormService = $svc['name'];
$heroFormTagline = 'Tell us why you want it checked: a symptom, a purchase or a new load.';

$heroImage   = 'gbp-08-at_work';
$heroPreload = ['srcset' => imageSrcset($heroImage, 'avif'), 'sizes' => '100vw'];
$phoneText   = formatPhone($phone);

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/electrical-inspections/'],
];
$schemaMarkup = spSchema($svc, $canonicalUrl, $pageTitle, $pageDescription, $crumbs, '/assets/images/' . $heroImage . '-960.webp');

/* FAQs — research-brief questions only, reworded conversationally (visible text, never FAQPage JSON-LD) */
$faqs = [
    [
        'q' => 'What warning signs mean my house should be checked by an electrician?',
        'a' => 'Breakers that trip often, lights that flicker or dim, outlets or switches that feel warm or look discolored, a burning smell, or a panel that buzzes. Each can point to an overload or a failing connection that creates a fire risk, so have it looked at rather than waiting to see whether it gets worse.',
    ],
    [
        'q' => 'Is Goff Electric licensed and insured to inspect electrical systems in New Mexico?',
        'a' => 'Yes. Goff Electric is a licensed and insured New Mexico electrical contractor. Electrical contractors in New Mexico hold licenses issued through the state Construction Industries Division (CID), and you can look up any contractor&rsquo;s license status with CID before work starts.',
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo spStyles(); ?>
<style>
/* ==========================================================================
   Electrical inspections — page composition. Tokens only.
   ========================================================================== */
.hero--insp { --sp-hero-pos: 50% 20%; }

/* Checklist table first: paper band slanted over the hero, numbered rows */
.insp-check { background: var(--color-paper); }
.insp-check__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.5fr); gap: var(--space-xl) var(--space-3xl); align-items: start; }
.insp-check .sp-table { counter-reset: insp-row; }
.insp-check .sp-table tbody th { width: 34%; }
.insp-check .sp-table tbody th::before { counter-increment: insp-row; content: counter(insp-row, decimal-leading-zero); display: inline-block; min-width: 2.2em; font-family: var(--font-accent); color: var(--color-accent-dark); }
.insp-check .sp-table tbody tr:hover > * { background: color-mix(in srgb, var(--color-accent) 7%, var(--color-surface)); }
@media (max-width: 1000px) { .insp-check__grid { grid-template-columns: 1fr; } }

/* When-to-inspect: dark band with parallelogram edge; light cards read on dark */
.insp-when .sp-head { max-width: 64ch; }
.insp-when .sp-sign--lead { background: var(--color-accent); border-color: var(--color-accent); }
.insp-when .sp-sign--lead h3, .insp-when .sp-sign--lead p, .insp-when .sp-sign--lead svg { color: var(--color-ink); }
.insp-when .sp-pull { margin-top: var(--space-2xl); }

/* Who it's for: white band, three audience rows beside photos */
.insp-who { background: var(--color-surface); }
.insp-aud { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-md); }
.insp-aud li { display: grid; grid-template-columns: 44px minmax(0, 1fr); gap: var(--space-sm); padding: var(--space-md); border-radius: var(--radius-lg); background: var(--color-paper); border: 1px solid var(--color-line); }
.insp-aud li > svg { width: 44px; height: 44px; padding: var(--space-2); border-radius: var(--radius); background: var(--color-dark); color: var(--color-accent); }
.insp-aud b { display: block; font-family: var(--font-heading); font-size: 1.1rem; text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); }
.insp-aud span { font-size: var(--fs-small); color: var(--color-ink-2); }
.insp-who .sp-photo--wide { margin-top: var(--space-md); }

/* Expert on alt band, process on paper with a curved edge */
.insp-expert { background: var(--color-paper-2); }
.insp-process { background: var(--color-paper); }
.insp-process .sp-steps li:first-child { border-left: 4px solid var(--color-accent); }

/* Proof dark, FAQ white */
.insp-proof .sp-review:first-child { border-top: 4px solid var(--color-accent); }
.insp-faq { background: var(--color-surface); }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--photo hero--interior hero--service hero--insp" aria-labelledby="hero-title">
  <div class="hero-bg"><?php echo responsivePicture($heroImage, 'Inside of an open panelboard showing breakers and the conductors landed on them', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']); ?></div>
  <div class="hero-overlay"></div>
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <?php echo spCrumbs($crumbs); ?>
    <div class="hero-grid hero-grid--form">
      <div class="hero-text hero-copy">
        <span class="eyebrow">Safety checks · homes, buyers, businesses</span>
        <h1 class="hero-title" id="hero-title">Electrical inspections in <span class="text-accent">Rio Rancho</span>, NM</h1>
        <p class="hero-answer">Goff Electric checks your panel, wiring and outlets and says plainly what needs work.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong></span></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('clipboard-check', 16); ?>Homes, buyers &amp; businesses</li>
          <li><?php echo icon('shield-check', 16); ?>Licensed &amp; insured</li>
          <li><?php echo icon('badge-check', 16); ?>Free estimates</li>
        </ul>
      </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

  <!-- ===================== CHECKLIST (what's included) ===================== -->
  <section class="section insp-check slant-top" aria-labelledby="check-title">
    <div class="container insp-check__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow-label">The checklist</span>
        <h2 id="check-title">What does a Goff Electric electrical inspection check?</h2>
        <p class="answer-block">A Goff Electric electrical inspection checks the panel and breakers, grounding and bonding, GFCI and AFCI protection, outlets and switches, visible wiring and the service entrance. You come away with a clear list of what needs attention and what is fine as it is, so nothing gets replaced just because it is old.</p>
      </div>
      <div class="sp-table-wrap reveal-right">
        <table class="sp-table">
          <caption>Code expectations depend on the edition in force when the work was done; an older home is not automatically out of compliance.</caption>
          <thead>
            <tr><th scope="col">Area checked</th><th scope="col">What it can catch</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row">Panel and breakers</th><td>Heat damage, loose terminations, two wires under one breaker, a panel brand widely flagged for replacement, no room left for new circuits</td></tr>
            <tr><th scope="row">Grounding and bonding</th><td>Missing or loose ground and bonding connections at the service and on metal water and gas piping</td></tr>
            <tr><th scope="row">GFCI and AFCI protection</th><td>Kitchen, bath, garage and outdoor outlets without shock protection; bedroom circuits without arc-fault protection where it applies</td></tr>
            <tr><th scope="row">Outlets and switches</th><td>Warm, loose, discolored or reverse-wired devices, and three-prong outlets on circuits with no ground</td></tr>
            <tr><th scope="row">Visible wiring</th><td>Damaged cable, open splices, extension cords used as wiring, do-it-yourself additions in garages and attics</td></tr>
            <tr><th scope="row">Service entrance</th><td>The meter base, mast and service conductors, checked for damage and for weathering from high-desert sun and storms</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===================== PROBLEM: when to inspect ===================== -->
  <section class="section texture-grain edge-parallelogram-top insp-when" aria-labelledby="when-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">When to call</span>
        <h2 id="when-title">When should a Rio Rancho or Albuquerque home get an electrical inspection?</h2>
        <p class="answer-block">Schedule a Goff Electric inspection when warning signs appear, before buying an older home, or before adding a big load. Warning signs include breakers that trip often, lights that flicker or dim, warm or discolored outlets, a burning smell and a panel that buzzes; any of them is worth a professional look.</p>
      </div>
      <div class="sp-signs">
        <div class="sp-sign sp-sign--lead reveal-up">
          <?php echo icon('alert-triangle', 32); ?>
          <h3>Something seems off</h3>
          <p>A flicker when the cooler kicks on, a switch plate that feels warm, a breaker that has started tripping. Small symptoms are cheaper to chase down before they become an outage.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-1">
          <?php echo icon('house', 26); ?>
          <h3>Buying an older house</h3>
          <p>Much of Rio Rancho went up in the decades after AMREP started the community in 1961. Original panels and wiring from the '70s and '80s are worth a look before closing.</p>
        </div>
        <div class="sp-sign reveal-up reveal-delay-2">
          <?php echo icon('plug-zap', 26); ?>
          <h3>Before a hot tub, charger or shop</h3>
          <p>Adding a large load is the moment to know what the panel and existing wiring can actually carry, before the equipment arrives.</p>
        </div>
      </div>
      <p class="sp-pull reveal-up">Sometimes the most useful result of an inspection is hearing that nothing needs to be done.</p>
    </div>
  </section>

  <!-- ===================== WHO IT'S FOR ===================== -->
  <section class="section insp-who" aria-labelledby="who-title">
    <div class="container sp-split">
      <div>
        <div class="sp-head reveal-up">
          <span class="eyebrow-label">Who it's for</span>
          <h2 id="who-title">Who uses Goff Electric's electrical inspections?</h2>
          <p class="answer-block">Homeowners, home buyers and business owners in Rio Rancho, Albuquerque, Corrales, Bernalillo, Placitas and Tijeras use Goff Electric's electrical inspections. Owners want to know if a symptom is serious, buyers want to know what an older house will need, and businesses want equipment and panels checked before changes.</p>
        </div>
        <ul class="insp-aud reveal-up">
          <li><?php echo icon('house', 24); ?><div><b>Homeowners</b><span>A symptom you cannot explain, or a house you have never had looked at. If the check turns up a failing panel, the next step is <?php echo serviceLink('electrical-panel-upgrades-repair', 'panel repair or an upgrade'); ?>.</span></div></li>
          <li><?php echo icon('clipboard-list', 24); ?><div><b>Home buyers</b><span>A general home inspection report often says "have an electrician evaluate" next to a few items. An electrician's look tells you what those items actually involve before you negotiate or close.</span></div></li>
          <li><?php echo icon('building-2', 24); ?><div><b>Businesses</b><span>Electrical rooms, panelboards and conduit runs like the ones pictured, checked for heat and capacity before new equipment or a tenant build-out. Problems found in the walls lead to <?php echo serviceLink('electrical-wiring-installation-repair', 'wiring repair'); ?>.</span></div></li>
        </ul>
      </div>
      <div>
        <figure class="sp-photo sp-photo--wide reveal-right">
          <?php echo responsivePicture('gbp-01-additional', 'Commercial electrical room with panels, a dry-type transformer, EMT conduit runs and spools of wire', '(max-width: 900px) 90vw, 480px'); ?>
          <figcaption>Commercial electrical room: panels, a transformer and conduit</figcaption>
        </figure>
        <figure class="sp-photo sp-photo--wide reveal-right reveal-delay-2">
          <?php echo responsivePicture('gbp-03-additional', 'Parallel EMT conduit runs dropping into a wireway between electrical panels', '(max-width: 900px) 90vw, 480px'); ?>
          <figcaption>Conduit runs dropping into a wireway between panels</figcaption>
        </figure>
      </div>
    </div>
  </section>

  <!-- ===================== EXPERT POSITIONING ===================== -->
  <section class="section insp-expert" aria-labelledby="expert-title">
    <div class="container sp-expert">
      <div class="sp-figure reveal-left">
        <b><?php echo esc(number_format((float) $gbpRating, 1)); ?></b>
        <span>Google rating · <a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo (int) $gbpReviewCount; ?> reviews</a></span>
      </div>
      <div class="reveal-right">
        <span class="eyebrow-label">Why Goff Electric</span>
        <h2 id="expert-title">Why trust Goff Electric to tell you what does not need fixing?</h2>
        <p class="answer-block">You can trust a Goff Electric inspection because owner Garrett Goff separates real problems from things that are fine as they are. Google reviewers describe Garrett explaining the job and laying out options instead of selling the biggest fix, and one credits Goff Electric with finding a fault that three other electricians had missed.</p>
        <ul class="sp-diffs">
          <li><?php echo icon('thumbs-up', 22); ?><div><b>Options, not a single answer</b><span>One reviewer wrote that Garrett gave options for the work instead of only telling them what they needed.</span></div></li>
          <li><?php echo icon('users', 22); ?><div><b>The owner on site</b><span>Google reviews name owner Garrett Goff as the electrician who came out and did the work.</span></div></li>
          <li><?php echo icon('building-2', 22); ?><div><b>Houses and electrical rooms</b><span>The same eyes on a 1980s Rio Rancho house and on a commercial electrical room with its own transformer.</span></div></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===================== PROCESS (sticky storytelling) ===================== -->
  <section class="section insp-process edge-curve-top" aria-labelledby="process-title">
    <div class="container sp-process">
      <div class="sp-process__head reveal-left">
        <span class="eyebrow-label">How it runs</span>
        <h2 id="process-title">How does a Goff Electric electrical inspection work?</h2>
        <p class="answer-block">A Goff Electric electrical inspection works in four steps: you say why you want it, the system is walked from the service entrance to the outlets, the findings are gone over with you on site, and you decide what happens next. Any repair is priced before it is started.</p>
      </div>
      <ol class="sp-steps">
        <li class="reveal-up"><h3>Tell us why you're asking</h3><p>A symptom, a house you are buying, a new hot tub or charger, or a commercial space changing hands. The reason shapes where the inspection spends its time.</p></li>
        <li class="reveal-up"><h3>Walk the system</h3><p>The panel is opened, outlets are tested, and visible wiring in the garage, attic and crawlspaces is checked, along with the meter and service outside.</p></li>
        <li class="reveal-up"><h3>Go over the findings</h3><p>You hear what needs attention, what can wait and what is fine, in plain language, while you are standing next to it.</p></li>
        <li class="reveal-up"><h3>Decide what's next</h3><p>Repairs are priced so you can decide. Have Goff Electric do them, take the list elsewhere, or do nothing if nothing is needed.</p></li>
      </ol>
    </div>
  </section>

<?php $spProof = spReviews('didn.t even need|shortage', 3); if ($spProof !== ''): ?>
  <!-- ===================== PROOF: matched Google reviews ===================== -->
  <section class="section texture-grain slant-top insp-proof" aria-labelledby="proof-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">On Google</span>
        <h2 id="proof-title">What do customers say about Goff Electric's straight answers?</h2>
        <p class="answer-block">Customers say Goff Electric gives a straight answer, even when the answer is that no work is needed. A Corrales couple who called to hire Goff Electric were told the setup they already had was right and they did not need an electrician at all, and another customer credits Garrett with finding a short others missed.</p>
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
  <section class="section sp-faq insp-faq" aria-labelledby="faq-title">
    <div class="container">
      <div class="sp-head reveal-up">
        <span class="eyebrow-label">Questions</span>
        <h2 id="faq-title">What do people ask before scheduling an electrical inspection?</h2>
        <p class="answer-block">People ask Goff Electric two things before an electrical inspection: which warning signs justify one, and whether Goff Electric holds a New Mexico license. Both answers are below. For anything else, call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a> or see <a href="/services/">every service Goff Electric offers</a>.</p>
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
    'What work usually follows an electrical inspection in <span class="text-accent">Rio Rancho</span>?',
    'When an inspection in Rio Rancho does turn something up, it usually lands in one of three places: a panel that needs repair or replacement, wiring that needs a fault fixed or a run replaced, or outlets and switches that need GFCI protection or new devices.'
); ?>

<!-- ===================== FINAL CTA ===================== -->
<section class="closing-cta texture-grain slant-top sp-final insp-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-accent float-animate-slow" aria-hidden="true"><?php echo icon('clipboard-check', 340); ?></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Not sure what you have?</span>
      <h2 id="final-title">Want a straight answer on your home's wiring?</h2>
      <p>Tell Goff Electric why you want the system checked and where the property is. You will hear what needs attention, and what does not.</p>
    </div>
    <div class="actions reveal-right">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="btn btn-outline-white btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
