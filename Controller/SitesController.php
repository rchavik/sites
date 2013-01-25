<?php

App::uses('SitesAppController', 'Sites.Controller');

class SitesController extends SitesAppController {

	public $name = 'Sites';

	public $uses = array('Sites.Site');

	public $helpers = array(
		'Sites.Sites',
	);

	public function admin_index() {
		$this->set('sites', $this->paginate());
	}

	public function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid site'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('site', $this->Site->read(null, $id));
	}

	public function admin_add() {
		if (!empty($this->request->data)) {
			$this->Site->create();
			if ($this->Site->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The site has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site could not be saved. Please, try again.'));
			}
		}

		$this->set('title_for_layout', __('Create new Site'));
		$this->render('admin_edit');
	}

	public function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid site'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Site->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The site has been saved'));
				$this->Croogo->redirect(array('action' => 'edit', $this->Site->id));
			} else {
				$this->Session->setFlash(__('The site could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->Site->contain(array('SiteDomain', 'SiteMeta'));
			$this->request->data = $this->Site->read(null, $id);
		}

		$this->set('title_for_layout', __('Edit Site'));
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Site->delete($id)) {
			$this->Session->setFlash(__('Site deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Site was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function admin_setdefault($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Setting default failed.'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->request->data = $this->Site->find('all') ;
			foreach ($this->request->data as $key => $site) {
				if ($site['Site']['id'] == $id) {
					$this->request->data[$key]['Site']['default'] = 1;
				} else {
					$this->request->data[$key]['Site']['default'] = 0;
				}
			}
			$this->Site->saveAll($this->request->data);
			$this->Session->setFlash(__('Site has been set as default.'));
			$this->redirect(array('action' => 'index'));
		}
	}

	public function admin_adddomain($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('No Id has been specified!'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Site->SiteDomain->create();
			$this->request->data['domain'] = '';
			$this->request->data['site_id'] = $id;
			unset($this->Site->SiteDomain->validate['domain']);
			$this->Site->SiteDomain->save($this->request->data);
			$this->Session->setFlash(__('A new domain has been successfully added. You may now enter the desired URL.'));
			$this->redirect(array('action' => 'edit', $id, '?' => array(
				'domain_id' => $this->Site->SiteDomain->id
				)
			));
		}
	}

	public function admin_deletedomain($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site domain'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		if ($this->Site->SiteDomain->delete($id)) {
			$this->Session->setFlash(__('Site domain deleted'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		$this->Session->setFlash(__('Site domain was not deleted'));
		$this->redirect(array('controller' => 'sites', 'action' => 'index'));
	}

	public function admin_publish_nodes($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		if ($this->Site->publish_all($id, $this->Site->Node)) {
			$this->Session->setFlash(__('All nodes has been published for this site %d', $id), 'default', array('class' => 'success'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		$this->Session->setFlash(__('Unable to publish existing nodes'));
		$this->redirect(array('controller' => 'sites', 'action' => 'index'));
	}

	public function admin_publish_blocks($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		if ($this->Site->publish_all($id, $this->Site->Block)) {
			$this->Session->setFlash(__('All blocks has been published for this site %d', $id), 'default', array('class' => 'success'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		$this->Session->setFlash(__('Unable to publish existing blocks'));
		$this->redirect(array('controller' => 'sites', 'action' => 'index'));
	}

	public function admin_publish_links($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		if ($this->Site->publish_all($id, $this->Site->Link)) {
			$this->Session->setFlash(__('All links has been published for this site %d', $id), 'default', array('class' => 'success'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		$this->Session->setFlash(__('Unable to publish existing links'));
		$this->redirect(array('controller' => 'sites', 'action' => 'index'));
	}

	public function _writeSetting($value) {
		$this->Site->updateAll(array('status' => $value));
		$this->loadModel('Settings.Setting');
		$this->Setting->write('Site.status', $value);
	}

	public function admin_enable() {
		$this->_writeSetting(1);
		$this->redirect(array('action' => 'index', 'admin' => true));
	}

	public function admin_disable() {
		$this->_writeSetting(0);
		$this->redirect(array('action' => 'index', 'admin' => true));
	}

}
