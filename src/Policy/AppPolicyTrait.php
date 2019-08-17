<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @since         3.7.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Policy;

/**
 * A trait intended to make application tests of your controllers easier.
 */
trait AppPolicyTrait
{
    /**
     * @param \App\Model\Entity\User $user Identity object.
     * @param mixed $resource The resource being operated on.
     * @param string $action The action/operation being performed.
     *
     * @return bool|void
     */
    public function before($user, $resource, $action)
    {
        if (is_null($user)) {
            return false;
        }

        if ($user->checkCapability('ALL')) {
            return true;
        }
        // fall through
    }
}
