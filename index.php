<?PHP

/**
 * Dossier par defaut de wamp_homepage
 * le modifier si vous l'avez renommé
 */
$ressourceFolder = 'wamp_homepage/';

require_once dirname(__FILE__) ."/$ressourceFolder/autoload.php";

Autoloader::initialize();


# ================================================================ #
# On stock dans le container
# ================================================================ #
Container::set('template', new Template());
Container::set('default', new Connexion());


# ================================================================ #
# On charge les plugins
# ================================================================ #
Plugin::load([
	'Rss_Reader'
]);


# ================================================================ #
# On stock les preferences et on l'envoie a la vue
# ================================================================ #
Container::get('template')->set([
	'preferences'	=> Container::get('default')->query("SELECT * FROM preferences WHERE id = 1")
]);

# ================================================================ #
# On stock les données necessaires a l'application
# ================================================================ #
$currentPage = str_replace ('/index.php', '', $_SERVER['REQUEST_URI']);


# ================================================================ #
# Regle de routing pour la page index
# ================================================================ #
Routeur::connect('/', function () {

	$ignored = array();

	foreach (Container::get('default')->query("SELECT directory FROM ignore", true) as $key => $value) {
		array_push($ignored, $value->directory);
	}

	$fileManager = new File();
	$listing = $fileManager->liste($ignored);

	Container::get('template')->set([
		'folders'	=> 	$listing,
		'config'	=>  $fileManager->config()
	]);

	Container::get('template')->render('index.tpl');

});


# ================================================================ #
# Regle de routing pour la page config
# ================================================================ #
Routeur::connect('/config', function () {

	Container::get('template')->set([
		'message' 	=> ''
	]);

	Container::get('template')->render('config.tpl');

});


# ================================================================ #
# On lance le routeur qui est en ecoute sur les urls
# ================================================================ #
Routeur::start($currentPage);