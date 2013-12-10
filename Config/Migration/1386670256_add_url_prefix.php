<?php

App::uses('CakeMigration', 'Migrations.Lib');

class AddUrlPrefix extends CakeMigration {

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
					'url_prefix' => array('type' => 'string', 'null' => true, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'ix_sites_prefix' => array(
							'column' => array('url_prefix'), 'unique' => 1
						),
					),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'sites' => array(
					'url_prefix',
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
