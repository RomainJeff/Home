<<<<<<< HEAD
<?php $this->start('title'); ?>
    <?= $folderName; ?>
<?php $this->end(); ?>

<?php foreach ($folders as $key => $name): ?>
    <div onclick="window.location = '/index.php/folder/<?= $folderName; ?>/<?= $name; ?>';" class="lg span2 box blue">
        <center class="Entypo_">
            <span class="icon Entypo">&#128230;</span>
        </center><br>
        <small>
            <?= $name; ?>
        </small>
    </div>
<?php endforeach; ?>
=======
<?php $this->start('title'); ?>
    <?= $folderName; ?>
<?php $this->end(); ?>

<?php foreach ($folders as $key => $name): ?>
    <div onclick="window.location = '/index.php/folder/<?= $folderName; ?>/<?= $name; ?>';" class="lg span2 box blue">
        <center class="Entypo_">
            <span class="icon Entypo">&#128230;</span>
        </center><br>
        <small>
            <?= $name; ?>
        </small>
    </div>
<?php endforeach; ?>
>>>>>>> 3324ea59168c1ab2a3998b849a550d945a557fea
