<?php

class SitesHelper extends AppHelper {

	var $helpers = array(
		'Html',
		);

	function beforeRender() {
		if (isset($this->params['admin'])) {
			echo $this->Html->css('/sites/css/admin_sites', null, array('inline' => false));
		}
	}

}
