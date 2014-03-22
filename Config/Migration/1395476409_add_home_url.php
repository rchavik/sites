<?php

App::uses('CakeMigration', 'Migrations.Lib');

class AddHomeUrl extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'sites' => array(
					'home_url' => array('type' => 'string', 'null' => true, 'length' => 255, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'sites' => array(
					'home_url',
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}

}
