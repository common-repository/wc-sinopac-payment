=== Payment Gateway for SinoPac Bank on WooCommerce ===

Contributors: terrylin
Tags: payment
Requires at least: 4.7
Tested up to: 6.2
Stable tag: 1.1.3
Requires PHP: 7.1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl.html

== Description ==

Payment Gateway for SinoPac Bank on WooCommerce is an unofficial plugin, written by [Terry L](https://terryl.in), which can be found open-sourced at: [terrylinooo/wc-sinopac-payment](https://github.com/terrylinooo/wc-sinopac-payment)

This plugin provides two payment methods: credit card and virtual account. A virtual account is a series of dummy accounts used to facilitate payments on behalf of your physical bank account. Both credit card and virtual account payment methods function through the SinoPac API. As such, you must sign up for a SinoPac developer account to use this plugin. More details can be found on the signup page at [https://developer.sinopac.com/apicate/e-pay](https://developer.sinopac.com/apicate/e-pay).

Before you begin using this plugin, ensure that you have already obtained the Shop number and four Hash keys from SinoPac's technical support.

Note: Since late April 2023, all requests sent to the Sinopac API must include the `X-KeyId` field in the header. If you do not have this X-Key, please request it from Sinopac's technical customer service.

== Features ==

* Credit card payment.
* Virtual account payment (bank transfer).

== Frequently Asked Questions ==

None for now.

== Changelog ==

= 1.0.0 (2021-10-14)

- First release.

= 1.0.1 (2022-07-27)

- Tested with WooCommerce 6.0.1 and made adjustments to fix coding style.

= 1.0.2 (2023-03-31)

- Added feature to check transaction status.

= 1.0.3 (2023-04-19)

- Fixed bug: Resolved a PHP type error that occurred when completing an order using a different payment method.

= 1.0.4 (2023-05-11)

- Tested with PHP 8.2
- Tested with WordPress 6.2 and WooCommerce 7.7
- Fixed "dynamic properties are deprecated" messages for PHP 8.2
- Thanks to [Colocal](https://colocal.com) for helping to fix the English translation.
- Added functionality to throw exceptions when the Sinopac API responds with an invalid JSON string.

= 1.0.5 (2023-05-12)

- Added an exception when the Nonce is empty.

= 1.1.0 (2023-05-18)

- Added X-KeyId authorization to the API request.
- Added X-KeyId field to the payment settings page.
- Added translation for Sinopac PHP SDK.
- Updated Sinopac PHP SDK.

= 1.1.1 (2023-05-19)

- Fixed handling the request for backend URL.
- Added ATM payment information to ThankYou page.

= 1.1.2 (2023-05-22)

- Fixed redirection problem.

= 1.1.3 (2023-05-31)

- Fixed the length limitation of the product name.
