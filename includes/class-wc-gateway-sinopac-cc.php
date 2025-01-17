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

use Sinopac\Exception\QPayException;

/**
 * SinoPac Credit Card Payment (永豐金流信用卡付款方式)
 */
class WC_SinoPac_Credit_Card_Payment extends WC_SinoPac_Payment {

	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {
		$this->id                 = 'sinopac-cc';
		$this->icon               = '';
		$this->has_fields         = false;
		$this->method_title       = __( 'SinoPac QPay: credit card', 'wc-sinopac-payment' );
		$this->method_description = __( 'Have your customers pay with credit card.', 'wc-sinopac-payment' );

		$this->init();
	}

	/**
	 * Initialize settings.
	 *
	 * @return void
	 */
	function init() {

		$this->init_form_fields();
		$this->init_settings();

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * Initialise Gateway Settings Form Fields.
	 *
	 * @return void
	 */
	function init_form_fields() {
	
		$this->form_fields = include __DIR__ . '/settings-cc-payment.php';

		foreach ( $this->form_fields as $key => $value ) {
			$option = $this->get_option( $key );

			if ( '' !== $option ) {
				$this->{$key} = $this->get_option( $key );
			}
		}
	}

	/**
	 * Process the payment and return the result.
	 *
	 * @param int $order_id Order ID.
	 *
	 * @return array
	 */
	public function process_payment( $order_id ) {
		$qpay  = wcsp_get_qpay_instance( $this );

		$order = wc_get_order( $order_id );

		foreach ( $order->get_items() as $item ) {
			$product_names[] = $item['name'];
		}

		$api_data = [
			'order_no'        => (string) $order->get_id(),
			'amount'          => $order->get_total() * 100,
			'cc_auto_billing' => 'Y',
			'product_name'    => mb_substr( $product_names[0], 0 , 20 ), // Chinese characters are counted as 3 bytes.
			'return_url'      => get_site_url( null, 'sinopac/message_receive' ),
			'backend_url'     => '',
		];

		try {
			$results = $qpay->createOrderByCreditCard( $api_data );
			$message = $this->parse_message( $results );

		} catch ( QPayException $e ) {
			error_log( '[Sinopac] ' . $e->getMessage() );
			$filtered_message = $this->sinopac_sdk_translation( $e->getMessage() );
			throw new QPayException( $filtered_message );
		}

		if ( $message['success'] ) {
			wc_reduce_stock_levels( $order_id );
			WC()->cart->empty_cart();

			return array(
				'result'   => 'success',
				'redirect' => $message['redirect'],
			);
		}

		return array(
			'result'   => 'failed',
			'redirect' => wc_get_checkout_url(),
		);
	}

	/**
	 * Parse the SinoPac API response.
	 *
	 * @param array $results
	 *
	 * @return array
	 */
	private function parse_message( $results )
	{
		$success = false;
		$url = '';

		if ( ! empty( $results['Message'] ) ) {
			$success = ( 'S' === $results['Message']['Status'] );

			if ( $success ) {
				if ( 'C' === $results['Message']['PayType'] ) {
					$url = $results['Message']['CardParam']['CardPayURL'];
				}
			} else {
				throw new QPayException( $results['Message']['Description'] );
			}
		}

		return array(
			'success'  => $success,
			'redirect' => $url,
		);
	}
}
