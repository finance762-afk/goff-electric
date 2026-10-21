<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /terms/ — Goff Electric (Phase 5, 2026-10-21). Template: legal-compliance.md "Terms of Service", adapted for an electrical
 * contractor: governing law New Mexico (state of formation assumed — see /content-confirmations.json), venue Sandoval County;
 * the "Insurance Claim Work" clause is omitted (not an insurance-claim trade, per the Sep 29 2026 rule); payment methods,
 * deposits, financing and warranty length are left to the written estimate/contract because intake supplied none of them;
 * an electrical-safety clause is added. Indexable. WebPage + BreadcrumbList schema. No reveals.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.php';

$pageTitle       = 'Terms of Service | Goff Electric | Rio Rancho NM Electrician';
$pageDescription = 'Terms for the Goff Electric website and for estimates and electrical work in Rio Rancho, Albuquerque and nearby NM towns. Call (505) 549-9454 with questions.';
$canonicalUrl    = $siteUrl . '/terms/';
$currentPage     = 'legal';
$pageType        = 'other';
$schemaMarkup    = legalSchema('/terms/', 'Terms of Service', $pageDescription);

$toc = [
    'agreement' => 'Agreement to terms', 'website' => 'Use of this website', 'safety' => 'Electrical safety', 'estimates' => 'Estimates and quotes',
    'work' => 'Electrical work', 'emergency' => 'Emergency service', 'warranties' => 'Warranties', 'payment' => 'Payment',
    'cancellation' => 'Cancellation', 'liability' => 'Limitation of liability', 'ip' => 'Intellectual property', 'law' => 'Governing law',
    'changes' => 'Changes to these terms', 'contact' => 'Contact us',
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo legalStyles(); ?>
<style>
/* Terms — page specifics: safety warning callout in the danger tone */
.tos-warning { display: flex; gap: var(--space-sm); align-items: flex-start; background: color-mix(in srgb, var(--color-danger) 7%, var(--color-surface)); border-left-color: var(--color-danger); }
.tos-warning svg { color: var(--color-danger); flex: 0 0 auto; margin-top: var(--space-1); }
.tos-cancel { counter-reset: tos; list-style: none; padding: 0; }
.tos-cancel li { counter-increment: tos; position: relative; padding-left: var(--space-xl); }
.tos-cancel li::before { content: counter(tos); position: absolute; left: 0; top: 0; font-family: var(--font-accent); font-weight: 700; color: var(--color-accent-dark); }
</style>

<section class="hero hero--legal" aria-labelledby="legal-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero__copy">
      <?php echo legalCrumbs('Terms of Service'); ?>
      <span class="eyebrow">Legal</span>
      <h1 id="legal-title">Terms of Service</h1>
      <p class="legal-sub"><?php echo esc('The terms for using this website and hiring ' . $siteName . '.'); ?></p>
      <?php echo legalUpdated(); ?>
    </div>
  </div>
</section>

<section class="legal-body" aria-label="Terms of Service text">
  <div class="container">
    <article class="content-narrow legal-prose">

      <p class="legal-intro">These Terms of Service ("Terms") govern your use of <?php echo esc($companyDomain); ?> (the "Site") and your requests for estimates and electrical services from <?php echo esc($companyName); ?> ("<?php echo esc($siteName); ?>", "we", "us", "our"), a <?php echo esc($companyState); ?> <?php echo esc(strtolower($companyEntityType)); ?>.</p>

      <nav class="legal-toc" aria-label="On this page">
        <h2>On this page</h2>
        <ol>
<?php foreach ($toc as $tocId => $tocName): ?>
          <li><a href="#<?php echo esc($tocId); ?>"><?php echo esc($tocName); ?></a></li>
<?php endforeach; ?>
        </ol>
      </nav>

      <h2 id="agreement">1. Agreement to Terms</h2>
      <p>By using the Site or engaging <?php echo esc($siteName); ?> for services, you agree to these Terms and to our <a href="/privacy-policy/">Privacy Policy</a>. If you do not agree, do not use the Site.</p>

      <h2 id="website">2. Use of This Website</h2>
      <ul>
        <li>You may use the Site to learn about our services and to contact us.</li>
        <li>You may not use the Site for unlawful purposes, try to access non-public systems, copy or scrape content without written permission, submit false information through our forms, or use automated tools to send requests or extract data.</li>
      </ul>

      <h2 id="safety">3. Electrical Safety and Site Information</h2>
      <div class="legal-callout tos-warning"><?php echo icon('alert-triangle', 20); ?><p>Content on the Site is general information, not instructions for working on your own electrical system. Electrical work can cause shock, fire and death. If you see smoke or flames, leave the building and call 911.</p></div>
      <p>Code requirements, permit rules and prices described on the Site are general and may change. Your written estimate and the conditions at your property control.</p>

      <h2 id="estimates">4. Estimates and Quotes</h2>
      <p>Estimates are free and are based on the information you give us and the conditions we can see at the time. The final price may differ if the scope changes, hidden conditions are found (for example damaged wiring inside walls or a panel without capacity), material prices change before the work starts, or a permit, inspection or the utility requires something different from what was first assumed. Verbal quotes are not binding; a written estimate or contract you accept is our agreement.</p>

      <h2 id="work">5. Electrical Work</h2>
      <ul>
        <li>Each job is governed by the written estimate or contract for that job. If it conflicts with these Terms, the estimate or contract controls.</li>
        <li>We are a licensed and insured <?php echo esc($companyState); ?> electrical contractor and perform work to the electrical code and local requirements in effect where the work is done.</li>
        <li>Where a job requires a permit and inspection, the work is subject to approval by the building official, and the schedule may depend on inspection timing.</li>
        <li>Work is performed by <?php echo esc($siteName); ?> and, where needed, qualified subcontractors.</li>
        <li>You agree to give safe access to the work area, the electrical panel and the meter, and to tell us about any known hazards.</li>
      </ul>

      <h2 id="emergency">6. Emergency and After-Hours Service</h2>
      <p>Our phone line is answered 24 hours a day. Arrival times we give are estimates and can change with weather, traffic and other emergencies. Problems on the utility's side of the meter, such as a downed or cut service line, must be repaired by the utility; we can help identify them and report them.</p>

      <h2 id="warranties">7. Warranties</h2>
      <p>Any workmanship warranty is stated in your written estimate or contract. Manufacturer warranties on fixtures, chargers, breakers and other equipment come from those manufacturers and pass through to you. Warranties do not cover damage from lightning or power surges beyond a product's rating, misuse, alterations or repairs by others, or conditions that existed before our work and were pointed out to you.</p>

      <h2 id="payment">8. Payment</h2>
      <p>Payment amounts, due dates, any deposit and accepted payment methods are set out in your estimate, contract or invoice. Past-due balances may accrue interest and collection costs to the extent permitted by <?php echo esc($companyState); ?> law.</p>

      <h2 id="cancellation">9. Cancellation</h2>
      <p>Cancellation terms in your contract control. If your contract is silent:</p>
      <ol class="tos-cancel">
        <li>Before materials are ordered: you may cancel without charge for the work.</li>
        <li>After materials are ordered: you pay for special-order materials that cannot be returned, plus any restocking fees.</li>
        <li>After work begins: you pay for work completed and materials used.</li>
      </ol>

      <h2 id="liability">10. Limitation of Liability</h2>
      <p>To the fullest extent permitted by <?php echo esc($companyState); ?> law, <?php echo esc($siteName); ?> is not liable for indirect, incidental, special or consequential damages arising from use of the Site, and our total liability for any claim related to the Site or our services will not exceed the amount you paid for the specific service that gave rise to the claim. Nothing in these Terms limits liability that cannot be limited by law.</p>

      <h2 id="ip">11. Intellectual Property</h2>
      <p>The text, photographs, logos and graphics on the Site belong to <?php echo esc($siteName); ?> or are used with permission and are protected by copyright and trademark law. You may not reproduce or distribute them without written permission.</p>

      <h2 id="law">12. Governing Law and Disputes</h2>
      <p>These Terms are governed by the laws of the State of <?php echo esc($companyState); ?>, without regard to conflict-of-law rules. Any dispute will be resolved in the state or federal courts serving <?php echo esc($companyCounty); ?>, <?php echo esc($companyState); ?>, and you consent to their jurisdiction.</p>

      <h2 id="changes">13. Changes to These Terms</h2>
      <p>We may update these Terms at any time. The "Last Updated" date at the top shows the current version. Using the Site after an update means you accept the revised Terms; the terms of a job you already accepted do not change.</p>

      <h2 id="contact">14. Contact Us</h2>
      <p>Questions about these Terms:</p>
      <?php echo legalContactBlock(); ?>

      <?php echo legalRelated('/terms/'); ?>
    </article>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
