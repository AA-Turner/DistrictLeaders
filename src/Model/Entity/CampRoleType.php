<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CampRoleType Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string $camp_role_type
 *
 * @property \App\Model\Entity\CampRole[] $camp_roles
 */
class CampRoleType extends Entity
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
        'created' => true,
        'modified' => true,
        'camp_role_type' => true,
        'camp_roles' => true
    ];
}
