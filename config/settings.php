<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2019-01-03
 * Time: 20:55
 */

return [

    'notificationTypes' => [
        [
            'notification_type' => 'Generic',
            'notification_description' => 'Generic Notification.',
            'icon' => 'fa-envelope',
            'type_code' => 'GEN-NOT',
        ],
        [
            'notification_type' => 'Welcome',
            'notification_description' => 'Welcome to the System Email & Notification.',
            'icon' => 'fa-user',
            'type_code' => 'USR-NEW',
        ],
        [
            'notification_type' => 'Password Reset',
            'notification_description' => 'A password reset password has been triggered.',
            'icon' => 'fa-unlock',
            'type_code' => 'USR-PWD',
        ],
        [
            'notification_type' => 'New Payment Received',
            'notification_description' => 'Notification that a payment has been recorded by an administrator.',
            'icon' => 'fa-receipt',
            'type_code' => 'INV-PAY',
        ],
        [
            'notification_type' => 'Surcharge Added',
            'notification_description' => 'A Payment Surcharge was added to the Invoice.',
            'icon' => 'fa-tag',
            'type_code' => 'INV-SUR',
        ],
        [
            'notification_type' => 'Outstanding Balance',
            'notification_description' => 'Balance Outstanding on Invoice',
            'icon' => 'fa-clock',
            'type_code' => 'INV-OUT',
        ],
        [
            'notification_type' => 'Invoice Attached',
            'notification_description' => 'Invoice is attached to the email.',
            'icon' => 'fa-paperclip',
            'type_code' => 'INV-ATC',
        ],
        [
            'notification_type' => 'Deposit Outstanding',
            'notification_description' => 'Notification of an Invoice where the deposit is past due.',
            'icon' => 'fa-clock',
            'type_code' => 'INV-DEP',
        ],
    ]
];
