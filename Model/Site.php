<?php
class Site extends SitesAppModel {
	var $name = 'Site';
	var $displayField = 'title';
	var $useTable = 'sites';

	var $actsAs = array(
		'Containable',
		'Utils.Sluggable' => array(
				'label' => 'title',
				'slug' => 'slug',
				'update' => true,
				'separator' => '-',
			),
		);

	var $hasMany = array(
		'SiteDomain' => array(
			'className' => 'Sites.SiteDomain',
			'foreignKey' => 'site_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
			),
		);

	var $hasAndBelongsToMany = array(
		'Node' => array(
			'className' => 'Node',
			'joinTable' => 'sites_nodes',
			'foreignKey' => 'site_id',
			'associationForeignKey' => 'node_id',
			'dependent' => true,
			'with' => 'Sites.SitesNode',
			),
		'Block' => array(
			'className' => 'Block',
			'joinTable' => 'sites_blocks',
			'foreignKey' => 'site_id',
			'associationForeignKey' => 'block_id',
			'dependent' => true,
			'with' => 'Sites.SitesBlock',
			),
		'Link' => array(
			'className' => 'Link',
			'joinTable' => 'sites_links',
			'foreignKey' => 'site_id',
			'associationForeignKey' => 'link_id',
			'dependent' => true,
			'with' => 'Sites.SitesLink',
			),
		);

	function publish_all($siteId, &$model) {
		$model->Behaviors->attach('Containable');
		$model->disableFilter();
		$conditions = array(
			'contain' => array('Site' => array('id')),
			'fields' => 'id',
			'conditions' => array(
				$model->alias . '.status' => true,
				)
			);
		$rows = $model->find('all', $conditions);
		foreach ($rows as &$row) {
			if (isset($row['Site']['Site'])) {
				$row['Site']['Site'] = array_unique(Set::merge($row['Site']['Site'], array($siteId)));
			} else {
				$row['Site']['Site'] = array($siteId);
			}
		}
		return $model->saveAll($rows);
	}

}
