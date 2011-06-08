<div class="sites form">
	<h2><?php echo $title_for_layout;?></h2>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('Back', true), array('action'=>'index')); ?></li>
			<?php if (isset($this->data['SiteDomain']) && count($this->data['SiteDomain']) > 0 ) : ?>
			<li><?php echo $html->link(__('Add Domain', true), array('action' => 'adddomain', $this->data['Site']['id'])); ?></li>
			<?php endif; ?>
		</ul>
	</div>

	<?php echo $form->create('Site');?>
	<fieldset>
		<div class="tabs">
			<ul>
				<li><a href="#site-basic"><span><?php __('Settings'); ?></span></a></li>
				<li><a href="#site-domains"><span><?php __('Domains'); ?></span></a></li>
				<?php echo $layout->adminTabs(); ?>
			</ul>

			<div id="site-basic">
				<?php
					echo $form->input('Site.id');
					echo $form->input('Site.title');
					echo $form->input('Site.description');
					echo $form->input('Site.tagline');
					echo $form->input('Site.email');
					echo $form->input('Site.locale');
					echo $form->input('Site.timezone');
					echo $form->input('Site.theme');
					echo $form->input('Site.status');
				?>
			</div>

			<div id="site-domains">
			<?php
				if (isset($this->data['SiteDomain']) && count($this->data['SiteDomain']) > 0 ) {
					//$amount_of_domains = count($this->data['SiteDomain']);
					foreach ( $this->data['SiteDomain'] as $key => $value ) {
						echo $form->input('SiteDomain.'.$key.'.id');
						echo $form->input('SiteDomain.'.$key.'.domain');
						if (count($this->data['SiteDomain']) > 1) {
							echo $html->link(__('Delete', true), array('action' => 'deletedomain', $this->data['SiteDomain'][$key]['id']));
						}
					}

				} else {
					echo $form->input('SiteDomain.0.id');
					echo $form->input('SiteDomain.0.domain');
				}
			?>
			</div>
			<?php echo $layout->adminTabs(); ?>
		</div>
	</fieldset>
	<?php echo $form->end('Submit');?>

</div>