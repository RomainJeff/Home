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
                    Configurations
                </div>
                
            </div>

            <div class="span11">
                <!-- MES PROJETS -->
                <div class="span11">
                    <h1 class="cat">Projets</h1>

                    <?= $this->fetch('content'); ?>
                </div>
            </div>

        </div>

        <script type="text/javascript" src="<?= $url; ?>/js/jquery.js"></script>
        <script type="text/javascript">
            function OpenWindow( id ) {
                $('#'+ id).fadeToggle();
            }

            function OpenApp( id ) {
                if( id == 'preference' ) {
                    $('body').css('background', '#f8f8f8');
                }
                $('#global').fadeOut();
                $('#'+ id).delay(500).fadeIn();
            }

            function CloseApp( id ) {
                if( id == 'preference' ) {
                    $('body').css('background', 'url(<?= $url; ?>/img/<?= $Preferences->background; ?>)');
                }
                $('#'+ id).fadeOut();
                $('#global').delay(500).fadeIn();
            }

            $('#chercher').keydown(function(e){
                if(e.which == 13) {
                    var search = $('#chercher').val();
                    window.open('http://google.fr/hl=fr&tbo=d&output=search&q='+ search +'&oq='+ search);
                    OpenWindow('recherche_google');
                }
            });
        </script>
    </body>
</html>