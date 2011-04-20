<?php

App::import('Libs', 'Sites.sites');

class MultisiteComponent extends Object {

	function _setLookupFields(&$controller) {
		$controller->set('sites', ClassRegistry::init('Sites.Site')->find('list'));
	}

	function _setupNodeRelationships(&$controller) {
/*
		$controller->Node->bindModel( array(
			'hasMany' => array(
				'Publisher' => array(
					'className' => 'Sites.SitesNode',
					'alias' => 'SitesNode',
					'foreignKey' => 'node_id',
					),
				),
			),
			false
		);
*/

		$controller->Node->bindModel( array(
			'hasAndBelongsToMany' => array(
				'Site' => array(
					'className' => 'Sites.Site',
					'joinTable' => 'sites_nodes',
					'foreignKey' => 'node_id',
					'associationForeignKey' => 'site_id',
					'unique' => true,
					),
				),
			),
			false
		);

	}

	function startup(&$controller) {
		$this->_setLookupFields($controller);
		$this->_setupNodeRelationships($controller);
	}

	function initialize(&$controller, $settings = array()) {
		if (1 == $controller->Auth->user('role_id') && isset($controller->params['admin'])) {
			$controller->Node->Behaviors->detach('Sites.SiteFilter');
		}
		$site = Sites::currentSite();
	}

}
