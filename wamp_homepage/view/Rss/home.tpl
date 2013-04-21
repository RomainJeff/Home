<!-- MON READER RSS -->
<?php
Container::get('rss_cache')->setFilter($rssConfig->filter);
$type = "get". $rssConfig->home_type;

if ($type == "getAll") {
    $flux = Container::get('rss_cache')->getAll();
} else {
    $flux = Container::get('rss_cache')->$type($rssConfig->home_id);
}

?>
<div class="span11">
    <h1 class="cat"><?= Container::get('rss_cache')->h1; ?></h1>
     <?php 
        if (!empty ($flux) ):
        foreach ($flux as $key => $datas): 
     ?>
        <div onclick="window.location = '<?= $datas->guid; ?>';" class="lg span4 box <?= $datas->categorieInfos['color']; ?>">
            <br>
            <div style="margin-left: 10px; margin-right: 10px;">
                <small><?= $datas->fluxInfos['name']; ?>:</small><br><div style="border-bottom: solid 1px white;margin-bottom:2px"></div>
                <?= Plugin_Rss_Reader::filter($datas->title); ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        Aucun résultat.
    <?php endif; ?>
</div>
