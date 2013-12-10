<?php

class SitesHelper extends AppHelper {

	public $helpers = array(
		'Html',
		);

/**
 * constructor
 */
	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->Site = ClassRegistry::init('Sites.Site');
	}

/**
 * beforeRender
 */
	public function beforeRender($viewFile) {
		if (isset($this->params['admin'])) {
			echo $this->Html->css('/sites/css/admin_sites', null, array('inline' => false));
		}
	}

/**
 * adds a canonical url for $node
 */
	public function canonical($node = null) {
		if ($node == null && isset($this->_View->viewVars['node'])) {
			$node = $this->_View->viewVars['node'];
		}
		if (isset($node['Site'][0]['SiteDomain'][0]['domain'])) {
			$href = $this->_href($node);
		} else {
			$plugin = Inflector::camelize($this->request->plugin);
			$corePlugins = array(
				'Acl', 'Blocks', 'Comments', 'Contacts', 'Extensions',
				'FileManager', 'Menus', 'Meta', 'Nodes', 'Settings',
				'Taxonomy', 'Translate', 'Users',
			);
			$domain = in_array($plugin, $corePlugins) ? null : env('HTTP_HOST');
			$href = $this->Site->href($this->here, $domain);
		}
		if ($href) {
			$link = $this->Html->tag('link', null, array(
				'rel' => 'canonical',
				'href' => $href,
			));
			$this->_View->append('script', $link);
		}
	}

/**
 * gets the domain name for use in canonical url
 */
	protected function _href($node) {
		if (empty($node['Site'][0]['SiteDomain'][0]['domain'])) {
			return $node['Node']['path'];
		}

		if (strpos($node['Node']['path'], 'http') === false) {
			if ($node['Site'][0]['id'] == Sites::ALL_SITES) {
				$site = $this->Site->find('default');
				$domain = $site['SiteDomain'][0]['domain'];
			} else {
				$domain = $node['Site'][0]['SiteDomain'][0]['domain'];
			}
			return $this->Site->href($node['Node']['path'], $domain);
		}

		return $node['Node']['path'];
	}

}
