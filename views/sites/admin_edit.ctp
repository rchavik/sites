<div class="sites form">
	<h2><?php echo $title_for_layout;?></h2>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Back', true), array('action'=>'index')); ?></li>
			<?php if (isset($this->data['SiteDomain']) && count($this->data['SiteDomain']) > 0 ) : ?>
			<li><?php echo $this->Html->link(__('Add Domain', true), array('action' => 'adddomain', $this->data['Site']['id'])); ?></li>
			<?php endif; ?>
		</ul>
	</div>

	<?php echo $this->Form->create('Site');?>
	<fieldset>
		<div class="tabs">
			<ul>
				<li><a href="#site-basic"><span><?php __('Settings'); ?></span></a></li>
				<li><a href="#site-domains"><span><?php __('Domains'); ?></span></a></li>
				<?php echo $this->Layout->adminTabs(); ?>
			</ul>

			<div id="site-basic">
				<?php
					echo $this->Form->input('Site.id');
					echo $this->Form->input('Site.title');
					echo $this->Form->input('Site.description');
					echo $this->Form->input('Site.tagline');
					echo $this->Form->input('Site.email');
					echo $this->Form->input('Site.locale');
					echo $this->Form->input('Site.timezone');
					echo $this->Form->input('Site.theme');
					echo $this->Form->input('Site.status');
				?>
			</div>

			<div id="site-domains">
			<?php
				if (isset($this->data['SiteDomain']) && count($this->data['SiteDomain']) > 0 ) {
					//$amount_of_domains = count($this->data['SiteDomain']);
					foreach ( $this->data['SiteDomain'] as $key => $value ) {
						echo $this->Form->input('SiteDomain.'.$key.'.id');
						echo $this->Form->input('SiteDomain.'.$key.'.domain');
						if (count($this->data['SiteDomain']) > 1) {
							echo $this->Html->link(__('Delete', true), array('action' => 'deletedomain', $this->data['SiteDomain'][$key]['id']));
						}
					}

				} else {
					echo $this->Form->input('SiteDomain.0.id');
					echo $this->Form->input('SiteDomain.0.domain');
				}
			?>
			</div>
			<?php echo $this->Layout->adminTabs(); ?>
		</div>
	</fieldset>
	<?php echo $this->Form->end('Submit');?>

</div>