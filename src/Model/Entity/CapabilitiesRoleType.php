<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CapabilitiesRoleType Entity
 *
 * @property int $capability_id
 * @property int $role_type_id
 *
 * @property \App\Model\Entity\Capability $capability
 * @property \App\Model\Entity\RoleType $role_type
 */
class CapabilitiesRoleType extends Entity
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
        'capability' => true,
        'role_type' => true
    ];

    public const FIELD_CAPABILITY_ID = 'capability_id';
    public const FIELD_ROLE_TYPE_ID = 'role_type_id';
    public const FIELD_CAPABILITY = 'capability';
    public const FIELD_ROLE_TYPE = 'role_type';
}