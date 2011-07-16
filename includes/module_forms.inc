<?php
/**
 * @file
 * pubnub settings page
 */

/**
 * Form builder function for admin settings.
 */
	function pubnub_settings() {
		$form['pubnub_publish_key'] = array(
			'#type' => 'textfield',
			'#title' => t('Publish Key'),
			'#default_value' => variable_get('pubnub_publish_value', ''),
			'#required' => TRUE, 
			'#description' => t('Publish Key from PubNub API'),
		);
		$form['pubnub_subscribe_key'] = array(
			'#type' => 'textfield',
			'#title' => t('Subscribe Key'),
			'#default_value' => variable_get('pubnub_subscribe_value', ''),
			'#required' => TRUE, 
			'#description' => t('Subscribe Key from PubNub API'),
		);
		$form['pubnub_secret_key'] = array(
			'#type' => 'textfield',
			'#title' => t('Secret Key'),
			'#default_value' => variable_get('pubnub_secret_value', ''),
			'#description' => t('Secret Key from PubNub API'),
		);
		$form['#submit'][] = 'pubnub_settings_submit';
		return system_settings_form($form);
	}

/**
* Set 'PubNub Publish Key', 'PubNub Subscribe Key', & 'PubNub Scret Key'
* based on the three textfields.
**/
	function pubnub_settings_submit($form, &$form_state) {	
		variable_set('pubnub_publish_value', $form_state['values']['pubnub_publish_key']);
		variable_set('pubnub_subscribe_value', $form_state['values']['pubnub_subscribe_key']);
		
		if (isset($form_state['values']['pubnub_secret_key'])) {
			$tf = $form_state['values']['pubnub_secret_key'];
			variable_set('pubnub_secret_value', $tf);
		}
		else {
			variable_del('pubnub_secret_value');
		}
	}
	