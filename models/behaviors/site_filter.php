<?php

class SiteFilterBehavior extends ModelBehavior {

	function setup(&$model, $config = array()) {
		if (empty($config)) {
			// when $config is empty, we assume that it was loaded by
			// Croogo hookHelper()
			$config = array(
				'relationship' => array(
					'hasAndBelongsToMany' => array(
						'Site' => array(
							'className' => 'Sites.Site',
							'with' => 'Sites.SitesNode',
							)
						)
					)
				);
		}
		$this->settings[$model->alias] = $config;
		$this->_setupRelationships($model, $config);
	}

	function _setupRelationships(&$model, $config = array()) {
		if (!empty($this->settings[$model->alias])) {
			if (!empty($this->settings[$model->alias]['relationship'])) {
				$model->bindModel($config['relationship'], false);
			}
		}
	}

	function beforeFind(&$model, $query) {
		$site = Sites::currentSite();
		$sites = array(Sites::ALL_SITES, $site['Site']['id']);

		$setting = Set::merge(
			array('relationship' => array(), 'joins' => array()),
			$this->settings[$model->alias]
			);
		extract($setting);

		if (!empty($joins)) {
			foreach ($joins as $join => &$joinConfig) {
				if (empty($joinConfig)) continue;

				// link to Site model
				$foreignKey = $joinConfig['alias']. '.site_id';
				if (empty($joinConfig['conditions'][$foreignKey])) {
					$joinConfig['conditions'][$foreignKey] = $sites;
				}

				$foreignKey = $joinConfig['alias']. '.' . Inflector::underscore($model->alias) . '_id';
				$condition = "{$model->alias}.{$model->primaryKey} = {$foreignKey}";
				if (!in_array($condition, $joinConfig['conditions'])) {
					$joinConfig['conditions'][] = $condition;
				}
			}
		}

		if (!empty($relationship)) {
			$relation = key($relationship);
			$foreignKey = $model->{$relation}['Site']['foreignKey'];
			switch ($relation) {

			case 'belongsTo':
				$query['conditions'][$model->alias . '.' . $foreignKey] = $sites;
				break;

			case 'hasAndBelongsToMany':
			default:
				$with = $model->{$relation}['Site']['with'];
				$joinModel = $model->{$with};
				$ds = $joinModel->getDataSource();
				$associationForeignKey = $model->{$relation}['Site']['associationForeignKey'];

				$joins = Set::merge($joins, array(
					array(
						'type' => 'LEFT',
						'table' => $ds->fullTableName($joinModel),
						'alias' => $joinModel->alias,
						'conditions' => array(
							"{$model->alias}.{$model->primaryKey} = {$joinModel->alias}.$foreignKey",
							),
						),
					));
				$query['conditions'][$joinModel->alias . '.' . $associationForeignKey] = $sites;
				break;
			}
		}

		$query['joins'] = $joins;
		return $query;
	}

}
