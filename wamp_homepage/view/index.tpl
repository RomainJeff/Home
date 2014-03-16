<?php $this->start('title'); ?>
    Tableau de bord
<?php $this->end(); ?>

<?php foreach ($folders as $key => $name): ?>
    <div onclick="window.location = '<?= $config[$name]['link']; ?>';" class="lg span<?= $config[$name]['span']; ?> box <?= $config[$name]['couleur']; ?>">
        <center>
            <span class="icon-<?= $config[$name]['icone']; ?>"></span>
        </center><br>
        <small>
            <?= $config[$name]['title']; ?>
        </small>
    </div>
<?php endforeach; ?>