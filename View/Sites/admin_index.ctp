<div class="sites index">
	<h2><?php echo __('Sites');?></h2>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Site'), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('Enable All Sites'), array('action' => 'enable'), null, 'Enable all sites?'); ?></li>
			<li><?php echo $this->Html->link(__('Disable All Sites'), array('action' => 'disable'), null, 'Disable all sites?'); ?></li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
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
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $site['Site']['id']; ?>&nbsp;</td>
		<td><?php echo $site['Site']['title']; ?>&nbsp;</td>
		<td><?php echo $site['Site']['theme']; ?>&nbsp;</td>
		<td><?php echo $site['Site']['status']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View Domains'), array('controller' => 'sites', 'action' => 'edit', $site['Site']['id'], '#site-domains')); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $site['Site']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $site['Site']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $site['Site']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $site['Site']['id'])); ?>
			<?php echo $this->Html->link(__('Publish All Nodes'), array('action' => 'publish_nodes', $site['Site']['id']), null, sprintf(__('Publish all existing published nodes to site "%s"?'), $site['Site']['title'])); ?>
			<?php echo $this->Html->link(__('Publish All Blocks'), array('action' => 'publish_blocks', $site['Site']['id']), null, sprintf(__('Publish all existing published blocks to site "%s"?'), $site['Site']['title'])); ?>
			<?php echo $this->Html->link(__('Publish All Links'), array('action' => 'publish_links', $site['Site']['id']), null, sprintf(__('Publish all existing published links to site "%s"?'), $site['Site']['title'])); ?>
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
</div>

<div class="paging"><?php echo $this->Paginator->numbers(); ?></div>
<div class="counter"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'))); ?></div>
