<?php
defined('ROOT') OR exit('No direct script access allowed');
define('AC_FOLDER','ac_downloads/');
define('AC_DATA_FILE','download.json');

## Fonction d'installation
function ac_downloadsInstall(){
	if(!file_exists( DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE)){
		@mkdir( UPLOAD . AC_FOLDER);
		$data = array();
		util::writeJsonFile( DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE, $data);
	}
}

## Code relatif au plugin

include PLUGINS . AC_FOLDER . 'ac_downloadItem.php';
include PLUGINS . AC_FOLDER . 'ac_util.php';

class ac_downloads {
	private $items;

	public function __construct(){
		$data = array();
		if(file_exists( DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE)){
			$temp = util::readJsonFile( DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE);
			if(pluginsManager::getPluginConfVal('ac_downloads', 'order') == 'byName') $temp = util::sort2DimArray($temp, 'title', 'asc');
			elseif(pluginsManager::getPluginConfVal('ac_downloads', 'order') == 'natural') $temp = util::sort2DimArray($temp, 'id', 'asc');
			foreach($temp as $key=>$value){
				$data[] = new ac_downloadItem($value);
			}
		}
		$this->items = $data;
	}

	public function createItem($id){
		foreach($this->items as $obj){
			if($obj->getId() == $id) return $obj;
		}
		return false;
	}

	private function saveItems(){
		$data = array();
		foreach($this->items as $key=>$value){
			$data[] = array(
				'id' => $value->getId(),
				'title' => $value->getTitle(),
				'content' => $value->getContent(),
				'link' => $value->getLink()
			);
		}
		if(util::writeJsonFile(DATA_PLUGIN . AC_FOLDER . AC_DATA_FILE, $data)){
			return true;
		}
		return false;
	}

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

	public function getItems(){
		return $this->items;
	}

	public function delItem($obj){
		foreach($this->items as $key=>$value){
			if($obj->getId() == $value->getId()){
				unlink(getcwd() .'/' . $this->items[$key]->getLink());
				unset($this->items[$key]);
			}
		}
		return $this->saveItems();
	}
}