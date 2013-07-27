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
