<?php

declare(strict_types=1);

use Symfony\Component\Filesystem\Filesystem;

pest()->beforeEach(function (): void {
    $filesystem = new Filesystem;
    $filesystem->remove(
        dirname(__DIR__, 2).'/Playground/.ai',
    );
});
