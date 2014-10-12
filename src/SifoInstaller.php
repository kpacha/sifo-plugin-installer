<?php

namespace Sifo\Composer;

use Composer\Installers\BaseInstaller;

class SifoInstaller extends BaseInstaller
{
    protected $locations = array(
        'library' => 'libs/{$name}/',
        'instance' => 'instances/{$name}/',
    );
}
