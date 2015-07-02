<?php

namespace Sites\Controller\Admin;

use Croogo\Croogo\Controller\CroogoAppController;
use Sites\Model\Table\SitesTable;
use Cake\ORM\TableRegistry;

/**
 * @property SitesTable Sites
 */
class SitesController extends CroogoAppController {

    public function index() {
        $this->set('sites', $this->paginate());
    }

    public function view($id = null) {
        $site = $this->Sites->get($id);

        $this->set('site', $site);
    }

    public function add() {
        $site = $this->Sites->newEntity();

        if ($this->request->is('post')) {
            $site = $this->Sites->patchEntity($site, $this->request->data);

            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved'));

                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }

        $this->set(compact('site'));

        $this->set('title_for_layout', __('Create new Site'));
    }

    public function edit($id = null) {
        $site = $this->Sites->get($id, [
            'contain' => ['SiteDomains', 'SiteMetas']
        ]);

        if ($this->request->is('put')) {
            $site = $this->Sites->patchEntity($site, $this->request->data);

            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved'));

                return $this->Croogo->redirect(array('action' => 'edit', $site->id));
            }

            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }

        $this->set(compact('site'));
    }

    public function delete($id = null) {
        $site = $this->Sites->get($id);

        if (!$this->Sites->delete($site)) {
            $this->Flash->error(__('Site was not deleted'));

            return $this->redirect(array('action' => 'index'));
        }

        $this->Flash->success(__('Site deleted'));

        return $this->redirect(array('action' => 'index'));
    }

    public function setDefault($id = null) {
        $site = $this->Sites->get($id);

        $this->Sites->setDefault($site);

        $this->Flash->success(__('Site has been set as default.'));
        $this->redirect(array('action' => 'index'));
    }

    public function adddomain($id = null) {
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

    public function deletedomain($id = null) {
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

    public function publishNodes($id = null) {
        $site = $this->Sites->get($id);

        if (!$this->Sites->publishAll($site, $this->Sites->Nodes)) {
            $this->Flash->error(__('Unable to publish existing nodes'));

            return $this->redirect(array('action' => 'index'));
        }

        $this->Flash->success(__('All nodes has been published for this site {0}', $site->title));

        return $this->redirect(array('action' => 'index'));
    }

    public function publishBlocks($id = null) {
        $site = $this->Sites->get($id);

        if (!$this->Sites->publishAll($site, $this->Sites->Blocks)) {
            $this->Flash->error(__('Unable to publish existing blocks'));

            return $this->redirect(array('action' => 'index'));
        }

        $this->Flash->success(__('All blocks has been published for this site {0}', $site->title));

        return $this->redirect(array('action' => 'index'));
    }

    public function publish_links($id = null) {
        $site = $this->Sites->get($id);

        if (!$this->Sites->publishAll($site, $this->Sites->Links)) {
            $this->Flash->error(__('Unable to publish existing links'));

            return $this->redirect(array('action' => 'index'));
        }

        $this->Flash->success(__('All links has been published for this site {0}', $site->title));

        return $this->redirect(array('action' => 'index'));
    }

    public function _writeSetting($value) {
        $this->Site->updateAll(array('status' => $value));
        $this->loadModel('Settings.Setting');
        $this->Setting->write('Site.status', $value);
    }

    public function enableAll() {
        $this->Sites->enableAll();

        TableRegistry::get('Croogo/Settings.Settings')->write('Site.status', true);

        $this->redirect(array('action' => 'index'));
    }

    public function disableAll() {
        $this->Sites->disableAll();

        TableRegistry::get('Croogo/Settings.Settings')->write('Site.status', false);

        $this->redirect(array('action' => 'index'));
    }

}
