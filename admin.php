<?php
defined('ROOT') OR exit('No direct script access allowed');

$action = (isset($_GET['action'])) ? $_GET['action'] : '';
$download = new ac_downloads();

switch($action) {
	case 'saveconf':
		if($administrator->isAuthorized()) {
			$runPlugin->setConfigVal( 'label', trim( $_POST['label'] ) );
			$runPlugin->setConfigVal('buttonlabel', trim($_POST['buttonlabel']));
			$runPlugin->setConfigVal('order', trim($_POST['order']));
			$runPlugin->setConfigVal('introduction', trim($_POST['introduction']));
			if($pluginsManager->savePluginConfig($runPlugin)){
				$msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
			}
			else{
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			header('location:index.php?p=ac_downloads&msg='.urlencode($msg).'&msgType='.$msgType);
			die();
		}
		break;
	case 'save':
		if($administrator->isAuthorized()){
			$item = ($_REQUEST['id']) ?  $download->createItem($_REQUEST['id']) : new ac_downloadItem();
			$item->setTitle($_REQUEST['title']);
			$item->setSection($_REQUEST['section']);
			$item->setContent($_REQUEST['content']);
			$item->setLink($_REQUEST['link']);
			$item->setSortNumber($_REQUEST['sortNumber']);
			if($download->saveItem($item)){
				$msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
			}
			else{
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			header('location:index.php?p=ac_downloads&msg='.urlencode($msg).'&msgType='.$msgType);
			die();
		}
		break;
	case 'save-section':
		if($administrator->isAuthorized()){
			$section = ($_REQUEST['id']) ?  $download->createSection($_REQUEST['id']) : new ac_downloadsSection();
			$section->setTitle($_REQUEST['title']);
			$section->setSortNumber($_REQUEST['sortNumber']);
			if($download->saveSection($section)){
				$msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
			}
			else{
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			header('location:index.php?p=ac_downloads&action=list-section&msg='.urlencode($msg).'&msgType='.$msgType);
			die();
		}
		break;
	case 'del':
		if($administrator->isAuthorized()){
			$item = $download->createItem($_REQUEST['id']);
			if($download->delItem($item)){
				$msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
			}
			else{
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			header('location:index.php?p=ac_downloads&msg='.urlencode($msg).'&msgType='.$msgType);
			die();
		}
		break;
	case 'del-section':
		if($administrator->isAuthorized()){
			$section = $download->createSection($_REQUEST['id']);
			if($download->delSection($section)){
				$msg = "Les modifications ont été enregistrées";
				$msgType = 'success';
			}
			else{
				$msg = "Une erreur est survenue";
				$msgType = 'error';
			}
			header('location:index.php?p=ac_downloads&action=list-section&msg='.urlencode($msg).'&msgType='.$msgType);
			die();
		}
		break;
	case 'edit':
		$mode = 'edit';
		$item = (isset($_REQUEST['id'])) ?  $download->createItem($_GET['id']) : new ac_downloadItem();
		break;
	case 'edit-section':
	case 'add-section':
		$mode = 'edit-section';
		$section = (isset($_REQUEST['id'])) ?  $download->createSection($_GET['id']) : new ac_downloadsSection();
		break;
	case 'list-section':
		$mode = 'list-section';
		break;
	default:
		$mode = 'list';
}