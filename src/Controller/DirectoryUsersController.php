<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DirectoryUser;
/**
 * DirectoryUsers Controller
 *
 * @property \App\Model\Table\DirectoryUsersTable $DirectoryUsers
 *
 * @method \App\Model\Entity\DirectoryUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DirectoryUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Directories'],
        ];
        $directoryUsers = $this->paginate($this->DirectoryUsers);

        $this->set(compact('directoryUsers'));
    }

    /**
     * View method
     *
     * @param string|null $DirectoryUserId Directory User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $directoryUser = $this->DirectoryUsers->get($id, [
            'contain' => ['Directories'],
        ]);

        $this->set('directoryUser', $directoryUser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $directoryUser = $this->DirectoryUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $directoryUser = $this->DirectoryUsers->patchEntity($directoryUser, $this->request->getData());
            if ($this->DirectoryUsers->save($directoryUser)) {
                $this->Flash->success(__('The directory user has been saved.'));

                return $this->redirect(['action' => 'view', $directoryUser->get(DirectoryUser::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory user could not be saved. Please, try again.'));
        }
        $directories = $this->DirectoryUsers->Directories->find('list', ['limit' => 200]);
        $this->set(compact('directoryUser', 'directories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Directory User id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $directoryUser = $this->DirectoryUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $directoryUser = $this->DirectoryUsers->patchEntity($directoryUser, $this->request->getData());
            if ($this->DirectoryUsers->save($directoryUser)) {
                $this->Flash->success(__('The directory user has been saved.'));

                return $this->redirect(['action' => 'view', $directoryUser->get(DirectoryUser::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory user could not be saved. Please, try again.'));
        }
        $directories = $this->DirectoryUsers->Directories->find('list', ['limit' => 200]);
        $this->set(compact('directoryUser', 'directories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Directory User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $directoryUser = $this->DirectoryUsers->get($id);
        if ($this->DirectoryUsers->delete($directoryUser)) {
            $this->Flash->success(__('The directory user has been deleted.'));
        } else {
            $this->Flash->error(__('The directory user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
