<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(THEMES .$core->getConfigVal('theme').'/header.php');
?>
<!-- Intro -->
<?php echo $runPlugin->getConfigVal('introduction'); ?>

<!-- Liste -->
<?php
    $currentSection = 'first';
    $nbSections = 0;
    foreach($downloads->getItems() as $key=>$obj) {
        $temp = $obj->getSection();
        if(strlen($temp)==0) $temp = 'Autres'; else $nbSections++;
        if($currentSection!=$temp) {
?>
            <?php if($temp!='first') ?> </section>
            <section id="<?php echo strtolower(str_replace(' ', '-', $temp))?>"
            <?php if( $nbSections > 0 || $temp == 'autres' && $nbSections > 0) { ?>
                ><header><span class="expand"></span><h2><?php echo $temp ?></h2></header>
            <?php } else { ?>
                class="one-section" >
            <?php }
            $currentSection = $temp;
        }
?>
    <article>
        <header>
            <h3><?php echo $obj->getTitle(); ?></h3>
            <p><?php echo htmlentities($obj->getContent(),ENT_HTML5); ?>
        </header>
        <aside>
            <a href="<?php echo $obj->getLink(); ?>"><?php echo $runPlugin->getConfigVal('buttonlabel'); ?></a>
        </aside>
    </article>
<?php } ?>
</section>


<?php include_once(THEMES .$core->getConfigVal('theme').'/footer.php') ?>
