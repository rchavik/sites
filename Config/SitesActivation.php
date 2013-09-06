<?php

App::uses('CroogoPlugin', 'Extensions.Lib');
App::uses('Setting', 'Settings.Model');

class SitesActivation {

	public function beforeActivation(&$controller) {
		return true;
	}

	public function onActivation(&$controller) {
		$CroogoPlugin = new CroogoPlugin();
		$result = $CroogoPlugin->migrate('Sites');
		if ($result) {
			$Setting = ClassRegistry::init('Settings.Setting');
			$result = $Setting->write('Sites.installed', true);
		}
		return $result;
	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
		$Setting = ClassRegistry::init('Settings.Setting');
		$result = $Setting->write('Sites.installed', false);
	}

}