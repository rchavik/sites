<?php

App::uses('Sites', 'Sites.Lib');

class SiteFilterBehavior extends ModelBehavior {

	public function setup(Model $model, $config = array()) {
		$model->Behaviors->setPriority(array('SiteFilter' => 5));
		$config = Set::merge(array(
			'relationship' => false,
			'joins' => array(),
			'enabled' => true,
			'filter' => true,
			), $config);
		$this->settings[$model->alias] = $config;
		$this->_setupRelationships($model, $config);
	}

	protected function _setupRelationships(Model $model, $config = array()) {
		if (!empty($this->settings[$model->alias]['relationship'])) {
			$model->bindModel($config['relationship'], false);
		}
	}

	public function enableFilter(Model $model) {
		$this->settings[$model->alias]['filter'] = true;
	}

	public function disableFilter(Model $model) {
		$this->settings[$model->alias]['filter'] = false;
	}

	public function beforeFind(Model $model, $query) {
		if ($this->settings[$model->alias]['enabled'] === false) {
			return $query;
		}
		$this->_setupRelationships($model, $this->settings[$model->alias]);
		$site = Sites::currentSite();

		$sites = array(Sites::ALL_SITES);

		if ($site) {
			$sites = array_unique(array(Sites::ALL_SITES, $site['Site']['id']));
		}

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
				if (strpos($with, '.') !== false) {
					list($pluginName, $with) = pluginSplit($with);
				}
				$joinModel = $model->{$with};
				$ds = $joinModel->getDataSource();
				$associationForeignKey = $model->{$relation}['Site']['associationForeignKey'];

				$currentJoins = Set::extract('{n}.alias', $joins);
				if (!empty($currentJoins) && in_array($joinModel->alias, $currentJoins)) {
					break;
				}

				$joins[] = array(
					'type' => 'LEFT',
					'table' => $ds->fullTableName($joinModel, true, true),
					'alias' => $joinModel->alias,
					'conditions' => array(
						"{$model->alias}.{$model->primaryKey} = {$joinModel->alias}.$foreignKey",
						),
					);
				if (is_string($query['conditions'])) {
					$query['conditions'] = array(
						$query['conditions'],
						$joinModel->alias . '.' . $associationForeignKey => $sites,
						);
				} else {
					$query['conditions'][$joinModel->alias . '.' . $associationForeignKey] = $sites;
				}
				break;
			}
		}

		$query['joins'] = $joins;
		unset($query['recursive']);
		return $query;
	}

/**
 * retrieve domain information
 */
	public function afterFind(Model $model, $results, $primary = false) {
		if (!$primary || $this->settings[$model->alias]['enabled'] === false) {
			return $query;
		}
		foreach ($results as &$result) {
			if (empty($result['Site'])) {
				continue;
			}
			foreach ($result['Site'] as &$site) {
				if (isset($site['SiteDomain'])) {
					continue;
				}
				$domains = $model->Site->SiteDomain->find('all', array(
					'cache' => array(
						'name' => 'site_domains_' . $site['id'],
						'config' => 'sites',
					),
					'conditions' => array(
						'SiteDomain.site_id' => $site['id'],
					),
				));
				$site['SiteDomain'] = Hash::extract($domains, '{n}.SiteDomain');
			}
		}
		return $results;
	}

}
