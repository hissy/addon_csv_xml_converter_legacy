<?php

defined('C5_EXECUTE') or die(_("Access Denied."));

class CsvXmlConverterPackage extends Package {

    protected $pkgHandle = 'csv_xml_converter';
    protected $appVersionRequired = '5.6.2';
    protected $pkgVersion = '0.1';
    
    public function getPackageName() {
        return t('CSV to XML Converter');
    }
    
    public function getPackageDescription() {
        return t('Export page structure as importable XML (CIF) file from CSV file.');
    }

    public function install() {
        $pkg = parent::install();
        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/config/install.xml');
    }

}
