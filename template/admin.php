<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'admin/header.php');

if($mode == 'list' || $mode == 'list-section') {
	?>
    <ul class="tabs_style">
        <li><a class="button" href="index.php?p=ac_downloads&action=edit">Ajouter un lien</a></li>
        <li><a class="button" href="index.php?p=ac_downloads&action=add-section">Ajouter une section</a></li>

	<?php
}
if($mode == 'list'){
?>
        <li><a class="button" href="index.php?p=ac_downloads&action=list-section">Modifier une section</a></li>
    </ul>
    <table>
        <tr>
            <th>Titre</th>
            <th>Section</th>
            <th></th>
        </tr>
	    <?php foreach($download->getItems() as $key=>$value){ ?>
        <tr>
            <td><?php echo $value->getTitle(); ?></td>
            <td><em><?php echo $value->getSection(); ?></em></td>
            <td class="cmd">
                <a href="index.php?p=ac_downloads&action=edit&id=<?php echo $value->getId(); ?>" class="button">Modifier</a>
                <a href="index.php?p=ac_downloads&action=del&id=<?php echo $value->getId(); ?>&token=<?php echo administrator::getToken(); ?>" onclick = "if(!confirm('Supprimer cet élément ?')) return false;" class="button alert">Supprimer</a>
            </td>
        </tr>
        <?php } ?>
    </table>
<?php } elseif($mode == 'list-section'){ ?>
    <li><a class="button" href="index.php?p=ac_downloads">Retourner à la liste des liens</a></li>
    </ul>
    <table>
        <tr>
            <th>Titre</th>
            <th></th>
        </tr>
		<?php foreach($download->getSections() as $key=>$value){ ?>
            <tr>
                <td><?php echo $value->getTitle(); ?></td>
                <td class="cmd">
                    <a href="index.php?p=ac_downloads&action=edit-section&id=<?php echo $value->getId(); ?>" class="button">Modifier</a>
                    <a href="index.php?p=ac_downloads&action=del-section&id=<?php echo $value->getId(); ?>&token=<?php echo administrator::getToken(); ?>" onclick = "if(!confirm('Supprimer cet élément ?')) return false;" class="button alert">Supprimer</a>
                </td>
            </tr>
		<?php } ?>
    </table>

<?php } elseif($mode == 'edit'){ ?>
    <form id="acd-form" method="post" action="index.php?p=ac_downloads&action=save" enctype="multipart/form-data">
		<?php show::adminTokenField(); ?>
        <input type="hidden" name="id" value="<?php echo $item->getId(); ?>" />

        <p>
            <label for="title">Titre</label><br>
            <input type="text" id="title" name="title" value="<?php echo $item->getTitle(); ?>" required="required" />
        </p>

        <p>
            <label for="section">Section</label><br>
            <select id="section" name="section">
                <option value="">(Pas de section)</option>
	            <?php foreach($download->getSections() as $key=>$section){ ?>
                    <option <?php if($section->getTitle()==$item->getSection()) echo 'selected="selected"' ?>><?php echo $section->getTitle() ?></option>
	            <?php } ?>
            </select>

        </p>

        <p>
            <label for="link">Lien</label><br>
            <input type="text" id="link" name="link" value="<?php echo $item->getLink(); ?>" />
            <label for="file">Ou</label><br>
            <input type="file" id="file" name="file" />
        </p>

        <p>
            <label for="sortNumber">Ordre de tri</label><br>
            <input type="number" id="sortNumber" name="sortNumber" value="<?php echo $item->getSortNumber(); ?>" />
        </p>

        <p>
            <label for="content">Contenu</label><br>
            <textarea id="content" name="content" class="editor"><?php echo $item->getContent(); ?></textarea>
        </p>

        <p><button type="submit" class="button">Enregistrer</button></p>
    </form>
<?php } elseif($mode == 'edit-section'){ ?>
    <form id="acd-form" method="post" action="index.php?p=ac_downloads&action=save-section" enctype="multipart/form-data">
	    <?php show::adminTokenField(); ?>
        <input type="hidden" name="id" value="<?php echo $section->getId(); ?>" />

        <p>
            <label for="title">Titre</label><br>
            <input type="text" id="title" name="title" value="<?php echo $section->getTitle(); ?>" required="required" />
        </p>

        <p>
            <label for="sortNumber">Ordre de tri</label><br>
            <input type="number" id="sortNumber" name="sortNumber" value="<?php echo $section->getSortNumber(); ?>" />
        </p>

        <p><button type="submit" class="button">Enregistrer</button></p>
    </form>
<?php } ?>

<?php include_once(ROOT.'admin/footer.php'); ?>
