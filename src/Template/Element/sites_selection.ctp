<?php

$options = array('multiple' => 'checkbox', 'div' => 'input checkbox', 'class' => false);
if (in_array($this->action, array('add', 'admin_add'))) {
	$options = Set::merge($options, array('selected' => array(Sites::ALL_SITES)));
}
echo $this->Form->input('Site', $options);
