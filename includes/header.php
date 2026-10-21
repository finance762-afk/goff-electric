<?php
/**
 * includes/header.php — skip link, fixed dark-glass navbar, mobile overlay menu; opens <main id="main-content">.
 * Include right after head.php (which opens <body>). Nav state comes from the page's $currentPage:
 *   home | services | areas | about | blog | faq | contact
 * Dark glass header: the logo is a white mark knocked out of a black field (logo-mark-v1.png), so the bar is
 * rgba(16,13,12,.72) at the top → .92 scrolled (.site-header--dark).
 * LINK INTEGRITY: page links render only when the page exists on disk (siteHas / serviceUrl / areaUrl). Services and
 * areas that are not built yet print as plain text, so the nav fills in by itself and never points at a 404.
 * Shared-include rule: loop variables are prefixed ($navSvc, $navArea).
 */
$navPhoneText   = formatPhone($phone);
$navLogo        = siteLogo();
$navCtaHref     = siteHas('/contact/') ? '/contact/' : 'tel:' . $phoneRaw;   // data-open-estimate opens the dialog; href is the no-JS fallback
$navHasServices = siteHas('/services/');
$navAreasHub    = areasHubUrl();

$navServices = [];
foreach ($services as $navSvc) {
    $navServices[] = ['name' => $navSvc['name'], 'url' => serviceUrl($navSvc['slug'])];
}
$navAreas = [];
foreach ($serviceAreas as $navArea) {
    $navAreas[] = ['name' => $navArea['name'], 'url' => areaUrl($navArea['slug'], false)];
}
?>
<a href="#main-content" class="skip-link">Skip to main content</a>

<header class="site-header site-header--dark" data-header>
  <nav class="navbar" aria-label="Main navigation">
    <div class="navbar-inner container">

      <a class="brand site-logo" href="/" aria-label="<?php echo esc($siteName); ?> — home">
<?php if ($navLogo): ?>
        <img src="<?php echo esc($navLogo['src']); ?>" alt="<?php echo esc($siteName); ?>" width="<?php echo (int) $navLogo['width']; ?>" height="<?php echo (int) $navLogo['height']; ?>"<?php echo $navLogo['class'] !== '' ? ' class="' . esc($navLogo['class']) . '"' : ''; ?> loading="eager" decoding="async">
<?php else: ?>
        <span class="logo-mark" aria-hidden="true">G</span>
        <span class="logo-text">
          <span class="brand-name logo-name"><?php echo esc($siteName); ?></span>
          <span class="brand-sub logo-tagline"><?php echo esc($address['city'] . ', ' . $address['state']); ?></span>
        </span>
<?php endif; ?>
      </a>

      <ul class="navbar-links">
        <li><a href="/"<?php echo ariaCurrent('home'); ?>>Home</a></li>
        <li class="has-dropdown">
<?php if ($navHasServices): ?>
          <a href="/services/"<?php echo ariaCurrent('services'); ?>>Services <?php echo icon('chevron-down', 14, 'nav-caret'); ?></a>
<?php else: ?>
          <button type="button" class="dropdown-toggle" aria-haspopup="true">Services <?php echo icon('chevron-down', 14, 'nav-caret'); ?></button>
<?php endif; ?>
          <ul class="dropdown dropdown--wide" aria-label="Electrical services" style="display:none">
<?php foreach ($navServices as $navSvcItem): ?>
            <li><?php if ($navSvcItem['url'] !== ''): ?><a href="<?php echo esc($navSvcItem['url']); ?>"><?php echo esc($navSvcItem['name']); ?></a><?php else: ?><span class="dropdown-item--pending"><?php echo esc($navSvcItem['name']); ?></span><?php endif; ?></li>
<?php endforeach; ?>
<?php if ($navHasServices): ?>
            <li class="dropdown-all"><a href="/services/">View all <?php echo count($services); ?> services <?php echo icon('arrow-right', 14); ?></a></li>
<?php endif; ?>
          </ul>
        </li>
<?php if ($tier === 'premium'): ?>
        <li class="has-dropdown">
<?php if ($navAreasHub !== ''): ?>
          <a href="<?php echo esc($navAreasHub); ?>"<?php echo ariaCurrent('areas'); ?>>Service Areas <?php echo icon('chevron-down', 14, 'nav-caret'); ?></a>
<?php else: ?>
          <button type="button" class="dropdown-toggle" aria-haspopup="true">Service Areas <?php echo icon('chevron-down', 14, 'nav-caret'); ?></button>
<?php endif; ?>
          <ul class="dropdown" aria-label="Service areas" style="display:none">
<?php foreach ($navAreas as $navAreaItem): ?>
            <li><?php if ($navAreaItem['url'] !== ''): ?><a href="<?php echo esc($navAreaItem['url']); ?>"><?php echo esc($navAreaItem['name']); ?></a><?php else: ?><span class="dropdown-item--pending"><?php echo esc($navAreaItem['name']); ?></span><?php endif; ?></li>
<?php endforeach; ?>
<?php if ($navAreasHub !== ''): ?>
            <li class="dropdown-all"><a href="<?php echo esc($navAreasHub); ?>">View all areas <?php echo icon('arrow-right', 14); ?></a></li>
<?php endif; ?>
          </ul>
        </li>
<?php endif; ?>
<?php if (siteHas('/about/')): ?>
        <li><a href="/about/"<?php echo ariaCurrent('about'); ?>>About</a></li>
<?php endif; ?>
<?php if ($tier === 'premium' && siteHas('/blog/')): ?>
        <li><a href="/blog/"<?php echo ariaCurrent('blog'); ?>>Blog</a></li>
<?php endif; ?>
<?php if (siteHas('/contact/')): ?>
        <li><a href="/contact/"<?php echo ariaCurrent('contact'); ?>>Contact</a></li>
<?php endif; ?>
      </ul>

      <div class="navbar-cta">
        <a class="btn btn-secondary navbar-phone" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span><?php echo esc($navPhoneText); ?></span></a>
        <a class="btn btn-nav-cta" href="<?php echo esc($navCtaHref); ?>" data-open-estimate>Free Estimate</a>
      </div>

      <button type="button" class="hamburger" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>

    </div>
  </nav>
</header>

<?php /* Mobile overlay lives OUTSIDE <header>: the header's backdrop-filter would become the containing block for position:fixed
         and shrink the overlay to the bar height. main.js toggles .active + aria-hidden — no second toggle here. */ ?>
<div class="mobile-menu" id="mobile-menu" aria-hidden="true">
  <nav class="mobile-menu-inner" aria-label="Mobile navigation">
    <ul class="mobile-menu-links mm-top">
      <li><a href="/"<?php echo ariaCurrent('home'); ?>>Home</a></li>
      <li>
<?php if ($navHasServices): ?>
        <a href="/services/"<?php echo ariaCurrent('services'); ?>>Services</a>
<?php else: ?>
        <span class="mm-label">Services</span>
<?php endif; ?>
        <ul class="mobile-submenu">
<?php foreach ($navServices as $navSvcItem): ?>
          <li><?php if ($navSvcItem['url'] !== ''): ?><a href="<?php echo esc($navSvcItem['url']); ?>"><?php echo esc($navSvcItem['name']); ?></a><?php else: ?><span class="mobile-submenu__pending"><?php echo esc($navSvcItem['name']); ?></span><?php endif; ?></li>
<?php endforeach; ?>
        </ul>
      </li>
<?php if ($tier === 'premium'): ?>
      <li>
<?php if ($navAreasHub !== ''): ?>
        <a href="<?php echo esc($navAreasHub); ?>"<?php echo ariaCurrent('areas'); ?>>Service Areas</a>
<?php else: ?>
        <span class="mm-label">Service Areas</span>
<?php endif; ?>
        <ul class="mobile-submenu">
<?php foreach ($navAreas as $navAreaItem): ?>
          <li><?php if ($navAreaItem['url'] !== ''): ?><a href="<?php echo esc($navAreaItem['url']); ?>"><?php echo esc($navAreaItem['name']); ?></a><?php else: ?><span class="mobile-submenu__pending"><?php echo esc($navAreaItem['name']); ?></span><?php endif; ?></li>
<?php endforeach; ?>
        </ul>
      </li>
<?php endif; ?>
<?php if (siteHas('/about/')): ?>
      <li><a href="/about/"<?php echo ariaCurrent('about'); ?>>About</a></li>
<?php endif; ?>
<?php if ($tier === 'premium' && siteHas('/blog/')): ?>
      <li><a href="/blog/"<?php echo ariaCurrent('blog'); ?>>Blog</a></li>
<?php endif; ?>
<?php if (siteHas('/faq/')): ?>
      <li><a href="/faq/"<?php echo ariaCurrent('faq'); ?>>FAQ</a></li>
<?php endif; ?>
<?php if (siteHas('/contact/')): ?>
      <li><a href="/contact/"<?php echo ariaCurrent('contact'); ?>>Contact</a></li>
<?php endif; ?>
    </ul>
    <div class="mobile-menu-cta">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 20); ?>Call <?php echo esc($navPhoneText); ?></a>
      <a class="btn btn-outline-white btn-lg" href="<?php echo esc($navCtaHref); ?>" data-open-estimate>Free Estimate</a>
    </div>
  </nav>
</div>

<main id="main-content">
