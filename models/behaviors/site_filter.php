<?php

class SiteFilterBehavior extends ModelBehavior {

	function beforeFind(&$model, $query) {
		$site = Sites::currentSite();
		$joins = array(
			array(
				'type' => 'LEFT',
				'table' => 'sites_nodes',
				'alias' => 'SitesNode',
				'conditions' => array(
					'Node.id = SitesNode.node_id',
					),
				),
			);
		$query['joins'] = $joins;
		$query['conditions']['SitesNode.site_id'] = $site['Site']['id'];
		return $query;
	}

}
