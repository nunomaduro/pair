<?php

declare(strict_types=1);

namespace Pair;

use Pair\Agents\Cline;
use Pair\Agents\Copilot;
use Pair\Agents\Cursor;
use Pair\Agents\Junie;
use Pair\Agents\Windsurf;
use Pair\Contracts\Agent;

/**
 * @internal
 */
final readonly class AgentManager
{
    /**
     * Creates a new instance of the agent manager.
     *
     * @param  array<int,class-string<Agent>>  $agents
     */
    public function __construct(
        private array $agents = [
            Cursor::class,
            Windsurf::class,
            Junie::class,
            Cline::class,
            Copilot::class,
        ]
    ) {
        //
    }

    /**
     * Returns all the agents.
     *
     * @return array<int,Agent>
     */
    public function all(): array
    {
        return array_map(
            static fn (string $agentClass): Agent => new $agentClass,
            $this->agents
        );
    }

    /**
     * Returns agents filtered by the given names.
     *
     * @param  array<int,string>  $agentNames
     * @return array<int,Agent>
     */
    public function only(array $agentNames): array
    {
        if (empty($agentNames)) {
            return $this->all();
        }

        $normalizedNames = array_map('strtolower', $agentNames);
        $filteredAgents = [];

        foreach ($this->agents as $agentClass) {
            $agentName = strtolower(basename(str_replace('\\', '/', $agentClass)));

            if (in_array($agentName, $normalizedNames, true)) {
                $filteredAgents[] = new $agentClass;
            }
        }

        return $filteredAgents;
    }

    /**
     * Returns the available agent names.
     *
     * @return array<int,string>
     */
    public function getAvailableAgentNames(): array
    {
        return array_map(
            static fn (string $agentClass): string => strtolower(basename(str_replace('\\', '/', $agentClass))),
            $this->agents
        );
    }
}
