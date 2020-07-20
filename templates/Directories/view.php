<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Directory $directory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Directory'), ['action' => 'edit', $directory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Directory'), ['action' => 'delete', $directory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Directories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Directory Types'), ['controller' => 'DirectoryTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory Type'), ['controller' => 'DirectoryTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Directory Domains'), ['controller' => 'DirectoryDomains', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory Domain'), ['controller' => 'DirectoryDomains', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Directory Groups'), ['controller' => 'DirectoryGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory Group'), ['controller' => 'DirectoryGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Directory Users'), ['controller' => 'DirectoryUsers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory User'), ['controller' => 'DirectoryUsers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="directories view large-9 medium-8 columns content">
    <h3><?= h($directory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Directory') ?></th>
            <td><?= h($directory->directory) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Configuration Payload') ?></th>
            <td><?= h($directory->configuration_payload) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Directory Type') ?></th>
            <td><?= $directory->has('directory_type') ? $this->Html->link($directory->directory_type->id, ['controller' => 'DirectoryTypes', 'action' => 'view', $directory->directory_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer Reference') ?></th>
            <td><?= h($directory->customer_reference) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($directory->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $directory->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Directory Domains') ?></h4>
        <?php if (!empty($directory->directory_domains)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Directory Domain') ?></th>
                <th scope="col"><?= __('Directory Id') ?></th>
                <th scope="col"><?= __('Ingest') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($directory->directory_domains as $directoryDomains): ?>
            <tr>
                <td><?= h($directoryDomains->id) ?></td>
                <td><?= h($directoryDomains->directory_domain) ?></td>
                <td><?= h($directoryDomains->directory_id) ?></td>
                <td><?= h($directoryDomains->ingest) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DirectoryDomains', 'action' => 'view', $directoryDomains->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DirectoryDomains', 'action' => 'edit', $directoryDomains->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DirectoryDomains', 'action' => 'delete', $directoryDomains->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryDomains->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Directory Groups') ?></h4>
        <?php if (!empty($directory->directory_groups)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Directory Id') ?></th>
                <th scope="col"><?= __('Directory Group Name') ?></th>
                <th scope="col"><?= __('Directory Group Email') ?></th>
                <th scope="col"><?= __('Directory Group Reference') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($directory->directory_groups as $directoryGroups): ?>
            <tr>
                <td><?= h($directoryGroups->id) ?></td>
                <td><?= h($directoryGroups->directory_id) ?></td>
                <td><?= h($directoryGroups->directory_group_name) ?></td>
                <td><?= h($directoryGroups->directory_group_email) ?></td>
                <td><?= h($directoryGroups->directory_group_reference) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DirectoryGroups', 'action' => 'view', $directoryGroups->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DirectoryGroups', 'action' => 'edit', $directoryGroups->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DirectoryGroups', 'action' => 'delete', $directoryGroups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryGroups->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Directory Users') ?></h4>
        <?php if (!empty($directory->directory_users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Directory Id') ?></th>
                <th scope="col"><?= __('Directory User Reference') ?></th>
                <th scope="col"><?= __('Given Name') ?></th>
                <th scope="col"><?= __('Family Name') ?></th>
                <th scope="col"><?= __('Primary Email') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($directory->directory_users as $directoryUsers): ?>
            <tr>
                <td><?= h($directoryUsers->id) ?></td>
                <td><?= h($directoryUsers->directory_id) ?></td>
                <td><?= h($directoryUsers->directory_user_reference) ?></td>
                <td><?= h($directoryUsers->given_name) ?></td>
                <td><?= h($directoryUsers->family_name) ?></td>
                <td><?= h($directoryUsers->primary_email) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DirectoryUsers', 'action' => 'view', $directoryUsers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DirectoryUsers', 'action' => 'edit', $directoryUsers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DirectoryUsers', 'action' => 'delete', $directoryUsers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryUsers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
