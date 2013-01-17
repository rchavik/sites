<?php

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__('Extensions'), array(
		'plugin' => 'extensions', 'controller' => 'extensions_plugins',
	))
	->addCrumb(__('Sites'), array('plugin' => 'sites', 'controller' => 'sites'))
	;

?>
<?php $this->start('actions'); ?>
	<li><?php echo $this->Html->link(__('New Site'), array('action' => 'add'), array('button' => 'default')); ?></li>
	<li><?php echo $this->Html->link(__('Enable All Sites'), array('action' => 'enable'), array('button' => 'default'), 'Enable all sites?'); ?></li>
	<li><?php echo $this->Html->link(__('Disable All Sites'), array('action' => 'disable'), array('button' => 'default'), 'Disable all sites?'); ?></li>
<?php $this->end(); ?>

<h2 class="hidden-desktop"><?php echo __('Sites');?></h2>
<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('title');?></th>
	<th><?php echo $this->Paginator->sort('theme');?></th>
	<th><?php echo $this->Paginator->sort('status');?></th>
	<th><?php echo __('Actions');?></th>
	<th><?php echo __('Default');?></th>
</tr>
<?php
$i = 0;
foreach ($sites as $site):
	$actions = array();
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<tr<?php echo $class;?>>
	<td><?php echo $site['Site']['id']; ?>&nbsp;</td>
	<td><?php echo $site['Site']['title']; ?>&nbsp;</td>
	<td><?php echo $site['Site']['theme']; ?>&nbsp;</td>
	<td><?php echo $this->Html->status($site['Site']['status']); ?>&nbsp;</td>
	<td>
	<?php
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'sites', 'action' => 'edit', $site['Site']['id'], '#' => 'site-domains'),
			array('icon' => 'zoom-in', 'tooltip' => __('View Domains'))
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'view', $site['Site']['id']),
			array('icon' => 'eye-open', 'tooltip' => __('View'))
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'edit', $site['Site']['id']),
			array('icon' => 'pencil', 'tooltip' => __('Edit'))
		);
		$actions[] = $this->Croogo->adminRowAction('', array('action' => 'delete', $site['Site']['id']), array('icon' => 'trash', 'tooltip' => __('Delete')),
			__('Are you sure you want to delete # %s?', $site['Site']['id'])
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'publish_nodes', $site['Site']['id']),
			array('tooltip' => __('Publish All Nodes'), 'icon' => 'file'),
			__('Publish all existing published nodes to site \'%s\'?', $site['Site']['title'])
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'publish_blocks', $site['Site']['id']),
			array('tooltip' => __('Publish All Blocks'), 'icon' => 'columns'),
			__('Publish all existing published blocks to site \'%s\'?', $site['Site']['title'])
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'publish_links', $site['Site']['id']),
			array('tooltip' => __('Publish All Links'), 'icon' => 'sitemap'),
			__('Publish all existing published links to site \'%s\'?', $site['Site']['title'])
		);
		echo $this->Html->div('item-actions', implode(' ', $actions));
	?>
	</td>
	<td>
	<?php
		if ($site['Site']['default'] == 1) {
			$default = __('Yes');
		} else {
			$default = __('No').' ('.$this->Html->link(__('Set as default'), array('controller' => 'sites', 'action' => 'setdefault', $site['Site']['id'])).')';
		}
		echo $default;
	?>
	</td>
</tr>
<?php endforeach; ?>
</table>
