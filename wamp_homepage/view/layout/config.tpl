<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Home: <?= $this->fetch('title'); ?></title>

        <link rel="stylesheet" type="text/css" href="<?= $url; ?>/css/style.css">

        <script type="text/javascript" src="<?= $url; ?>/js/jquery.js"></script>
    </head>
    
    <body style="background: white;">
        
        <div id="preference" class="container">

            <div class="span11" style="margin-right: 10px;">
                <div class="span3">
                    <li onclick="window.location.href = '/index.php/config';" class="menu <?php if ($page == 'main'): ?>selected<?php endif; ?>">
                        APPARENCES
                    </li>
                    <li onclick="window.location.href = '/index.php/config/folders';" class="menu <?php if ($page == 'folders'): ?>selected<?php endif; ?>">
                        DOSSIERS
                    </li>
                    <li onclick="window.location.href = '/index.php/config/ignored';" class="menu <?php if ($page == 'ignored'): ?>selected<?php endif; ?>">
                        IGNORES
                    </li>
                    <li onclick="window.location.href = '/';" class="menu">
                        RETOUR SUR HOME
                    </li>
                </div>

            <div class="span8" style="padding-left: 10px;">
                <div class="span11">
                    <?= $this->fetch('content'); ?>
                </div>
            </div>

        </div>

    </body>
</html>
