<?php

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__('Extensions'), array(
		'plugin' => 'extensions', 'controller' => 'extensions_plugins',
	))
	->addCrumb(__('Sites'), array('controller' => 'sites', 'action' => 'index'))
	->addCrumb($site['Site']['title'], $this->here)
	;

?>
<?php $this->start('actions'); ?>
	<li><?php echo $this->Html->link(__('Edit Site'), array('action' => 'edit', $site['Site']['id']), array('icon' => 'pencil', 'button' => 'default')); ?> </li>
	<li><?php echo $this->Html->link(__('Delete Site'), array('action' => 'delete', $site['Site']['id']), array('icon' => 'trash', 'button' => 'default'), sprintf(__('Are you sure you want to delete # %s?'), $site['Site']['id'])); ?> </li>
	<li><?php echo $this->Html->link(__('List Sites'), array('action' => 'index'), array('icon' => 'list', 'button' => 'default')); ?> </li>
	<li><?php echo $this->Html->link(__('New Site'), array('action' => 'add'), array('icon' => 'plus', 'button' => 'default')); ?> </li>
<?php $this->end(); ?>

<div class="row-fluid">
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['id']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['title']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Tagline'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['tagline']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Theme'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['theme']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Timezone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['timezone']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Locale'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['locale']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['status']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
