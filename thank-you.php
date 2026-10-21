<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * thank-you.php — where every lead form lands (_next = $siteUrl/thank-you). Phase 5, 2026-10-21.
 * noindex ($noindex), no estimate dialog ($noEstimateDialog — the visitor just sent one). Confirmation → what happens
 * next (no promised response time: intake did not supply one) → emergency call → links back to every built service →
 * Google review link for existing customers (GBP place_id review URL from build-plan integrations).
 */
$pageTitle        = 'Thank You | Goff Electric, Rio Rancho Electrician';
$pageDescription  = 'Thanks for contacting Goff Electric in Rio Rancho, NM. Your estimate request is in; here is what happens next.';
$canonicalUrl     = $siteUrl . '/thank-you';
$noindex          = true;
$noEstimateDialog = true;
$currentPage      = '';
$pageType         = 'other';
$phoneText        = formatPhone($phone);

$tyServices = [];
foreach ($services as $tySvc) {
    $tyUrl = serviceUrl($tySvc['slug']);
    if ($tyUrl !== '') $tyServices[] = ['name' => $tySvc['name'], 'url' => $tyUrl];
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ==========================================================================
   Thank you — Goff Electric. Confirmation hero with a lit "bulb" check, next-steps rail, services index. Tokens only.
   ========================================================================== */
.hero--thanks { padding-bottom: calc(var(--space-3xl) + 3.5vw); background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 130%); }
.hero--thanks .grain { z-index: -1; opacity: .3; }
.hero--thanks::before { content: ""; position: absolute; left: 50%; top: 30%; width: min(70vw, 720px); aspect-ratio: 1; transform: translate(-50%, -50%); z-index: -1; pointer-events: none; background: radial-gradient(closest-side, rgba(var(--color-accent-rgb), .22), transparent 70%); }
.hero--thanks .container { display: grid; justify-items: center; text-align: center; }
.hero--thanks .hero-text { justify-items: center; max-width: 40rem; }
.hero--thanks .hero-title { max-width: 22ch; }
.hero--thanks .text-accent { color: var(--color-accent-bright); }
.hero--thanks .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.ty-badge { width: calc(var(--space-4xl) + var(--space-md)); height: calc(var(--space-4xl) + var(--space-md)); display: grid; place-items: center; border-radius: var(--radius-full); background: var(--color-accent); color: var(--color-ink); box-shadow: 0 0 0 var(--space-xs) rgba(var(--color-accent-rgb), .25), 0 0 var(--space-3xl) rgba(var(--color-accent-rgb), .45); animation: ty-glow 2.4s var(--ease) infinite alternate; }
@keyframes ty-glow { from { box-shadow: 0 0 0 var(--space-xs) rgba(var(--color-accent-rgb), .25), 0 0 var(--space-xl) rgba(var(--color-accent-rgb), .3); } to { box-shadow: 0 0 0 var(--space-sm) rgba(var(--color-accent-rgb), .18), 0 0 var(--space-3xl) rgba(var(--color-accent-rgb), .55); } }
.hero--thanks .hero-actions { justify-content: center; }
.hero--thanks .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.hero--thanks .link-call svg { color: var(--color-accent-bright); }
.hero--thanks .link-call strong { color: var(--color-white); }

.ty-next { background: var(--color-paper); margin-top: -3.5vw; z-index: 1; }
.ty-next__head { display: grid; gap: var(--space-sm); margin-bottom: var(--space-2xl); max-width: 60ch; }
.ty-steps { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-lg); counter-reset: ty-step; position: relative; }
.ty-steps::before { content: ""; position: absolute; left: 0; right: 0; top: calc(var(--space-xl) - 1px); height: 2px; background: linear-gradient(90deg, var(--color-accent), color-mix(in srgb, var(--color-accent) 15%, transparent)); }
.ty-steps li { counter-increment: ty-step; position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: calc(var(--space-2xl) + var(--space-lg)) var(--space-lg) var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); }
.ty-steps li::before { content: counter(ty-step, decimal-leading-zero); position: absolute; top: var(--space-md); left: var(--space-lg); display: grid; place-items: center; width: var(--space-2xl); height: var(--space-2xl); border-radius: var(--radius-full); background: var(--color-dark); color: var(--color-accent); font-family: var(--font-accent); font-size: 1.1rem; }
.ty-steps h3 { text-transform: uppercase; letter-spacing: .02em; }
.ty-steps p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.ty-urgent { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: var(--space-md) var(--space-xl); margin-top: var(--space-2xl); padding: var(--space-lg); background: var(--color-dark); color: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: var(--radius-lg); }
.ty-urgent p { margin: 0; max-width: 60ch; color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.ty-urgent strong { color: var(--color-white); }
@media (max-width: 900px) { .ty-steps { grid-template-columns: 1fr; } .ty-steps::before { display: none; } }

.ty-services { background: var(--color-surface); }
.ty-services__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.6fr); gap: var(--space-xl) var(--space-3xl); align-items: start; }
.ty-services .service-links { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.ty-services .service-link-card { display: flex; align-items: center; justify-content: space-between; gap: var(--space-sm); border-left: 3px solid var(--color-accent); }
.ty-services .service-link-card svg { color: var(--color-accent-dark); flex: 0 0 auto; transition: transform var(--transition); }
.ty-services .service-link-card:hover svg { transform: translateX(3px); }
.ty-review { display: grid; gap: var(--space-sm); margin-top: var(--space-xl); padding: var(--space-lg); background: var(--color-card-tint-3); border-radius: var(--radius-lg); }
.ty-review h3 { text-transform: uppercase; letter-spacing: .02em; }
.ty-review p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.ty-review .btn { justify-self: start; }
@media (max-width: 900px) { .ty-services__grid { grid-template-columns: 1fr; } }
@media (max-width: 520px) { .ty-services .service-links { grid-template-columns: 1fr; } }
</style>

<section class="hero hero--interior hero--thanks" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-text hero-copy">
      <span class="ty-badge" aria-hidden="true"><?php echo icon('check', 44); ?></span>
      <span class="eyebrow">Request received</span>
      <h1 class="hero-title" id="hero-title">Thank you. <span class="text-accent">Goff Electric</span> has your request.</h1>
      <p class="hero-answer">Your estimate request reached Goff Electric in Rio Rancho. Keep your phone nearby: you will hear back by phone or email to set up the free estimate.</p>
      <div class="hero-actions">
        <a class="btn btn-accent btn-lg" href="/">Back to the home page</a>
        <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>Urgent? <strong><?php echo esc($phoneText); ?></strong>, 24/7</span></a>
      </div>
    </div>
  </div>
</section>

<section class="section ty-next slant-top" aria-labelledby="next-title">
  <div class="container">
    <div class="ty-next__head">
      <span class="eyebrow-label">What Happens Next</span>
      <h2 id="next-title">What happens after you contact Goff Electric?</h2>
    </div>
    <ol class="ty-steps">
      <li><h3>Your request is read</h3><p>It arrives at Goff Electric by email with your name, contact details, the service you picked and your notes.</p></li>
      <li><h3>You get a call or email</h3><p>Goff Electric gets back to you to ask about the job and set up the free estimate.</p></li>
      <li><h3>You see the price first</h3><p>You hear what the job takes and what it costs before any work starts.</p></li>
    </ol>
    <div class="ty-urgent">
      <p><strong>Can't wait?</strong> For a power loss, a burning smell or sparking, call now instead of waiting for a reply. If there is smoke or fire, get out and call 911 first.</p>
      <a class="btn btn-accent" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc($phoneText); ?></a>
    </div>
  </div>
</section>

<?php if ($tyServices): ?>
<section class="section ty-services edge-wave-top" aria-labelledby="services-title">
  <div class="container ty-services__grid">
    <div>
      <span class="eyebrow-label">While You Wait</span>
      <h2 id="services-title">Which Goff Electric service fits your job?</h2>
      <p>Read up on the service you asked about, or see everything Goff Electric does for homes and businesses in Rio Rancho and Albuquerque.</p>
<?php if (siteHas('/services/')): ?>
      <a class="btn btn-secondary" href="/services/">All services <?php echo icon('arrow-right', 16); ?></a>
<?php endif; ?>
<?php if (!empty($reviewRequestUrl)): ?>
      <div class="ty-review">
        <h3>Already a Goff Electric customer?</h3>
        <p>A Google review helps neighbors in Rio Rancho and Albuquerque find an electrician they can trust.</p>
        <a class="btn btn-primary" href="<?php echo esc($reviewRequestUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?>Leave us a Google review</a>
      </div>
<?php endif; ?>
    </div>
    <div class="service-links">
<?php foreach ($tyServices as $tyLink): ?>
      <a class="service-link-card" href="<?php echo esc($tyLink['url']); ?>"><span><?php echo esc($tyLink['name']); ?></span><?php echo icon('arrow-right', 18); ?></a>
<?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
