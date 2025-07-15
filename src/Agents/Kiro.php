<?php

declare(strict_types=1);

namespace Pair\Agents;

use Pair\Contracts\Agent;

/**
 * @internal
 */
final class Kiro implements Agent
{
    /**
     * Returns the base folder for the agent.
     */
    public function baseFolder(): string
    {
        return '.kiro/steering';
    }
}
