<?php

namespace Sites\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\Utility\Hash;
use Sites\Sites;

class SiteFilterBehavior extends Behavior {

    protected $_defaultConfig = [
        'relationship' => false,
        'joins' => array(),
        'enabled' => true,
        'filter' => true,
    ];

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

    protected function _setupRelationships($config = array()) {
        if ($this->config('relationship')) {
            $this->_table->addAssociations($config['relationship']);
        }
    }

    public function enableFilter() {
        $this->config('filter', true);
    }

    public function disableFilter() {
        $this->config('filter', false);
    }

    public function beforeFind(Event $event, Query $query) {
        if ($this->config('enabled') === false) {
            return $query;
        }
        $this->_setupRelationships($this->config());
        $site = Sites::currentSite();

        $sites = array(Sites::ALL_SITES);

        if ($site) {
            $sites = array_unique(array(Sites::ALL_SITES, $site->id));
        }

        $setting = Hash::merge(
            array('relationship' => array(), 'joins' => array()),
            $this->config()
        );
        extract($setting);

        $query->contain(['Sites']);

//        var_dump($query);

//		if (!empty($joins)) {
//			foreach ($joins as $join => &$joinConfig) {
//				if (empty($joinConfig)) continue;
//
//				// link to Site model
//				$foreignKey = $joinConfig['alias']. '.site_id';
//				if (empty($joinConfig['conditions'][$foreignKey])) {
//					$joinConfig['conditions'][$foreignKey] = $sites;
//				}
//
//				$foreignKey = $joinConfig['alias']. '.' . Inflector::underscore($model->alias) . '_id';
//				$condition = "{$model->alias}.{$model->primaryKey} = {$foreignKey}";
//				if (!in_array($condition, $joinConfig['conditions'])) {
//					$joinConfig['conditions'][] = $condition;
//				}
//			}
//		}

        if (!empty($relationship) && $this->config('filter')) {
            $relation = key($relationship[key($relationship)]);
            $foreignKey = $this->_table->association($relation)->foreignKey();
            switch ($relation) {

                case 'belongsTo':
                    $query->where([$this->_table->alias() . '.' . $foreignKey . ' IN' => $sites]);
                    break;

                case 'belongsToMany':
                default:
                    $joinModel = $this->_table->{$relation}->junction();
                    $associationForeignKey = $this->_table->{$relation}->targetForeignKey();

                    $query->join([
                        'type' => 'LEFT',
                        'table' => $joinModel->table(),
                        'alias' => $joinModel->alias(),
                        'conditions' => [
                            $this->_table->alias() . '.' . $this->_table->primaryKey() . ' = ' . $joinModel->alias() . '.' . $foreignKey,
                        ],
                    ]);

                    $query->where([
                        $joinModel->alias() . '.' . $associationForeignKey . ' IN' => $sites
                    ]);
                    break;
            }
        }

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
