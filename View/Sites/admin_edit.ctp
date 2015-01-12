<?php

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__('Extensions'), array(
		'plugin' => 'extensions', 'controller' => 'extensions_plugins',
	))
	->addCrumb(__('Sites'), array('controller' => 'sites', 'action' => 'index'))
	;

if (!empty($this->data['Site']['id'])) {
	$crumb = $this->data['Site']['title'];
} else {
	$crumb = __('Add');
}
$this->Html->addCrumb($crumb, $this->here);

$this->start('actions');

	echo $this->Croogo->adminAction(__('Back'), array('action'=>'index'));
	if (isset($this->data['SiteDomain']) && count($this->data['SiteDomain']) > 0):
		echo $this->Croogo->adminAction(__('Add Domain'), array('action' => 'adddomain', $this->data['Site']['id']), array(
		'icon' => 'plus',
	));
	endif;
$this->end();

if (!empty($this->request->query['domain_id'])):
	$domainId = $this->request->query['domain_id'];
	$script = '$("a[href=#site-domains]").tab("show");';
	$script .= '$("input[data-domain_id=' . $domainId . ']").focus();';
	$this->Js->buffer($script);
endif;

$this->append('form-start',  $this->Form->create('Site'));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__('Settings'), '#site-basic');
	echo $this->Croogo->adminTab(__('URL Prefix'), '#site-prefix');
	echo $this->Croogo->adminTab(__('Domains'), '#site-domains');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

	echo $this->Html->tabStart('site-basic') .
		$this->Form->input('Site.id') .
		$this->Form->input('Site.title', array(
			'placeholder' => __('Title'),
		)) .
		$this->Form->input('Site.description') .
		$this->Form->input('Site.tagline') .
		$this->Form->input('Site.email') .
		$this->Form->input('Site.locale') .
		$this->Form->input('Site.timezone') .
		$this->Form->input('Site.theme') .
		$this->Form->input('Site.home_url');
	echo $this->Html->tabEnd();

	echo $this->Html->tabStart('site-prefix') .
		$this->Form->input('Site.url_prefix', array(
			'placeholder' => __('URL Prefix'),
			'help' => 'Simple Regex expression for URL Prefix to identify a site (without leading/terminating slash)',
		));
	echo $this->Html->tabEnd();

	echo $this->Html->tabStart('site-domains');
		if (isset($this->data['SiteDomain']) && count($this->data['SiteDomain']) > 0):
			foreach ($this->data['SiteDomain'] as $key => $value):
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
			endforeach;

		else:
			echo $this->Form->input('SiteDomain.0.id');
			echo $this->Form->input('SiteDomain.0.domain');
		endif;
	echo $this->Html->tabEnd();

	echo $this->Layout->adminTabs();
$this->end();

$this->start('panels');
	echo $this->Html->beginBox(__('Publishing')) .
		$this->Form->button(__('Apply'), array('name' => 'apply')) .
		$this->Form->button(__('Save'), array('button' => 'primary')) .
		$this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'cancel', 'button' => 'danger')) .

		$this->Form->input('Site.status', array(
			'label' => __('Status'),
			'class' => false,
		));
	echo $this->Html->endBox();

	echo $this->Html->beginBox(__('Meta')) .
		$this->Form->input('SiteMeta.robots', array(
			'tooltip' => 'Robots',
		)) .
		$this->Form->input('SiteMeta.keywords', array(
			'tooltip' => 'Keywords',
		)) .
		$this->Form->input('SiteMeta.description', array(
			'tooltip' => 'Description',
		));
	echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());