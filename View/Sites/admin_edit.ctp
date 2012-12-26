<?php

$this->extend('/Common/admin_edit');

?>

<?php $this->start('actions'); ?>
<?php
?>
	<?php echo $this->Html->link(__('Back'), array('action'=>'index'), array('button' => 'default')); ?>
	<?php if (isset($this->data['SiteDomain']) && count($this->data['SiteDomain']) > 0 ) : ?>
	<?php echo $this->Html->link(__('Add Domain'), array('action' => 'adddomain', $this->data['Site']['id']), array(
		'icon' => 'plus', 'button' => 'default',
	)); ?>
	<?php endif; ?>
<?php $this->end(); ?>
<style>
.input .btn {
	vertical-align: top;
}
</style>
<?php

if (!empty($this->request->query['domain_id'])) {
	$domainId = $this->request->query['domain_id'];
	$script = '$("a[href=#site-domains]").tab("show");';
	$script .= '$("input[data-domain_id=' . $domainId . ']").focus();';
	$this->Js->buffer($script);
}

?>
<?php echo $this->Form->create('Site');?>
<div class="row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
			<li><a href="#site-basic" data-toggle="tab"><?php echo __('Settings'); ?></a></li>
			<li><a href="#site-domains" data-toggle="tab"><?php echo __('Domains'); ?></a></li>
			<?php echo $this->Croogo->adminTabs(); ?>
		</ul>

		<div class="tab-content">
			<div id="site-basic" class="tab-pane">
				<?php
					$this->Form->inputDefaults(array(
						'label' => false,
						'class' => 'span10',
					));
					echo $this->Form->input('Site.id');
					echo $this->Form->input('Site.title', array(
						'placeholder' => __('Title'),
					));
					echo $this->Form->input('Site.description');
					echo $this->Form->input('Site.tagline');
					echo $this->Form->input('Site.email');
					echo $this->Form->input('Site.locale');
					echo $this->Form->input('Site.timezone');
					echo $this->Form->input('Site.theme');
				?>
			</div>

			<div id="site-domains" class="tab-pane">
			<?php
				if (isset($this->data['SiteDomain']) && count($this->data['SiteDomain']) > 0 ) {
					foreach ( $this->data['SiteDomain'] as $key => $value ) {
						if (count($this->data['SiteDomain']) > 1) {
							$after = ' ' . $this->Html->link(__('Delete'),
								array('action' => 'deletedomain', $this->data['SiteDomain'][$key]['id']),
								array('button' => 'danger')
							);
						}
						if (!isset($after)) {
							$after = '';
						}
						echo $this->Form->input('SiteDomain.' .$key . '.id');
						echo $this->Form->input('SiteDomain.' .$key . '.domain', array(
							'data-domain_id' => $this->data['SiteDomain'][$key]['id'],
							'after' => $after,
						));
					}

				} else {
					echo $this->Form->input('SiteDomain.0.id');
					echo $this->Form->input('SiteDomain.0.domain');
				}
			?>
			</div>

			<div id="site-metas" class="tab-pane">
			<?php
			?>
			</div>

			<?php echo $this->Layout->adminTabs(); ?>
		</div>
	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__('Publishing')) .
			$this->Form->button(__('Apply'), array('name' => 'apply', 'class' => 'btn')) .
			$this->Form->button(__('Save'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'cancel btn btn-danger')) .

			$this->Form->input('Site.status', array(
				'label' => __('Status'),
				'class' => false,
			));
		echo $this->Html->endBox();

		echo $this->Html->beginBox(__('Meta')) .
			$this->Form->input('SiteMeta.robots') .
			$this->Form->input('SiteMeta.keywords') .
			$this->Form->input('SiteMeta.description');
		echo $this->Html->endBox();

		echo $this->Croogo->adminBoxes();
	?>
	</div>

</div>
<?php echo $this->Form->end(); ?>