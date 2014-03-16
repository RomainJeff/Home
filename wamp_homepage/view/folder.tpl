<?php $this->start('title'); ?>
    <?= $folderName; ?>
<?php $this->end(); ?>

<?php foreach ($folders as $key => $name): ?>
    <div onclick="window.location = '<?php if ($config[$name]['link'] == 'folder'): ?>/index.php/folder/<?= $folderName . "/". $name; ?><?php else: ?>/<?= $folderName ."/". $name; ?><?php endif; ?>';" class="lg span2 box <?= $config[$name]['couleur']; ?>">
        <center>
            <span class="icon-<?= $config[$name]['icone']; ?>"></span>
        </center><br>
        <small>
            <?= $name; ?>
        </small>
    </div>
<?php endforeach; ?>
