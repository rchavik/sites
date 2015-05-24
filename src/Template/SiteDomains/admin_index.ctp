<div class="siteDomains index">
	<h2><?php echo __('Domains');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('site_id');?></th>
			<th><?php echo $this->Paginator->sort('domain');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($siteDomains as $siteDomain):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $siteDomain['SiteDomain']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($siteDomain['Site']['title'], array('controller' => 'sites', 'action' => 'view', $siteDomain['Site']['id'])); ?>
		</td>
		<td><?php echo $siteDomain['SiteDomain']['domain']; ?>&nbsp;</td>
		<td><?php echo $siteDomain['SiteDomain']['created']; ?>&nbsp;</td>
		<td><?php echo $siteDomain['SiteDomain']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $siteDomain['SiteDomain']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $siteDomain['SiteDomain']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $siteDomain['SiteDomain']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $siteDomain['SiteDomain']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Domain'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Sites'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Site'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
	</ul>
</div>