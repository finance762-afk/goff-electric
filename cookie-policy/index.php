<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /cookie-policy/ — Goff Electric (Phase 5, 2026-10-21). Template: legal-compliance.md "Cookie Policy", made specific to
 * what this site actually sets: the first-party attribution cookie p1_ft (includes/attribution.php, 30 days, HttpOnly),
 * the cookie-notice flag in localStorage (cookieBannerDismissed_v1, main.js), and Google Analytics 4 only once a real
 * measurement ID replaces the placeholder in config.php. Fonts are self-hosted, icons are inline, Google reviews are
 * fetched server-side and maps are links, so none of those set third-party cookies. Indexable. WebPage + BreadcrumbList.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.php';

$pageTitle       = 'Cookie Policy | Goff Electric, Rio Rancho NM';
$pageDescription = 'The cookies and similar technologies the Goff Electric website in Rio Rancho, NM uses, why it uses them, and how to control or opt out of them.';
$canonicalUrl    = $siteUrl . '/cookie-policy/';
$currentPage     = 'legal';
$pageType        = 'other';
$schemaMarkup    = legalSchema('/cookie-policy/', 'Cookie Policy', $pageDescription);

$gaActive = !empty($googleAnalyticsId) && $googleAnalyticsId !== 'G-XXXXXXXXXX';
$cookieRows = [
    ['name' => 'p1_ft', 'type' => 'First-party cookie', 'purpose' => 'Remembers how your visit started (landing page, referring site, campaign tags, a random visit ID, device type) so an estimate request shows which page and channel it came from.', 'life' => '30 days', 'cat' => 'Functional / analytics'],
    ['name' => 'cookieBannerDismissed_v1', 'type' => 'Browser localStorage', 'purpose' => 'Remembers that you dismissed the cookie notice so it does not appear again.', 'life' => 'Until you clear site data', 'cat' => 'Strictly necessary'],
    ['name' => '_ga, _ga_*', 'type' => 'Google Analytics 4 cookies', 'purpose' => 'Count visits and see which pages are used. ' . ($gaActive ? 'Active on this site.' : 'Only set if we turn on Google Analytics; not active at the time of this update.'), 'life' => 'Up to 2 years', 'cat' => 'Analytics'],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo legalStyles(); ?>
<style>
/* Cookie Policy — page specifics: cookie inventory table, "no third-party cookies" checklist */
.ck-table-wrap { overflow-x: auto; margin: var(--space-md) 0 var(--space-lg); border: 1px solid var(--color-line); border-radius: var(--radius-lg); }
.ck-table { width: 100%; min-width: 560px; border-collapse: collapse; font-size: var(--fs-small); }
.ck-table caption { caption-side: bottom; padding: var(--space-sm) var(--space-md); text-align: left; color: var(--color-muted); }
.ck-table th, .ck-table td { padding: var(--space-sm) var(--space-md); text-align: left; vertical-align: top; border-bottom: 1px solid var(--color-line); }
.ck-table thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-ink); background: var(--color-paper-2); }
.ck-table tbody tr:last-child > * { border-bottom: 0; }
.ck-table code { font-weight: 700; color: var(--color-ink); }
.ck-none { list-style: none; padding: 0; display: grid; gap: var(--space-xs); }
.ck-none li { display: flex; gap: var(--space-xs); align-items: flex-start; margin: 0; }
.ck-none svg { color: var(--color-success); flex: 0 0 auto; margin-top: var(--space-1); }
</style>

<section class="hero hero--legal" aria-labelledby="legal-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero__copy">
      <?php echo legalCrumbs('Cookie Policy'); ?>
      <span class="eyebrow">Legal</span>
      <h1 id="legal-title">Cookie Policy</h1>
      <p class="legal-sub"><?php echo esc('What the ' . $siteName . ' website stores in your browser, and why.'); ?></p>
      <?php echo legalUpdated(); ?>
    </div>
  </div>
</section>

<section class="legal-body" aria-label="Cookie Policy text">
  <div class="container">
    <article class="content-narrow legal-prose">

      <p class="legal-intro">This Cookie Policy explains how <?php echo esc($companyName); ?> ("<?php echo esc($siteName); ?>", "we", "us") uses cookies and similar technologies on <?php echo esc($companyDomain); ?>. It supplements our <a href="/privacy-policy/">Privacy Policy</a>.</p>

      <h2 id="what">1. What Are Cookies?</h2>
      <p>Cookies are small text files a website stores in your browser. Similar technologies, such as browser localStorage, work the same way. They let a site remember something between pages or visits.</p>

      <h2 id="ours">2. Cookies We Use</h2>
      <div class="ck-table-wrap">
        <table class="ck-table">
          <caption>Cookies and storage on <?php echo esc($companyDomain); ?> as of <?php echo esc($legalLastUpdated); ?>.</caption>
          <thead><tr><th scope="col">Name</th><th scope="col">Type</th><th scope="col">Purpose</th><th scope="col">Lasts</th></tr></thead>
          <tbody>
<?php foreach ($cookieRows as $ckRow): ?>
            <tr><th scope="row"><code><?php echo esc($ckRow['name']); ?></code><br><small><?php echo esc($ckRow['cat']); ?></small></th><td><?php echo esc($ckRow['type']); ?></td><td><?php echo esc($ckRow['purpose']); ?></td><td><?php echo esc($ckRow['life']); ?></td></tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <h3>Strictly necessary</h3>
      <p>Needed for the site and its forms to work, such as remembering that you dismissed the cookie notice and the security fields on our estimate forms. These cannot be switched off in our site.</p>

      <h3>Functional and analytics</h3>
      <p>The <code>p1_ft</code> cookie is set by our own website (first party), can only be read by our server, and is never used to show you ads. If we turn on Google Analytics 4, it sets <code>_ga</code> cookies to measure visits; Google processes that data under its own privacy terms.</p>

      <h3>What we do not use</h3>
      <ul class="ck-none">
        <li><?php echo icon('check', 18); ?><span><strong>No font or icon CDNs:</strong> our fonts and icons are served from our own website, so Google Fonts and similar services set no cookies here.</span></li>
        <li><?php echo icon('check', 18); ?><span><strong>No review widgets:</strong> Google reviews are loaded by our server, not by a third-party script in your browser.</span></li>
        <li><?php echo icon('check', 18); ?><span><strong>No embedded maps by default:</strong> "View on Google Maps" is a link. If we add an embedded Google map, Google may set its own cookies when that map loads.</span></li>
        <li><?php echo icon('check', 18); ?><span><strong>No advertising or social-media pixels.</strong></span></li>
      </ul>

      <h2 id="control">3. How to Control Cookies</h2>
      <p>Most browsers let you view, delete and block cookies and clear site data. Blocking all cookies will not stop you from calling us, but our forms may not record how you found us. Instructions are in your browser's help pages (Chrome, Safari, Firefox and Edge all offer them).</p>

      <h2 id="opt-out">4. Opting Out of Google Analytics</h2>
      <p>If Google Analytics is active, you can opt out on every site by installing the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Google Analytics Opt-out Browser Add-on</a>. A Global Privacy Control signal from your browser is treated as an opt-out request under our <a href="/privacy-policy/#ccpa-rights">Privacy Policy</a>.</p>

      <h2 id="notice">5. Our Cookie Notice</h2>
      <p>We show a short cookie notice after you first scroll. Once you click "Got it" it stays hidden on later visits. Clear this site's data in your browser to see it again.</p>

      <h2 id="changes">6. Changes to This Policy</h2>
      <p>We update this policy when the cookies on our site change. The "Last Updated" date at the top shows the current version.</p>

      <h2 id="contact">7. Contact Us</h2>
      <p>Questions about cookies on this site:</p>
      <?php echo legalContactBlock(); ?>

      <?php echo legalRelated('/cookie-policy/'); ?>
    </article>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
