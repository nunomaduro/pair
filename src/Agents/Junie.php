<?php

declare(strict_types=1);

namespace Pair\Agents;

use Pair\Contracts\Agent;

/**
 * @internal
 */
final class Junie implements Agent
{
    /**
     * Returns the base folder for the agent.
     */
    public function baseFolder(): string
    {
        return '.junie';
    }

    /**
     * Returns the file extension that this agent expects.
     */
    public function fileExtension(): string
    {
        return 'mdc';
    }

    /**
     * Returns the target filename for a given source file.
     */
    public function getTargetFilename(string $sourceFile): string
    {
        $basename = pathinfo($sourceFile, PATHINFO_FILENAME);
        return $basename . '.' . $this->fileExtension();
    }
}
