<?php
defined('ROOT') OR exit('No direct script access allowed');
define('AC_FOLDER','ac_downloads/');
define('AC_DATA_FILE','download.json');
define('AC_SECTION_FILE','sections.json');

## Fonction d'installation
function ac_downloadsInstall(){
	if(!file_exists( DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE)){
		@mkdir( UPLOAD . AC_FOLDER);
		$data = array();
		util::writeJsonFile( DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE, $data);
	}
}

## Code relatif au plugin
/**
 * Import des class pour les items et les sections, ainsi qu'une class utilitaire.
 */
include PLUGINS . AC_FOLDER . 'ac_downloadItem.php';
include PLUGINS . AC_FOLDER . 'ac_downloadsSection.php';
include PLUGINS . AC_FOLDER . 'ac_util.php';

/**
 * Class ac_downloads
 *
 * Class principal
 */
class ac_downloads {
	private $items;
	private $sections;

	/**
	 * ac_downloads constructor.
	 *
	 * Initialise la class et charge en mémoires les données.
	 */
	public function __construct(){
		$sectionData = array();
		$linkData = array();

		if(file_exists( DATA_PLUGIN . AC_FOLDER . AC_SECTION_FILE)){
			$temp = util::readJsonFile( DATA_PLUGIN . AC_FOLDER . AC_SECTION_FILE);
			if(pluginsManager::getPluginConfVal('ac_downloads', 'order') == 'byName') $temp = util::sort2DimArray($temp, 'title', 'asc');
			elseif(pluginsManager::getPluginConfVal('ac_downloads', 'order') == 'natural') $temp = util::sort2DimArray($temp, 'order', 'asc');
			elseif(pluginsManager::getPluginConfVal('ac_downloads', 'order') == 'order') $temp = util::sort2DimArray($temp, 'sortNumber', 'num');
			foreach($temp as $key=>$value){
				$sectionData[] = new ac_downloadsSection($value);
			}
		}
		$this->sections = $sectionData;

		if(file_exists( DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE)){
			$temp = util::readJsonFile( DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE);
			$this->addSectionsOrder($temp, $this->sectionOrder());
			if(pluginsManager::getPluginConfVal('ac_downloads', 'order') == 'byName') {
				array_multisort(array_column($temp, "section"),SORT_ASC, array_column($temp,'title'),SORT_ASC, $temp);
			}
			elseif(pluginsManager::getPluginConfVal('ac_downloads', 'order') == 'natural') {
				array_multisort(array_column($temp, "section"),SORT_ASC, array_column($temp,'id'),SORT_ASC, $temp);
			}
			elseif(pluginsManager::getPluginConfVal('ac_downloads', 'order') == 'order') {
				array_multisort(array_column($temp, "sectionOrder"),SORT_NUMERIC, array_column($temp,'sortNumber'),SORT_NUMERIC, $temp);
				//var_dump($temp);
			}
			foreach($temp as $key=>$value){
				$linkData[] = new ac_downloadItem($value);
			}
		}
		$this->items = $linkData;
	}

	/**
	 * Ajoute les paramètres pour le tri des sections dans les données des liens.
	 *
	 * @param $data
	 * @param $sections
	 */
	private function addSectionsOrder(&$data, $sections) {
		foreach ($data as $key => $row) {
			$data[$key]['sectionOrder'] = $sections[$row['section']];
		}
	}

	/**
	 * Prépare un tableau pour ajouter les informations de tri des section dans les données des liens.
	 *
	 * @return array
	 */
	private function sectionOrder(){
		$sort = array();
		foreach ($this->sections as $key=>$obj){
			$sort[$obj->getTitle()] = $key;;
		}
		$sort[''] = sizeof($sort);
		return $sort;
	}

	/**
	 * créer un item.
	 *
	 * @param $id
	 *
	 * @return bool|mixed
	 */
	public function createItem($id){
		foreach($this->items as $obj){
			if($obj->getId() == $id) return $obj;
		}
		return false;
	}

	/**
	 * Enregistre les items dans le fichier JSON
	 *
	 * @return bool
	 */
	private function saveItems(){
		$data = array();
		foreach($this->items as $key=>$value){
			$data[] = array(
				'id' => $value->getId(),
				'title' => $value->getTitle(),
				'section' => $value->getSection(),
				'content' => $value->getContent(),
				'link' => $value->getLink(),
				'sortNumber' => $value->getSortNumber()
			);
		}
		if(util::writeJsonFile(DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE, $data)){
			return true;
		}
		return false;
	}

	/**
	 * Enregistre les items en mémoire et lance la fonction saveItems.
	 *
	 * @param $obj
	 *
	 * @return bool
	 */
	public function saveItem($obj){
		$id = $obj->getId();
		if($id == ''){
			$obj->setId(uniqid());
			$upload = ac_util::uploadFile('file', UPLOAD . AC_FOLDER);
			if($upload['state'] == 'success'){
				$obj->setLink(UPLOAD . AC_FOLDER . $upload['value']);
			}
			$this->items[] = $obj;
		}
		else{
			foreach($this->items as $key=>$value){
				if($id == $value->getId()){
					$upload = ac_util::uploadFile('file', UPLOAD . AC_FOLDER);
					if($upload['state'] == 'success'){
						if($obj->getLink() != '') unlink(getcwd() .'/' . $obj->getLink());
						$obj->setLink(UPLOAD . AC_FOLDER . $upload['value']);
					}
					$this->items[$key] = $obj;
				}
			}
		}
		return $this->saveItems();
	}

	/**
	 * Retourne la liste des items.
	 *
	 * @return array
	 */
	public function getItems(){
		return $this->items;
	}

	/**
	 * Supprime un item en mémoire et lance fonction saveItems.
	 *
	 * @param $obj
	 *
	 * @return bool
	 */
	public function delItem($obj){
		foreach($this->items as $key=>$value){
			if($obj->getId() == $value->getId()){
				unlink(getcwd() .'/' . $this->items[$key]->getLink());
				unset($this->items[$key]);
			}
		}
		return $this->saveItems();
	}

	/**
	 * Créer une section.
	 *
	 * @param $id
	 *
	 * @return bool|mixed
	 */
	public function createSection($id){
		foreach($this->sections as $obj){
			if($obj->getId() == $id) return $obj;
		}
		return false;
	}

	/**
	 * Enregistre les sections dans le fichier JSON
	 *
	 * @return bool
	 */
	private function saveSections(){
		$data = array();
		foreach($this->sections as $key=>$value){
			$data[] = array(
				'id' => $value->getId(),
				'title' => $value->getTitle(),
				'sortNumber' => $value->getSortNumber(),
			);
		}
		if(util::writeJsonFile(DATA_PLUGIN . AC_FOLDER . AC_SECTION_FILE, $data)){
			return true;
		}
		return false;
	}

	/**
	 * Enregistre les sections en mémoire et lance la fonction saveSections.
	 *
	 * @param $obj
	 *
	 * @return bool
	 */
	public function saveSection($obj){
		$id = $obj->getId();
		if($id == ''){
			$obj->setId(uniqid());
			$this->sections[] = $obj;
		}
		else{
			foreach($this->sections as $key=>$value){
				if($id == $value->getId()){
					$this->sections[$key] = $obj;
				}
			}
		}
		return $this->saveSections();
	}

	/**
	 * Retourne les sections.
	 *
	 * @return array
	 */
	public function getSections(){
		return $this->sections;
	}

	/**
	 * Supprime une section en mémoire et lance la function saveSections.
	 *
	 * @param $obj
	 *
	 * @return bool
	 */
	public function delSection($obj){
		foreach($this->sections as $key=>$value){
			if($obj->getId() == $value->getId()){
				unset($this->sections[$key]);
			}
		}
		return $this->saveSections();
	}
}