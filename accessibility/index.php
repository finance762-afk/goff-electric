<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /accessibility/ — Goff Electric (Phase 5, 2026-10-21). Template: legal-compliance.md "Accessibility Statement".
 * The features list describes what this build actually ships (skip link, landmarks, focus ring, alt text, labelled forms,
 * keyboard-operable menus with aria-expanded, reduced-motion support, content visible without JavaScript). Known issues are
 * the honest ones: horizontal scroll strips and the third-party Google review data. Indexable. WebPage + BreadcrumbList.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.php';

$pageTitle       = 'Accessibility Statement | Goff Electric, Rio Rancho NM';
$pageDescription = 'Goff Electric in Rio Rancho, NM works to meet WCAG 2.1 AA on its website. See its features and known issues, and call (505) 549-9454 to report a barrier.';
$canonicalUrl    = $siteUrl . '/accessibility/';
$currentPage     = 'legal';
$pageType        = 'other';
$schemaMarkup    = legalSchema('/accessibility/', 'Accessibility Statement', $pageDescription);

$a11yFeatures = [
    ['icon' => 'layers',       'text' => 'Semantic HTML with landmark regions (header, navigation, main, footer)'],
    ['icon' => 'arrow-right',  'text' => 'A "Skip to main content" link at the top of every page'],
    ['icon' => 'eye',          'text' => 'A visible keyboard focus outline on every link, button and form field'],
    ['icon' => 'menu',         'text' => 'Menus and the estimate form work with a keyboard; the mobile menu announces open and closed states'],
    ['icon' => 'pencil-ruler', 'text' => 'Every form field has a label, and required fields are marked'],
    ['icon' => 'sparkles',     'text' => 'Descriptive alt text on photos; decorative graphics are hidden from screen readers'],
    ['icon' => 'sun',          'text' => 'Body text and buttons chosen to meet WCAG AA color contrast'],
    ['icon' => 'waves',        'text' => 'Animations turn off when your device asks for reduced motion, and all content shows even if JavaScript does not load'],
    ['icon' => 'ruler',        'text' => 'Responsive layouts that work on phones, tablets and desktops and at 200% zoom'],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php echo legalStyles(); ?>
<style>
/* Accessibility — page specifics: feature checklist with icons, conformance status chip */
.a11y-status { display: inline-flex; align-items: center; gap: var(--space-xs); padding: var(--space-xs) var(--space-md); border-radius: var(--radius-full); background: var(--color-dark); color: var(--color-white); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; }
.a11y-status svg { color: var(--color-accent); }
.a11y-features { list-style: none; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-sm); }
.a11y-features li { display: grid; grid-template-columns: var(--space-xl) minmax(0, 1fr); gap: var(--space-xs); align-items: start; margin: 0; padding: var(--space-sm) var(--space-md); background: var(--color-paper); border: 1px solid var(--color-line); border-radius: var(--radius); font-size: var(--fs-small); }
.a11y-features svg { color: var(--color-accent-dark); margin-top: var(--space-1); }
@media (max-width: 560px) { .a11y-features { grid-template-columns: 1fr; } }
</style>

<section class="hero hero--legal" aria-labelledby="legal-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero__copy">
      <?php echo legalCrumbs('Accessibility Statement'); ?>
      <span class="eyebrow">Legal</span>
      <h1 id="legal-title">Accessibility Statement</h1>
      <p class="legal-sub"><?php echo esc('Our commitment to a website everyone can use.'); ?></p>
      <?php echo legalUpdated(); ?>
    </div>
  </div>
</section>

<section class="legal-body" aria-label="Accessibility Statement text">
  <div class="container">
    <article class="content-narrow legal-prose">

      <p class="legal-intro"><?php echo esc($companyName); ?> wants everyone, including people with disabilities, to be able to find an electrician, read about our services and reach us through <?php echo esc($companyDomain); ?>.</p>

      <h2 id="commitment">1. Our Commitment</h2>
      <p><?php echo esc($siteName); ?> is committed to digital accessibility. We review the site as it changes and apply the Web Content Accessibility Guidelines (WCAG) when we add pages and features.</p>

      <h2 id="status">2. Conformance Status</h2>
      <p><span class="a11y-status"><?php echo icon('shield-check', 16); ?>WCAG 2.1 Level AA · partially conformant</span></p>
      <p>The site is designed to conform with WCAG 2.1 Level AA. "Partially conformant" means some content may not yet fully meet the standard. We are working to fix any issue we find or that you report.</p>

      <h2 id="features">3. Accessibility Features</h2>
      <ul class="a11y-features">
<?php foreach ($a11yFeatures as $a11yItem): ?>
        <li><?php echo icon($a11yItem['icon'], 18); ?><span><?php echo esc($a11yItem['text']); ?></span></li>
<?php endforeach; ?>
      </ul>

      <h2 id="known-issues">4. Known Issues</h2>
      <ul>
        <li>The project-photo and review strips scroll sideways. They can be scrolled with a keyboard, but some screen reader and switch users may find them slower to move through.</li>
        <li>Google review text is shown exactly as customers wrote it, so it may include emoji or abbreviations.</li>
        <li>Links to outside sites, such as Google Maps and our Google Business Profile, are run by those companies and may not meet the same standard.</li>
      </ul>
      <p>If any of these gets in your way, call or email us and we will give you the same information directly.</p>

      <h2 id="feedback">5. Feedback and Reporting a Barrier</h2>
      <p>If something on the site is hard to use, please tell us the page address and what happened. We read every report and will work with you to get you the information or service you need.</p>

      <h2 id="alternatives">6. Other Ways to Reach Us</h2>
      <p>You never need the website to hire us. Call <a href="tel:<?php echo esc($companyPhoneE164); ?>"><?php echo esc($companyPhone); ?></a>, 24 hours a day, or email <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a>, and we will take your request, answer questions or provide information in another format on request.</p>

      <h2 id="changes">7. Changes to This Statement</h2>
      <p>We update this statement as the site changes. The "Last Updated" date at the top shows the current version.</p>

      <h2 id="contact">8. Contact Us</h2>
      <?php echo legalContactBlock(); ?>

      <?php echo legalRelated('/accessibility/'); ?>
    </article>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
