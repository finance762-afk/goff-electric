<?php
/**
 * includes/config.php — site-wide configuration for Goff Electric.
 * All pages: require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php'; before head.php.
 * Generated Phase 1 (scaffold) from build-plan.json (research brief generated 2026-10-21).
 * Pages set their own $canonicalUrl, $pageType, $serviceSlug / $citySlug — never here.
 */

/* ---------------------------------------------------------------------------
 * Identity
 * ------------------------------------------------------------------------- */
$slug            = 'goff-electric';                         // exact build directory name
$siteName        = 'Goff Electric';                         // build-plan company_name
$tagline         = 'Trusted electricians serving Rio Rancho & Albuquerque, NM — open 24 hours';
$ownerName       = 'Garrett Goff';
$phone           = '(505) 549-9454';
$phoneRaw        = '+15055499454';                          // tel: friendly (E.164)
$phoneSecondary  = '';
$email           = 'goffelectric32@gmail.com';
$tier            = 'premium';

$address = [
    'street' => '',                                         // not supplied — service-area business
    'city'   => 'Rio Rancho',
    'state'  => 'NM',
    'zip'    => '87124',
];
$addressPublic = false;   // build-plan address_public = false → never print a street address

/* ---------------------------------------------------------------------------
 * Domain / URL
 *   build-plan.json has no production_domain field → default to the preview
 *   domain. $domain must NEVER be blank; $siteUrl must always be absolute.
 *   The plan's "domain" (electricgoff.com) is recorded below for go-live only.
 * ------------------------------------------------------------------------- */
$domain           = $slug . '.pageone.cloud';               // goff-electric.pageone.cloud
$siteUrl          = 'https://' . $domain;                   // absolute site root, no trailing slash
$productionDomain = 'electricgoff.com';                     // build-plan "domain" — swap into $domain at launch
$industry         = 'Electrician';

/* ---------------------------------------------------------------------------
 * Keywords (build-plan seo)
 * ------------------------------------------------------------------------- */
$primaryKeyword = 'electrician Rio Rancho NM';
$secondaryKeywords = [
    'electrician Albuquerque NM',
    'EV charger installation Albuquerque',
    'electrical panel upgrade Rio Rancho',
    'emergency electrician Albuquerque',
    'commercial electrician Albuquerque',
];

/* ---------------------------------------------------------------------------
 * Services — build-plan "services" (10, all solo pages, under the premium cap
 *   of 16). Each: name, slug (dir under /services/), description, keywords.
 *   Descriptions are factual placeholders — the copywriter owns final copy.
 * ------------------------------------------------------------------------- */
$services = [
    [
        'name'        => 'Residential Electrical',
        'slug'        => 'residential-electrical',
        'description' => 'Electrical repairs, upgrades and new installations for homes in Rio Rancho and the Albuquerque metro.',
        'keywords'    => ['residential electrical Rio Rancho NM', 'residential electrician Rio Rancho', 'home electrician Albuquerque', 'electrician Rio Rancho NM'],
    ],
    [
        'name'        => 'Commercial Electrical',
        'slug'        => 'commercial-electrical',
        'description' => 'Electrical installation, repair and upgrades for offices, storefronts and other commercial buildings.',
        'keywords'    => ['commercial electrical Rio Rancho NM', 'commercial electrician Albuquerque', 'commercial electrical contractor NM'],
    ],
    [
        'name'        => 'EV Charger Installation',
        'slug'        => 'ev-charger-installation',
        'description' => 'Level 2 EV charger installation with a load calculation to confirm panel capacity and a dedicated circuit for the charger.',
        'keywords'    => ['ev charger installation Rio Rancho NM', 'EV charger installation Albuquerque', 'Level 2 charger install NM'],
    ],
    [
        'name'        => 'Electrical Panel Upgrades & Repair',
        'slug'        => 'electrical-panel-upgrades-repair',
        'description' => 'Panel replacement, service upgrades and breaker repair for homes and buildings that need more capacity or a safer panel.',
        'keywords'    => ['electrical panel upgrades & repair Rio Rancho NM', 'electrical panel upgrade Rio Rancho', 'breaker panel replacement Albuquerque'],
    ],
    [
        'name'        => 'Lighting Installation',
        'slug'        => 'lighting-installation',
        'description' => 'Indoor and outdoor lighting installation, including fixtures, recessed lighting and exterior lights.',
        'keywords'    => ['lighting installation Rio Rancho NM', 'recessed lighting installation Albuquerque', 'outdoor lighting electrician'],
    ],
    [
        'name'        => 'Ceiling Fan Installation',
        'slug'        => 'ceiling-fan-installation',
        'description' => 'Ceiling fan installation and replacement, including fan-rated boxes and wall controls.',
        'keywords'    => ['ceiling fan installation Rio Rancho NM', 'ceiling fan installer Albuquerque'],
    ],
    [
        'name'        => 'Outlets & Switches',
        'slug'        => 'outlets-switches',
        'description' => 'Repair and replacement of dead or warm outlets, faulty switches and GFCI outlets, plus new outlet installation.',
        'keywords'    => ['outlets & switches Rio Rancho NM', 'outlet repair Rio Rancho', 'GFCI outlet installation Albuquerque'],
    ],
    [
        'name'        => 'Electrical Wiring Installation & Repair',
        'slug'        => 'electrical-wiring-installation-repair',
        'description' => 'New wiring, rewiring and faulty wiring repair for homes, renovations and additions.',
        'keywords'    => ['electrical wiring installation & repair Rio Rancho NM', 'rewiring Albuquerque', 'faulty wiring repair Rio Rancho'],
    ],
    [
        'name'        => 'Electrical Inspections',
        'slug'        => 'electrical-inspections',
        'description' => 'Electrical safety inspections for homeowners, buyers and businesses, with a clear report of what needs attention.',
        'keywords'    => ['electrical inspections Rio Rancho NM', 'home electrical inspection Albuquerque', 'electrical safety inspection NM'],
    ],
    [
        'name'        => '24/7 Emergency Electrical Service',
        'slug'        => '24-7-emergency-electrical-service',
        'description' => 'Around-the-clock response for power loss, tripping breakers, burning smells and other urgent electrical problems.',
        'keywords'    => ['24/7 emergency electrical service Rio Rancho NM', 'emergency electrician Albuquerque', 'emergency electrician Rio Rancho'],
    ],
];

/* ---------------------------------------------------------------------------
 * Service areas — build-plan service_areas (6). Home base first.
 *   ZIP only for the home base (from intake); add others once verified.
 * ------------------------------------------------------------------------- */
$serviceAreas = [
    ['name' => 'Rio Rancho',  'slug' => 'rio-rancho',  'zip' => '87124', 'county' => 'Sandoval',   'primary' => true],
    ['name' => 'Albuquerque', 'slug' => 'albuquerque', 'zip' => '',      'county' => 'Bernalillo', 'primary' => false],
    ['name' => 'Corrales',    'slug' => 'corrales',    'zip' => '',      'county' => 'Sandoval',   'primary' => false],
    ['name' => 'Bernalillo',  'slug' => 'bernalillo',  'zip' => '',      'county' => 'Sandoval',   'primary' => false],
    ['name' => 'Placitas',    'slug' => 'placitas',    'zip' => '',      'county' => 'Sandoval',   'primary' => false],
    ['name' => 'Tijeras',     'slug' => 'tijeras',     'zip' => '',      'county' => 'Bernalillo', 'primary' => false],
];
$targetRadiusMiles = 30;   // build-plan seo.target_radius

/* ---------------------------------------------------------------------------
 * Social links (only platforms the client uses; none supplied at intake)
 * ------------------------------------------------------------------------- */
$socialLinks = [];

/* ---------------------------------------------------------------------------
 * Analytics (placeholder — replace with client GA4 ID post-launch)
 * ------------------------------------------------------------------------- */
$googleAnalyticsId = 'G-XXXXXXXXXX';

/* ---------------------------------------------------------------------------
 * Brand colors — Phase 2 logo analysis (2026-10-21), mirrored in framework.css
 *   :root and build-plan design.colors.
 * ------------------------------------------------------------------------- */
$colors = [
    'primary'   => '#1e1a18',   // logo black (lifted)
    'secondary' => '#5f5e5e',   // logo steel grey
    'accent'    => '#f2a71b',   // Edison-filament amber (logo is monochrome)
];
$archetype = 'bold-industrial';   // Phase 2 logo analysis (build-plan design.archetype)

/* ---------------------------------------------------------------------------
 * Company age — build-plan content.years is null. Do not invent a founding
 *   year; omit "Est." / years-in-business claims until the client supplies it.
 * ------------------------------------------------------------------------- */
$yearEstablished = null;
$yearsInBusiness = null;

/* ---------------------------------------------------------------------------
 * Hours — build-plan business_hours (and GBP: open 24 hours)
 * ------------------------------------------------------------------------- */
$businessHours = 'Open 24 hours, 7 days a week';
$open24x7      = true;

/* ---------------------------------------------------------------------------
 * Proof facts from intake (content.usps). Visible page content only —
 *   NEVER emit as aggregateRating/ratingValue in JSON-LD.
 * ------------------------------------------------------------------------- */
$gbpRating      = 4.9;
$gbpReviewCount = 42;
$licenseNumber  = '';   // NM CID license number not supplied — never invent one

/* ---------------------------------------------------------------------------
 * CSS cache-bust — SINGLE source of truth. Pages MUST NOT set their own.
 * Bump this on every framework.css change.
 * ------------------------------------------------------------------------- */
$cssVersion = '2';

/* ---------------------------------------------------------------------------
 * Forms — Page One leads endpoint (build-plan form_action, verbatim)
 * ------------------------------------------------------------------------- */
$formAction            = 'https://db.pageone.cloud/functions/v1/leads/goff-electric';
$leadsFormSecret       = 'bac7714a8f41505ab12d75311ccbb11a6374e38b1a010d69111c84a652cfa0f3'; // spam-shield HMAC (matches leads fn LEADS_FORM_SECRET)
$leadNotificationEmail = 'goffelectric32@gmail.com';
$leadNotificationPhone = '(505) 549-9454';

/* ---------------------------------------------------------------------------
 * Google Business Profile (build-plan integrations). No map embed or geo
 *   coordinates were supplied — leave them empty, never guess.
 * ------------------------------------------------------------------------- */
$gbpPlaceId       = 'ChIJUaTQ3sDB0KwRCjCl6we6pWc';
$gbpMapsUrl       = 'https://www.google.com/maps/place/?q=place_id:ChIJUaTQ3sDB0KwRCjCl6we6pWc';
$directionsUrl    = 'https://www.google.com/maps/dir/?api=1&destination=place_id:ChIJUaTQ3sDB0KwRCjCl6we6pWc';
$reviewRequestUrl = 'https://search.google.com/local/writereview?placeid=ChIJUaTQ3sDB0KwRCjCl6we6pWc';
$gbpMapEmbed      = '';
$geo              = null;
$acceptsSms       = false;   // integrations.accepts_sms = null (not confirmed)

/* ---------------------------------------------------------------------------
 * v8 component variables (2026-10-09) — copied from build-plan "integrations".
 *   Empty = component renders nothing. Never fill these without the plan.
 * ------------------------------------------------------------------------- */
$estimateTool   = [];   // integrations.estimate_tool.authorized = false
$bookingWindows = [];   // integrations.booking.authorized = false
$textUsNumber   = '';   // integrations.text_us_number = null
$financing      = [];   // integrations.financing = null
$serviceZips    = [];   // integrations.service_zips not present

/* ---------------------------------------------------------------------------
 * Lead attribution (v6.3) — MUST be last. Sets first-touch cookie and
 * provides p1_attribution_fields(). Never edit includes/attribution.php.
 * ------------------------------------------------------------------------- */
require_once __DIR__ . '/attribution.php';
