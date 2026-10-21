<?php
/**
 * includes/cta-band.php — the ONE mid-page estimate band for About, FAQ and (later) blog posts (v6.3 placement standard).
 * Sits after the first content section. Copy column ≈1/3, form card ≈2/3 with the fields three-up:
 *   name | phone | email  /  service | button  /  consent | footnote   (≈300px tall on desktop).
 * Form id "cta-band" (unique on the page). p1_lead_hidden_fields('cta-band') emits _next, _honey, form_location,
 * consent fields, p1_attribution_fields('cta-band') and the _ft/_js spam shield; the underscore consent fields
 * (_consent_version/_consent_page) are what the leads endpoint writes to consent_records.
 *
 * Page sets before including (all optional):
 *   $ctaBandEyebrow, $ctaBandTitle (plain text), $ctaBandText, $ctaBandService (preselected service name)
 * Shared-include rule: variables are prefixed ($cb…).
 */
$cbEyebrow = $ctaBandEyebrow ?? 'Free estimate';
$cbTitle   = $ctaBandTitle ?? 'Tell Goff Electric what you need';
$cbText    = $ctaBandText ?? 'Describe the problem or the project and the town. Goff Electric will tell you what it takes before any work starts.';
$cbService = $ctaBandService ?? '';
$cbPhone   = formatPhone($phone);
?>
<style>
/* ==========================================================================
   CTA band (includes/cta-band.php) — dark slanted band, form card two-thirds wide. Tokens only.
   ========================================================================== */
.cta-band { padding-block: var(--space-3xl); }
.cta-band .container { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 2fr); gap: var(--space-xl) var(--space-3xl); align-items: center; }
.cta-band__copy { display: grid; gap: var(--space-sm); }
.cta-band__copy h2 { font-size: var(--fs-h2); text-transform: uppercase; max-width: 16ch; }
.cta-band__copy p { margin: 0; font-size: var(--fs-small); }
.cta-band__call { display: inline-flex; align-items: center; gap: var(--space-xs); font-family: var(--font-heading); font-size: 1.5rem; color: var(--color-white); text-decoration: none; }
.cta-band__call svg { color: var(--color-accent-bright); }
.cta-band__call:hover { color: var(--color-accent-bright); }
.cta-band__card { background: var(--color-surface); color: var(--color-ink); border-radius: var(--radius-lg); border-top: 4px solid var(--color-accent); box-shadow: var(--shadow-lg); padding: var(--space-lg); }
.cta-band__form { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-sm); align-items: end; }
.cta-band__form .field label { color: var(--color-ink-2); }
.cta-band__form .cb-service { grid-column: span 2; }
.cta-band__form .btn { min-height: 48px; width: 100%; }
.cta-band__form .consent { grid-column: span 2; margin: 0; color: var(--color-ink-2); }
.cta-band__form .form-footnote { margin: 0; align-self: center; }
.cta-band .grain-layer { opacity: .3; }
@media (max-width: 1000px) { .cta-band .container { grid-template-columns: 1fr; } .cta-band__copy h2 { max-width: none; } }
@media (max-width: 640px) { .cta-band__form { grid-template-columns: 1fr; } .cta-band__form .cb-service, .cta-band__form .consent { grid-column: auto; } }
</style>
<section class="cta-band texture-grain slant-top" id="estimate" aria-labelledby="cta-band-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-band__copy">
      <span class="eyebrow"><?php echo esc($cbEyebrow); ?></span>
      <h2 id="cta-band-title"><?php echo esc($cbTitle); ?></h2>
      <p><?php echo esc($cbText); ?></p>
      <a class="cta-band__call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 20); ?><?php echo esc($cbPhone); ?></a>
    </div>
    <div class="cta-band__card">
      <form class="cta-band__form" action="<?php echo esc($formAction); ?>" method="POST" id="cta-band">
        <?php echo p1_lead_hidden_fields('cta-band'); ?>
        <input type="hidden" name="_consent_version" value="v2.1">
        <input type="hidden" name="_consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/', ENT_QUOTES, 'UTF-8'); ?>">
        <div class="field"><label for="cta-band-name">Your name *</label><input id="cta-band-name" type="text" name="name" autocomplete="name" required></div>
        <div class="field"><label for="cta-band-phone">Phone *</label><input id="cta-band-phone" type="tel" name="phone" autocomplete="tel" inputmode="tel" required></div>
        <div class="field"><label for="cta-band-email">Email *</label><input id="cta-band-email" type="email" name="email" autocomplete="email" required></div>
        <div class="field cb-service"><label for="cta-band-service">Service needed</label><select id="cta-band-service" name="service"><?php echo p1_service_options($cbService); ?></select></div>
        <button type="submit" class="btn btn-accent">Send my request</button>
        <label class="consent" for="cta-band-terms"><input id="cta-band-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted about my request. *</span></label>
        <p class="form-footnote">Free estimates. Power out or a burning smell? Call instead, any hour.</p>
      </form>
    </div>
  </div>
</section>
