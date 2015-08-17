<?php

use Cake\Utility\Hash;
use Sites\Sites;

$options = ['multiple' => 'checkbox', 'div' => 'input checkbox', 'class' => false];
if (in_array($this->request->action, ['add', 'admin_add'])) {
	$options = Hash::merge($options, ['default' => [Sites::ALL_SITES]]);
}
echo $this->Form->input('sites', $options);
