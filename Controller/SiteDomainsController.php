<?php

App::uses('SitesAppController', 'Sites.Controller');

class SiteDomainsController extends SitesAppController {

	public function admin_index() {
		$this->SiteDomain->recursive = 0;

		if (!empty($this->params['pass'][0])) {
			$this->paginate = array(
				'conditions' => array(
					'Site.id' => $this->params['pass'][0],
					),
				);
		}
		$this->set('siteDomains', $this->paginate());
	}

	public function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid site domain'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('siteDomain', $this->SiteDomain->read(null, $id));
	}

	public function admin_add() {
		if (!empty($this->request->data)) {
			$this->SiteDomain->create();
			if ($this->SiteDomain->save($this->request->data)) {
				$this->Session->setFlash(__('The site domain has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site domain could not be saved. Please, try again.'));
			}
		}
		$selected = isset($this->params['pass'][0]) ? $this->params['pass'][0] : array();

		$options = array(
			'conditions' => array(
				//'Site.id >' => Sites::ALL_SITES,
			),
		);
		if (!empty($selected)) {
			$options = Set::merge($options, array(
				'conditions' => array('Site.id' => $selected)
				)
			);
		}
		$sites = $this->SiteDomain->Site->find('list', $options);
		$this->set(compact('sites', 'selected'));
	}

	public function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid site domain'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->SiteDomain->save($this->request->data)) {
				$this->Session->setFlash(__('The site domain has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site domain could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->SiteDomain->read(null, $id);
		}
		$options = array(
			'conditions' => array(
				//'Site.id >' => Sites::ALL_SITES,
			),
		);
		$sites = $this->SiteDomain->Site->find('list', $options);
		$this->set(compact('sites'));
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site domain'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		if ($this->SiteDomain->delete($id)) {
			$this->Session->setFlash(__('Site domain deleted'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		$this->Session->setFlash(__('Site domain was not deleted'));
		$this->redirect(array('controller' => 'sites', 'action' => 'index'));
	}
}
