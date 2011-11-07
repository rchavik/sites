<?php

App::uses('Sites', 'Sites.Lib');

class SiteFilterComponent extends Component {

	var $controller = false;

	function adminFilter(&$controller) {
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
			$modelClass = $controller->modelClass;
			$alias = 'Sites' . $modelClass;
			$joinModel = $controller->{$controller->modelClass}->{$alias};
			$joinTable = $joinModel->getDataSource()->fullTableName($joinModel);
			$controller->paginate[$controller->modelClass]['joins'][] = array(
				'type' => 'LEFT',
				'table' => $joinTable,
				'alias' => $alias,
				'conditions' => array(
					$alias . '.forum_category_id = ' . $controller->modelClass. '.id',
					),
				);
            $controller->paginate[$modelClass]['conditions'][$alias . '.site_id'] = $filterSiteId;
        }
	}

	function startup(&$controller) {
		if (isset($controller->params['admin'])) {
			$this->adminFilter($controller);
		}
	}

	function initialize(&$controller) {
		$this->controller = $controller;
		if (1 == $controller->Auth->user('role_id') && isset($controller->params['admin'])) {
			$Model =& $controller->{$controller->modelClass};
			if (property_exists($Model->Behaviors, 'SiteFilter')) {
				$Model->Behaviors->SiteFilter->disableFilter($Model);
			}
		}
		$site = Sites::currentSite();
	}

}
