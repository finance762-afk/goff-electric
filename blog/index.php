<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /blog/ — Goff Electric blog, COMING SOON placeholder (Phase 6, 2026-10-21).
 * The build writes no posts; real posts are added later through the design-portal Blogs tab (includes/blog-data.php registry,
 * /blog/<slug>/index.php per post — see ~/crm/references/blog-standard.md). Until then this page:
 *   - carries <meta name="robots" content="noindex, follow"> ($robotsMeta),
 *   - stays OUT of sitemap.php / any sitemap,
 *   - is not featured on the homepage (no "From the Blog" section).
 * Links onward to pages that already answer common questions (FAQ, services, service areas) so a visitor is never stranded.
 */
$pageTitle       = 'Electrical Tips & Guides, Coming Soon | Goff Electric Blog';
$pageDescription = 'The Goff Electric blog is coming soon with practical electrical guides for Rio Rancho and Albuquerque homeowners. Until then, see our FAQ and services.';
$canonicalUrl    = $siteUrl . '/blog/';
$robotsMeta      = 'noindex, follow';
$currentPage     = 'blog';
$pageType        = 'other';
$phoneText       = formatPhone($phone);

$blogNext = [];
if (siteHas('/faq/'))           $blogNext[] = ['/faq/', 'info', 'Electrical FAQ', 'Straight answers on permits, warning signs, surge protection, panels and EV chargers.'];
if (siteHas('/services/'))      $blogNext[] = ['/services/', 'zap', 'All ' . count($services) . ' services', 'What Goff Electric does for homes and businesses, with a guide to which service fits your problem.'];
if (areasHubUrl() !== '')       $blogNext[] = [areasHubUrl(), 'map-pin', 'Service areas', 'Six towns from Rio Rancho to Tijeras, with local permit and climate notes for each.'];
if (serviceUrl('24-7-emergency-electrical-service') !== '') $blogNext[] = [serviceUrl('24-7-emergency-electrical-service'), 'alert-triangle', 'Electrical emergency?', 'What to do first, and when to call PNM instead of an electrician.'];

$crumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Blog', 'url' => '/blog/'],
];
$blogPage = generateWebPageSchema($canonicalUrl, $pageTitle, $pageDescription);
$schemaMarkup = [$blogPage, generateBreadcrumbSchema($crumbs)];

$ctaBandEyebrow = 'Have a question now?';
$ctaBandTitle   = 'Ask Goff Electric directly';
$ctaBandText    = 'No need to wait for an article. Describe the problem or project and the town, and Garrett will get back to you with a straight answer.';
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ==========================================================================
   Blog placeholder — page composition. Tokens only.
   ========================================================================== */
.hero--blog { background: var(--color-dark); color: var(--color-white); padding-bottom: calc(clamp(2.5rem, 5vw, 3.5rem) + 3vw); }
.hero--blog::before { content: ""; position: absolute; inset: -30% -10% auto 50%; height: 140%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side, rgba(var(--color-accent-rgb), .22), transparent 70%); }
.hero--blog .hero-title { color: var(--color-white); max-width: 20ch; }
.hero--blog .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.hero--blog .eyebrow { color: var(--color-accent-bright); }
.hero--blog .blog-badge { display: inline-flex; align-items: center; gap: var(--space-xs); width: fit-content; padding: var(--space-1) var(--space-sm); border-radius: var(--radius-full); border: 1px solid color-mix(in srgb, var(--color-accent) 60%, transparent); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.hero--blog .blog-badge::before { content: ""; width: 8px; height: 8px; border-radius: var(--radius-full); background: var(--color-accent); animation: blog-blink 1.6s var(--ease) infinite; }
@keyframes blog-blink { 0%, 100% { opacity: 1; } 50% { opacity: .25; } }
.hero--blog .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.hero--blog .link-call strong { color: var(--color-white); }
.hero--blog .link-call svg { color: var(--color-accent-bright); }

.blog-next { background: var(--color-paper); margin-top: -3vw; z-index: 1; }
.blog-next__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: var(--space-md); }
.blog-next__card { position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-top: 4px solid var(--color-accent); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.blog-next__card:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.blog-next__card svg { color: var(--color-accent-dark); }
.blog-next__card h3 { font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .02em; }
.blog-next__card p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.blog-next__card a { color: var(--color-ink); text-decoration: none; }
.blog-next__card a::after { content: ""; position: absolute; inset: 0; }
.blog-next__card:has(a:focus-visible) { outline: 3px solid var(--color-accent); outline-offset: 3px; }
.blog-next__card a:focus-visible { outline: none; }
</style>

<!-- ===================== HERO ===================== -->
<section class="hero hero--interior hero--blog" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-text hero-copy">
      <span class="blog-badge">Coming soon</span>
      <h1 class="hero-title" id="hero-title">The Goff Electric blog is coming soon</h1>
      <p class="hero-answer">Practical electrical guides for Rio Rancho and Albuquerque homeowners are on the way. Until then, the pages below already answer the most common questions.</p>
      <div class="hero-actions">
        <a class="btn btn-accent btn-lg" href="#estimate">Ask a question</a>
        <a class="link-call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span>or call <strong><?php echo esc($phoneText); ?></strong>, 24/7</span></a>
      </div>
    </div>
  </div>
</section>

<?php if ($blogNext): ?>
<!-- ===================== WHERE TO GO NOW ===================== -->
<section class="section blog-next slant-top" aria-labelledby="next-title">
  <div class="container">
    <div class="section-head">
      <span class="eyebrow-label">Read now</span>
      <h2 id="next-title">Where can you find answers before the first article is posted?</h2>
      <p>Until the first Goff Electric articles are posted, the FAQ, the services pages and the service-area pages already cover the questions Rio Rancho and Albuquerque homeowners ask most.</p>
    </div>
    <div class="blog-next__grid">
<?php foreach ($blogNext as $blogLink): ?>
      <article class="blog-next__card">
        <?php echo icon($blogLink[1], 28); ?>
        <h3><a href="<?php echo esc($blogLink[0]); ?>"><?php echo esc($blogLink[2]); ?></a></h3>
        <p><?php echo esc($blogLink[3]); ?></p>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php'; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
