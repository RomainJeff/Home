<<<<<<< HEAD
<?php $this->start('title'); ?>
    Tableau de bord
<?php $this->end(); ?>

<?php foreach ($folders as $key => $name): ?>
    <div onclick="window.location = '<?= $config[$name]['link']; ?>';" class="lg span<?= $config[$name]['span']; ?> box <?= $config[$name]['couleur']; ?>">
        <center class="<?= $config[$name]['font']; ?>_">
            <span class="icon <?= $config[$name]['font']; ?>"><?= $config[$name]['icone']; ?></span>
        </center><br>
        <small>
            <?= $config[$name]['title']; ?>
        </small>
    </div>
=======
<?php $this->start('title'); ?>
    Tableau de bord
<?php $this->end(); ?>

<?php foreach ($folders as $key => $name): ?>
    <div onclick="window.location = '<?= $config[$name]['link']; ?>';" class="lg span<?= $config[$name]['span']; ?> box <?= $config[$name]['couleur']; ?>">
        <center class="<?= $config[$name]['font']; ?>_">
            <span class="icon <?= $config[$name]['font']; ?>"><?= $config[$name]['icone']; ?></span>
        </center><br>
        <small>
            <?= $config[$name]['title']; ?>
        </small>
    </div>
>>>>>>> 3324ea59168c1ab2a3998b849a550d945a557fea
<?php endforeach; ?>