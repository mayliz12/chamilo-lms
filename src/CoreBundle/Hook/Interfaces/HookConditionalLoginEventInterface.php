<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Hook\Interfaces;

/**
 * Interface HookConditionalLoginEventInterface.
 *
 * @package Chamilo\CoreBundle\Hook\Interfaces
 */
interface HookConditionalLoginEventInterface extends HookEventInterface
{
    /**
     * Call Conditional Login hooks.
     */
    public function notifyConditionalLogin(): array;
}
