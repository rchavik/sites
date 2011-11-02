<div class="siteDomains form">
<?php echo $this->Form->create('SiteDomain');?>
	<fieldset>
		<legend><?php echo __('Add Domain'); ?></legend>
	<?php
		echo $this->Form->input('site_id', array('selected' => $selected));
		echo $this->Form->input('domain');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Domains'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Sites'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Site'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
	</ul>
</div>