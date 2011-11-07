<?php
class SitesController extends SitesAppController {

	var $name = 'Sites';

	var $helpers = array(
		'Sites.Sites',
		);

	function admin_index() {
		$this->Site->recursive = 0;
		$this->set('sites', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid site'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('site', $this->Site->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Site->create();
			if ($this->Site->saveAll($this->data)) {
				$this->Session->setFlash(__('The site has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site could not be saved. Please, try again.'));
			}
		}

		$this->set('title_for_layout', __('Create new Site'));
		$this->render('admin_edit');
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid site'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Site->saveAll($this->data)) {
				$this->Session->setFlash(__('The site has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site could not be saved. Please, try again.'));
			}
		}
		if (empty($this->data)) {
			$this->Site->contain('SiteDomain');
			$this->data = $this->Site->read(null, $id);
		}

		$this->set('title_for_layout', __('Edit Site'));
	}

	function admin_delete($id = null) {
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

	function admin_setdefault($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Setting default failed.'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->data = $this->Site->find('all') ;
			foreach ($this->data as $key => $site) {
				if ($site['Site']['id'] == $id) {
					$this->data[$key]['Site']['default'] = 1;
				} else {
					$this->data[$key]['Site']['default'] = 0;
				}
			}
			$this->Site->saveAll($this->data);
			$this->Session->setFlash(__('Site has been set as default.'));
			$this->redirect(array('action' => 'index'));
		}
	}

	function admin_adddomain($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('No Id has been specified!'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Site->update($this->data);
			$this->Site->SiteDomain->create();
			$this->data['domain'] = '';
			$this->data['site_id'] = $id;
			$this->Site->SiteDomain->save($this->data);
			$this->Session->setFlash(__('A new domain has been successfully added. You may now enter the desired URL.'));
			$this->redirect(array('action' => 'edit', $id, '#site-domains'));
		}
	}

	function admin_deletedomain($id = null) {
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

	function admin_publish_nodes($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		if ($this->Site->publish_all($id, $this->Site->Node)) {
			$this->Session->setFlash(__('All nodes has been published for this site %d', $id));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		$this->Session->setFlash(__('Unable to publish existing nodes'));
		$this->redirect(array('controller' => 'sites', 'action' => 'index'));
	}

	function _writeSetting($value) {
		$this->Site->updateAll(array('status' => $value));
		$this->loadModel('Setting');
		$this->Setting->write('Site.status', $value);
	}

	function admin_enable() {
		$this->_writeSetting(true);
		$this->redirect(array('action' => 'index', 'admin' => true));
	}

	function admin_disable() {
		$this->_writeSetting(false);
		$this->redirect(array('action' => 'index', 'admin' => true));
	}

}
