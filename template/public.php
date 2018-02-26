<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(THEMES .$core->getConfigVal('theme').'/header.php');
?>
<!-- Intro -->
<?php echo $runPlugin->getConfigVal('introduction'); ?>

<!-- Liste -->

<?php foreach($downloads->getItems() as $key=>$obj) { ?>
    <article>
        <header>
            <h2><?php echo $obj->getTitle(); ?></h2>
            <p><?php echo htmlentities($obj->getContent(),ENT_HTML5); ?>
        </header>
        <aside>
            <a href="<?php echo $obj->getLink(); ?>"><?php echo $runPlugin->getConfigVal('buttonlabel'); ?></a>
        </aside>
    </article>
<?php } ?>


<?php include_once(THEMES .$core->getConfigVal('theme').'/footer.php') ?>
