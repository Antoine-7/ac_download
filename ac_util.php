<?php
/**
 * Created by PhpStorm.
 * User: Antoine
 * Date: 26.02.2018
 * Time: 10:30
 */

/**
 * Class ac_util
 */
class ac_util {

	/**
	 * ac_util constructor.
	 */
	public function __construct(){

	}

	/**
	 * Upload un fichier et l'enregistre dans le bon dossier. Si l'opération est un succès retourne un tableau avec le resultat de l'opération et le nom du fichier.
	 *
	 * @param $baliseName
	 * @param $dir
	 * @param array $validations
	 *
	 * @return array
	 */
	public static function uploadFile($baliseName, $dir, $validations = array()){
		if( isset($_FILES[$baliseName]) && $_FILES[$baliseName]['name'] != ''){
			$extension = mb_strtolower(util::getFileExtension($_FILES[$baliseName]['name']));
			if(isset($validations['extensions']) && !in_array($extension, $validations['extensions'])) return array('state'=>'error','value'=>'extension error');
			$size = filesize($_FILES[$baliseName]['tmp_name']);
			if(isset($validations['size']) && $size > $validations['size']) return array('state'=>'error','value'=>'size error');
			if(move_uploaded_file($_FILES[$baliseName]['tmp_name'], $dir . $_FILES[$baliseName]['name'])) {
				return array('state'=>'success','value'=>$_FILES[$baliseName]['name']);
			} else {
				return array('state'=>'error','value'=>'upload error');
			}
		}
		return array('state'=>'error','value'=>'undefined');
	}
}