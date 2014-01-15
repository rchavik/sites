<?php

App::uses('CakeSession', 'Model/Datasource');
App::uses('SitesRoute', 'Sites.Routing/Route');

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
			'home_url',
			));
		if (!empty(self::$_site['SiteMeta'])) {
			$_this->_overrideMeta();
		}
		CakeSession::write(self::$_sessionKey, self::$_site);
		return self::$_site;
	}

	protected function _getSite($siteId = null) {
		$Site = ClassRegistry::init('Sites.Site');
		if (empty($siteId)) {
			$request = Router::getRequest();
			if (isset($request->params['site'])) {
				$site = $Site->find('first', array(
					'recursive' => -1,
					'fields' => 'id',
					'conditions' => array(
						'url_prefix like' => '%' . $request->params['site'] . '%',
					),
				));
				if (!empty($site['Site']['id'])) {
					$siteId = $site['Site']['id'];
				}
			}
		}
		$SiteDomain = $Site->SiteDomain;
		$SiteMeta = $Site->SiteMeta;
		$siteDomainTable = $SiteDomain->getDataSource()->fullTableName($SiteDomain, true, true);
		$siteMetaTable = $Site->SiteMeta->getDataSource()->fullTableName($SiteMeta, true, true);
		$options = array(
			'recursive' => false,
			'fields' => array(
				'Site.id', 'Site.title', 'Site.tagline', 'Site.theme',
				'Site.timezone', 'Site.locale', 'Site.status',
				'Site.url_prefix', 'Site.home_url',
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

/**
 * Setup site detection from prefixes in URL
 *
 * To use this feature, call this function from the application's routes file
 * before CakePlugin::routes() is completed.
 */
	public static function setupUrlPrefixes() {
		$cacheKey = 'SitesUrlPrefixes';
		$regex = Cache::read($cacheKey, 'sites');
		if ($regex === false) {
			$Site = ClassRegistry::init('Sites.Site');
			$sites = $Site->find('all', array(
				'fields' => array('id', 'url_prefix'),
				'conditions' => array(
					'url_prefix <>' => null,
				),
			));
			$regex = implode('|', Hash::extract($sites, '{n}.Site.url_prefix'));
			Cache::write($cacheKey, $regex, 'sites');
		}
	}

}
