<?php
/**
 * Helper for processing [faq_question_form] shortcode.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   1.2.0
 */

class ATDTP_Shortcodes_FAQ_Question_Form
{
	/**
	 * Nonce field name.
	 * If empty - nonce check will be ignored.
	 *
	 * @var string
	 */
	public static $formNonceFieldName = 'ncs';

	/**
	 * Nonce name.
	 * If empty - nonce check will be ignored.
	 *
	 * @var string
	 */
	public static $formNonceKey = 'ticket-form';

	/**
	 * State hash field name value.
	 * If empty state hash will not be used, default attribute values will be used durind question saving.
	 *
	 * @var string
	 */
	public static $formHashFieldName = 'fx';

	/**
	 * Name for the ajax action used by shortcode.
	 *
	 * @var string
	 */
	public static $ajaxActionName = 'faq_submit_question';

	/**
	 * Shortcode view.
	 *
	 * @var string
	 */
	public static $formView = 'templates/shortcodes/faq_question_form';

	/**
	 * Email view.
	 *
	 * @var string
	 */
	public static $emailView = 'templates/shortcodes/faq_question_form_email';

	/**
	 * Name for the transient used for the attributes state saving.
	 * Used to pass attributes to the ajax action.
	 *
	 * @see saveToPersistentStorage
	 * @var string
	 */
	protected static $transientKey = 'adventure_tours_faq_question_form';

	/**
	 * Set of the error/notice messages used by form.
	 *
	 * @see getMessageText
	 * @var array
	 */
	public static $messages = array();

	/**
	 * Registers question submission form shortcode.
	 * Registers shortcode and adds ajax action for form processing.
	 *
	 * @return boolean
	 */
	public static function register( $shortcode_name = 'faq_question_form' ) {
		if ( $shortcode_name ) {
			$class = get_class();

			add_shortcode( $shortcode_name, array( $class, 'do_shortcode' ) );
			add_action( 'wp_ajax_' . self::$ajaxActionName, array( $class, 'ajax_action_post_question' ) );
			add_action( 'wp_ajax_nopriv_' . self::$ajaxActionName, array( $class, 'ajax_action_post_question' ) );

			return true;
		}

		return false;
	}

	/**
	 * Returns set of default values for shortode attributes.
	 *
	 * @return assoc
	 */
	protected static function getAttributeDefaults() {
		static $cache;

		if ( null === $cache ) {
			$cache = array(
				'email' => '',
				'email_subject' => '',
				'email_view' => '',
				'css_class' => '',
				'view' => '',
			);
		}

		return $cache;
	}

	/**
	 * Shortcode processing fucntion.
	 *
	 * @param  assoc  $atts     attributes
	 * @param  string $content
	 * @return string
	 */
	public static function do_shortcode($atts, $content = null) {
		$atts = shortcode_atts( self::getAttributeDefaults(), $atts );
		$nonceKey = self::getNonceKey();

		$viewData = array(
			'form_action' => admin_url( 'admin-ajax.php' ) . '?action=' . self::$ajaxActionName,
			'form_data' => self::getVisitorDetails(),
			'nonce_field' => array(
				'name' => self::getNonceFieldName(),
				'value' => $nonceKey ? wp_create_nonce( $nonceKey ) : '',
			),
			'state_hash_field' => array(
				'name' => self::$formHashFieldName,
				'value' => self::saveAttributesState( $atts ),
			),
		);

		return ATDTP()->shortcodes_helper()->render_view( self::$formView, $atts['view'], array_merge( $atts, $viewData ) );
	}

	/**
	 * Sends emil notification that new question has been submitted.
	 *
	 * @param  assoc $data                 form fields.
	 * @param  assoc $shortcode_attributes shortcode attributes.
	 * @return boolean
	 */
	public static function save_question(array $data, array $shortcode_attributes) {
		$receiverEmail = $shortcode_attributes['email'];
		if ( ! $receiverEmail || ! filter_var( $receiverEmail, FILTER_VALIDATE_EMAIL ) ) {
			$receiverEmail = get_option( 'admin_email' );
		}

		$isHtml = true;

		$subject = ! empty( $shortcode_attributes['email_subject'] ) ? $shortcode_attributes['email_subject'] : self::getMessageText( 'default_notification_subject' );

		$message = ATDTP()->shortcodes_helper()->render_view( self::$emailView, '', $data );

		$contentTypeFilter = $isHtml ? array( get_class(), 'mail_filter_set_html_content_type' ) : null;

		if ( $contentTypeFilter ) {
			add_filter( 'wp_mail_content_type', $contentTypeFilter );
		}

		$result = wp_mail( $receiverEmail, $subject, $message );
		if ( $contentTypeFilter ) {
			remove_filter( 'wp_mail_content_type', $contentTypeFilter );
		}

		return $result;
	}

	/**
	 * Returns mime type for email message.
	 *
	 * @return [type] [description]
	 */
	public static function mail_filter_set_html_content_type() {
		return 'text/html';
	}

	/**
	 * Messages translation function. Allows define own text messages via $messages option.
	 *
	 * @param  string $messageCode 
	 * @return string
	 */
	public static function getMessageText( $messageCode ) {
		if ( isset( self::$messages[$messageCode] ) ) {
			return self::$messages[$messageCode];
		}

		static $defaultMessages;
		if ( ! $defaultMessages ) {
			$defaultMessages = array(
				'nonce_is_invalid' => esc_html__( 'Please reload the page and resubmit the form again.', 'adventure-tours-data-types' ),
				'question_has_been_sent' => esc_html__( 'Your question has been submitted successfully.', 'adventure-tours-data-types' ),
				'question_submit_is_fail' => esc_html__( 'Your question has not been submitted. Please contact support.', 'adventure-tours-data-types' ),
				'unknown_validation_error' => esc_html__( 'Please fill in all required fields.', 'adventure-tours-data-types' ),
				'complete_required_field' => esc_html__( 'Fill in the required field.', 'adventure-tours-data-types' ),
				'check_email_address_field' => esc_html__( 'Email invalid.', 'adventure-tours-data-types' ),
				'default_notification_subject' => esc_html__( 'FAQs: new question', 'adventure-tours-data-types' ),
			);
		}

		return isset( $defaultMessages[$messageCode] ) ? $defaultMessages[$messageCode] : $messageCode;
	}

	/**
	 * Action. Form submission processing method.
	 * Validates data submitted by form and call 'save_question' to save submission details.
	 * @return void
	 */
	public static function ajax_action_post_question() {
		$formData = isset( $_POST['question'] ) ? $_POST['question'] : array();

		$response = array(
			'success' => false,
			// 'field_errors' => array(),
			// 'error' => '',
			// 'message' => ''
		);

		$nonceIsValid = true;
		$nonceKey = self::getNonceKey();
		if ( $nonceKey ) {
			$nonceFieldName = self::getNonceFieldName();
			$nonceValue = isset( $_POST[$nonceFieldName] ) ? $_POST[$nonceFieldName] : '';
			if ( ! wp_verify_nonce( $nonceValue, $nonceKey ) ) {
				$nonceIsValid = false;
				$response['error'] = self::getMessageText( 'nonce_is_invalid' );
			}
		}

		$stateHash = self::$formHashFieldName && isset( $_POST[self::$formHashFieldName] ) ? $_POST[self::$formHashFieldName] : '';
		$atts = self::getAttributesState( $stateHash );

		if ( $nonceIsValid ) {
			$validationResult = self::validateForm( $formData, $atts );

			if ( true === $validationResult ) {
				if ( self::save_question( $formData, $atts ) ) {
					$response['success'] = true;
					$response['message'] = self::getMessageText( 'question_has_been_sent' );
				} else {
					$response['error'] = self::getMessageText( 'question_submit_is_fail' );
				}
			} else {
				if ( is_array( $validationResult ) ) {
					$response['field_errors'] = $validationResult;
				} else {
					$response['error'] = self::getMessageText( 'unknown_validation_error' );
				}
			}
		}
		if ( ! $response['success'] ) {
			header( 'HTTP/1.1 400 Bad Request', true, 400 );
		}
		wp_send_json( $response );
	}

	/**
	 * Validates form data.
	 * @param  assoc $data       form data
	 * @param  assoc $attributes shortcode attributes
	 * @return true|assoc             if all data is valid returns true, otherwise assoc with errors
	 */
	public static function validateForm( array $data, array $attributes = array() ) {
		// checking that all fields are completed
		$fieldsList = array(
			'name',
			'email',
			'question',
		);

		$errors = array();
		foreach ( $fieldsList as $fieldKey ) {
			$value = isset( $data[$fieldKey] ) ? $data[$fieldKey] : '';
			if ( empty( $value ) ) {
				$errors[$fieldKey] = self::getMessageText( 'complete_required_field' );
				continue;
			}
			if ( 'email' == $fieldKey ) {
				if ( ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
					$errors[$fieldKey] = self::getMessageText( 'check_email_address_field' );
				}
			}
		}

		return empty( $errors ) ? true : $errors;
	}

	public static function getVisitorDetails() {
		$result = array(
			'name' => '',
			'email' => '',
		);

		if ( is_user_logged_in() ) {
			$user = wp_get_current_user();
			$result['name'] = $user->display_name;
			$result['email'] = $user->user_email;
		} else {
			// getting details from the comment author details
			$authorNameKey = 'comment_author_' . COOKIEHASH;
			$authorEmailKey = 'comment_author_email_' . COOKIEHASH;

			if ( isset( $_COOKIE[$authorNameKey] ) ) {
				$result['name'] = $_COOKIE[$authorNameKey];
			}
			if ( isset( $_COOKIE[$authorEmailKey] ) ) {
				$result['email'] = $_COOKIE[$authorEmailKey];
			}
		}

		return $result;
	}

	protected static function saveAttributesState( array $attributes ) {
		$shortcodeHash = '';

		$save = array();
		$defaults = self::getAttributeDefaults();
		foreach ( $attributes as $key => $value ) {
			$defValue = isset( $defaults[$key] ) ? $defaults[$key] : '';
			if ( $defValue != $value ) {
				$save[$key] = $value;
			}
		}

		if ( $save ) {
			$shortcodeHash = md5( serialize( $save ) );
			self::saveToPersistentStorage( $shortcodeHash, $save );
		}

		return $shortcodeHash;
	}

	protected static function getAttributesState( $shortcodeHash ) {
		$loaded = null;
		if ( $shortcodeHash && 32 == strlen( $shortcodeHash ) ) {
			$loaded = self::getFromPersistentStorage( $shortcodeHash );
		}

		$defaults = self::getAttributeDefaults();

		if ( ! $loaded || ! is_array( $loaded ) ) {
			return $defaults;
		}

		return array_merge( $defaults, $loaded );
	}

	protected static function saveToPersistentStorage( $key, $value ) {
		if ( ! self::$transientKey ) {
			return false;
		}
		$storageState = get_transient( self::$transientKey );
		$nowTimestamp = time();
		if ( ! $storageState ) {
			$storageState = array();
		}
		if ( null === $value ) {
			if ( ! isset( $storageState[$key] ) ) {
				return true;
			} else {
				unset( $storageState[$key] );
			}
		} elseif ( isset( $storageState[$key] ) && $value == $storageState[$key] ) {
			if ( isset( $storageState['___nrt'] ) && $storageState['___nrt'] > $nowTimestamp ) {
				return true; // value is a same as current one and will not expire at least for 2 hours
			}
		} else {
			$storageState[$key] = $value;
		}

		$transientTimeout = 5 * 3600; // expire in 5 hours
		$storageState['___nrt'] = $nowTimestamp + $transientTimeout - 7200;
		set_transient( self::$transientKey, $storageState, $transientTimeout );
		return true;
	}

	protected static function getFromPersistentStorage( $key, $defaultValue = null ) {
		if ( self::$transientKey ) {
			$storageState = get_transient( self::$transientKey );
			if ( $storageState && isset( $storageState[$key] ) ) {
				return $storageState[$key];
			}
		}
		return $defaultValue;
	}

	protected static function getNonceKey() {
		$fieldName = self::getNonceFieldName();
		return $fieldName && self::$formNonceKey ? self::$formNonceKey : null;
	}

	protected static function getNonceFieldName() {
		return self::$formNonceFieldName;
	}
}
