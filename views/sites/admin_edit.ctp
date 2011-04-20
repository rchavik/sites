<div class="sites form">
<?php echo $this->Form->create('Site');?>
	<fieldset>
		<legend><?php __('Edit Site'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('tagline');
		echo $this->Form->input('email');
		echo $this->Form->input('locale');
		echo $this->Form->input('timezone');
		echo $this->Form->input('theme');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Site.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Site.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sites', true), array('action' => 'index'));?></li>
	</ul>
</div>