<?php

namespace Sites\Model\Table;

use Cake\ORM\Table;

class SitesNodesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('sites_nodes');
    }

}
