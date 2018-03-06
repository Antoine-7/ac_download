<?php
/**
 * Created by PhpStorm.
 * User: Antoine
 * Date: 20.02.2018
 * Time: 11:27
 */

/**
 * Class ac_downloadItem
 */
class ac_downloadItem {
	private $id;
	private $title;
	private $section;
	private $content;
	private $link;
	private $sortNumber;

	/**
	 * ac_downloadItem constructor.
	 *
	 * @param array $data
	 */
	public function __construct($data = array()){
		if(count($data) > 0){
			$this->id = $data['id'];
			$this->title = $data['title'];
			$this->section = $data['section'];
			$this->content = $data['content'];
			$this->link = $data['link'];
			$this->sortNumber = $data['sortNumber'];
		}
	}

	/**
	 * Enregistre un ID.
	 *
	 * @param $val
	 */
	public function setId($val){
		$this->id = $val;
	}

	/**
	 * Enregistre un titre.
	 *
	 * @param $val
	 */
	public function setTitle($val){
		$val = trim($val);
		if($val == '') $val = $core->lang("News unnamed");
		$this->title = $val;
	}

	/**
	 * Enregistre le nom de la section séléctionnée.
	 *
	 * @param $val
	 */
	public function setSection($val) {
		$this->section = $val;
	}

	/**
	 * Enregistre le texte de description du lien.
	 *
	 * @param $val
	 */
	public function setContent($val){
		$this->content = strip_tags(trim($val));
	}

	/**
	 * Enregistre le lien.
	 *
	 * @param $val
	 */
	public function setLink($val){
		$this->link = trim($val);
	}

	/**
	 * Enregistre le numéro de tri.
	 *
	 * @param $val
	 */
	public function setSortNumber($val){
		if(is_numeric($val)) $this->sortNumber = $val;
	}

	/**
	 * Retourne l'ID.
	 *
	 * @return mixed
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * Retourne le titre.
	 *
	 * @return mixed
	 */
	public function getTitle(){
		return $this->title;
	}

	/**
	 * Retourne la section associée.
	 *
	 * @return mixed
	 */
	public function getSection(){
		return $this->section;
	}

	/**
	 * Retourne le texte de description du lien.
	 *
	 * @return mixed
	 */
	public function getContent(){
		return $this->content;
	}

	/**
	 * Retourne le lien.
	 *
	 * @return mixed
	 */
	public function getLink(){
		return $this->link;
	}

	/**
	 * Retourne l'ordre de tri.
	 *
	 * @return mixed
	 */
	public function getSortNumber() {
		return $this->sortNumber;
	}
}