<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>AddwebHome: <?= $this->fetch('title'); ?></title>

        <link rel="stylesheet" type="text/css" href="<?= $url; ?>/css/style.css">
    </head>
    
    <body style="background: url('<?= $url; ?>/img/<?= $preferences->background; ?>');">
        
        <div id="global" class="container">

            <div class="right" style="margin-right: 10px;">
                <!-- Infos utilisateur -->
                <div class="span2 name" style="text-align: center">
                    Préférences
                </div>
                
            </div>

            <div class="span11">
                <!-- MES PROJETS -->
                <div class="span11">
                    <h1 class="cat">Projets</h1>

                    <?= $this->fetch('content'); ?>
                </div>

                <?php $this->inc('Rss/home.tpl'); ?>

            </div>

        </div>

        <script type="text/javascript" src="<?= $url; ?>/js/jquery.js"></script>
    </body>
</html>