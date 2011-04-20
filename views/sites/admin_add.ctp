<div class="sites form">
<?php echo $this->Form->create('Site');?>
	<fieldset>
		<legend><?php __('Add Site'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Sites', true), array('action' => 'index'));?></li>
	</ul>
</div>