<?php

$this->extend('Croogo/Croogo./Common/admin_edit');

$this->CroogoHtml
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__('Extensions'), array(
		'plugin' => 'Croogo/Extensions', 'controller' => 'ExtensionsPlugins',
	))
	->addCrumb(__('Sites'), ['action' => 'index'])
	->addCrumb($site->title, ['action' => 'view', $site->id])
	;

?>
<?php $this->start('actions'); ?>
	<li><?php echo $this->CroogoHtml->link(__('Edit Site'), array('action' => 'edit', $site->id), array('icon' => 'pencil', 'button' => 'default')); ?> </li>
	<li><?php echo $this->CroogoHtml->link(__('Delete Site'), array('action' => 'delete', $site->id), array('icon' => 'trash', 'button' => 'default'), sprintf(__('Are you sure you want to delete # %s?'), $site->id)); ?> </li>
	<li><?php echo $this->CroogoHtml->link(__('List Sites'), array('action' => 'index'), array('icon' => 'list', 'button' => 'default')); ?> </li>
	<li><?php echo $this->CroogoHtml->link(__('New Site'), array('action' => 'add'), array('icon' => 'plus', 'button' => 'default')); ?> </li>
<?php $this->end(); ?>

<div class="row-fluid">
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->id; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->title; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Tagline'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->tagline; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->description; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Theme'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->theme; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Timezone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->timezone; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Locale'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->locale; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->status; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->created; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site->modified; ?>
			&nbsp;
		</dd>
	</dl>
</div>
