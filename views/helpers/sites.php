<?php

class SitesHelper extends AppHelper {

	var $helpers = array(
		'Html',
		);

	function afterRender() {
		if ($view = ClassRegistry::getObject('view')) {
			echo $this->Html->css('/sites/css/admin_sites');
		}
	}

}
