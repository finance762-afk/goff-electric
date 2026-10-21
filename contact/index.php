<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /contact/ — Goff Electric (Phase 5, 2026-10-21).
 * Layout: compact dark hero with the phone as the headline action → full estimate form (id "contact") beside the direct
 * lines (phone, email, hours, base) → emergency strip → where Goff Electric works (map slot) → closing CTA.
 * The full form carries the THREE separate consent boxes (email opt-in, SMS opt-in, required terms) in a
 * .form-consent-fieldset, plus _consent_version/_consent_page — the names the leads endpoint writes to consent_records.
 * Field names follow the endpoint contract: name, phone, email, service (dropdown of all 10 services), message; the
 * honeypot is _honey (the only honeypot name the endpoint checks), emitted by p1_lead_hidden_fields().
 * Map: no GBP map embed was supplied ($gbpMapEmbed = ''), and the street address is private (address_public = false), so the
 * map slot renders the service-area panel with a Google Maps link; paste the embed into config.php and the iframe takes over.
 * The page has its own full form, so footer.php skips the estimate dialog ($noEstimateDialog) and every
 * header/mobile-bar "Free Estimate" link falls back to its href (/contact/, this page).
 */
$pageTitle       = 'Contact Goff Electric | 24/7 Electrician in Rio Rancho, NM';
$pageDescription = 'Call Goff Electric at (505) 549-9454, any hour, or request a free estimate online. Electricians for Rio Rancho, Albuquerque, Corrales and nearby towns.';
$canonicalUrl    = $siteUrl . '/contact/';
$currentPage     = 'contact';
$pageType        = 'contact';
$noEstimateDialog = true;

$phoneText = formatPhone($phone);
$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Contact', 'url' => '/contact/'],
];

$areaCards = [];
foreach ($serviceAreas as $areaRow) {
    $areaCards[] = ['name' => $areaRow['name'], 'county' => $areaRow['county'], 'url' => areaUrl($areaRow['slug']), 'primary' => !empty($areaRow['primary'])];
}

/* Schema: ContactPage (about → #organization, with the phone as a ContactPoint) + BreadcrumbList */
$root = rtrim($siteUrl, '/');
$contactPage = generateWebPageSchema($canonicalUrl, $pageTitle, $pageDescription);
$contactPage['@type']      = 'ContactPage';
$contactPage['breadcrumb'] = ['@id' => $canonicalUrl . '#breadcrumb'];
$contactPage['mainEntity'] = [
    '@type'        => 'Electrician',
    '@id'          => $root . '/#organization',
    'name'         => $siteName,
    'telephone'    => $phoneRaw,
    'email'        => $email,
    'contactPoint' => [[
        '@type'             => 'ContactPoint',
        'telephone'         => $phoneRaw,
        'email'             => $email,
        'contactType'       => 'customer service',
        'areaServed'        => 'US-NM',
        'availableLanguage' => 'English',
        'hoursAvailable'    => ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], 'opens' => '00:00', 'closes' => '23:59'],
    ]],
];
$contactCrumbs = generateBreadcrumbSchema($crumbs);
$contactCrumbs['@id'] = $canonicalUrl . '#breadcrumb';
$schemaMarkup = [$contactPage, $contactCrumbs];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ==========================================================================
   Contact — Goff Electric. Page composition only; tokens only.
   ========================================================================== */
/* Hero: type-led dark band, the phone number is the display line, bolt watermark */
.hero--contact { padding-bottom: calc(var(--space-3xl) + 3.5vw); background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 62%, var(--color-primary-deep) 130%); }
.hero--contact::before { content: ""; position: absolute; inset: auto -10% -55% 50%; height: 125%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side, rgba(var(--color-accent-rgb), .2), transparent 72%); }
.hero--contact .grain { z-index: -1; opacity: .3; }
.hero--contact .container { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr); gap: var(--space-xl) var(--space-3xl); align-items: end; }
.hero--contact .hero-text { max-width: 40rem; }
.hero--contact .text-accent { color: var(--color-accent-bright); }
.hero--contact .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.ct-crumbs { margin: 0; color: color-mix(in srgb, var(--color-white) 72%, transparent); }
.ct-crumbs ol { display: flex; flex-wrap: wrap; align-items: center; gap: 0 var(--space-xs); list-style: none; margin: 0; padding: 0; }
.ct-crumbs li + li::before { content: "/"; margin-right: var(--space-xs); opacity: .5; }
.ct-crumbs a { color: inherit; }
.ct-crumbs [aria-current] { color: var(--color-white); }
.ct-hotline { display: grid; gap: var(--space-xs); justify-items: start; padding: var(--space-lg); border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent); border-left: 4px solid var(--color-accent); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 5%, transparent); }
.ct-hotline__label { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.ct-hotline__number { font-family: var(--font-heading); font-size: clamp(2rem, 1.3rem + 2.4vw, 3rem); line-height: 1; color: var(--color-white); text-decoration: none; }
.ct-hotline__number:hover { color: var(--color-accent-bright); }
.ct-hotline small { color: color-mix(in srgb, var(--color-white) 72%, transparent); font-size: var(--fs-small); }
.hero--contact .floating-accent { right: -3%; top: 8%; width: clamp(180px, 20vw, 300px); color: var(--color-accent); }
.hero--contact .floating-accent svg { width: 100%; height: auto; }
@media (max-width: 900px) { .hero--contact .container { grid-template-columns: 1fr; } }

/* Form + direct lines: paper band slants up over the hero; form card 60 / aside 40 */
.ct-main { background: var(--color-paper); margin-top: -3.5vw; z-index: 1; padding-top: calc(var(--space-3xl) + 3.5vw); }
.ct-main .estimate { grid-template-columns: minmax(0, 1.35fr) minmax(0, .9fr); }
@media (max-width: 900px) { .ct-main .estimate { grid-template-columns: 1fr; } }
.ct-form-card { display: grid; gap: var(--space-md); border-top: 4px solid var(--color-accent); scroll-margin-top: calc(var(--nav-height) + var(--space-md)); }
.ct-form-card h2 { text-transform: uppercase; }
.ct-form-card > p { margin: 0; color: var(--color-ink-2); }
.ct-form .form-grid { margin-bottom: var(--space-md); }
.ct-form textarea { min-height: 130px; resize: vertical; }
.ct-form .form-consent-fieldset { padding: var(--space-md); background: var(--color-paper); border: 1px solid var(--color-line); border-radius: var(--radius); }
.ct-form .form-consent-item { margin: 0 0 var(--space-sm); }
.ct-form .form-consent-item:last-child { margin-bottom: 0; }
.ct-form .form-consent-required { padding-top: var(--space-sm); border-top: 1px dashed var(--color-line); }
.ct-form .required-star { color: var(--color-danger); font-weight: 700; }
.ct-form .btn { margin-top: var(--space-md); }
.ct-form .form-footnote { text-align: center; }
.ct-aside { display: grid; gap: var(--space-lg); }
.ct-lines { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-sm); }
.ct-line { display: grid; grid-template-columns: var(--space-2xl) minmax(0, 1fr); gap: var(--space-sm); align-items: center; padding: var(--space-md); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.ct-line:hover { transform: translateX(3px); box-shadow: var(--shadow); }
.ct-line__icon { width: var(--space-2xl); height: var(--space-2xl); display: grid; place-items: center; border-radius: var(--radius); background: var(--color-dark); color: var(--color-accent); }
.ct-line b { display: block; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.ct-line div a, .ct-line div span { color: var(--color-ink); font-weight: 600; text-decoration: none; overflow-wrap: anywhere; }
.ct-line a:hover { color: var(--color-accent-dark); }
.ct-next { padding: var(--space-lg); background: var(--color-card-tint-3); border-radius: var(--radius-lg); }
.ct-next h3 { text-transform: uppercase; letter-spacing: .03em; }
.ct-next .next-steps { margin-top: var(--space-sm); }
.ct-review { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-xs) var(--space-sm); font-size: var(--fs-small); color: var(--color-ink-2); }
.ct-review svg { color: var(--color-star); fill: currentColor; }
.ct-review a { color: var(--color-primary); font-weight: 600; }

/* Emergency strip: thin dark rule between the form and the map */
.ct-emergency { padding-block: var(--space-xl); }
.ct-emergency .container { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: var(--space-md) var(--space-xl); }
.ct-emergency p { margin: 0; max-width: 60ch; }
.ct-emergency strong { color: var(--color-white); }
.ct-emergency svg { color: var(--color-accent-bright); }
.ct-emergency .grain-layer { opacity: .25; }

/* Where we work: map slot (embed when supplied, service-area panel otherwise) beside town tiles */
.ct-areas { background: var(--color-surface); }
.ct-areas__grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: var(--space-2xl) var(--space-3xl); align-items: start; }
.ct-areas__head { display: grid; gap: var(--space-sm); margin-bottom: var(--space-xl); }
.ct-areas__head .answer-block { margin: 0; }
.ct-map-slot { position: relative; isolation: isolate; overflow: hidden; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
.ct-map-panel { position: relative; aspect-ratio: 4 / 3; display: grid; align-content: end; gap: var(--space-sm); padding: var(--space-xl); color: var(--color-white); background: radial-gradient(circle at 38% 42%, rgba(var(--color-accent-rgb), .28) 0 5%, transparent 5.5%), repeating-radial-gradient(circle at 38% 42%, transparent 0 var(--space-2xl), color-mix(in srgb, var(--color-white) 9%, transparent) var(--space-2xl) calc(var(--space-2xl) + 1px)), linear-gradient(135deg, var(--color-dark) 0%, var(--color-dark-alt) 100%); }
.ct-map-panel__pin { position: absolute; left: 38%; top: 42%; transform: translate(-50%, -100%); color: var(--color-accent); }
.ct-map-panel__pin svg { filter: drop-shadow(var(--shadow)); }
.ct-map-panel b { font-family: var(--font-heading); font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .02em; }
.ct-map-panel p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 80%, transparent); max-width: 40ch; }
.ct-map-panel .btn { justify-self: start; }
.ct-towns { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-sm); }
.ct-towns li { display: grid; gap: 2px; padding: var(--space-md); border: 1px solid var(--color-line); border-left: 4px solid var(--color-accent); border-radius: var(--radius); background: var(--color-paper); }
.ct-towns li.is-home { background: var(--color-dark); border-color: var(--color-dark); border-left-color: var(--color-accent); }
.ct-towns b { font-family: var(--font-heading); font-size: 1.15rem; text-transform: uppercase; letter-spacing: .02em; color: var(--color-ink); }
.ct-towns li.is-home b { color: var(--color-white); }
.ct-towns span { font-size: var(--fs-small); color: var(--color-muted); }
.ct-towns li.is-home span { color: color-mix(in srgb, var(--color-white) 74%, transparent); }
.ct-towns a { color: inherit; }
@media (max-width: 1000px) { .ct-areas__grid { grid-template-columns: 1fr; } }
@media (max-width: 420px) { .ct-towns { grid-template-columns: 1fr; } }

/* Closing CTA */
.ct-final { margin-top: -3.5vw; z-index: 1; }
.ct-final h2 { text-transform: uppercase; max-width: 22ch; }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--interior hero--contact" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <span class="floating-accent" aria-hidden="true"><?php echo icon('zap', 300); ?></span>
  <div class="container">
    <div class="hero-text hero-copy">
      <nav class="breadcrumb ct-crumbs" aria-label="Breadcrumb"><ol><li><a href="/">Home</a></li><li><span aria-current="page">Contact</span></li></ol></nav>
      <span class="eyebrow">Rio Rancho · Albuquerque · open 24/7</span>
      <h1 class="hero-title" id="hero-title">Contact <span class="text-accent">Goff Electric</span> in Rio Rancho, NM</h1>
      <p class="hero-answer">Call Goff Electric any hour, day or night, or send the form below for a free estimate on home or business electrical work.</p>
      <div class="hero-actions">
        <a class="btn btn-accent btn-lg" href="#contact-form">Request a free estimate</a>
      </div>
    </div>
    <div class="ct-hotline">
      <span class="ct-hotline__label">Phone · answered 24/7</span>
      <a class="ct-hotline__number" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>
      <small>Power out, a burning smell or sparking? Call now instead of using the form.</small>
    </div>
  </div>
</section>

<!-- ===================== FORM + DIRECT LINES ===================== -->
<section class="section ct-main slant-top" aria-labelledby="form-title">
  <div class="container estimate">
    <div class="card ct-form-card" id="contact-form">
      <span class="eyebrow-label">Free Estimate</span>
      <h2 id="form-title">What do you need done?</h2>
      <p>Tell Goff Electric what is going on, the service you need and the town. The more detail, the more useful the first call.</p>
      <form class="estimate-form ct-form" action="<?php echo esc($formAction); ?>" method="POST" id="contact">
        <?php echo p1_lead_hidden_fields('contact'); ?>
        <input type="hidden" name="_consent_version" value="v2.1">
        <input type="hidden" name="_consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/', ENT_QUOTES, 'UTF-8'); ?>">
        <div class="form-grid">
          <div class="field"><label for="contact-name">Your name *</label><input id="contact-name" type="text" name="name" autocomplete="name" required></div>
          <div class="field"><label for="contact-phone">Phone *</label><input id="contact-phone" type="tel" name="phone" autocomplete="tel" inputmode="tel" required></div>
          <div class="field full"><label for="contact-email">Email *</label><input id="contact-email" type="email" name="email" autocomplete="email" required></div>
          <div class="field full"><label for="contact-service">Service needed</label><select id="contact-service" name="service"><?php echo p1_service_options(); ?><option value="Something else">Something else / not sure</option></select></div>
          <div class="field full"><label for="contact-message">Project details</label><textarea id="contact-message" name="message" rows="5" placeholder="What is happening, which town, and anything urgent we should know."></textarea></div>
        </div>

        <fieldset class="form-consent-fieldset">
          <legend class="form-consent-legend">Communication consent</legend>
          <label class="form-consent-item" for="contact-email-opt-in">
            <input id="contact-email-opt-in" type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
            <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo esc($siteName); ?> about my inquiry, services, promotions and news. I can unsubscribe at any time with the link in any email or by emailing <?php echo esc($email); ?>. Message frequency varies.</span>
          </label>
          <label class="form-consent-item" for="contact-sms-opt-in">
            <input id="contact-sms-opt-in" type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
            <span class="consent-label"><strong>SMS/Text messages (optional):</strong> I agree to receive text messages from <?php echo esc($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
          </label>
          <label class="form-consent-item form-consent-required" for="contact-terms">
            <input id="contact-terms" type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
            <span class="consent-label">I have read and agree to the <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and <a href="/terms/" target="_blank" rel="noopener">Terms of Service</a>. <span class="required-star" aria-hidden="true">*</span></span>
          </label>
        </fieldset>

        <button type="submit" class="btn btn-accent btn-block btn-lg">Send my request</button>
        <p class="form-footnote">Free estimates. Your details go only to <?php echo esc($siteName); ?> and are handled under the <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a>.</p>
      </form>
    </div>

    <aside class="ct-aside" aria-label="Direct contact details">
      <ul class="ct-lines">
        <li class="ct-line"><span class="ct-line__icon"><?php echo icon('phone', 22); ?></span><div><b>Call or emergency</b><a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a></div></li>
        <li class="ct-line"><span class="ct-line__icon"><?php echo icon('mail', 22); ?></span><div><b>Email</b><a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a></div></li>
        <li class="ct-line"><span class="ct-line__icon"><?php echo icon('clock', 22); ?></span><div><b>Hours</b><span><?php echo esc($businessHours); ?></span></div></li>
        <li class="ct-line"><span class="ct-line__icon"><?php echo icon('map-pin', 22); ?></span><div><b>Based in</b><span><?php echo esc($address['city'] . ', ' . $address['state'] . ' ' . $address['zip']); ?> · we come to you</span></div></li>
      </ul>
      <div class="ct-next">
        <h3>What happens after you send it?</h3>
        <ol class="next-steps">
          <li><strong>Goff Electric gets your request</strong>It arrives by email with your details and the service you picked.</li>
          <li><strong>You get a call or email back</strong>To ask any questions and set up the free estimate.</li>
          <li><strong>You see the price before any work</strong>Goff Electric tells you what the job takes and what it costs before it starts.</li>
        </ol>
      </div>
<?php if (!empty($gbpRating) && !empty($gbpReviewCount)): ?>
      <p class="ct-review"><?php echo icon('star', 18); ?><span>Rated <?php echo esc(number_format((float) $gbpRating, 1)); ?> on Google from <?php echo (int) $gbpReviewCount; ?> reviews.</span><a href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener">Read the reviews</a></p>
<?php endif; ?>
    </aside>
  </div>
</section>

<!-- ===================== EMERGENCY STRIP ===================== -->
<section class="ct-emergency texture-grain" aria-label="Emergency electrical service">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <p><?php echo icon('alert-triangle', 20); ?> <strong>Electrical emergency?</strong> Smoke or flames: get out and call 911 first. For a burning smell, sparking, or power out on part of the house, call Goff Electric at any hour.</p>
<?php if (serviceUrl('24-7-emergency-electrical-service') !== ''): ?>
    <a class="btn btn-outline-white" href="<?php echo esc(serviceUrl('24-7-emergency-electrical-service')); ?>">What to do before we arrive</a>
<?php endif; ?>
  </div>
</section>

<!-- ===================== WHERE WE WORK ===================== -->
<section class="section ct-areas edge-curve-top" aria-labelledby="areas-title">
  <div class="container ct-areas__grid">
    <div class="ct-map-slot reveal-left">
<?php if (!empty($gbpMapEmbed)): ?>
      <div class="map-embed"><?php echo $gbpMapEmbed; ?></div>
<?php else: ?>
      <div class="ct-map-panel">
        <span class="ct-map-panel__pin" aria-hidden="true"><?php echo icon('map-pin', 44); ?></span>
        <b><?php echo esc($siteName); ?> · <?php echo esc($address['city'] . ', ' . $address['state']); ?></b>
        <p>A mobile, service-area business: Goff Electric drives to homes and job sites across Sandoval and Bernalillo counties.</p>
        <a class="btn btn-accent" href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('map', 18); ?>View on Google Maps</a>
      </div>
<?php endif; ?>
    </div>
    <div class="reveal-right">
      <div class="ct-areas__head">
        <span class="eyebrow-label">Service Area</span>
        <h2 id="areas-title">Where does Goff Electric work?</h2>
        <p class="answer-block">Goff Electric works in Rio Rancho, Albuquerque, Corrales, Bernalillo, Placitas and Tijeras, across Sandoval and Bernalillo counties. It comes to you: share the town in the form or on the phone.</p>
      </div>
      <ul class="ct-towns">
<?php foreach ($areaCards as $areaCard): ?>
        <li<?php echo $areaCard['primary'] ? ' class="is-home"' : ''; ?>><b><?php echo $areaCard['url'] !== '' ? '<a href="' . esc($areaCard['url']) . '">' . esc($areaCard['name']) . '</a>' : esc($areaCard['name']); ?></b><span><?php echo esc($areaCard['county']); ?> County<?php echo $areaCard['primary'] ? ' · home base' : ''; ?></span></li>
<?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ===================== CLOSING CTA ===================== -->
<section class="closing-cta texture-grain slant-top ct-final" aria-labelledby="final-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Rather talk it through?</span>
      <h2 id="final-title">Is it faster to just call an electrician?</h2>
      <p>Often, yes. The <?php echo esc($siteName); ?> line is answered 24 hours a day, so you can describe the problem and get a straight answer on what it needs.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc($phoneText); ?></a>
<?php if (siteHas('/services/')): ?>
      <a class="btn btn-outline-white btn-lg" href="/services/">Browse services</a>
<?php endif; ?>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
