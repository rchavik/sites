<?php

namespace Sites\Model\Table;

use Cake\ORM\Table;

class SiteMetasTable extends Table {

	public $useTable = 'site_metas';

	public $primaryKey = 'site_id';

	public $belongsTo = array(
		'Site' => array(
			'className' => 'Sites.Site',
			'foreignKey' => 'site_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
