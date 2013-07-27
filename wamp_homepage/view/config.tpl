<<<<<<< HEAD
<h2>Background</h2><br>
    <img src="<?= $url; ?>/img/<?= $preferences->background; ?>" class="span11"><br>
    <div class="clearfix"></div><br>
    <form method="post" enctype="multipart/form-data">
        <div class="span11">
            <input type="file" value="Choisir une image" name="background" class="left" style="padding-top: 10px;padding-bottom: 10px;">
        </div>
        <div class="clearfix"></div>
        <div class="span11">
            <button class="right button">Enregistrer</button>
        </div>
    </form>
=======
<h2>Background</h2><br>
    <img src="<?= $url; ?>/img/<?= $preferences->background; ?>" class="span11"><br>
    <div class="clearfix"></div><br>
    <div class="span11">
        <span class="left" style="padding-top: 10px;padding-bottom: 10px;">
            Aucun fichier choisis... &nbsp;
        </span>
        <div class="button left">Choisir une image</div>
    </div>
    <div class="clearfix"></div>
    <div class="span11">
        <button class="right button">Enregistrer</button>
    </div>
>>>>>>> 3324ea59168c1ab2a3998b849a550d945a557fea
