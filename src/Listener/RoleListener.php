<?php
declare(strict_types=1);

namespace App\Listener;

use Cake\Event\EventListenerInterface;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 * @property \App\Model\Table\UsersTable $Users
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class RoleListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    /**
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'Model.Roles.roleAdded' => 'newRole',
            'Model.Roles.newAudits' => 'roleChange',
        ];
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     * @return void
     */
    public function newRole($event)
    {
        /** @var \App\Model\Entity\Role $role */
        $role = $event->getData('role');

        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'ROL-' . $role->id . '-NEW']
        );
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     * @return void
     */
    public function roleChange($event)
    {
        /** @var \App\Model\Entity\Role $role */
        $role = $event->getData('role');

        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'ROL-' . $role->id . '-CNG']
        );
    }
}
