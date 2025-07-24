<?php

declare(strict_types=1);

namespace Pair\Console\Commands;

use Pair\AgentManager;
use Pair\Agents\Copilot;
use Pair\Support\Filesystem;
use Pair\Support\Project;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function Termwind\render;
use function Termwind\renderUsing;

/**
 * @internal
 */
#[AsCommand(name: 'install')]
final class InstallCommand extends Command
{
    /**
     * Executes the command.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        renderUsing($output);

        /** @var string $path */
        $path = $input->getOption('path') ?: Project::fromEnv()->path();

        $this->ensureAiFolderExists($input, $path);
        $this->ensureAgentsFoldersAreIgnored($path);

        return Command::SUCCESS;
    }

    /**
     * Configures the current command.
     */
    protected function configure(): void
    {
        $this
            ->addOption('path', null, InputOption::VALUE_REQUIRED, 'The path to the project')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force the installation, overwriting existing files');
    }

    /**
     * Ensures that the `.ai` folder exists in the specified path.
     */
    private function ensureAiFolderExists(InputInterface $input, string $path): void
    {
        $aiFolder = $path.'/.ai';

        if (file_exists($aiFolder) && ! $input->getOption('force')) {
            render(
                <<<'HTML'
                <div>
                    <span>
                    The [.ai] folder already exists. You may use the [--force] option to overwrite it.
                    </span>
                </div>
                HTML,
            );

            return;
        }

        if (file_exists($aiFolder)) {
            Filesystem::truncateDirectory($aiFolder);
        } else {
            Filesystem::createDirectory($aiFolder);
        }

        $defaultFolder = dirname(__DIR__, 3).'/defaults';

        Filesystem::copyDirectoryFiles($defaultFolder, $aiFolder);
    }

    /**
     * Ensures that `.junie`, `.cursor`, etc, folders are ignored in the `.gitignore` file.
     */
    private function ensureAgentsFoldersAreIgnored(string $path): void
    {
        $gitignorePath = $path.'/.gitignore';

        if (! file_exists($gitignorePath)) {
            return;
        }

        if (($gitignoreContent = file_get_contents($gitignorePath)) === false) {
            return;
        }

        foreach ((new AgentManager)->all() as $agent) {
            $baseFolder = $agent->baseFolder();

            if (str_contains($gitignoreContent, $baseFolder)) {
                continue;
            }

            $gitignoreContent .= "{$baseFolder}\n";
        }

        file_put_contents($gitignorePath, $gitignoreContent);
    }
}
