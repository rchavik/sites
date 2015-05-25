<?php

namespace Sites\Model\Table;

use Cake\ORM\Table;

class SitesForumCategoriesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('sites_forum_categories');
    }

}
