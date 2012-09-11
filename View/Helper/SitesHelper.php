<?php

class SitesHelper extends AppHelper {

	public $helpers = array(
		'Html',
		);

	public function beforeRender() {
		if (isset($this->params['admin'])) {
			echo $this->Html->css('/sites/css/admin_sites', null, array('inline' => false));
		}
	}

/**
 * adds a canonical url for $node
 */
	public function canonical($node) {
		if (empty($node['Site'][0]['SiteDomain'][0]['domain'])) {
			return;
		}
		$href = $this->_href($node);
		$link = $this->Html->tag('link', null, array(
			'rel' => 'canonical',
			'href' => $href,
		));
		$this->_View->append('script', $link);
	}

/**
 * gets the domain name for use in canonical url
 */
	protected function _href($node) {
		if (empty($node['Site'][0]['SiteDomain'][0]['domain'])) {
			return $node['Node']['path'];
		}

		if (strpos($node['Node']['path'], 'http:') === false) {
			$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
			return $scheme . '://' . $node['Site'][0]['SiteDomain'][0]['domain'] . $node['Node']['path'];
		}

		return $node['Node']['path'];
	}

}
