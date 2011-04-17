<div class="siteDomains form">
<?php echo $this->Form->create('SiteDomain');?>
	<fieldset>
		<legend><?php __('Edit Domain'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('site_id');
		echo $this->Form->input('domain');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('SiteDomain.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('SiteDomain.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Domains', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Sites', true), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Site', true), array('controller' => 'sites', 'action' => 'add')); ?> </li>
	</ul>
</div>