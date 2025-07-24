<?php

declare(strict_types=1);

namespace Pair\Contracts;

/**
 * @internal
 */
interface Agent
{
    /**
     * Returns the base folder for the agent.
     */
    public function baseFolder(): string;

    /**
     * Returns the file extension that this agent expects.
     */
    public function fileExtension(): string;

    /**
     * Returns the target filename for a given source file.
     */
    public function getTargetFilename(string $sourceFile): string;
}
