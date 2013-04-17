<?PHP

/**
 * Dossier par defaut de wamp_homepage
 * le modifier si vous l'avez renommé
 */
$ressourceFolder = 'wamp_homepage/';

require_once dirname(__FILE__) ."/$ressourceFolder/autoload.php";

Autoloader::initialize();


# ================================================================ #
# On stock les données necessaires a l'application
# ================================================================ #
$currentPage = isset ($_GET['page']) ? $_GET['page'] : 'index';


# ================================================================ #
# Regle de routing pour la page index
# ================================================================ #
Routeur::connect('index', function () {

	$defaultConnexion = new Connexion();
	$ignored = [];

	foreach ($defaultConnexion->query("SELECT directory FROM ignore", true) as $key => $value) {
		array_push($ignored, $value->directory);
	}

	$fileManager = new File();
	$listing = $fileManager->liste($ignored);

	foreach ($listing AS $key => $value) {
		echo $value ."<br>";
	}

});


# ================================================================ #
# Regle de routing pour la page config
# ================================================================ #
Routeur::connect('config', function () {

	echo "Configurations";
});


# ================================================================ #
# On lance le routeur qui est en ecoute sur les urls
# ================================================================ #
Routeur::start($currentPage);
