<?php

class SiteFilterBehavior extends ModelBehavior {

	function setup(&$model, $config = array()) {
		$config = Set::merge(array(
			'relationship' => false,
			'joins' => false,
			'enabled' => true,
			'filter' => true,
			), $config);
		$this->settings[$model->alias] = $config;
	}

	function _setupRelationships(&$model, $config = array()) {
		if (!empty($this->settings[$model->alias]['relationship'])) {
			$model->bindModel($config['relationship'], false);
		}
	}

	function enableFilter(&$model) {
		$this->settings[$model->alias]['filter'] = true;
	}

	function disableFilter(&$model) {
		$this->settings[$model->alias]['filter'] = false;
	}

	function beforeFind(&$model, $query) {
		if ($this->settings[$model->alias]['enabled'] === false) {
			return $query;
		}
		$this->_setupRelationships($model, $this->settings[$model->alias]);
		$site = Sites::currentSite();
		$sites = array(
			//$default['Site']['id'],
			//Sites::ALL_SITES,
			$site['Site']['id']
		);

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

		if (!empty($query['joins'])) {
			$joins = Set::merge($query['joins'], $joins);
		}

		if (!empty($relationship) && $this->settings[$model->alias]['filter']) {
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

				$joins[] = array(
					'type' => 'LEFT',
					'table' => $ds->fullTableName($joinModel),
					'alias' => $joinModel->alias,
					'conditions' => array(
						"{$model->alias}.{$model->primaryKey} = {$joinModel->alias}.$foreignKey",
						),
					);
				$query['conditions'][$joinModel->alias . '.' . $associationForeignKey] = $sites;
				break;
			}
		}

		$query['joins'] = $joins;
		return $query;
	}

}
