<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

/**
 * Capabilities Controller
 *
 * @property \App\Model\Table\CapabilitiesTable $Capabilities
 * @method \App\Model\Entity\Capability[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CapabilitiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $capabilities = $this->paginate($this->Capabilities);

        $this->set(compact('capabilities'));
    }

    /**
     * View method
     *
     * @param int|null $id Capability id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $capability = $this->Capabilities->get($id, [
            'contain' => ['RoleTypes'],
        ]);

        $this->set('capability', $capability);
    }

    /**
     * View method
     *
     * @param int|null $userId User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function permissions($userId = null)
    {
        $user = $this->Capabilities->RoleTypes->Roles->Users->get($userId);
        $this->set('user', $user);

        $capabilities = $this->Capabilities->enrichUserCapability($user->capabilities);

        foreach ($capabilities as $key => $array) {
            if (strstr($key, '.')) {
                $keyArray = explode('.', $key);
                if (strstr($key, 'Group')) {
                    $group = $this->Capabilities->RoleTypes->Roles->Sections->ScoutGroups->get($keyArray[1]);
                    $capabilities[$key]['object'] = $group;
                }
                if (strstr($key, 'Section')) {
                    $section = $this->Capabilities->RoleTypes->Roles->Sections->get($keyArray[1]);
                    $capabilities[$key]['object'] = $section;
                }
            }
            $array = [];
        }
        $this->set('capabilities', $capabilities);

        $models = Configure::read('allModels');
        ksort($models);
        $this->set('models', $models);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $capability = $this->Capabilities->newEmptyEntity();
        if ($this->request->is('post')) {
            $capability = $this->Capabilities->patchEntity($capability, $this->request->getData());
            if ($this->Capabilities->save($capability)) {
                $this->Flash->success(__('The capability has been saved.'));

                return $this->redirect(['action' => 'view', $capability->get('id')]);
            }
            $this->Flash->error(__('The capability could not be saved. Please, try again.'));
        }
        $this->set(compact('capability'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Capability id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $capability = $this->Capabilities->get($id, [
            'contain' => ['RoleTypes'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $capability = $this->Capabilities->patchEntity($capability, $this->request->getData());
            if ($this->Capabilities->save($capability)) {
                $this->Flash->success(__('The capability has been saved.'));

                return $this->redirect(['action' => 'view', $capability->get('id')]);
            }
            $this->Flash->error(__('The capability could not be saved. Please, try again.'));
        }
        $roleTypes = $this->Capabilities->RoleTypes->find('list', [
            'conditions' => [
                'level >=' => $capability->min_level,
            ],
            'keyField' => 'id',
            'valueField' => 'role_abbreviation',
            'groupField' => 'level',
        ]);
        $this->set(compact('capability', 'roleTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Capability id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $capability = $this->Capabilities->get($id);
        if ($this->Capabilities->delete($capability)) {
            $this->Flash->success(__('The capability has been deleted.'));
        } else {
            $this->Flash->error(__('The capability could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
