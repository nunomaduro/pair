<?php

declare(strict_types=1);

namespace Pair\Support;

use Pair\Contracts\Agent;

/**
 * @internal
 */
final readonly class RulesGenerator
{
    /**
     * Generates rules for the given agent.
     */
    public static function generate(Agent $agent, string $path): void
    {
        Filesystem::remove(
            $base = ($path.'/'.$agent->baseFolder()),
        );

        mkdir($base, 0755, true);

        $aiDir = $path.'/.ai';
        $defaultsDir = dirname(__DIR__, 2).'/defaults';
        $sourceDir = is_dir($aiDir) && !empty(glob($aiDir.'/*')) ? $aiDir : $defaultsDir;

        Filesystem::copyDirectoryFilesForAgent($sourceDir, $base, $agent);
    }
}
