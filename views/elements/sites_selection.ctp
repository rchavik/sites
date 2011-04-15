<?php

$options = array('multiple' => 'checkbox');
if (empty($this->data['Node']['title'])) {
	$options = Set::merge($options, array('selected' => array_keys($sites)));
}
echo $this->Form->input('Site', $options);
