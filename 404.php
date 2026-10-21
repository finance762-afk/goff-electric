<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * 404.php — Goff Electric "page not found" (Phase 5, 2026-10-21). Served by `ErrorDocument 404 /404.php` (.htaccess).
 * Sends a real 404 status and noindex. Search suggestion: the missing URL's words (or the search box's ?q=) are matched in
 * PHP against a small registry of the site's pages, so /ev-charger or /breaker-panel points straight at the right page.
 * No JavaScript, no third-party search. Registry links are gated with siteHas()/serviceUrl() — never a link to another 404.
 */
http_response_code(404);

$pageTitle       = 'Page Not Found | Goff Electric, Rio Rancho Electrician';
$pageDescription = 'This page could not be found. Find Goff Electric services, contact details and answers for Rio Rancho and Albuquerque electrical work.';
$canonicalUrl    = $siteUrl . '/404';
$noindex         = true;
$currentPage     = '';
$pageType        = 'other';
$phoneText       = formatPhone($phone);

/* What was asked for: the search box (?q=) wins, else the words in the missing path */
$nfQuery = trim((string) ($_GET['q'] ?? ''));
if ($nfQuery === '' && !empty($_SERVER['REDIRECT_QUERY_STRING'])) {
    parse_str((string) $_SERVER['REDIRECT_QUERY_STRING'], $nfQs);
    $nfQuery = trim((string) ($nfQs['q'] ?? ''));
}
$nfPath = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$nfFromPath = !preg_match('#^/404(\.php)?/?$#', $nfPath);
$nfSource = $nfQuery !== '' ? $nfQuery : ($nfFromPath ? $nfPath : '');
$nfQuery  = mb_substr($nfQuery, 0, 80);

/* Page registry: url + words a visitor might type */
$nfPages = [];
$nfServiceWords = [
    'residential-electrical'                => 'residential home house hot tub spa jacuzzi circuit remodel addition',
    'commercial-electrical'                 => 'commercial business office shop store tenant building electrical room conduit',
    'ev-charger-installation'               => 'ev charger charging car vehicle tesla level 2 electric vehicle',
    'electrical-panel-upgrades-repair'      => 'panel breaker breakers upgrade service amp amps 200 tripping box',
    'lighting-installation'                 => 'light lights lighting recessed can cans pendant fixture fixtures outdoor security',
    'ceiling-fan-installation'              => 'ceiling fan fans',
    'outlets-switches'                      => 'outlet outlets switch switches gfci plug plugs receptacle',
    'electrical-wiring-installation-repair' => 'wire wiring rewire rewiring short shorts faulty trench underground',
    'electrical-inspections'                => 'inspection inspections inspect buyer safety check',
    '24-7-emergency-electrical-service'     => 'emergency emergencies 24 7 247 outage power out sparking burning smell urgent',
];
foreach ($services as $nfSvc) {
    $nfUrl = serviceUrl($nfSvc['slug']);
    if ($nfUrl !== '') $nfPages[] = ['name' => $nfSvc['name'], 'url' => $nfUrl, 'desc' => $nfSvc['description'], 'words' => $nfSvc['name'] . ' ' . ($nfServiceWords[$nfSvc['slug']] ?? '')];
}
/* Town pages (Phase 6) — "rio", "rancho", "albuquerque" are stop words below, so each town also carries neighborhood words */
$nfAreaWords = [
    'rio-rancho'  => 'riorancho estates enchanted hills cabezon mariposa northern meadows star heights 87124 87144',
    'albuquerque' => 'abq westside heights northeast taylor ventana paradise valley 87114 87120',
    'corrales'    => 'corrales village 87048',
    'bernalillo'  => 'bernalillo town 87004',
    'placitas'    => 'placitas foothills 87043',
    'tijeras'     => 'tijeras east mountains canyon cedar crest 87059',
];
foreach ($serviceAreas as $nfArea) {
    $nfUrl = areaUrl($nfArea['slug'], false);
    if ($nfUrl !== '') $nfPages[] = ['name' => 'Electrician in ' . $nfArea['name'], 'url' => $nfUrl, 'desc' => 'Local electrical notes, permits and services for ' . $nfArea['name'] . ', NM.', 'words' => $nfArea['name'] . ' ' . ($nfAreaWords[$nfArea['slug']] ?? '')];
}
foreach ([
    ['/service-areas/', 'Service areas', 'The six towns Goff Electric serves, with a coverage map.', 'areas area service towns town cities city locations location serve served coverage map'],
    ['/services/', 'All electrical services', 'Every service Goff Electric offers, with a problem-to-service guide.', 'services service electrician electrical list all'],
    ['/about/', 'About Goff Electric', 'Owner Garrett Goff, credentials and what customers say.', 'about owner garrett goff company who team license licensed insured'],
    ['/contact/', 'Contact and free estimate', 'Phone, email, hours and the estimate form.', 'contact phone call email estimate quote hours number'],
    ['/faq/', 'Electrician FAQ', 'Pricing, permits, service areas and emergencies.', 'faq question questions cost costs price pricing permit permits'],
    ['/privacy-policy/', 'Privacy Policy', 'How Goff Electric handles your information.', 'privacy policy data ccpa'],
    ['/terms/', 'Terms of Service', 'Terms for this website and Goff Electric services.', 'terms service conditions'],
] as $nfRow) {
    if (siteHas($nfRow[0])) $nfPages[] = ['name' => $nfRow[1], 'url' => $nfRow[0], 'desc' => $nfRow[2], 'words' => $nfRow[3]];
}

/* Score each page by the words it shares with the request */
$nfStop = ['the', 'and', 'for', 'a', 'an', 'of', 'in', 'to', 'my', 'nm', 'rio', 'rancho', 'albuquerque', 'php', 'html', 'index', 'page', 'goff'];
$nfTokens = array_values(array_diff(array_filter(preg_split('/[^a-z0-9]+/', strtolower($nfSource))), $nfStop));
$nfMatches = [];
if ($nfTokens) {
    foreach ($nfPages as $nfPage) {
        $nfWords = preg_split('/[^a-z0-9]+/', strtolower($nfPage['words']));
        $nfScore = count(array_intersect($nfTokens, $nfWords));
        if ($nfScore > 0) $nfMatches[] = $nfPage + ['score' => $nfScore];
    }
    usort($nfMatches, fn($a, $b) => $b['score'] <=> $a['score']);
    $nfMatches = array_slice($nfMatches, 0, 3);
}

/* Popular pages (always shown) */
$nfPopular = [];
foreach (['24-7-emergency-electrical-service' => 'alert-triangle', 'electrical-panel-upgrades-repair' => 'gauge', 'ev-charger-installation' => 'plug-zap', 'residential-electrical' => 'house'] as $nfSlug => $nfIcon) {
    $nfUrl = serviceUrl($nfSlug);
    $nfRow = nfServiceRow($nfSlug);
    if ($nfUrl !== '' && $nfRow) $nfPopular[] = ['name' => $nfRow['name'], 'url' => $nfUrl, 'icon' => $nfIcon];
}
foreach ([['/services/', 'All services', 'layers'], ['/about/', 'About Goff Electric', 'users'], ['/faq/', 'FAQ', 'message-square'], ['/contact/', 'Contact', 'mail']] as $nfRow) {
    if (siteHas($nfRow[0])) $nfPopular[] = ['name' => $nfRow[1], 'url' => $nfRow[0], 'icon' => $nfRow[2]];
}

function nfServiceRow(string $slug): ?array {
    global $services;
    foreach ($services as $row) if ($row['slug'] === $slug) return $row;
    return null;
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style>
/* ==========================================================================
   404 — Goff Electric. A "tripped breaker" page: dark hero with an oversized 404, suggestions, popular pages, call CTA.
   Tokens only.
   ========================================================================== */
.hero--404 { padding-bottom: calc(var(--space-3xl) + 3.5vw); background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 130%); }
.hero--404 .grain { z-index: -1; opacity: .3; }
.hero--404::before { content: ""; position: absolute; inset: auto -12% -55% 48%; height: 120%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side, rgba(var(--color-accent-rgb), .18), transparent 72%); }
.hero--404 .container { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: var(--space-xl) var(--space-3xl); align-items: center; }
.hero--404 .hero-text { max-width: 38rem; }
.hero--404 .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.nf-code { display: flex; align-items: center; justify-content: center; margin: 0; position: relative; font-family: var(--font-heading); font-size: clamp(6rem, 3rem + 12vw, 13rem); line-height: .85; letter-spacing: -.02em; color: transparent; -webkit-text-stroke: 2px color-mix(in srgb, var(--color-white) 30%, transparent); }
.nf-code span { color: var(--color-accent); -webkit-text-stroke: 0; text-shadow: 0 0 var(--space-xl) rgba(var(--color-accent-rgb), .45); }
.nf-code small { position: absolute; bottom: calc(-1 * var(--space-lg)); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .2em; text-transform: uppercase; color: color-mix(in srgb, var(--color-white) 70%, transparent); -webkit-text-stroke: 0; }
.nf-search { display: flex; gap: var(--space-xs); max-width: 30rem; }
.nf-search input { flex: 1; min-width: 0; min-height: 48px; padding: 0 var(--space-md); font: inherit; font-size: 16px; color: var(--color-ink); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius); }
.nf-search input:focus { outline: 3px solid var(--color-accent); outline-offset: 2px; }
.nf-search .btn { flex: 0 0 auto; }
@media (max-width: 800px) { .hero--404 .container { grid-template-columns: 1fr; } .nf-code { justify-content: flex-start; flex-wrap: wrap; font-size: clamp(5rem, 3rem + 10vw, 7rem); } .nf-code small { position: static; flex-basis: 100%; margin-top: var(--space-xs); } }

.nf-body { background: var(--color-paper); margin-top: -3.5vw; z-index: 1; }
.nf-body__grid { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr); gap: var(--space-2xl) var(--space-3xl); align-items: start; }
.nf-body h2 { font-size: var(--fs-h3); text-transform: uppercase; letter-spacing: .03em; margin-bottom: var(--space-md); }
.nf-matches { list-style: none; margin: 0 0 var(--space-xl); padding: 0; display: grid; gap: var(--space-sm); }
.nf-match a { display: grid; gap: var(--space-1); padding: var(--space-md) var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-left: 4px solid var(--color-accent); border-radius: var(--radius); text-decoration: none; color: var(--color-ink); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.nf-match a:hover { transform: translateX(4px); box-shadow: var(--shadow); }
.nf-match b { font-family: var(--font-heading); font-size: 1.15rem; text-transform: uppercase; letter-spacing: .02em; }
.nf-match span { font-size: var(--fs-small); color: var(--color-ink-2); }
.nf-note { margin: 0 0 var(--space-xl); padding: var(--space-md) var(--space-lg); background: var(--color-card-tint-3); border-radius: var(--radius); color: var(--color-ink-2); }
.nf-popular { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-sm); }
.nf-popular a { display: flex; align-items: center; gap: var(--space-sm); min-height: 56px; padding: var(--space-sm) var(--space-md); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius); font-weight: 600; color: var(--color-ink); text-decoration: none; transition: border-color var(--transition), color var(--transition); }
.nf-popular a:hover { border-color: var(--color-ink); color: var(--color-accent-dark); }
.nf-popular svg { color: var(--color-accent-dark); flex: 0 0 auto; }
.nf-call { display: grid; gap: var(--space-sm); padding: var(--space-xl); background: var(--color-dark); color: var(--color-white); border-radius: var(--radius-lg); border-top: 4px solid var(--color-accent); box-shadow: var(--shadow-lg); }
.nf-call h2 { color: var(--color-white); margin: 0; }
.nf-call p { margin: 0; color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.nf-call__number { font-family: var(--font-heading); font-size: clamp(1.9rem, 1.3rem + 2vw, 2.6rem); line-height: 1; color: var(--color-white); text-decoration: none; }
.nf-call__number:hover { color: var(--color-accent-bright); }
.nf-call .actions { display: flex; flex-wrap: wrap; gap: var(--space-sm); margin-top: var(--space-xs); }
@media (max-width: 900px) { .nf-body__grid { grid-template-columns: 1fr; } }
@media (max-width: 480px) { .nf-popular { grid-template-columns: 1fr; } }
</style>

<section class="hero hero--interior hero--404" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-text hero-copy">
      <span class="eyebrow">Error 404 · page not found</span>
      <h1 class="hero-title" id="hero-title">This circuit's dead: page not found</h1>
      <p class="hero-answer">The link may be old or mistyped. Search below, try one of the pages listed, or call Goff Electric in Rio Rancho any hour.</p>
      <form class="nf-search" action="/404" method="get" role="search" aria-label="Search the Goff Electric site">
        <label class="sr-only" for="nf-q">What are you looking for?</label>
        <input id="nf-q" type="search" name="q" value="<?php echo esc($nfQuery); ?>" placeholder="e.g. EV charger, breaker panel" autocomplete="off">
        <button type="submit" class="btn btn-accent"><?php echo icon('search', 18); ?>Search</button>
      </form>
    </div>
    <p class="nf-code" aria-hidden="true">4<span>0</span>4<small>Breaker tripped</small></p>
  </div>
</section>

<section class="section nf-body slant-top" aria-label="Where to go next">
  <div class="container nf-body__grid">
    <div>
<?php if ($nfMatches): ?>
      <h2><?php echo $nfQuery !== '' ? 'Results for "' . esc($nfQuery) . '"' : 'Were you looking for one of these?'; ?></h2>
      <ul class="nf-matches">
<?php foreach ($nfMatches as $nfMatch): ?>
        <li class="nf-match"><a href="<?php echo esc($nfMatch['url']); ?>"><b><?php echo esc($nfMatch['name']); ?></b><span><?php echo esc($nfMatch['desc']); ?></span></a></li>
<?php endforeach; ?>
      </ul>
<?php elseif ($nfQuery !== ''): ?>
      <p class="nf-note">Nothing on the site matched "<?php echo esc($nfQuery); ?>". Try a shorter word like "panel", "fan" or "outlet", or call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a> and ask.</p>
<?php endif; ?>
      <h2>Popular pages</h2>
      <ul class="nf-popular">
        <li><a href="/"><?php echo icon('home', 20); ?>Home</a></li>
<?php foreach ($nfPopular as $nfLink): ?>
        <li><a href="<?php echo esc($nfLink['url']); ?>"><?php echo icon($nfLink['icon'], 20); ?><?php echo esc($nfLink['name']); ?></a></li>
<?php endforeach; ?>
      </ul>
    </div>
    <aside class="nf-call" aria-labelledby="nf-call-title">
      <h2 id="nf-call-title">Need an electrician now?</h2>
      <p>Goff Electric answers 24 hours a day for Rio Rancho, Albuquerque, Corrales, Bernalillo, Placitas and Tijeras.</p>
      <a class="nf-call__number" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($phoneText); ?></a>
      <div class="actions">
        <a class="btn btn-accent" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call now</a>
        <a class="btn btn-outline-white" href="<?php echo siteHas('/contact/') ? '/contact/' : '#'; ?>" data-open-estimate>Free estimate</a>
      </div>
    </aside>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
