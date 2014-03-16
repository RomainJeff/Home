<h2>Folders</h2>
<br>
<table class="span11" style="color: black">

<?php foreach ($folders as $key => $name): ?>
    <tr style="text-align: left;">
        <td style="line-height: 50px;"><?= $config[$name]['title']; ?></td>
        <td><a class="button" href="/index.php/config/folders/<?= $name; ?>">Configurer</a></td>
    </tr>
<?php endforeach; ?>

</table>