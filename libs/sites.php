<?php

class Sites {

	private static $_site = array();

	public function &getInstance() {
		static $instance = null;
		if (! $instance) {
			$instance = new Sites;
		}
		return $instance;
	}

	public function currentSite($siteId = null) {
		$_this = Sites::getInstance();
		if (! self::$_site) {
			self::$_site = $_this->_getSite($siteId);
		}
		return self::$_site;
	}

	function _getSite($siteId) {

		$options = array(
			'recursive' => false,
			'fields' => array('id', 'theme'),
			'joins' => array(
				array(
					'table' => 'site_domains',
					'alias' => 'SiteDomain',
					'conditions' => array(
						'SiteDomain.site_id = Site.id',
						'SiteDomain.domain LIKE' => '%' . env('HTTP_HOST')
						),
					),
				),
			);

		return ClassRegistry::init('Sites.Site')->find('first', $options);
	}

}
?>
