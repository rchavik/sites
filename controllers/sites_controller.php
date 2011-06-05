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
			$this->Session->setFlash(__('Invalid site', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('site', $this->Site->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Site->create();
			if ($this->Site->saveAll($this->data)) {
				$this->Session->setFlash(__('The site has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site could not be saved. Please, try again.', true));
			}
		}
		
		$this->set('title_for_layout', __('Create new Site', true));
		$this->render('admin_edit');
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid site', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Site->saveAll($this->data)) {
				$this->Session->setFlash(__('The site has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Site->read(null, $id);
		}
		
		$this->set('title_for_layout', __('Edit Site', true));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Site->delete($id)) {
			$this->Session->setFlash(__('Site deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Site was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_setdefault($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Setting default failed.', true));
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
			$this->Session->setFlash(__('Site has been set as default.', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function admin_adddomain($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('No Id has been specified!', true));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Site->SiteDomain->create();
			$this->data['domain'] = '';
			$this->data['site_id'] = $id;
			$this->Site->SiteDomain->save($this->data);
			$this->Session->setFlash(__('A new domain has been successfully added. You may now enter the desired URL.', true));
			$this->redirect(array('action' => 'edit', $id, '#site-domains'));
		}
	}
	
	function admin_deletedomain($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for site domain', true));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		if ($this->Site->SiteDomain->delete($id)) {
			$this->Session->setFlash(__('Site domain deleted', true));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		$this->Session->setFlash(__('Site domain was not deleted', true));
		$this->redirect(array('controller' => 'sites', 'action' => 'index'));
	}
	
}
