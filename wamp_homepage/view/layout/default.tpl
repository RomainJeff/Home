<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Home: <?= $this->fetch('title'); ?></title>

        <link rel="stylesheet" type="text/css" href="<?= $url; ?>/css/style.css">

        <script type="text/javascript" src="<?= $url; ?>/js/jquery.js"></script>
    </head>
    
    <body style="background: url('<?= $url; ?>/img/<?= $preferences->background; ?>') no-repeat center fixed; -webkit-background-size: cover;">
        
        <div id="global" class="container">

            <div class="span11" style="margin-right: 10px;">
                <!-- Infos utilisateur -->
                <div class="span2 name right" onclick="window.location.href = '/index.php/config';" style="text-align: center">
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
                    <h1 class="cat">Projets</h1>

                    <?= $this->fetch('content'); ?>
                </div>

                <?php //$this->inc('Rss/home.tpl'); ?>

            </div>

        </div>

    </body>
</html>
