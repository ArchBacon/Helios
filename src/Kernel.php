<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function __construct(string $environment, bool $debug)
    {
        parent::__construct($environment, $debug);

        $filePath = realpath(glob('build/messageBox*.js')[0]);
        $contents = file_get_contents($filePath);
        $contents = str_replace('PHP_REPLACE_HOST', $_SERVER['HTTP_HOST'], $contents);
        file_put_contents($filePath, $contents);
        copy($filePath, 'build/messageBox.js');
    }
}
