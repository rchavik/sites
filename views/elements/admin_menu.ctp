<?php
if ($this->Layout->getRoleId() !== 1): return; endif;

echo $this->Html->link('Sites', array(
	'plugin' => 'sites',
	'admin' => true,
	'controller' => 'sites',
	'action' => 'index',
	)
);
