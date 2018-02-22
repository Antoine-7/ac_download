<?php defined('ROOT') OR exit('No direct script access allowed'); ?>

<form method="post" action="index.php?p=ac_downloads&action=saveconf">
	<?php show::adminTokenField(); ?>

	<p>
		<label>Titre de page</label><br>
		<input type="text" name="label" value="<?php echo $runPlugin->getConfigVal('label'); ?>" />
	</p>

    <p>
        <label>Étiquette du bouton</label><br>
        <input type="text" name="buttonlabel" value="<?php echo $runPlugin->getConfigVal('buttonlabel'); ?>" />
    </p>

	<p>
		<label>Introduction</label><br>
		<textarea class="editor" name="introduction"><?php echo $runPlugin->getConfigVal('introduction'); ?></textarea>
	</p>

	<p><button type="submit" class="button">Enregistrer</button></p>
</form>