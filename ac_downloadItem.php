<?php
/**
 * Created by PhpStorm.
 * User: Antoine
 * Date: 20.02.2018
 * Time: 11:27
 */
class ac_downloadItem {
	private $id;
	private $title;
	private $content;
	private $link;

	public function __construct($data = array()){
		if(count($data) > 0){
			$this->id = $data['id'];
			$this->title = $data['title'];
			$this->content = $data['content'];
			$this->link = $data['link'];
		}
	}

	public function setId($val){
		$this->id = $val;
	}

	public function setTitle($val){
		$val = trim($val);
		if($val == '') $val = $core->lang("News unnamed");
		$this->title = $val;
	}

	public function setContent($val){
		$this->content = strip_tags(trim($val));
	}

	public function setLink($val){
		$this->link = trim($val);
	}

	public function getId(){
		return $this->id;
	}

	public function getTitle(){
		return $this->title;
	}

	public function getContent(){
		return $this->content;
	}

	public function getLink(){
		return $this->link;
	}
}