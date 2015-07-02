<?php

namespace Sites\Model\Table;

use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\Table;

class SitesTable extends Table {

    public $hasOne = array(
        'SiteMeta' => array(
            'className' => 'Sites.SiteMeta',
        ),
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
            'className' => 'Blocks.Block',
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

    /**
     * custom finds
     */
    public $findMethods = array(
        'default' => true,
    );

    public function initialize(array $config) {
        $this->hasOne('SiteMetas', [
            'className' => 'Sites.SiteMetas'
        ]);
        $this->hasMany('SiteDomains', [
            'className' => 'Sites.SiteDomains'
        ]);
        $this->belongsToMany('Nodes', [
            'className' => 'Croogo/Nodes.Nodes',
            'joinTable' => 'sites_nodes',
            'foreignKey' => 'site_id',
            'targetForeignKey' => 'node_id',
            'through' => 'Sites.SitesNodes',
        ]);
        $this->belongsToMany('Blocks', [
            'className' => 'Croogo/Blocks.Blocks',
            'joinTable' => 'sites_blocks',
            'foreignKey' => 'site_id',
            'targetForeignKey' => 'block_id',
            'through' => 'Sites.SitesBlocks',
        ]);
        $this->belongsToMany('Links', [
            'className' => 'Croogo/Menus.Links',
            'joinTable' => 'sites_links',
            'foreignKey' => 'site_id',
            'targetForeignKey' => 'link_id',
            'through' => 'Sites.SitesLinks',
        ]);
    }

    public function publishAll(Entity $site, BelongsToMany $association) {
        $query = $association->find()
            ->contain([
                'Sites'
            ])
            ->where([
                $association->alias() . '.status' => true
            ])
            ->select([
                'id'
            ]);
        $entities = $query;
        foreach ($entities as $entity) {
            if (in_array($site->id, collection($entity->sites)->extract('id')->toArray())) {
                continue;
            }

            $association->link($entity, [$site]);
        }

        return true;
    }

    /**
     * finds the default site
     */
    public function findDefault(Query $query, array $options) {
        return $query->applyOptions([
            'name' => 'default_domain',
            'config' => 'nodes_index',
        ])->where([
            'Sites.default' => true,
            'Sites.status' => true,
        ]);
    }

    public function setDefault(Entity $site) {
        $this->updateAll([
            'default' => false,
        ], [
            'id IS NOT' => $site->id
        ]);

        $site->default = true;

        return $this->save($site);
    }

    public function enableAll() {
        return $this->updateAll([
            'status' => true
        ], [
            'status' => false
        ]);
    }

    public function disableAll() {
        return $this->updateAll([
            'status' => false
        ], [
            'status' => true
        ]);
    }

    /**
     * returns the canonical target
     *
     * @param string $path
     * @param string $domain when null, the default domain will be used
     */
    public function href($path, $domain = null) {
        $scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        if ($domain == null) {
            $site = $this->find('default');
            if (!$site) {
                return false;
            }
            if (!empty($site['SiteDomain'][0]['domain'])) {
                $domain = $site['SiteDomain'][0]['domain'];
            } else {
                return $path;
            }
        }
        return $scheme . '://' . $domain . $path;
    }

}
