<?php
$action = isset($action) ? $action : 'index';

echo $this->Form->create('filter', array(
	'url' => array(
		'admin' => true,
		'controller' => $controller,
		'action' => $action,
		),
	));

echo $this->Form->input('Site', array('empty' => __d('sites', '-- No site selected --', true)));
echo $this->Form->end();
