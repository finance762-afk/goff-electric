<?php
/**
 * includes/payment-methods.php — "We accept" strip (2026-10-20).
 *
 * Shown ONLY after the client confirms which payment types they take (the draft
 * email asks). Wire it up by setting in config.php, e.g.
 *   $paymentMethods = ['visa', 'mastercard', 'amex', 'discover', 'cash', 'check', 'zelle'];
 * then `include $_SERVER['DOCUMENT_ROOT'] . '/includes/payment-methods.php';` in
 * footer.php (above the legal row) and/or the contact page.
 *
 * Card marks are Font Awesome Free brand icons (CC BY 4.0 — attribution kept in
 * the rendered credit below; the marks themselves remain trademarks of Visa,
 * Mastercard, American Express, Discover, PayPal and Apple, used here only to
 * state that the business accepts them). Copy the SVGs from
 * references/components/payments/ into /assets/svg/payments/ on the site.
 * Never show a card the client did not confirm.
 */
$paymentMethods = $paymentMethods ?? [];
if (!$paymentMethods) return;
$pmLabels = [
    'visa' => 'Visa', 'mastercard' => 'Mastercard', 'amex' => 'American Express', 'discover' => 'Discover',
    'paypal' => 'PayPal', 'apple_pay' => 'Apple Pay',
    'cash' => 'Cash', 'check' => 'Check', 'zelle' => 'Zelle', 'venmo' => 'Venmo', 'financing' => 'Financing available',
];
$pmSvg = ['visa' => 'cc-visa', 'mastercard' => 'cc-mastercard', 'amex' => 'cc-amex', 'discover' => 'cc-discover', 'paypal' => 'cc-paypal', 'apple_pay' => 'cc-apple-pay'];
$pmRoot = rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
?>
<div class="payment-methods" aria-label="Payment methods accepted">
  <span class="payment-methods__label">We accept</span>
  <ul class="payment-methods__list">
<?php foreach ($paymentMethods as $pm): $pm = strtolower(trim((string) $pm)); if (!isset($pmLabels[$pm])) continue; ?>
    <li class="payment-methods__item" title="<?php echo htmlspecialchars($pmLabels[$pm], ENT_QUOTES); ?>">
<?php if (isset($pmSvg[$pm]) && is_file($pmRoot . '/assets/svg/payments/' . $pmSvg[$pm] . '.svg')): ?>
      <?php echo preg_replace('/<svg\b/', '<svg class="payment-methods__mark" role="img" aria-label="' . htmlspecialchars($pmLabels[$pm], ENT_QUOTES) . '" width="40" height="26"', file_get_contents($pmRoot . '/assets/svg/payments/' . $pmSvg[$pm] . '.svg'), 1); ?>
<?php else: ?>
      <span class="payment-methods__text"><?php echo htmlspecialchars($pmLabels[$pm], ENT_QUOTES); ?></span>
<?php endif; ?>
    </li>
<?php endforeach; ?>
  </ul>
  <?php /* CC BY 4.0 attribution for the Font Awesome brand marks */ ?>
  <span class="payment-methods__credit">Card marks: Font Awesome (CC BY 4.0)</span>
</div>
<?php /*
framework.css (add once):
.payment-methods { display: flex; flex-wrap: wrap; align-items: center; gap: .6rem 1rem; padding: .75rem 0; }
.payment-methods__label { font-family: var(--font-accent); font-size: .78rem; letter-spacing: .12em; text-transform: uppercase; color: var(--color-muted); }
.payment-methods__list { display: flex; flex-wrap: wrap; gap: .5rem .75rem; list-style: none; margin: 0; padding: 0; align-items: center; }
.payment-methods__mark { display: block; height: 26px; width: auto; fill: currentColor; color: var(--color-ink-2); }
.site-footer .payment-methods__mark { color: rgba(255,255,255,.85); }
.payment-methods__text { font-size: .85rem; color: var(--color-ink-2); }
.site-footer .payment-methods__text { color: rgba(255,255,255,.8); }
.payment-methods__credit { font-size: .62rem; color: var(--color-muted); opacity: .7; margin-left: auto; }
*/ ?>
