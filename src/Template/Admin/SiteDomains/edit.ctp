<div class="siteDomains form">
<?php echo $this->Form->create('SiteDomain');?>
	<fieldset>
		<legend><?php echo __('Edit Domain'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('site_id');
		echo $this->Form->input('domain');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('SiteDomain.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('SiteDomain.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Domains'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Sites'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Site'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
	</ul>
</div>