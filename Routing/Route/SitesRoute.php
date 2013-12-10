<?php

App::uses('CakeRoute', 'Routing/Route');

/**
 * Sites Route class
 *
 * @package Sites.Routing.Route
 */
class SitesRoute extends CakeRoute {

/**
 * Parse route
 *
 * @param string $url The URL to attempt to parse.
 * @return mixed Boolean false on failure, otherwise an array or parameters
 * @see CakeRoute::parse()
 */

	public function parse($url) {
		$parsed = parent::parse($url);
		if (!isset($parsed['site'])) {
			return false;
		}
		return $parsed;
	}

/**
 * Checks if an URL array matches this route instance
 *
 * @param array $url An array of parameters to check matching with.
 * @return mixed Either a string URL for the parameters if they match or false.
 * @see CakeRoute::match()
 */
	public function match($url) {
		$site = Sites::currentSite();
		if (!empty($site['Site']['url_prefix'])) {
			if (strpos($site['Site']['url_prefix'], '|') === false) {
				$prefix = $site['Site']['url_prefix'];
			} else {
				list($prefix, ) = explode('|', $site['Site']['url_prefix'], 2);
			}
			$url['site'] = $prefix;
		}
		$match = parent::match($url);
		return $match;
	}

}
