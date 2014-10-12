<?php

namespace Sifo\Composer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

class Installer extends LibraryInstaller
{

    const SUPPORTED_TYPE_PREFIX = "sifo";

    public function getInstallPath(PackageInterface $package)
    {
        if (!$this->isPackageTypeSupported($package->getType())) {
            throw new \InvalidArgumentException(
                    'Sorry the package type of this package is not yet supported.'
            );
        }

        return $this->getInstallerInstance($package)->getInstallPath($package, self::SUPPORTED_TYPE_PREFIX);
    }

    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if (!$repo->hasPackage($package)) {
            throw new \InvalidArgumentException('Package is not installed: ' . $package);
        }

        $repo->removePackage($package);

        $installPath = $this->getInstallPath($package);
        $this->io->write(sprintf('Deleting %s - %s', $installPath,
                        $this->filesystem->removeDirectory($installPath) ? '<comment>deleted</comment>' : '<error>not deleted</error>'));
    }

    public function supports($packageType)
    {
        if (!$this->isPackageTypeSupported($packageType)) {
            return false;
        }

        $locationPattern = $this->getLocationPattern();

        return preg_match('#' . self::SUPPORTED_TYPE_PREFIX . '-' . $locationPattern . '#', $packageType, $matches) === 1;
    }

    private function isPackageTypeSupported($type)
    {
        return self::SUPPORTED_TYPE_PREFIX === substr($type, 0, strlen(self::SUPPORTED_TYPE_PREFIX));
    }

    private function getInstallerInstance(PackageInterface $package = null)
    {
        return new SifoInstaller($package, $this->composer);
    }

    private function getLocationPattern()
    {
        $installer = $this->getInstallerInstance(null);
        $locations = array_keys($installer->getLocations());
        $pattern = $locations ? '(' . implode('|', $locations) . ')' : false;

        return $pattern ? : '(\w+)';
    }

}
