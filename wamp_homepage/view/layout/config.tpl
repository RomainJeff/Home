<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>AddwebHome: <?= $this->fetch('title'); ?></title>

        <link rel="stylesheet" type="text/css" href="<?= $url; ?>/css/style.css">

        <script type="text/javascript" src="<?= $url; ?>/js/jquery.js"></script>
    </head>
    
    <body style="background: white;">
        
        <div id="preference" class="container">

            <div class="span11" style="margin-right: 10px;">
                <div class="span3">
                    <li class="menu selected">APPARENCES</li>
                    <li class="menu">DOSSIERS</li>
                    <li onclick="window.location.href = '/';" class="menu">RETOUR SUR HOME</li>
                </div>

            <div class="span8" style="padding-left: 10px;">
                <div class="span11">
                    <?= $this->fetch('content'); ?>
                </div>
            </div>

        </div>

    </body>
</html>
