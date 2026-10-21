<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /privacy-policy/ — Goff Electric (Phase 5, 2026-10-21). Template: legal-compliance.md "Privacy Policy", adapted:
 * forms post to the Page One leads endpoint (Formsubmit retired), no photo uploads (the forms take none), no insurance-
 * carrier sharing (not an insurance-claim trade), first-party attribution cookie p1_ft disclosed, New Mexico as home state,
 * CCPA/CPRA section at #ccpa-rights (target of the footer "Do Not Sell or Share" link) plus other state privacy laws.
 * Indexable. WebPage + BreadcrumbList schema. No reveals.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.php';

$pageTitle       = 'Privacy Policy | Goff Electric, Rio Rancho NM';
$pageDescription = 'How Goff Electric in Rio Rancho, NM collects, uses and protects information from its website, estimate forms, calls and texts, and your privacy rights.';
$canonicalUrl    = $siteUrl . '/privacy-policy/';
$currentPage     = 'legal';
$pageType        = 'other';
$schemaMarkup    = legalSchema('/privacy-policy/', 'Privacy Policy', $pageDescription);

$toc = [
    'introduction' => 'Introduction', 'collect' => 'Information we collect', 'use' => 'How we use it', 'share' => 'How we share it',
    'rights' => 'Your privacy rights', 'sms' => 'Calls, texts and email', 'retention' => 'Data retention', 'security' => 'Data security',
    'children' => "Children's privacy", 'links' => 'Third-party links', 'changes' => 'Changes to this policy', 'contact' => 'Contact us',
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo legalStyles(); ?>
<style>
/* Privacy Policy — page specifics: rights cards for the CCPA list, "we do not sell" callout */
.pp-rights { list-style: none; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-sm); }
.pp-rights li { margin: 0; padding: var(--space-sm) var(--space-md); background: var(--color-paper); border: 1px solid var(--color-line); border-radius: var(--radius); font-size: var(--fs-small); }
.pp-rights li strong { display: block; font-family: var(--font-heading); font-size: 1rem; text-transform: uppercase; letter-spacing: .02em; }
.pp-nosell { display: flex; gap: var(--space-sm); align-items: flex-start; }
.pp-nosell svg { color: var(--color-accent-dark); flex: 0 0 auto; margin-top: var(--space-1); }
#ccpa-rights { padding: var(--space-md); margin-inline: calc(-1 * var(--space-md)); border-radius: var(--radius); }
#ccpa-rights:target { background: var(--color-card-tint-3); }
@media (max-width: 560px) { .pp-rights { grid-template-columns: 1fr; } }
</style>

<section class="hero hero--legal" aria-labelledby="legal-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero__copy">
      <?php echo legalCrumbs('Privacy Policy'); ?>
      <span class="eyebrow">Legal</span>
      <h1 id="legal-title">Privacy Policy</h1>
      <p class="legal-sub"><?php echo esc('How ' . $siteName . ' collects, uses and protects your information.'); ?></p>
      <?php echo legalUpdated(); ?>
    </div>
  </div>
</section>

<section class="legal-body" aria-label="Privacy Policy text">
  <div class="container">
    <article class="content-narrow legal-prose">

      <p class="legal-intro">This Privacy Policy explains how <?php echo esc($companyName); ?> ("<?php echo esc($siteName); ?>", "we", "us", "our"), a <?php echo esc($companyState); ?> <?php echo esc(strtolower($companyEntityType)); ?> based in <?php echo esc($address['city'] . ', ' . $address['state']); ?>, collects, uses and protects personal information when you visit <?php echo esc($companyDomain); ?>, send us an estimate request, or call, text or email us.</p>

      <nav class="legal-toc" aria-label="On this page">
        <h2>On this page</h2>
        <ol>
<?php foreach ($toc as $tocId => $tocName): ?>
          <li><a href="#<?php echo esc($tocId); ?>"><?php echo esc($tocName); ?></a></li>
<?php endforeach; ?>
        </ol>
      </nav>

      <h2 id="introduction">1. Introduction</h2>
      <p>We are an electrical contractor serving homes and businesses in Rio Rancho, Albuquerque, Corrales, Bernalillo, Placitas and Tijeras. We collect only the information we need to answer your request, give you an estimate and do the work you hire us for. By using this website you agree to the practices described here.</p>

      <h2 id="collect">2. Information We Collect</h2>
      <ul>
        <li><strong>Information you give us:</strong> your name, phone number, email address, the service you need, project details you type into a form, and anything you tell us by phone, text, email or in person (such as a service address).</li>
        <li><strong>Your consent choices:</strong> whether you opted in to email or text messages and accepted our Terms, with the consent wording version, the page you submitted from and the time.</li>
        <li><strong>How you found us:</strong> a first-party cookie (<code>p1_ft</code>, 30 days) records the page you first landed on, the referring website, any campaign tags in the link (UTM parameters or a Google Ads click ID), a random visit ID and your device type (desktop, tablet or mobile). These details are sent with your form so we know which pages and channels bring in requests.</li>
        <li><strong>Automatically collected:</strong> like most websites, our hosting servers log IP addresses, browser type and pages requested for security and troubleshooting. If we turn on Google Analytics 4, it also collects pages visited, approximate location and device information. See our <a href="/cookie-policy/">Cookie Policy</a>.</li>
      </ul>

      <h2 id="use">3. How We Use Your Information</h2>
      <ul>
        <li>Respond to your inquiry and schedule estimates, inspections and electrical work</li>
        <li>Communicate with you before, during and after a job, including phone calls and, where you have opted in, text messages and emails</li>
        <li>Prepare estimates, invoices and job records</li>
        <li>Understand which pages and channels bring in requests, and improve this website</li>
        <li>Prevent spam and abuse of our forms</li>
        <li>Meet legal obligations, including licensing, permit, tax and insurance requirements</li>
      </ul>

      <h2 id="share">4. How We Share Your Information</h2>
      <div class="legal-callout pp-nosell"><?php echo icon('shield-check', 20); ?><p>We do <strong>not</strong> sell your personal information, and we do not share it for cross-context behavioral advertising.</p></div>
      <ul>
        <li><strong>Service providers:</strong> Page One Insights, LLC, our website, hosting and lead-handling partner, receives and stores form submissions and emails them to us; its customer service team receives a copy for lead tracking and support. Our website host stores server logs. If enabled, Google provides analytics. Each provider uses the information only to provide its service to us.</li>
        <li><strong>Subcontractors and suppliers:</strong> only as needed to complete your job.</li>
        <li><strong>Utilities and building officials:</strong> when a job requires it, for example a permit, an inspection or reporting a utility-side fault.</li>
        <li><strong>Legal compliance:</strong> if required by <?php echo esc($companyState); ?> or federal law, or to protect our rights or someone's safety.</li>
        <li><strong>Business transfers:</strong> if our business is sold or merged, customer records may transfer to the new owner under this policy.</li>
      </ul>

      <h2 id="rights">5. Your Privacy Rights</h2>

      <h3 id="state-rights"><?php echo esc($companyState); ?> Residents</h3>
      <p>You may ask us what personal information we hold about you, ask us to correct it, or ask us to delete it, subject to records we must keep by law. Contact us using the details in section 12. We will not treat you differently for making a request.</p>

      <h3 id="ccpa-rights">California Residents (CCPA / CPRA) and "Do Not Sell or Share"</h3>
      <p>If you are a California resident, the California Consumer Privacy Act as amended by the California Privacy Rights Act gives you these rights:</p>
      <ul class="pp-rights">
        <li><strong>Right to know</strong>What personal information we collect, use and disclose.</li>
        <li><strong>Right to delete</strong>Personal information we collected from you, with legal exceptions.</li>
        <li><strong>Right to correct</strong>Inaccurate personal information.</li>
        <li><strong>Right to opt out</strong>Of the sale or sharing of personal information. We do neither, but you may still send a request for our records.</li>
        <li><strong>Right to limit</strong>The use of sensitive personal information.</li>
        <li><strong>Right to non-discrimination</strong>We will not deny service or charge more for using your rights.</li>
      </ul>
      <p><strong>How to make a request, including "Do Not Sell or Share My Personal Information":</strong> email <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a> or call <a href="tel:<?php echo esc($companyPhoneE164); ?>"><?php echo esc($companyPhone); ?></a>. We may need to confirm your identity. We will respond within 45 days, and when you opt out we will confirm that your request has been honored. If your browser sends a Global Privacy Control signal, we treat it as an opt-out request.</p>

      <h3>Residents of Other States</h3>
      <p>Residents of states with comprehensive consumer privacy laws, including Colorado, Connecticut, Delaware, Indiana, Iowa, Kentucky, Maryland, Minnesota, Montana, Nebraska, New Hampshire, New Jersey, Oregon, Rhode Island, Tennessee, Texas, Utah and Virginia, may have similar rights to access, correct, delete and opt out. Make a request the same way; you may appeal a decision by replying to our response.</p>

      <h2 id="sms">6. Phone Calls, Text Messages and Email (TCPA)</h2>
      <p>Our forms ask for consent in separate, unchecked boxes. Accepting our Terms and Privacy Policy lets us contact you about the request you sent. Email updates and text messages are each optional.</p>
      <ul>
        <li><strong>Text messages:</strong> if you opt in, we may text you at the number you gave about appointments, service updates and offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe and HELP for help. Consent is not a condition of purchase.</li>
        <li><strong>Email:</strong> if you opt in, you can unsubscribe at any time with the link in any email or by emailing <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a>.</li>
        <li><strong>Phone calls:</strong> tell us on any call, or email us, and we will stop calling except about work you have scheduled.</li>
      </ul>
      <p>We honor any reasonable way you tell us to stop, not only the methods above.</p>

      <h2 id="retention">7. Data Retention</h2>
      <p>We keep estimate requests and job records as long as needed to provide service and meet legal, tax, permit and warranty obligations, typically five to seven years for business records. Requests that never become a job are kept for a shorter time unless the law requires otherwise. Consent records are kept as long as needed to show what you agreed to.</p>

      <h2 id="security">8. Data Security</h2>
      <p>Form submissions travel over encrypted HTTPS connections and are stored by our service providers on access-controlled systems. No system is completely secure, so we cannot guarantee absolute security, but we limit who can see your information and keep only what we need.</p>

      <h2 id="children">9. Children's Privacy</h2>
      <p>This website is not directed to children under 13, and we do not knowingly collect information from them. If you believe a child has sent us information, contact us and we will delete it.</p>

      <h2 id="links">10. Third-Party Links</h2>
      <p>This website links to other sites, such as our Google Business Profile and Google Maps. We are not responsible for their privacy practices; please read their policies.</p>

      <h2 id="changes">11. Changes to This Policy</h2>
      <p>We may update this Privacy Policy from time to time. The "Last Updated" date at the top shows the latest version, and material changes will be posted on this page.</p>

      <h2 id="contact">12. Contact Us</h2>
      <p>For privacy questions or to make a request:</p>
      <?php echo legalContactBlock(); ?>

      <?php echo legalRelated('/privacy-policy/'); ?>
    </article>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
