<?php
defined('C5_EXECUTE') or die("Access Denied.");

class DashboardSystemBackupRestoreCsvXmlController extends DashboardBaseController {
	
	const PREFIX_PAGE   = 'page_';
	const PREFIX_ATTR   = 'attr_';
	const PREFIX_FILE   = 'file_';
	const PREFIX_SELECT = 'select_';
	
	public function convert() {
		if ($this->token->validate("convert")) {
			$valn = Loader::helper('validation/numbers');
			
			$fID = $this->post('fID');
			if (!$valn->integer($fID)) {
				$this->error->add(t('Invalid file.'));
			} else {
				$f = File::getByID($fID);
				if ($f->isError()) {
					$this->error->add(t('Invalid file.'));
				}
			}
			
			if (!$this->error->has()) {
				Loader::library('3rdparty/parsecsv.lib', 'csv_xml_converter');
				
				$path = $f->getPath();
				$csv = new parseCSV();
				$csv->auto($path);
				$this->set('csv', $csv);
				
				$xml = new SimpleXMLElement('<concrete5-cif version="1.0"></concrete5-cif>');
				$pages = $xml->addChild("pages");
				
				foreach ($csv->data as $r) {
					$p = $pages->addChild('page');
					
					foreach ($r as $k => $v) {
						if (substr($k, 0, strlen(self::PREFIX_PAGE)) == self::PREFIX_PAGE) {
							$key = substr($k, strlen(self::PREFIX_PAGE));
							$p->addAttribute($key, h($v));
						}
					}
					if (empty($p['path']) && !empty($p['name'])) {
						$p->addAttribute('path', '/' . Loader::helper('text')->urlify($p['name']));
					}
					
					$attributes = $p->addChild('attributes');
					
					foreach ($r as $k => $v) {
						$k = (string) $k;
						$v = (string) $v;
						
						if (substr($k, 0, strlen(self::PREFIX_ATTR)) == self::PREFIX_ATTR) {
							$key = substr($k, strlen(self::PREFIX_ATTR));
							$ak = $attributes->addChild('attributekey');
							
							if (substr($key, 0, strlen(self::PREFIX_FILE)) == self::PREFIX_FILE) {
								$ak->addAttribute('handle', substr($key, strlen(self::PREFIX_FILE)));
								$cnode = $ak->addChild('value');
								$cnode->addChild('fID', '{ccm:export:file:' . $v . '}');
							} elseif (substr($key, 0, strlen(self::PREFIX_SELECT)) == self::PREFIX_SELECT) {
								$ak->addAttribute('handle', substr($key, strlen(self::PREFIX_SELECT)));
								$cnode = $ak->addChild('value');
								$cnode->option = $v;
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
				}
				
				$this->set('xml', $xml);
				$this->set('f', $f);
				
				$output = $xml->asXML();
				$downloadfile = Loader::helper('file')->getTemporaryDirectory() . '/content_' . time() . '.xml';
				@file_put_contents($downloadfile, $output);
				if (file_exists($downloadfile)) {
					Loader::helper('file')->forceDownload($downloadfile);
					@unlink($downloadfile);
				} else {
					throw new Exception(t('Unable to create temporary xml file: %s', $file));
				}
			}
		} else {
			$this->error->add($this->token->getErrorMessage());
		}
	}
	
}
