<?php

namespace Sites\Model\Table;

use Cake\ORM\Table;

class SiteDomainsTable extends Table {

    public $validate = array(
        'domain' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Domain must not be empty',
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Domain must be unique',
            ),
        ),
    );

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('site_metas');
        $this->belongsTo('Sites', [
            'className' => 'Sites.Sites'
        ]);
    }

}
