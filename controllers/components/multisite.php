<?php

App::import('Libs', 'Sites.sites');

class MultisiteComponent extends Object {

	function _setLookupFields(&$controller) {
		$controller->set('sites', ClassRegistry::init('Sites.Site')->find('list'));
	}

	/** _setupCache
	 *  Differentiate croogo's cache prefix so that sites have their own cache
	 *  List of cache names are from croogo_bootstrap.php
	 */
	function _setupCache(&$controller) {
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

	function applyFilter(&$controller) {
        $filterKey = 'Sites.' . $controller->modelClass . '.adminFilter';
        if (isset($controller->data['filter']['Site'])) {
            $filterSiteId = $controller->data['filter']['Site'];
            if (empty($filterSiteId)) {
                $controller->Session->delete($filterKey);
            } else {
                $controller->Session->write($filterKey, $filterSiteId);
            }
        }
        if ($filterSiteId = $controller->Session->read($filterKey)) {
			$tableName = $controller->{$controller->modelClass}->useTable;
			$joinTable = 'sites_' . $tableName;
			$alias = 'Sites' . $controller->modelClass;
            $controller->paginate[$controller->modelClass]['joins'][] = array(
                'type' => 'LEFT',
                'table' => $joinTable,
                'alias' => $alias,
                'conditions' => array(
                    $alias . '.forum_category_id = ' . $controller->modelClass. '.id',
                    ),
                );
            $controller->paginate[$controller->modelClass]['conditions'][$alias . '.site_id'] = $filterSiteId;
        }

	}

	function startup(&$controller) {
		$this->_setLookupFields($controller);
		$this->_setupCache($controller);
	}

	function initialize(&$controller, $settings = array()) {
		if (1 == $controller->Auth->user('role_id') && isset($controller->params['admin'])) {
			$Model =& $controller->{$controller->modelClass};
			if (property_exists($Model->Behaviors, 'SiteFilter')) {
				$Model->Behaviors->SiteFilter->disableFilter($Model);
			}
		}
		$site = Sites::currentSite();
	}

}
