<?php

namespace Sifo\Composer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class SifoInstaller extends LibraryInstaller
{

    private static $allowedTypes = array(
        'sifo-library' => 'libs/',
        'sifo-instance' => 'instances/',
    );

    public function supports($packageType)
    {
        return in_array($packageType, array_keys(self::$allowedTypes));
    }

    protected function getPackageBasePath(PackageInterface $package)
    {
        if (!$this->supports($package->getType())) {
            throw new \InvalidArgumentException("Package type [$type] is not supported");
        }
        return self::$allowedTypes[$package->getType()] . '/' . $package->getPrettyName();
    }

}
