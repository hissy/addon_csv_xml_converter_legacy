<?php
namespace Concrete\Package\CsvXmlConverter;

use Concrete\Core\Backup\ContentImporter;

class Controller extends \Concrete\Core\Package\Package
{
    protected $pkgHandle = 'csv_xml_converter';
    protected $appVersionRequired = '5.7.4';
    protected $pkgVersion = '0.1';

    public function getPackageName()
    {
        return t('CSV to XML Converter');
    }

    public function getPackageDescription()
    {
        return t('Export page structure as importable XML (CIF) file from CSV file.');
    }

    public function install()
    {
        $pkg = parent::install();
        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/config/install.xml');
    }

    public function on_start()
    {
        $this->registerAutoload();
    }

    protected function registerAutoload()
    {
        require_once(__DIR__ . '/vendor/autoload.php');
    }

}
