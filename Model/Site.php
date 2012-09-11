<?php
class Site extends SitesAppModel {

	public $displayField = 'title';

	public $useTable = 'sites';

	public $actsAs = array(
		'Containable',
		);

	public $hasMany = array(
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

	public $hasAndBelongsToMany = array(
		'Node' => array(
			'className' => 'Nodes.Node',
			'joinTable' => 'sites_nodes',
			'foreignKey' => 'site_id',
			'associationForeignKey' => 'node_id',
			'dependent' => true,
			'with' => 'Sites.SitesNode',
		),
		'Block' => array(
			'className' => 'Regions.Block',
			'joinTable' => 'sites_blocks',
			'foreignKey' => 'site_id',
			'associationForeignKey' => 'block_id',
			'dependent' => true,
			'with' => 'Sites.SitesBlock',
		),
		'Link' => array(
			'className' => 'Menus.Link',
			'joinTable' => 'sites_links',
			'foreignKey' => 'site_id',
			'associationForeignKey' => 'link_id',
			'dependent' => true,
			'with' => 'Sites.SitesLink',
		),
	);

	public function publish_all($siteId, &$model) {
		$model->Behaviors->attach('Containable');
		foreach (array('hasMany', 'belongsTo', 'hasAndBelongsToMany') as $relation) {
			foreach ($model->{$relation} as $relatedModel => $config) {
				if ($relatedModel != 'Site') {
					$model->unbindModel(array($relation => array($relatedModel)), false);
				}
			}
		}
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
				$siteIds = Hash::extract($row, 'Site.{n}.id');
				$siteIds = array_merge($siteIds, array($siteId));
				$row['Site']['Site'] = $siteIds;
			}
		}
		return $model->saveAll($rows);
	}

}
