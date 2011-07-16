<?php
	
	function pn_blogform()
	{
		$form = array('#attributes' => array('enctype' => 'multipart/form-data'));
		$form['pubnub_blog'] = array(
			'#type' => 'textarea',
		);
		$form['picorvid'] = array(
			'#type' => 'file',
			'#title' => t(''),
			'#description' => t('Allowed Formats: jpeg, gif, png, flv'),
		);
		$form['pnc_fileBtn'] = array(
			'#type' => 'button',
			'#button_type' => 'false',
			'#title' => t(''),
			'#attributes' => array('class' => array('duplicate_camera'))
		);

		$form['post'] = array(
			'#type' => 'submit',
			'#value' => t('Post'),
			'#prefix' => '<div class="cboth">',
			'#suffix' => '</div>',
			/*'#ajax' => array(
				'callback' => 'pubnub_postblog_js',
				'wrapper' => 'pubnub_blogs',
				'method' => 'prepend',
				'effect' => 'slide',
			),*/
  		);
		
		return $form;
	}
