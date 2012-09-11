<?php

class SitesHelper extends AppHelper {

	public $helpers = array(
		'Html',
		);

	public function beforeRender() {
		if (isset($this->params['admin'])) {
			echo $this->Html->css('/sites/css/admin_sites', null, array('inline' => false));
		}
	}

}
