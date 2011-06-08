<div class="sites index">
	<h2><?php __('Sites');?></h2>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Site', true), array('action' => 'add')); ?></li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('theme');?></th>
			<th><?php __('Actions');?></th>
			<th><?php __('Default');?></th>
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
		<td class="actions">
			<?php echo $this->Html->link(__('View Domains', true), array('controller' => 'sites', 'action' => 'edit', $site['Site']['id'], '#site-domains')); ?>
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $site['Site']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $site['Site']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $site['Site']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $site['Site']['id'])); ?>
		</td>
		<td>
			<?php
			if ($site['Site']['default'] == 1) {
				$default = __('Yes', true);
			} else {
				$default = __('No', true).' ('.$html->link(__('Set as default', true), array('controller' => 'sites', 'action' => 'setdefault', $site['Site']['id'])).')';
			}
			echo $default;
			?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>

<div class="paging"><?php echo $paginator->numbers(); ?></div>
<div class="counter"><?php echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?></div>
