<?php

App::uses('MenusHelper', 'Menus.View/Helper');

/**
 * SitesMenus Helper
 *
 * PHP version 5
 *
 * @category Sites.View/Helper
 * @package  Sites
 * @version  1.0
 * @author   rchavik
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class SitesMenusHelper extends MenusHelper {

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view);
		$this->_setupEvents();
	}

	protected function _setupEvents() {
		$events = array(
			'Helper.Menus.beforeLink' => array(
				'callable' => 'absoluteUrl',
				'passParams' => true,
			),
		);
		$eventManager = $this->_View->getEventManager();
		foreach ($events as $name => $config) {
			$eventManager->attach(array($this, 'absoluteUrl'), $name, $config);
		}
	}

/**
 * converts $link array to absolute url if parameter absolute is set to 1
 *
 * @return string url
 */
	public function absoluteUrl(&$link) {
		if (!$this->SiteDomain) {
			$this->SiteDomain = ClassRegistry::init('Sites.SiteDomain');
		}
		if (is_array($link) &&
			isset($link['Params']['absolute']) &&
			$link['Params']['absolute'] == 1 &&
			!empty($link['Site'][0]['id'])
		) {
			$domainId = $link['Site'][0]['id'];
			$domain = $this->SiteDomain->find('first', array(
				'conditions' => array(
					'SiteDomain.site_id' => $domainId,
				),
				'cache' => array(
					'name' => 'domain_lookup',
					'config' => 'nodes_index',
				),
			));
			$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
			if (is_string($link['Link']['link'])) {
				$linkStr = $link['Link']['link'];
			} else {
				$linkStr = $this->url($link['Link']['link']);
			}
			if (strpos($linkStr, 'http://') === false) {
				$linkStr = $scheme . '://' . $domain['SiteDomain']['domain'] . $linkStr;
				$link['Link']['link'] = $linkStr;
			}
		}
	}

}
