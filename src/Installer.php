<?php

namespace Sifo\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Installer implements PluginInterface
{

    public function activate(Composer $composer, IOInterface $io)
    {
        $customInstaller = new SifoInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($customInstaller);
    }

}
