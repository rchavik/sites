<?php

$this->extend('Croogo/Croogo./Common/admin_edit');


$this->CroogoHtml
	->addCrumb('', '/admin', ['icon' => 'home'])
	->addCrumb(__('Extensions'), [
		'plugin' => 'Croogo/Extensions', 'controller' => 'ExtensionsPlugins',
    ])
	->addCrumb(__('Sites'), ['controller' => 'Sites', 'action' => 'index'])
	;

if ($site->title) {
	$crumb = $site->title;
} else {
	$crumb = __('Add');
}
$this->CroogoHtml->addCrumb($crumb, ['action' => 'add']);

?>

<?php $this->start('actions'); ?>
<?php
?>
	<?php echo $this->CroogoHtml->link(__('Back'), array('action'=>'index'), array('button' => 'default')); ?>
	<?php if (isset($site->site_domains) && count($site->site_domains) > 0 ) : ?>
	<?php echo $this->CroogoHtml->link(__('Add Domain'), array('action' => 'adddomain', $site->id), array(
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
<?php echo $this->CroogoForm->create($site);?>
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
					$this->CroogoForm->templates(array(
						'class' => 'span10',
						'placeholder' => true,
					));
					echo $this->CroogoForm->input('id');
					echo $this->CroogoForm->input('title', array(
						'placeholder' => __('Title'),
					));
					echo $this->CroogoForm->input('description');
					echo $this->CroogoForm->input('tagline');
					echo $this->CroogoForm->input('email');
					echo $this->CroogoForm->input('locale');
					echo $this->CroogoForm->input('timezone');
					echo $this->CroogoForm->input('theme');
				?>
			</div>

			<div id="site-domains" class="tab-pane">
			<?php
				if (isset($site->site_domains) && count($site->site_domains) > 0 ) {
					foreach ( $site->site_domains as $key => $value ) {
						if (count($site->site_domains) > 1) {
							$after = ' ' . $this->CroogoHtml->link(__('Delete'),
								array('action' => 'deletedomain', $site->site_domains[$key]->id),
								array('button' => 'danger')
							);
						}
						if (!isset($after)) {
							$after = '';
						}
						echo $this->CroogoForm->input('site_domains.' .$key . '.id');
						echo $this->CroogoForm->input('site_domains.' .$key . '.domain', array(
							'data-domain_id' => $site->site_domains[$key]->id,
							'after' => $after,
						));
					}

				} else {
					echo $this->CroogoForm->input('SiteDomain.0.id');
					echo $this->CroogoForm->input('SiteDomain.0.domain');
				}
			?>
			</div>

			<?php echo $this->Croogo->adminTabs();; ?>
		</div>
	</div>

	<div class="span4">
	<?php
		echo $this->CroogoHtml->beginBox(__('Publishing')) .
			$this->CroogoForm->button(__('Apply'), array('name' => 'apply', 'class' => 'btn')) .
			$this->CroogoForm->button(__('Save'), array('class' => 'btn btn-primary')) .
			$this->CroogoHtml->link(__('Cancel'), array('action' => 'index'), array('class' => 'cancel btn btn-danger')) .

			$this->CroogoForm->input('status', array(
				'label' => __('Status'),
				'class' => false,
			));
		echo $this->CroogoHtml->endBox();

		echo $this->CroogoHtml->beginBox(__('Meta')) .
			$this->CroogoForm->input('SiteMeta.robots', array(
				'tooltip' => 'Robots',
			)) .
			$this->CroogoForm->input('SiteMeta.keywords', array(
				'tooltip' => 'Keywords',
			)) .
			$this->CroogoForm->input('SiteMeta.description', array(
				'tooltip' => 'Description',
			));
		echo $this->CroogoHtml->endBox();

		echo $this->Croogo->adminBoxes();
	?>
	</div>

</div>
<?php echo $this->CroogoForm->end(); ?>
