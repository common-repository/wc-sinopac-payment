<?php
/**
 * This file is part of the WooCommerce SinoPac Payment package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

defined( 'WCSP_INC' ) || exit;

/**
 * SinoPac Payment (永豐金豐支付)
 */
abstract class WC_SinoPac_Payment extends WC_Payment_Gateway {
	/**
	 * Since PHP 8.2, dynamically assigning values to class properties is no longer allowed
	 * Declaring the properties for our customized settings.
	 */

	/**
	 * Test mode
	 *
	 * @var string
	 */
	public $testmode = 'no';

	/**
	 * API details
	 *
	 * @var string
	 */
	public $api_details = '';

	/**
	 * API shop no
	 *
	 * @var string
	 */
	public $api_shop_no = '';

	/**
	 * API key id
	 *
	 * @var string
	 */
	public $api_key_id = '';

	/**
	 * API hash a1
	 *
	 * @var string
	 */
	public $api_hash_a1 = '';

	/**
	 * API hash a2
	 *
	 * @var string
	 */
	public $api_hash_a2 = '';

	/**
	 * API hash b1
	 *
	 * @var string
	 */
	public $api_hash_b1 = '';

	/**
	 * API hash b2
	 *
	 * @var string
	 */
	public $api_hash_b2 = '';

	/**
	 * Test details
	 *
	 * @var string
	 */
	public $test_details = '';

	/**
	 * Test shop no
	 *
	 * @var string
	 */
	public $test_shop_no = '';

	/**
	 * Test key id
	 *
	 * @var string
	 */
	public $test_key_id = '';

	/**
	 * Test hash a1
	 *
	 * @var string
	 */
	public $test_hash_a1 = '';

	/**
	 * Test hash a2
	 *
	 * @var string
	 */
	public $test_hash_a2 = '';

	/**
	 * Test hash b1
	 *
	 * @var string
	 */
	public $test_hash_b1 = '';

	/**
	 * Test hash b2
	 *
	 * @var string
	 */
	public $test_hash_b2 = '';

	/**
	 * Constructor for the gateway.
	 *
	 * @param string $exception_message Exception message.
	 * @return string
	 */
	public function sinopac_sdk_translation( $exception_message = '' ): string {
		$matches = array();

		if ( ! preg_match( '/\((\d{4})\)/', $exception_message, $matches ) ) {
			return $exception_message;
		}

		if ( empty( $matches[1] ) ) {
			return $exception_message;
		}

		$error_code     = $matches[1];
		$error_messages = array(
			'1001' => __( 'The service type is not currently supported.', 'wc-sinopac-payment' ),
			'1002' => __( 'The shop_no field is missing.', 'wc-sinopac-payment' ),
			'1003' => __( 'The hash keys corresponding to the pair A and B are required.', 'wc-sinopac-payment' ),
			'1004' => __( 'The hash key is missing.', 'wc-sinopac-payment' ),
			'1005' => __( 'The QPay API requires data in order to process your request.', 'wc-sinopac-payment' ),
			'1006' => __( 'The field type is invalid.', 'wc-sinopac-payment' ),
			'1007' => __( 'The size of the field has reached its limit.', 'wc-sinopac-payment' ),
			'1008' => __( 'Error field value was found.', 'wc-sinopac-payment' ),
			'1009' => __( 'Error field value was found.', 'wc-sinopac-payment' ),
			'1010' => __( 'The field should adhere to the date format.', 'wc-sinopac-payment' ),
			'1011' => __( 'ATM payments cannot exceed $30,000 NTD.', 'wc-sinopac-payment' ),
			'1012' => __( 'The field contains invalid characters', 'wc-sinopac-payment' ),
			'2001' => __( 'There was an error with the cURL connection.', 'wc-sinopac-payment' ),
			'3001' => __( 'The Sinopac API returned an unexpected HTTP status code.', 'wc-sinopac-payment' ),
			'3002' => __( 'Unexpected results were received from the Sinopac API.', 'wc-sinopac-payment' ),
		);

		$message  = $error_messages[ $error_code ] ?? $exception_message;
		$message .= "\n\n";
		$message .= __( 'Please check out the error log to get details.', 'wc-sinopac-payment' );

		return $message;
	}
}
