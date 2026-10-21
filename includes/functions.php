<?php
/**
 * includes/functions.php — shared helpers for Goff Electric.
 * head.php requires config.php THEN this file, so every page (and header/footer) can call these.
 * Helpers read config.php globals ($siteName, $siteUrl, $address, $services, $serviceAreas, ...).
 * Shared-include rule: loop variables in helpers/partials are prefixed ($fnSvc, $fnArea) — never $svc/$area/$c/$card.
 * No FAQPage helper on purpose: FAQPage JSON-LD is never emitted (visible FAQ text only).
 */

// Lead-form helpers (p1_lead_hidden_fields, p1_consent_row, p1_service_options)
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

if (!function_exists('esc')) {
    /** HTML-escape for text and attribute output. */
    function esc($value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

/* ---------------------------------------------------------------------------
 * Navigation state + link integrity
 * ------------------------------------------------------------------------- */

if (!function_exists('isActivePage')) {
    /** True when $page matches the page's $currentPage (set before head.php). */
    function isActivePage(string $page): bool {
        global $currentPage;
        return isset($currentPage) && $currentPage === $page;
    }
}

if (!function_exists('ariaCurrent')) {
    /** ' aria-current="page"' when $page is active, else ''. */
    function ariaCurrent(string $page): string {
        return isActivePage($page) ? ' aria-current="page"' : '';
    }
}

if (!function_exists('siteHas')) {
    /**
     * Link integrity: true only when the page exists on disk.
     * siteHas('/about/') → /about/index.php · siteHas('/thank-you') → /thank-you.php · siteHas('/') → /index.php
     */
    function siteHas(string $path): bool {
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
        $path = '/' . trim($path, '/');
        if ($path === '/') return is_file($root . '/index.php');
        return is_file($root . $path . '/index.php') || is_file($root . $path . '.php');
    }
}

if (!function_exists('serviceUrl')) {
    /** "/services/<slug>/" when that page is built, else ''. */
    function serviceUrl(string $slug): string {
        return siteHas('/services/' . $slug . '/') ? '/services/' . $slug . '/' : '';
    }
}

if (!function_exists('serviceLink')) {
    /** Contextual body link to a service page: <a> when built, plain text otherwise (never a 404). */
    function serviceLink(string $slug, string $anchor): string {
        $url = serviceUrl($slug);
        return $url !== '' ? '<a href="' . esc($url) . '">' . esc($anchor) . '</a>' : esc($anchor);
    }
}

if (!function_exists('areasHubUrl')) {
    /** The service-areas overview page when built ('/service-areas/' or '/service-area/'), else ''. */
    function areasHubUrl(): string {
        foreach (['/service-areas/', '/service-area/'] as $hub) {
            if (siteHas($hub)) return $hub;
        }
        return '';
    }
}

if (!function_exists('areaUrl')) {
    /**
     * Built city page for a slug: /areas/<slug>/ (scaffold dir) or /service-areas/<slug>/ — whichever is on disk.
     * Until the city page exists, falls back to the overview anchor (/service-areas/#<slug>) when the overview is
     * built, else '' (callers print plain text). A link can never point at a 404.
     */
    function areaUrl(string $slug, bool $allowHubAnchor = true): string {
        foreach (['/areas/', '/service-areas/'] as $base) {
            if (is_dir($_SERVER['DOCUMENT_ROOT'] . $base . $slug) && siteHas($base . $slug . '/')) return $base . $slug . '/';
        }
        $hub = areasHubUrl();
        return ($allowHubAnchor && $hub !== '') ? $hub . '#' . $slug : '';
    }
}

if (!function_exists('siteLogo')) {
    /**
     * Image-first logo lookup in /assets/images/ (knocked-out, version-suffixed marks first). Returns
     * ['src','width','height','class'] at the LARGE-LOGO STANDARD height for its aspect ratio, or null.
     * Goff Electric: logo-mark-v1.png, 436x240 (1.82:1 combination mark) → 104px tall in the bar.
     */
    function siteLogo(): ?array {
        static $logo = false;
        if ($logo !== false) return $logo;
        $dir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/assets/images/';
        $files = [];
        foreach (['logo-mark-v*.png', 'logo-mark-v*.webp', 'logo-mark.png', 'logo.svg', 'logo.png', 'logo.webp'] as $pattern) {
            $hits = glob($dir . $pattern) ?: [];
            natsort($hits);
            $files = array_merge($files, array_reverse(array_values($hits)));
        }
        foreach ($files as $file) {
            $w = $h = 0;
            if (substr($file, -4) === '.svg') {
                $svgSrc = (string) file_get_contents($file);
                if (preg_match('/viewBox="[\d.\-]+[ ,]+[\d.\-]+[ ,]+([\d.]+)[ ,]+([\d.]+)"/', $svgSrc, $m)) { $w = (float) $m[1]; $h = (float) $m[2]; }
            } else {
                $info = @getimagesize($file);
                if ($info) { $w = $info[0]; $h = $info[1]; }
            }
            if ($w <= 0 || $h <= 0) continue;
            $ratio = $w / $h;
            [$rh, $cls] = $ratio > 3 ? [120, 'logo--wordmark'] : ($ratio >= 1.5 ? [104, ''] : [88, 'logo--square']);
            return $logo = ['src' => '/assets/images/' . basename($file), 'width' => (int) round($rh * $ratio), 'height' => $rh, 'class' => $cls];
        }
        return $logo = null;
    }
}

/* ---------------------------------------------------------------------------
 * Formatting
 * ------------------------------------------------------------------------- */

if (!function_exists('formatPhone')) {
    /** "(505) 549-9454" from any 10/11-digit US number. */
    function formatPhone(string $phone): string {
        $digits = preg_replace('/\D+/', '', $phone);
        if (strlen($digits) === 11 && $digits[0] === '1') $digits = substr($digits, 1);
        if (strlen($digits) !== 10) return $phone;
        return sprintf('(%s) %s-%s', substr($digits, 0, 3), substr($digits, 3, 3), substr($digits, 6));
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string {
        $text = strtolower(str_replace(['&', '/'], ' ', $text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}

if (!function_exists('getServiceSlug')) {
    /** "24/7 Emergency Electrical Service" → "24-7-emergency-electrical-service" (matches config.php slugs). */
    function getServiceSlug(string $name): string {
        return slugify($name);
    }
}

if (!function_exists('getAreaSlug')) {
    /** "Rio Rancho" → "rio-rancho". */
    function getAreaSlug(string $city): string {
        return slugify($city);
    }
}

/* ---------------------------------------------------------------------------
 * Icons — inline SVG at render time from references/lucide-icons (no runtime injection, no CDN)
 * ------------------------------------------------------------------------- */

if (!function_exists('icon')) {
    /** Inline Lucide SVG with aria-hidden + width/height. Returns '' for an unknown name. Memoised per request. */
    function icon(string $name, int $size = 20, string $class = ''): string {
        static $cache = [];
        $key = $name . '|' . $size . '|' . $class;
        if (isset($cache[$key])) return $cache[$key];
        if (!preg_match('/^[a-z0-9-]+$/', $name)) return '';
        $file = $_SERVER['DOCUMENT_ROOT'] . '/references/lucide-icons/' . $name . '.svg';
        if (!is_file($file)) return $cache[$key] = '';
        $svgSrc = preg_replace('/<!--.*?-->\s*/s', '', (string) file_get_contents($file));
        $svgSrc = preg_replace('/\s+(width|height)="[^"]*"/', '', $svgSrc, 2);
        $cls = 'lucide lucide-' . $name . ($class !== '' ? ' ' . $class : '');
        $svgSrc = preg_match('/class="[^"]*"/', $svgSrc)
            ? preg_replace('/class="[^"]*"/', 'class="' . $cls . '"', $svgSrc, 1)
            : preg_replace('/<svg\b/', '<svg class="' . $cls . '"', $svgSrc, 1);
        $svgSrc = preg_replace('/<svg\b/', '<svg aria-hidden="true" focusable="false" width="' . $size . '" height="' . $size . '"', $svgSrc, 1);
        return $cache[$key] = trim(preg_replace('/\s+/', ' ', $svgSrc));
    }
}

/* ---------------------------------------------------------------------------
 * Responsive images — <picture> with AVIF first, WebP srcset on the <img>, .jpg src (v6.3).
 * Only variants that exist on disk are emitted (most portrait originals have -480/-960 but no -1600).
 * ------------------------------------------------------------------------- */

if (!function_exists('imageSrcset')) {
    /** "/assets/images/<name>-480.<ext> 480w, …" for the variants on disk; '' when none exist. */
    function imageSrcset(string $name, string $ext = 'webp'): string {
        $dir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/assets/images/';
        $parts = [];
        foreach ([480, 960, 1600] as $fnW) {
            if (is_file($dir . $name . '-' . $fnW . '.' . $ext)) $parts[] = '/assets/images/' . $name . '-' . $fnW . '.' . $ext . ' ' . $fnW . 'w';
        }
        return implode(', ', $parts);
    }
}

if (!function_exists('responsivePicture')) {
    /**
     * <picture> for a photo in /assets/images/ by basename (no extension). width/height come from the original
     * scaled to the largest variant, so the box ratio is always the photo's real ratio (no CLS).
     * $opt: loading ('lazy'|'eager'), fetchpriority ('high' — hero only), class (on <img>).
     * Lazy images also get decoding="async".
     */
    function responsivePicture(string $name, string $alt, string $sizes, array $opt = []): string {
        $dir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/assets/images/';
        $src = is_file($dir . $name . '.jpg') ? '/assets/images/' . $name . '.jpg' : '/assets/images/' . $name . '-960.webp';
        $w = 960; $h = 720;
        $info = is_file($dir . $name . '.jpg') ? @getimagesize($dir . $name . '.jpg') : false;
        if ($info && $info[0] > 0) {
            $maxW = 480;
            foreach ([960, 1600] as $fnW) if (is_file($dir . $name . '-' . $fnW . '.webp')) $maxW = $fnW;
            $maxW = min($maxW, $info[0]);
            $w = $maxW; $h = (int) round($info[1] * $maxW / $info[0]);
        }
        $loading = ($opt['loading'] ?? 'lazy') === 'eager' ? 'eager' : 'lazy';
        $avif = imageSrcset($name, 'avif');
        $webp = imageSrcset($name, 'webp');
        $extra = '';
        if ($webp !== '') $extra .= ' srcset="' . esc($webp) . '" sizes="' . esc($sizes) . '"';
        if (!empty($opt['fetchpriority'])) $extra .= ' fetchpriority="' . esc($opt['fetchpriority']) . '"';
        if (!empty($opt['class'])) $extra .= ' class="' . esc($opt['class']) . '"';
        $img = sprintf('<img src="%s"%s alt="%s" width="%d" height="%d" loading="lazy" decoding="async">', esc($src), $extra, esc($alt), $w, $h);
        if ($loading === 'eager') $img = str_replace(' loading="lazy" decoding="async"', ' loading="eager"', $img);
        $source = $avif !== '' ? '<source type="image/avif" srcset="' . esc($avif) . '" sizes="' . esc($sizes) . '">' : '';
        return '<picture>' . $source . $img . '</picture>';
    }
}

/* ---------------------------------------------------------------------------
 * SEO helpers
 * ------------------------------------------------------------------------- */

if (!function_exists('absoluteUrl')) {
    function absoluteUrl(string $path): string {
        global $siteUrl;
        if (preg_match('#^https?://#i', $path)) return $path;
        return rtrim($siteUrl, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('requestCanonical')) {
    /** Self-referencing canonical from the request path: directories get a trailing slash, index.php/.php dropped. */
    function requestCanonical(): string {
        global $siteUrl;
        $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $path = preg_replace('#/index\.php$#', '/', $path);
        $path = preg_replace('#\.php$#', '', $path);
        if ($path === '') $path = '/';
        if ($path[0] !== '/') $path = '/' . $path;
        if (substr($path, -1) !== '/' && !preg_match('/\.[a-z0-9]{2,4}$/i', $path)) $path .= '/';
        return rtrim($siteUrl, '/') . $path;
    }
}

if (!function_exists('defaultPageTitle')) {
    /** "Electrician in Rio Rancho, NM | 24/7 Service | Goff Electric" — $primaryKeyword + city/state + $siteName. */
    function defaultPageTitle(): string {
        global $siteName, $primaryKeyword, $address, $open24x7;
        $base = trim(preg_replace('/\s+/', ' ', str_ireplace([$address['city'], $address['state']], '', (string) $primaryKeyword)));
        $base = $base !== '' ? ucfirst($base) : 'Electrician';
        return $base . ' in ' . $address['city'] . ', ' . $address['state'] . (!empty($open24x7) ? ' | 24/7 Service' : '') . ' | ' . $siteName;
    }
}

if (!function_exists('defaultMetaDescription')) {
    /**
     * 150-160 chars. USPs only from build-plan content.usps: licensed & insured (client's own site),
     * open 24/7 (GBP listing), residential + commercial. No years claim (content.years is null).
     */
    function defaultMetaDescription(): string {
        global $siteName, $address, $phone;
        return $siteName . ': licensed, insured electrician in ' . $address['city'] . ', ' . $address['state']
            . '. Panel upgrades, EV chargers, wiring, lighting and 24/7 emergency calls. Call ' . $phone . '.';
    }
}

if (!function_exists('ogImageUrl')) {
    /** Absolute OG image URL: page's $ogImage → og-default-v1.jpg (logo card) → boxed logo; '' when none exists. */
    function ogImageUrl(): string {
        global $ogImage;
        $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
        $candidates = [];
        if (!empty($ogImage)) $candidates[] = (string) $ogImage;
        foreach (['og-default-v1.jpg', 'logo-boxed-v1.jpg'] as $f) $candidates[] = '/assets/images/' . $f;
        foreach ($candidates as $cand) {
            if (preg_match('#^https?://#i', $cand)) return $cand;
            if (is_file($root . '/' . ltrim($cand, '/'))) return absoluteUrl($cand);
        }
        return '';
    }
}

if (!function_exists('generateMetaTags')) {
    /**
     * <title>, description, canonical, robots and Open Graph tags. Robots: $robotsMeta (verbatim) > $noindex > index, follow.
     * Never emits a keywords meta or any Twitter/X Card tag (both forbidden, QA blockers).
     */
    function generateMetaTags(string $title, string $description, string $canonical): string {
        global $siteName, $noindex, $robotsMeta, $ogType;
        $out  = '<title>' . esc($title) . "</title>\n";
        $out .= '<meta name="description" content="' . esc($description) . "\">\n";
        $out .= '<link rel="canonical" href="' . esc($canonical) . "\">\n";
        // $robotsMeta (e.g. "noindex, follow" on the blog placeholder) overrides $noindex's "noindex, nofollow"
        $out .= !empty($robotsMeta)
            ? '<meta name="robots" content="' . esc($robotsMeta) . "\">\n"
            : (!empty($noindex)
                ? "<meta name=\"robots\" content=\"noindex, nofollow\">\n"
                : "<meta name=\"robots\" content=\"index, follow, max-image-preview:large\">\n");
        $out .= '<meta property="og:type" content="' . esc(!empty($ogType) ? $ogType : 'website') . "\">\n";
        $out .= '<meta property="og:title" content="' . esc($title) . "\">\n";
        $out .= '<meta property="og:description" content="' . esc($description) . "\">\n";
        $out .= '<meta property="og:url" content="' . esc($canonical) . "\">\n";
        $img = ogImageUrl();
        if ($img !== '') {
            $out .= '<meta property="og:image" content="' . esc($img) . "\">\n";
            $out .= '<meta property="og:image:alt" content="' . esc($siteName) . " logo\">\n";
        }
        $out .= '<meta property="og:site_name" content="' . esc($siteName) . "\">\n";
        $out .= "<meta property=\"og:locale\" content=\"en_US\">\n";
        return $out;
    }
}

/* ---------------------------------------------------------------------------
 * Schema (JSON-LD). Never aggregateRating/ratingValue — the real GBP rating (4.9 from 42 reviews) is
 * visible page content only. Never FAQPage.
 * ------------------------------------------------------------------------- */

if (!function_exists('jsonLd')) {
    function jsonLd($data): string {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
    }
}

if (!function_exists('schemaPostalAddress')) {
    /** PostalAddress — streetAddress only when address_public is true (service-area business: city/state/zip only). */
    function schemaPostalAddress(): array {
        global $address, $addressPublic;
        $postal = ['@type' => 'PostalAddress'];
        if (!empty($addressPublic) && !empty($address['street'])) $postal['streetAddress'] = $address['street'];
        $postal += ['addressLocality' => $address['city'], 'addressRegion' => $address['state'], 'postalCode' => $address['zip'], 'addressCountry' => 'US'];
        return $postal;
    }
}

if (!function_exists('generateLocalBusinessSchema')) {
    /**
     * Electrician node (@id #organization). Every field comes from config.php; empty values are omitted, never guessed.
     * $full = false (inner pages): same entity and NAP without the service catalog, so every page carries LocalBusiness
     * while the homepage stays the one full definition.
     */
    function generateLocalBusinessSchema(bool $full = true): array {
        global $siteName, $siteUrl, $phoneRaw, $email, $geo, $gbpMapsUrl, $yearEstablished, $ownerName,
               $services, $serviceAreas, $socialLinks, $open24x7, $address, $licenseNumber;
        $root = rtrim($siteUrl, '/');
        $node = [
            '@type'       => 'Electrician',
            '@id'         => $root . '/#organization',
            'name'        => $siteName,
            'url'         => $root . '/',
            'telephone'   => $phoneRaw,
            'email'       => $email,
            'description' => $siteName . ' is a licensed and insured New Mexico electrical contractor based in ' . $address['city']
                           . ', handling residential and commercial electrical work across the Albuquerque metro, with 24-hour emergency service.',
            'address'     => schemaPostalAddress(),
        ];
        if (!empty($geo['lat']) && !empty($geo['lng'])) $node['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => $geo['lat'], 'longitude' => $geo['lng']];
        if (!empty($open24x7)) {
            $node['openingHoursSpecification'] = [[
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens'     => '00:00',
                'closes'    => '23:59',
            ]];
        }
        if (!empty($yearEstablished)) $node['foundingDate'] = (string) $yearEstablished;
        if (!empty($ownerName)) $node['founder'] = ['@type' => 'Person', 'name' => $ownerName];
        $img = ogImageUrl();
        if ($img !== '') $node['image'] = $img;
        if (is_file($_SERVER['DOCUMENT_ROOT'] . '/assets/images/logo-boxed-v1.jpg')) $node['logo'] = $root . '/assets/images/logo-boxed-v1.jpg';
        if (!empty($gbpMapsUrl)) $node['hasMap'] = $gbpMapsUrl;
        if (!empty($licenseNumber)) $node['hasCredential'] = ['@type' => 'EducationalOccupationalCredential', 'credentialCategory' => 'license', 'name' => 'New Mexico electrical contractor license ' . $licenseNumber];

        $areaNodes = [];
        foreach ((array) $serviceAreas as $fnArea) {
            $areaNodes[] = ['@type' => 'City', 'name' => $fnArea['name'] . ', ' . $address['state']];
        }
        if ($areaNodes) $node['areaServed'] = $areaNodes;

        if (!$full) return $node;

        $offers = [];
        foreach ((array) $services as $fnSvc) {
            $item = ['@type' => 'Service', 'name' => $fnSvc['name'], 'description' => $fnSvc['description']];
            if (serviceUrl($fnSvc['slug']) !== '') $item['url'] = $root . '/services/' . $fnSvc['slug'] . '/';
            $offers[] = ['@type' => 'Offer', 'itemOffered' => $item];
        }
        if ($offers) $node['hasOfferCatalog'] = ['@type' => 'OfferCatalog', 'name' => $siteName . ' electrical services', 'itemListElement' => $offers];
        if (!empty($socialLinks)) $node['sameAs'] = array_values(array_filter((array) $socialLinks));
        return $node;
    }
}

if (!function_exists('generateWebSiteSchema')) {
    function generateWebSiteSchema(): array {
        global $siteName, $siteUrl;
        $root = rtrim($siteUrl, '/');
        return ['@type' => 'WebSite', '@id' => $root . '/#website', 'url' => $root . '/', 'name' => $siteName, 'publisher' => ['@id' => $root . '/#organization']];
    }
}

if (!function_exists('generateWebPageSchema')) {
    /** WebPage node for the current page: part of #website, about #organization. $url is absolute (the canonical). */
    function generateWebPageSchema(string $url, string $name, string $description = ''): array {
        global $siteUrl;
        $root = rtrim($siteUrl, '/');
        $node = [
            '@type'    => 'WebPage',
            '@id'      => $url . '#webpage',
            'url'      => $url,
            'name'     => $name,
            'isPartOf' => ['@id' => $root . '/#website'],
            'about'    => ['@id' => $root . '/#organization'],
            'inLanguage' => 'en-US',
        ];
        if ($description !== '') $node['description'] = $description;
        return $node;
    }
}

if (!function_exists('generateServiceSchema')) {
    /**
     * Service node for a service page. $service is a config.php $services row (name, slug, description),
     * optionally with 'url'. Provider references the homepage #organization node — never a duplicate LocalBusiness.
     */
    function generateServiceSchema(array $service): array {
        global $siteUrl, $address, $serviceAreas;
        $root = rtrim($siteUrl, '/');
        $url = $service['url'] ?? ($root . '/services/' . ($service['slug'] ?? getServiceSlug($service['name'])) . '/');
        $areas = [];
        foreach ((array) $serviceAreas as $fnArea) $areas[] = ['@type' => 'City', 'name' => $fnArea['name'] . ', ' . $address['state']];
        $node = [
            '@type'       => 'Service',
            '@id'         => $url . '#service',
            'name'        => $service['name'],
            'serviceType' => $service['name'],
            'description' => $service['description'] ?? '',
            'url'         => $url,
            'provider'    => ['@id' => $root . '/#organization'],
        ];
        if ($areas) $node['areaServed'] = $areas;
        return $node;
    }
}

if (!function_exists('generateBreadcrumbSchema')) {
    /** BreadcrumbList from [['name' => 'Home', 'url' => '/'], ...] (last item = current page). */
    function generateBreadcrumbSchema(array $crumbs): array {
        $items = [];
        foreach (array_values($crumbs) as $i => $crumb) {
            $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $crumb['name'], 'item' => absoluteUrl($crumb['url'])];
        }
        return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }
}
