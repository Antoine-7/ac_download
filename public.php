<?php
if(!defined('ROOT')) die();

$downloads = new ac_downloads();

$runPlugin->setTitleTag($runPlugin->getConfigVal('label'));
$runPlugin->setMainTitle($runPlugin->getConfigVal('label'));
?>