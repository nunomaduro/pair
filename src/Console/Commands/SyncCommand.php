<?php

declare(strict_types=1);

namespace Pair\Console\Commands;

use Pair\AgentManager;
use Pair\Support\Project;
use Pair\Support\RulesGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function Termwind\renderUsing;

/**
 * @internal
 */
#[AsCommand(name: 'sync')]
final class SyncCommand extends Command
{
    /**
     * Executes the command.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        renderUsing($output);

        /** @var string $path */
        $path = $input->getOption('path') ?: Project::fromEnv()->path();

        $this->ensureAgentsRulesAreSynced($input, $path);

        return Command::SUCCESS;
    }

    /**
     * Configures the current command.
     */
    protected function configure(): void
    {
        $this
            ->addOption('path', null, InputOption::VALUE_REQUIRED, 'The path to the project')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force the installation, overwriting existing files')
            ->addOption('agents', 'a', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Target specific agents (e.g., cursor, junie, copilot)');
    }

    /**
     * Ensures that the agents rules are synced in the specified path.
     */
    private function ensureAgentsRulesAreSynced(InputInterface $input, string $path): void
    {
        $agentManager = new AgentManager;

        /** @var array<int,string> $targetAgents */
        $targetAgents = $input->getOption('agents') ?? [];

        $agents = empty($targetAgents) ? $agentManager->all() : $agentManager->only($targetAgents);

        if (empty($agents) && !empty($targetAgents)) {
            $availableAgents = implode(', ', $agentManager->getAvailableAgentNames());
            throw new \InvalidArgumentException(
                "No valid agents found. Available agents: {$availableAgents}"
            );
        }

        foreach ($agents as $agent) {
            RulesGenerator::generate($agent, $path);
        }
    }
}
