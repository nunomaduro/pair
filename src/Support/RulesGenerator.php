<?php

declare(strict_types=1);

namespace Pair\Support;

use Pair\Contracts\Agent;
use Symfony\Component\Filesystem\Filesystem;

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
        $filesystem = new Filesystem;
        $filesystem->remove($base = ($path.'/'.$agent->baseFolder()));

        $filesystem->mkdir($base, 0755);

        $defaultsDir = dirname(__DIR__, 2).'/defaults';

        $filesystem->copy($defaultsDir, $base);
    }
}
