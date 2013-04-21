<!-- MON READER RSS -->
<?php
Container::get('rss_cache')->setFilter($rssConfig->filter);
$type = "get". $rssConfig->home_type;
$flux = Container::get('rss_cache')->$type($rssConfig->home_id, false);
?>
<div class="span11">
    <h1 class="cat"><?= Container::get('rss_cache')->h1; ?></h1>
     <?php 
        if (!empty ($cat) ):
        foreach ($flux as $key => $datas): 
     ?>
        <div onclick="window.location = '<?= $datas->guid; ?>';" class="lg span4 box <?= $datas->categorieInfos['color']; ?>">
            <br>
            <div style="margin-left: 10px; margin-right: 10px;">
                <?= Plugin_Rss_Reader::filter($datas->title); ?><br><br>
                <small><?= $datas->fluxInfos['name']; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        Aucun résultat.
    <?php endif; ?>
</div>
