<?php
/**
 * Created by PhpStorm.
 * User: Antoine
 * Date: 27.02.2018
 * Time: 11:57
 */

/**
 * Class ac_downloadsSection
 */
class ac_downloadsSection {
	private $id;
	private $title;
	private $sortNumber;

	/**
	 * ac_downloadsSection constructor.
	 *
	 * @param array $data
	 */
	public function __construct($data = array()){
		if(count($data) > 0){
			$this->id         = $data['id'];
			$this->title      = $data['title'];
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
	 * Retourne l'ordre de tri.
	 *
	 * @return mixed
	 */
	public function getSortNumber(){
		return $this->sortNumber;
	}
}