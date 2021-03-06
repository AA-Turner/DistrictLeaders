<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotificationType Entity
 *
 * @property int $id
 * @property string|null $notification_type
 * @property string|null $notification_description
 * @property string|null $icon
 * @property string $type_code
 *
 * @property \App\Model\Entity\Notification[] $notifications
 */
class NotificationType extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'notification_type' => true,
        'notification_description' => true,
        'icon' => true,
        'type_code' => true,
        'notifications' => true,
    ];

    public const FIELD_ID = 'id';
    public const FIELD_NOTIFICATION_TYPE = 'notification_type';
    public const FIELD_NOTIFICATION_DESCRIPTION = 'notification_description';
    public const FIELD_ICON = 'icon';
    public const FIELD_TYPE_CODE = 'type_code';
    public const FIELD_NOTIFICATIONS = 'notifications';
}
