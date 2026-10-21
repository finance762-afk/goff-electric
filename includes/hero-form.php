<?php
/**
 * includes/hero-form.php — compact hero lead form card (service + city pages).
 * Desktop: the card sits in the right column of .hero-grid--form. ≤900px the scaffold hides it and the
 * page's data-open-estimate button opens #estimate-dialog (footer.php) instead.
 *
 * Page sets before including (all optional):
 *   $heroFormService — service name preselected in the select (matches a config.php $services name)
 *   $heroFormTitle   — card heading (default "Need a free estimate?")
 *   $heroFormTagline — one line under the heading
 * Form id "hero" (unique on the page). p1_lead_hidden_fields('hero') emits _next, _honey, form_location,
 * consent_version/consent_page, p1_attribution_fields('hero') and the _ft/_js spam shield.
 */
$hfService = $heroFormService ?? '';
$hfTitle   = $heroFormTitle ?? 'Need a free estimate?';
$hfTagline = $heroFormTagline ?? 'Tell Goff Electric what you need and how to reach you.';
?>
      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title"><?php echo esc($hfTitle); ?></h2>
        <p class="hero-form-tagline"><?php echo esc($hfTagline); ?></p>
        <form action="<?php echo esc($formAction); ?>" method="POST" class="hero-form" id="hero">
          <?php echo p1_lead_hidden_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row hf-pair">
            <div><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" inputmode="tel" required></div>
            <div><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          </div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($hfService); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Send my request</button>
        </form>
      </aside>
