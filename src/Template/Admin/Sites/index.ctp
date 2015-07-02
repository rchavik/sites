<?php

$this->extend('Croogo/Croogo./Common/admin_index');

$this->CroogoHtml
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__('Extensions'), array(
		'plugin' => 'Croogo/Extensions', 'controller' => 'ExtensionsPlugins',
	))
	->addCrumb(__('Sites'), array('plugin' => 'Sites', 'controller' => 'Sites'));
?>
<?php $this->start('actions'); ?>
	<li><?php echo $this->CroogoHtml->link(__('New Site'), array('action' => 'add'), array('button' => 'default')); ?></li>
	<li><?php echo $this->CroogoHtml->link(__('Enable All Sites'), array('action' => 'enableAll'), array('button' => 'default'), 'Enable all sites?'); ?></li>
	<li><?php echo $this->CroogoHtml->link(__('Disable All Sites'), array('action' => 'disableAll'), array('button' => 'default'), 'Disable all sites?'); ?></li>
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
	<td><?php echo $site->id; ?>&nbsp;</td>
	<td><?php echo $site->title; ?>&nbsp;</td>
	<td><?php echo $site->theme; ?>&nbsp;</td>
	<td><?php echo $this->CroogoHtml->status($site->status); ?>&nbsp;</td>
	<td>
	<?php
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'sites', 'action' => 'edit', $site->id, '#' => 'site-domains'),
			array('icon' => 'zoom-in', 'tooltip' => __('View Domains'))
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'view', $site->id),
			array('icon' => 'eye-open', 'tooltip' => __('View'))
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'edit', $site->id),
			array('icon' => 'pencil', 'tooltip' => __('Edit'))
		);
		$actions[] = $this->Croogo->adminRowAction('', array('action' => 'delete', $site->id), array('icon' => 'trash', 'tooltip' => __('Delete')),
			__('Are you sure you want to delete # %s?', $site->id)
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'publish_nodes', $site->id),
			array('tooltip' => __('Publish All Nodes'), 'icon' => 'file'),
			__('Publish all existing published nodes to site \'%s\'?', $site->title)
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'publish_blocks', $site->id),
			array('tooltip' => __('Publish All Blocks'), 'icon' => 'columns'),
			__('Publish all existing published blocks to site \'%s\'?', $site->title)
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('action' => 'publish_links', $site->id),
			array('tooltip' => __('Publish All Links'), 'icon' => 'sitemap'),
			__('Publish all existing published links to site \'%s\'?', $site->title)
		);
		echo $this->CroogoHtml->div('item-actions', implode(' ', $actions));
	?>
	</td>
	<td>
	<?php
		if ($site->default) {
			$default = __('Yes');
		} else {
			$default = __('No').' ('.$this->CroogoHtml->link(__('Set as default'), array('controller' => 'Sites', 'action' => 'setDefault', $site->id)).')';
		}
		echo $default;
	?>
	</td>
</tr>
<?php endforeach; ?>
</table>
