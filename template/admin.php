<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT.'admin/header.php');

if($mode == 'list'){
?>

    <ul class="tabs_style">
        <li><a class="button" href="index.php?p=ac_downloads&amp;action=edit">Ajouter un lien</a></li>
    </ul>

    <table>
        <tr>
            <th>Titre</th>
            <th></th>
        </tr>
	    <?php foreach($download->getItems() as $key=>$value){ ?>
        <tr>
            <td><?php echo $value->getTitle(); ?></td>
            <td class="cmd">
                <a href="index.php?p=ac_downloads&action=edit&id=<?php echo $value->getId(); ?>" class="button">Modifier</a>
                <a href="index.php?p=ac_downloads&action=del&id=<?php echo $value->getId(); ?>&token=<?php echo administrator::getToken(); ?>" onclick = "if(!confirm('Supprimer cet élément ?')) return false;" class="button alert">Supprimer</a>
            </td>
        </tr>
        <?php } ?>
    </table>

<?php } ?>
<?php if($mode == 'edit'){ ?>
    <form method="post" action="index.php?p=ac_downloads&action=save" enctype="multipart/form-data">
		<?php show::adminTokenField(); ?>
        <input type="hidden" name="id" value="<?php echo $item->getId(); ?>" />

        <p>
            <label>Titre</label><br>
            <input type="text" name="title" value="<?php echo $item->getTitle(); ?>" required="required" />
        </p>

        <p>
            <label>Lien</label><br>
            <input type="text" name="link" value="<?php echo $item->getLink(); ?>" required="required" />
        </p>

        <p>
            <label>Contenu</label><br>
            <textarea name="content" class="editor"><?php echo $item->getContent(); ?></textarea>
        </p>

        <p><button type="submit" class="button">Enregistrer</button></p>
    </form>
<?php } ?>

<?php include_once(ROOT.'admin/footer.php'); ?>
