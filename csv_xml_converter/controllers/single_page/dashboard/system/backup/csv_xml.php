<?php
namespace  Concrete\Package\CsvXmlConverter\Controller\SinglePage\Dashboard\System\Backup;

use Core;
use File;
use Concrete\Core\File\Importer as FileImporter;
use Concrete\Block\Content\Controller as ContentBlockController;

class CsvXml extends \Concrete\Core\Page\Controller\DashboardPageController {

    const PREFIX_PAGE   = 'page_';
    const PREFIX_ATTR   = 'attr_';
    const PREFIX_FILE   = 'file_';
    const PREFIX_SELECT = 'select_';
    const PREFIX_BLOCK  = 'block_';

    public function convert() {
        if ($this->token->validate("convert")) {
            $valn = Core::make('helper/validation/numbers');
            $fi = new FileImporter();

            // File validation
            $fID = $this->post('fID');
            if (!$valn->integer($fID)) {
                $this->error->add($fi->getErrorMessage(FileImporter::E_FILE_INVALID));
            } else {
                $f = File::getByID($fID);
                if ($f->isError()) {
                    $this->error->add($fi->getErrorMessage(FileImporter::E_FILE_INVALID));
                } else {
                    $fsr = $f->getFileResource();
                    if (!$fsr->isFile()) {
                        $this->error->add($fi->getErrorMessage(FileImporter::E_FILE_INVALID));
                    }
                }
            }

            if (!$this->error->has() && is_object($fsr)) {
                // Parse the csv file
                $csv = new \parseCSV();
                $csv->file_data = $fsr->read();
                $csv->auto();
                $this->set('csv', $csv);

                // Make a xml element
                $xml = new \SimpleXMLElement('<concrete5-cif version="1.0"></concrete5-cif>');
                $pages = $xml->addChild("pages");

                foreach ($csv->data as $r) {

                    // Import the page data
                    $p = $pages->addChild('page');

                    foreach ($r as $k => $v) {
                        if (substr($k, 0, strlen(self::PREFIX_PAGE)) == self::PREFIX_PAGE) {
                            $key = substr($k, strlen(self::PREFIX_PAGE));
                            $p->addAttribute($key, h($v));
                        }
                    }
                    if (!isset($p['pagetype']) || empty($p['pagetype'])) {
                        throw new \Exception(t('page_pagetype is required.'));
                    }
                    if (!isset($p['template']) || empty($p['template'])) {
                        throw new \Exception(t('template is required.'));
                    }
                    if (empty($p['path']) && !empty($p['name'])) {
                        $p->addAttribute('path', '/' . Core::make('helper/text')->urlify($p['name']));
                    }

                    // Import the attribute data for the page
                    $attributes = $p->addChild('attributes');

                    foreach ($r as $k => $v) {
                        if (substr($k, 0, strlen(self::PREFIX_ATTR)) == self::PREFIX_ATTR) {
                            $key = substr($k, strlen(self::PREFIX_ATTR));
                            $ak = $attributes->addChild('attributekey');

                            // File type attribute
                            if (substr($key, 0, strlen(self::PREFIX_FILE)) == self::PREFIX_FILE) {
                                $ak->addAttribute('handle', substr($key, strlen(self::PREFIX_FILE)));
                                $cnode = $ak->addChild('value');
                                $cnode->addChild('fID', '{ccm:export:file:' . $v . '}');
                            // Select type attribute
                            } elseif (substr($key, 0, strlen(self::PREFIX_SELECT)) == self::PREFIX_SELECT) {
                                $ak->addAttribute('handle', substr($key, strlen(self::PREFIX_SELECT)));
                                $cnode = $ak->addChild('value');
                                $options = explode('//', $v);
                                foreach ($options as $value) {
                                    $cnode->addChild('option', (string) $value);
                                }
                            // Other type attribute
                            } else {
                                $ak->addAttribute('handle', $key);
                                $cnode = $ak->addChild('value');
                                $node = dom_import_simplexml($cnode);
                                $no = $node->ownerDocument;
                                $cdata = $no->createCDATASection($v);
                                $node->appendChild($cdata);
                            }
                        }
                    }

                    // Import the block data for the page
                    foreach ($r as $k => $v) {
                        if (substr($k, 0, strlen(self::PREFIX_BLOCK)) == self::PREFIX_BLOCK && !empty($v)) {

                            // Get the key
                            $key = substr($k, strlen(self::PREFIX_BLOCK));

                            // Split the key to Area//BlockType
                            $key = explode('/', $key);
                            if (isset($key[1])) {
                                $area = $p->addChild('area');
                                $area->addAttribute('name', $key[0]);

                                // Now supports Content block only.
                                if ($key[1] == 'content') {
                                    $block = $area->addChild('block');
                                    $block->addAttribute('type', $key[1]);

                                    $btInstance = new ContentBlockController();
                                    $btInstance->content = $v;
                                    $btInstance->export($block);
                                }
                            }
                        }
                    }
                }

                $this->set('xml', $xml);
                $this->set('f', $f);

                // Download the converted XML file
                $output = $xml->asXML();
                $downloadfile = Core::make('helper/file')->getTemporaryDirectory() . '/content_' . time() . '.xml';
                @file_put_contents($downloadfile, $output);
                if (file_exists($downloadfile)) {
                    Core::make('helper/file')->forceDownload($downloadfile);
                    @unlink($downloadfile);
                } else {
                    throw new \Exception(t('Unable to create temporary xml file: %s', $file));
                }
            }
        } else {
            $this->error->add($this->token->getErrorMessage());
        }
    }

}
