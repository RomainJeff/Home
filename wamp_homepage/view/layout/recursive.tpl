<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>AddwebHome: <?= $this->fetch('title'); ?></title>

        <link rel="stylesheet" type="text/css" href="<?= $url; ?>/css/style.css">

        <script type="text/javascript" src="<?= $url; ?>/js/jquery.js"></script>
    </head>
    
    <body style="background: url('<?= $url; ?>/img/<?= $preferences->background; ?>');">
        
        <div id="global" class="container">

            <div class="span11" style="margin-right: 10px;">
                <!-- Infos utilisateur -->
                <div class="span2 name right" style="text-align: center">
                    Préférences
                </div>

                <?php $this->inc('Google/home.tpl'); ?>
                
                <div class="span2 name right" onclick="GoogleSearch();" style="text-align: center">
                    Google
                </div>
                
            </div>

            <div class="span11">
                <!-- MES PROJETS -->
                <div class="span11">
                    <h1 class="cat"><?= $this->fetch('title'); ?></h1>

                    <?= $this->fetch('content'); ?>
                </div>

            </div>

        </div>

    </body>
</html>
