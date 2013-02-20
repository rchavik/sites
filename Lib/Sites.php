<?php

App::uses('CakeSession', 'Model/Datasource');

class Sites {

	const ALL_SITES = 1;

	protected static $_site = array();

	protected static $_sessionKey = 'Sites.current';

	public static function &getInstance() {
		static $instance = null;
		if (! $instance) {
			$instance = new Sites;
		}
		return $instance;
	}

	protected function _overrideSetting($key) {
		if (is_string($key)) {
			$keys = array($key);
		} else {
			$keys = $key;
		}
		foreach ($keys as $key) {
			if (isset(self::$_site['Site'][$key])) {
				Configure::write('Site.' . $key, self::$_site['Site'][$key]);
			}
		}
	}

	protected function _overrideMeta() {
		foreach (self::$_site['SiteMeta'] as $key => $value) {
			if (!empty($value)) {
				Configure::write('Meta.' . $key, $value);
			}
		}
	}

	public static function currentSite($siteId = null) {
		$_this = Sites::getInstance();
		self::$_site = $_this->_getSite($siteId);
		$_this->_overrideSetting(array(
			'title', 'tagline', 'theme', 'timezone', 'locale', 'status',
			));
		if (!empty(self::$_site['SiteMeta'])) {
			$_this->_overrideMeta();
		}
		CakeSession::write(self::$_sessionKey, self::$_site);
		return self::$_site;
	}

	protected function _getSite($siteId = null) {
		$Site = ClassRegistry::init('Sites.Site');
		$SiteDomain = $Site->SiteDomain;
		$SiteMeta = $Site->SiteMeta;
		$siteDomainTable = $SiteDomain->getDataSource()->fullTableName($SiteDomain, true, true);
		$siteMetaTable = $Site->SiteMeta->getDataSource()->fullTableName($SiteMeta, true, true);
		$options = array(
			'recursive' => false,
			'fields' => array(
				'Site.id', 'Site.title', 'Site.tagline', 'Site.theme',
				'Site.timezone', 'Site.locale', 'Site.status',
				'SiteMeta.robots', 'SiteMeta.keywords', 'SiteMeta.description'
			),
			'joins' => array(
				array(
					'table' => $siteDomainTable,
					'alias' => 'SiteDomain',
					'conditions' => array(
						'SiteDomain.site_id = Site.id',
						),
					),
				),
				array(
					'table' => $siteMetaTable,
					'alias' => 'SiteMeta',
					'conditions' => array(
						'SiteMeta.site_id = Site.id',
					),
				),
			);

		$host = env('HTTP_HOST');
		if (empty($siteId)) {
			$options['joins'][0]['conditions']['SiteDomain.domain LIKE'] = '%' . $host;
			$options['cache'] = array(
				'name' => 'sites_' . $host,
				'config' => 'sites',
			);
		} else {
			$options['conditions'] = array('Site.id' => $siteId);
			$options['cache'] = array(
				'name' => 'sites_' . $siteId,
				'config' => 'sites',
			);
		}

		$site = $Site->find('first', $options);
		if (empty($site)) {
			$site = $Site->find('first', array(
				'recursive' => false,
				'fields' => array('id', 'title', 'tagline', 'theme', 'timezone', 'locale', 'status'),
				'joins' => array(
					array(
						'table' => $siteDomainTable,
						'alias' => 'SiteDomain',
						'conditions' => array(
							'SiteDomain.site_id = Site.id',
							),
						),
					),
					array(
						'table' => $siteMetaTable,
						'alias' => 'SiteMeta',
						'conditions' => array(
							'SiteMeta.site_id = Site.id',
						),
					),
				'conditions' => array( 'Site.default' => 1 ),
			));
		}
		if ($siteId === null && CakeSession::check(self::$_sessionKey) && $active = CakeSession::read(self::$_sessionKey)) {
			$found = $SiteDomain->find('count', array(
				'cache' => array(
					'name' => 'sites_count_' . $host,
					'config' => 'sites',
				),
				'conditions' => array(
					'SiteDomain.domain' => $host,
				)
			));
			if ($found == 0) {
				$site = $active;
			}
		}
		return $site;
	}

}
