<?php

App::uses('Sites', 'Sites.Lib');

class MultisiteComponent extends Component {

	public $controller = false;

	protected function _setLookupFields(Controller $controller) {
		$controller->set('sites', ClassRegistry::init('Sites.Site')->find('list'));
	}

/**
 * _setupCache
 *  Differentiate croogo's cache prefix so that sites have their own cache
 *  List of cache names are from croogo_bootstrap.php
 */
	public function _setupCache(Controller $controller) {
		$configured = Cache::configured();
		$croogoCacheNames = array(
			// components
			'croogo_blocks', 'croogo_menus', 'croogo_nodes',
			'croogo_types', 'croogo_vocabularies',
			// controllers
			'croogo_vocabularies', 'nodes_promoted', 'nodes_term',
			'nodes_index', 'contacts_view',
			);
		$siteTitle = Inflector::slug(strtolower(Configure::read('Site.title')));
		for ($i = 0, $ii = count($configured); $i < $ii; $i++) {
			if (!in_array($configured[$i], $croogoCacheNames)) { continue; }
			$cacheName = $configured[$i];
			$setting = Cache::settings($cacheName);
			$setting = Set::merge($setting, array(
				'prefix' => 'cake_' . $siteTitle . '_',
				)
			);
			Cache::config($cacheName, $setting);
		}
	}

	public function startup(Controller $controller) {
		$this->_setLookupFields($controller);
		$this->_setupCache($controller);
	}

	public function initialize(Controller $controller, $settings = array()) {
		if (1 == $controller->Auth->user('role_id') && isset($controller->params['admin'])) {
			if ($controller->{$controller->modelClass}) {
				$Model =& $controller->{$controller->modelClass};
				if ($Model instanceof Model && $Model->useTable && $Model->Behaviors->attached('SiteFilter')) {
					$Model->Behaviors->SiteFilter->disableFilter($Model);
				}
			}
		}
		$site = Sites::currentSite();
	}

}
