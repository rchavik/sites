<?php

namespace Sites;

use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

class Sites {

    const ALL_SITES = 1;

    /**
     * @var Entity
     */
    protected static $_site;

    protected static $_sessionKey = 'Sites.current';

    public static function &getInstance() {
        static $instance = null;
        if (!$instance) {
            $instance = new Sites;
        }
        return $instance;
    }

    protected function _overrideSetting($key) {
        if (is_string($key)) {
            $keys = array($key);
        } else {
            $keys = $key;
        }
        foreach ($keys as $key) {
            if (self::$_site->has($key)) {
                Configure::write('Site.' . $key, self::$_site->get($key));
            }
        }
    }

    protected function _overrideMeta() {
        foreach (self::$_site['SiteMeta'] as $key => $value) {
            if (!empty($value)) {
                Configure::write('Meta.' . $key, $value);
            }
        }
    }

    public static function currentSite($siteId = null) {
        $_this = Sites::getInstance();
        self::$_site = $_this->_getSite($siteId);
        $_this->_overrideSetting(array(
            'title', 'tagline', 'theme', 'timezone', 'locale', 'status',
        ));
        if (!empty(self::$_site['SiteMeta'])) {
            $_this->_overrideMeta();
        }
        $request = Request::createFromGlobals();
        $request->session()->write(self::$_sessionKey, self::$_site);
        return self::$_site;
    }

    protected function _getSite($siteId = null) {
        $Sites = TableRegistry::get('Sites.Sites');
        $SiteDomains = $Sites->SiteDomains;
        $SiteMeta = $Sites->SiteMetas;

        /** @var Query $query */
        $query = $Sites->find()->select([
            'Sites.id', 'Sites.title', 'Sites.tagline', 'Sites.theme',
            'Sites.timezone', 'Sites.locale', 'Sites.status',
            'SiteMetas.robots', 'SiteMetas.keywords', 'SiteMetas.description'
        ])->contain([
            'SiteDomains',
            'SiteMetas',
        ]);

        $host = env('HTTP_HOST');
        if (empty($siteId)) {
            $query->join([
                [
                    'table' => $Sites->SiteDomains->table(),
                    'alias' => 'SiteDomains',
                    'conditions' => [
                        'SiteDomains.site_id = Sites.id',
                        'SiteDomains.domain LIKE' => '%' . $host
                    ]
                ]
            ]);
            $query->applyOptions([
                'cache' => [
                    'name' => 'sites_' . $host,
                    'config' => 'sites',
                ]
            ]);
        } else {
            $query->where([
                'Sites.id' => $siteId
            ]);
            $query->applyOptions([
                'cache' => [
                    'name' => 'sites_' . $siteId,
                    'config' => 'sites',
                ]
            ]);
        }
        $site = $query->first();
        if (empty($site)) {
            $site = $Sites->find('default')->contain([
                'SiteDomains',
                'SiteMetas'
            ])->select(['id', 'title', 'tagline', 'theme', 'timezone', 'locale', 'status'])->first();
        }
        $request = Request::createFromGlobals();
        if ($siteId === null && $request->session()->check(self::$_sessionKey) && $active = $request->session()->read(self::$_sessionKey)) {
            $found = $SiteDomains->find('all', [
                'cache' => [
                    'name' => 'sites_count_' . $host,
                    'config' => 'sites',
                ]
            ])->where([
                'SiteDomains.domain' => $host,
            ])->count();
            if ($found == 0) {
                $site = $active;
            }
        }
        return $site;
    }

}
