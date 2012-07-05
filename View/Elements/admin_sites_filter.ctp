<?php
$action = isset($action) ? $action : 'index';

echo $this->Form->create('filter', array(
	'url' => array(
		'admin' => true,
		'controller' => $controller,
		'action' => $action,
		),
	));

echo $this->Form->input('Site', array('empty' => __d('sites', '-- No site selected --')));
echo $this->Form->end();

echo $this->Html->scriptBlock("
$(function() {
	$('#filterSite').change(function() {
		$(this.form).submit();
	});
});
");
