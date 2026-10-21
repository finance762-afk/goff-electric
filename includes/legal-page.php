<?php
/**
 * includes/legal-page.php — shared pieces for the four legal pages (privacy-policy, terms, cookie-policy, accessibility).
 * Source: ~/crm/references/legal-compliance.md (templates adapted to an electrical contractor on the Page One leads
 * endpoint: no Formsubmit, no insurance-claim clause, no "attorney review" disclaimer per the Sep 29 2026 rule).
 *
 *   $companyName / $companyEntityType / $companyState / $companyEmail / $companyPhone / $companyPhoneE164 / $companyAddress
 *   $legalLastUpdated — fixed date of the last real edit (never date(), which would change on every visit)
 *   legalSchema($path, $name, $description)  WebPage + BreadcrumbList nodes
 *   legalCrumbs($title) / legalUpdated()      breadcrumb + "Last Updated" stamp for the page's own 40vh .hero--legal (the H1 stays
 *                                             literal in each page so source-level QA sees it)
 *   legalContactBlock()                       standard contact block for the closing section
 *   legalStyles()                             shared legal-page CSS (tokens only), echoed once before the page's own <style>
 *
 * Entity type: intake has no entity field; the Google Business Profile name is "Goff Electric llc", so LLC is used and
 * listed in /content-confirmations.json with the state of formation (New Mexico assumed: the company is based and operates there).
 */
$companyEntityType = 'Limited Liability Company';
$companyName       = $siteName . ' LLC';
$companyState      = 'New Mexico';
$companyCounty     = 'Sandoval County';   // Rio Rancho (87124) sits in Sandoval County
$companyEmail      = $email;
$companyPhone      = formatPhone($phone);
$companyPhoneE164  = $phoneRaw;
$companyAddress    = (!empty($addressPublic) && !empty($address['street']) ? $address['street'] . ', ' : '')
                   . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$companyDomain     = $productionDomain;   // electricgoff.com (the site's live domain)
$legalLastUpdated  = 'October 21, 2026';
$legalLastUpdatedIso = '2026-10-21';

if (!function_exists('legalSchema')) {
    function legalSchema(string $path, string $name, string $description): array {
        global $siteUrl, $legalLastUpdatedIso;
        $url  = rtrim($siteUrl, '/') . $path;
        $page = generateWebPageSchema($url, $name, $description);
        $page['dateModified'] = $legalLastUpdatedIso;
        $page['breadcrumb']   = ['@id' => $url . '#breadcrumb'];
        $crumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => $name, 'url' => $path]]);
        $crumbs['@id'] = $url . '#breadcrumb';
        return [$page, $crumbs];
    }
}

if (!function_exists('legalCrumbs')) {
    /** Visible breadcrumb for the legal hero (Home / <title>). */
    function legalCrumbs(string $title): string {
        return '<nav class="breadcrumb legal-crumbs" aria-label="Breadcrumb"><ol><li><a href="/">Home</a></li>'
             . '<li class="breadcrumb-sep" aria-hidden="true">/</li><li aria-current="page">' . esc($title) . '</li></ol></nav>';
    }
}

if (!function_exists('legalUpdated')) {
    /** "Last Updated" stamp shown at the top of every legal page. */
    function legalUpdated(): string {
        global $legalLastUpdated, $legalLastUpdatedIso;
        return '<p class="legal-updated">Last Updated: <time datetime="' . esc($legalLastUpdatedIso) . '">' . esc($legalLastUpdated) . '</time></p>';
    }
}

if (!function_exists('legalContactBlock')) {
    function legalContactBlock(): string {
        global $companyName, $companyEmail, $companyPhone, $companyPhoneE164, $companyAddress;
        return '<div class="legal-contact">'
             . '<p><strong>' . esc($companyName) . '</strong></p>'
             . '<p>' . icon('mail', 18) . '<span>Email: <a href="mailto:' . esc($companyEmail) . '">' . esc($companyEmail) . '</a></span></p>'
             . '<p>' . icon('phone', 18) . '<span>Phone: <a href="tel:' . esc($companyPhoneE164) . '">' . esc($companyPhone) . '</a></span></p>'
             . '<p>' . icon('map-pin', 18) . '<span>Based in ' . esc($companyAddress) . '</span></p>'
             . '</div>';
    }
}

if (!function_exists('legalStyles')) {
    /** Shared legal-page CSS (legal-compliance.md "Legal Page CSS", restyled to the bold-industrial tokens). */
    function legalStyles(): string {
        return <<<'CSS'
<style>
/* ==========================================================================
   Legal pages — shared (includes/legal-page.php). Clean and functional: solid 40vh hero, single 65ch column,
   no reveals, no photos. Tokens only.
   ========================================================================== */
.hero--legal { position: relative; isolation: isolate; overflow: clip; min-height: 40vh; display: flex; align-items: flex-end; background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 70%, var(--color-primary-deep) 130%); }
.hero--legal::before { content: ""; position: absolute; inset: auto -10% -60% 55%; height: 130%; z-index: -1; pointer-events: none; background: radial-gradient(closest-side, rgba(var(--color-accent-rgb), .16), transparent 72%); }
.hero--legal .grain { z-index: -1; opacity: .3; }
.hero--legal .container { width: 100%; }
.hero--legal .hero__copy { display: grid; gap: var(--space-sm); max-width: 65ch; }
.hero--legal h1 { text-transform: uppercase; letter-spacing: .01em; }
.hero--legal .legal-sub { margin: 0; font-size: var(--fs-lead); color: color-mix(in srgb, var(--color-white) 82%, transparent); }
.hero--legal .legal-updated { margin: 0; display: inline-block; width: fit-content; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-accent-bright); border: 1px solid color-mix(in srgb, var(--color-white) 22%, transparent); border-radius: var(--radius-full); padding: var(--space-1) var(--space-sm); }
.legal-crumbs { background: none; border: 0; padding: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 72%, transparent); }
.legal-crumbs ol { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-xs); list-style: none; margin: 0; padding: 0; }
.legal-crumbs a { color: inherit; }
.legal-crumbs a:hover { color: var(--color-accent-bright); }
.legal-crumbs [aria-current] { color: var(--color-white); }

.legal-body { background: var(--color-surface); padding-block: var(--space-3xl) var(--space-4xl); }
.legal-body .content-narrow { margin-inline: auto; max-width: 65ch; }
.legal-prose { max-width: 65ch; color: var(--color-ink-2); }
.legal-prose h2 { color: var(--color-ink); text-transform: uppercase; letter-spacing: .02em; margin-top: var(--space-2xl); padding-top: var(--space-lg); border-top: 1px solid var(--color-line); scroll-margin-top: calc(var(--nav-height) + var(--space-md)); }
.legal-prose h2:first-of-type { margin-top: var(--space-lg); }
.legal-prose h3 { color: var(--color-ink); font-size: var(--fs-h3); scroll-margin-top: calc(var(--nav-height) + var(--space-md)); }
.legal-prose p, .legal-prose li { line-height: 1.7; }
.legal-prose ul, .legal-prose ol { padding-left: var(--space-lg); }
.legal-prose li { margin-bottom: var(--space-xs); }
.legal-prose li::marker { color: var(--color-accent-dark); }
.legal-prose a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: .2em; }
.legal-prose a:hover { color: var(--color-accent-dark); }
.legal-prose strong { color: var(--color-ink); }
.legal-intro { font-size: var(--fs-lead); color: var(--color-ink); }
.legal-toc { margin: 0 0 var(--space-xl); padding: var(--space-lg); background: var(--color-paper); border: 1px solid var(--color-line); border-left: 4px solid var(--color-accent); border-radius: var(--radius); }
.legal-toc h2 { margin: 0 0 var(--space-sm); padding: 0; border: 0; font-size: var(--fs-eyebrow); font-family: var(--font-accent); letter-spacing: .14em; color: var(--color-ink); }
.legal-toc ol { columns: 2; column-gap: var(--space-xl); margin: 0; padding-left: var(--space-lg); font-size: var(--fs-small); }
.legal-toc li { break-inside: avoid; margin-bottom: var(--space-1); }
.legal-toc a { font-weight: 500; text-decoration: none; }
.legal-toc a:hover { text-decoration: underline; }
.legal-callout { margin: var(--space-lg) 0; padding: var(--space-md) var(--space-lg); background: var(--color-card-tint-3); border-left: 4px solid var(--color-accent); border-radius: 0 var(--radius) var(--radius) 0; color: var(--color-ink); }
.legal-callout p:last-child { margin-bottom: 0; }
.legal-contact { display: grid; gap: var(--space-xs); padding: var(--space-lg); background: var(--color-paper); border: 1px solid var(--color-line); border-radius: var(--radius-lg); }
.legal-contact p { display: flex; gap: var(--space-xs); align-items: flex-start; margin: 0; }
.legal-contact svg { color: var(--color-accent-dark); flex: 0 0 auto; margin-top: var(--space-1); }
.legal-related { display: flex; flex-wrap: wrap; gap: var(--space-xs); margin-top: var(--space-2xl); padding-top: var(--space-lg); border-top: 1px solid var(--color-line); }
.legal-related a { display: inline-flex; align-items: center; min-height: 44px; padding: 0 var(--space-md); border: 1px solid var(--color-line); border-radius: var(--radius-full); font-size: var(--fs-small); font-weight: 600; color: var(--color-ink); text-decoration: none; }
.legal-related a:hover { border-color: var(--color-ink); }
@media (max-width: 640px) { .legal-toc ol { columns: 1; } .legal-body { padding-block: var(--space-2xl) var(--space-3xl); } }
</style>
CSS;
    }
}

if (!function_exists('legalRelated')) {
    /** Links to the other legal pages (excluding $current). */
    function legalRelated(string $current): string {
        $pages = ['/privacy-policy/' => 'Privacy Policy', '/terms/' => 'Terms of Service', '/cookie-policy/' => 'Cookie Policy', '/accessibility/' => 'Accessibility Statement'];
        $out = '<nav class="legal-related" aria-label="Other legal pages">';
        foreach ($pages as $lpPath => $lpName) {
            if ($lpPath !== $current) $out .= '<a href="' . esc($lpPath) . '">' . esc($lpName) . '</a>';
        }
        return $out . '</nav>';
    }
}
