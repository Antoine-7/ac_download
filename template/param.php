<?php defined('ROOT') OR exit('No direct script access allowed'); ?>

<form method="post" action="index.php?p=ac_downloads&action=saveconf">
	<?php show::adminTokenField(); ?>

	<p>
		<label for="label">Titre de page</label><br>
		<input type="text" id="label" name="label" value="<?php echo $runPlugin->getConfigVal('label'); ?>" />
	</p>

    <p>
        <label for="buttonlabel">Étiquette du bouton</label><br>
        <input type="text" id="buttonlabel" name="buttonlabel" value="<?php echo $runPlugin->getConfigVal('buttonlabel'); ?>" />
    </p>

    <p>
        <label for="order">Ordre des liens</label><br>
        <select id="order" name="order">
            <option <?php if($runPlugin->getConfigVal('order') == 'natural'){ ?>selected<?php } ?> value="natural">Naturel</option>
            <option <?php if($runPlugin->getConfigVal('order') == 'byName'){ ?>selected<?php } ?> value="byName">Titre</option>
            <option <?php if($runPlugin->getConfigVal('order') == 'order'){ ?>selected<?php } ?> value="order">Trier avec un numéro d'ordre</option>
        </select>
    </p>

	<p>
		<label for="introduction">Introduction</label><br>
		<textarea class="editor" id="introduction" name="introduction"><?php echo $runPlugin->getConfigVal('introduction'); ?></textarea>
	</p>

	<p><button type="submit" class="button">Enregistrer</button></p>
</form>