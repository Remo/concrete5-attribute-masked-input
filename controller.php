<?php

namespace Concrete\Package\AttributeMaskedInput;

use Concrete\Core\Backup\ContentImporter;
use Package;

class Controller extends Package
{

    protected $pkgHandle = 'attribute_masked_input';
    protected $appVersionRequired = '5.7.4';
    protected $pkgVersion = '1.0.0';
    protected $pkgThemeHandle = 'attribute_masked_input';

    public function getPackageName()
    {
        return t('Masked text attribute');
    }

    public function getPackageDescription()
    {
        return t('Installs a text attribute where you can specify an input mask');
    }

    protected function installXmlContent()
    {
        $pkg = Package::getByHandle($this->pkgHandle);

        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/install.xml');
    }

    public function install()
    {
        $pkg = parent::install();

        $this->installXmlContent();
    }

    public function upgrade()
    {
        parent::upgrade();

        $this->installXmlContent();
    }

}
