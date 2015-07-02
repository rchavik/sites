<?php

namespace Sites\Model\Table;

use Cake\ORM\Table;

class SiteMetasTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('site_metas');
        $this->primaryKey('site_id');
        $this->belongsTo('Sites', [
            'className' => 'Sites.Sites'
        ]);
    }

}
