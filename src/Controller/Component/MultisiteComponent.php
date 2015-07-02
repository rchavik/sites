<?php

namespace Sites\Controller\Component;

use Cake\Cache\Cache;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Sites\Sites;

class MultisiteComponent extends Component {

    public $controller = false;

    protected function _setLookupFields(Controller $controller) {
        $controller->set('sites', TableRegistry::get('Sites.Sites')->find('list')->toArray());
    }

    /**
     * _setupCache
     *  Differentiate croogo's cache prefix so that sites have their own cache
     *  List of cache names are from croogo_bootstrap.php
     */
    public function _setupCache(Controller $controller) {
        $configured = Cache::configured();
        $croogoCacheNames = array(
            // components
            'croogo_blocks', 'croogo_menus', 'croogo_nodes',
            'croogo_types', 'croogo_vocabularies',
            // controllers
            'croogo_vocabularies', 'nodes_promoted', 'nodes_term',
            'nodes_index', 'contacts_view',
        );
        return;
        $siteTitle = Inflector::slug(strtolower(Configure::read('Site.title')));
        for ($i = 0, $ii = count($configured); $i < $ii; $i++) {
            if (!in_array($configured[$i], $croogoCacheNames)) {
                continue;
            }
            $cacheName = $configured[$i];
            $setting = Cache::settings($cacheName);
            $setting = Set::merge($setting, array(
                    'prefix' => 'cake_' . $siteTitle . '_',
                )
            );
            Cache::config($cacheName, $setting);
        }
    }

    public function beforeFilter(Event $event) {
        /** @var Controller $controller */
        $controller = $event->subject();
        if (1 == $controller->Auth->user('role_id') && $controller->request->param('prefix') === 'admin') {
            list ($plugin, $class) = pluginSplit($controller->modelClass);
            if ($controller->{$class}) {
                $Model =& $controller->{$class};
                if ($Model instanceof Table && $Model->hasBehavior('SiteFilter')) {
                    $Model->disableFilter($Model);
                }
            }
        }
        $site = Sites::currentSite();

        $this->_setLookupFields($controller);
        $this->_setupCache($controller);
    }

}
