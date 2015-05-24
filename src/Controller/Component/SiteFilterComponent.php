<?php

App::uses('Sites', 'Sites.Lib');

class SiteFilterComponent extends Component {

	var $controller = false;

	public function adminFilter(Controller $controller) {
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

	public function startup(Controller $controller) {
		if (isset($controller->params['admin'])) {
			$this->adminFilter($controller);
		}
	}

	public function initialize(Controller $controller) {
		$this->controller = $controller;
		if (1 == $controller->Auth->user('role_id') && isset($controller->params['admin'])) {
			$Model =& $controller->{$controller->modelClass};
			if ($Model->Behaviors->attached('SiteFilter')) {
				$Model->Behaviors->SiteFilter->disableFilter($Model);
			}
		}
		$site = Sites::currentSite();
	}

}
