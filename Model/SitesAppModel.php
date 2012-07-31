<?php

class SitesAppModel extends AppModel {

	public $useDbConfig = 'sites';

	public $recursive = -1;

	public $actsAs = array(
		'Containable',
	);

}
