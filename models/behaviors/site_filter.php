<?php

class SiteFilterBehavior extends ModelBehavior {

	function setup(&$model, $config = array()) {
		$this->_setupNodeRelationships($model, $config);
	}

	function _setupNodeRelationships(&$model, $config = array()) {
/*
		$model->bindModel( array(
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

		$joinTable = 'sites_' . Inflector::underscore($model->name);
		$foreignKey = Inflector::underscore($model->name) . '_id';
		$with = 'Sites.Sites' . $model->name;

		$model->bindModel( array(
			'hasAndBelongsToMany' => array(
				'Site' => array(
					'className' => 'Sites.Site',
					'joinTable' => $joinTable,
					'foreignKey' => $foreignKey,
					'associationForeignKey' => 'site_id',
					'unique' => true,
					'with' => $with,
					),
				),
			),
			false
		);

	}

	function beforeFind(&$model, $query) {
		$site = Sites::currentSite();
		$joinModel = 'Sites' . $model->name;
		$dbConfig= ConnectionManager::getInstance()->config->{$model->Site->{$joinModel}->useDbConfig};
		$foreignKey = Inflector::underscore($model->name) . '_id';
		$joins = array(
			array(
				'type' => 'LEFT',
				'table' => $dbConfig['database'] . '.' . $model->Site->{$joinModel}->useTable,
				'alias' => $joinModel,
				'conditions' => array(
					$model->name . '.id = ' . $joinModel . '.' . $foreignKey,
					),
				),
			);
		$query['joins'] = $joins;
		$query['conditions'][$joinModel . '.site_id'] = array(Sites::ALL_SITES, $site['Site']['id']);
		return $query;
	}

}
