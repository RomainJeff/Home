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
// Plugin::load([
// 	'Rss_Reader'
// ]);


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

	$ignored = [];

	foreach (Container::get('default')->query("SELECT directory FROM ignore", true) as $key => $value) {
		array_push($ignored, $value->directory);
	}

	$fileManager = new File();
	$listing = $fileManager->liste($ignored);
	$folderConfig = new FolderConfig();

	Container::get('template')->set([
		'folders'	=> 	$listing,
		'config'	=>  $folderConfig->get(__DIR__, $listing)
	]);

	Container::get('template')->render('index.tpl');

});


# ================================================================ #
# Regle de routing pour la recursivite des dossiers
# ================================================================ #
Routeur::connect('/folder/(.*)', function () {

	$ignored = [];

	foreach (Container::get('default')->query("SELECT directory FROM ignore", true) as $key => $value) {
		array_push($ignored, $value->directory);
	}

	$dir = $_GET[0];
	$fileManager = new File(dirname( __FILE__ ) .'/'. $dir, true);
	$listing = $fileManager->recursive();
	$folderConfig = new FolderConfig();

	Container::get('template')->set([
		'folderName'=>  $dir,
		'folders'	=> 	$listing,
		'config'	=>  $folderConfig->getRecursive(__DIR__, $listing)
	]);

	Container::get('template')->layout('recursive');
	Container::get('template')->render('folder.tpl');

});


# ================================================================ #
# Regle de routing pour la page config
# ================================================================ #
Routeur::connect('/config', function () {

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (!empty($_FILES['background'])) {
			move_uploaded_file($_FILES['background']['tmp_name'], dirname( __FILE__ ) ."/wamp_homepage/webroot/img/bg.jpg");
			header('Location: /index.php/config');
			exit;
		}

	}

	Container::get('template')->set([
		'page'	=> 'main'
	]);
	Container::get('template')->layout('config');
	Container::get('template')->render('config.tpl');

});


# ================================================================ #
# Regle de routing pour la page config dossiers
# ================================================================ #
Routeur::connect('/config/folders', function () {

	$ignored = [];

	foreach (Container::get('default')->query("SELECT directory FROM ignore", true) as $key => $value) {
		array_push($ignored, $value->directory);
	}

	$fileManager = new File();
	$listing = $fileManager->liste($ignored);
	$folderConfig = new FolderConfig();
	$configs = $folderConfig->get(__DIR__, $listing);

	Container::get('template')->set([
		'folders'	=> 	$listing,
		'config'	=>  $configs,
		'page'		=> 'folders'
	]);
	Container::get('template')->layout('config');
	Container::get('template')->render('config_folders.tpl');

});


# ================================================================ #
# Regle de routing pour la page config d'un dossier
# ================================================================ #
Routeur::connect('/config/folders/(.*)', function () {

	$dir = $_GET[0];
	$folderConfig = new FolderConfig();

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$title = !isset($_POST['title']) ? false : $_POST['title'];
		$couleur = !isset($_POST['couleur']) ? false : $_POST['couleur'];
		$texte = !isset($_POST['text']) ? false : $_POST['text'];
		$icone = !isset($_POST['icone']) ? false : $_POST['icone'];
		$span = !isset($_POST['span']) ? false : $_POST['span'];
		$link = !isset($_POST['link']) ? false : $_POST['link'];

		if (!$title || !$couleur || !$icone || !$span || !$link || !$texte) {
			echo "<center><h3 style='color:red'>Merci de remplire les champs vides</h3></center>";
		} else {
			$folderConfig->update(__DIR__ .'/'. $dir, [
				'title'		=> $title,
				'couleur' 	=> $couleur,
				'text'		=> $texte,
				'icone'		=> $icone,
				'span'		=> $span,
				'link'		=> $link
			]);
			echo "<center><h3 style='color: green'>Modifications enregistrées</h3></center>";
		}
	}

	$configFolder = $folderConfig->getFromFolder(__DIR__ .'/'. $dir);

	Container::get('template')->set([
		'config'	=>  $configFolder,
		'page'		=> 'folders'
	]);
	Container::get('template')->layout('config');
	Container::get('template')->render('config_folders_one.tpl');

});


# ================================================================ #
# Regle de routing pour la page config des dossiers ignores
# ================================================================ #
Routeur::connect('/config/ignored', function () {

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$delete = !isset($_POST['delete']) ? false : $_POST['delete'];
		$directory = !isset($_POST['dir']) ? false : $_POST['dir'];

		if ($delete) {
			Container::get('default')->query("DELETE FROM ignore WHERE directory = '$directory'");
			echo "<center><h3 style='color:green'>Dossier supprimés des dossiers ignorés</h3></center>";
		} else {
			Container::get('default')->query("INSERT INTO ignore (directory) VALUES ('$directory')");
			echo "<center><h3 style='color:green'>Dossier ajouté aux dossiers ignorés</h3></center>";
		}
	}

	Container::get('template')->set([
		'page'		=> 'ignored',
		'ignored'	=> Container::get('default')->query("SELECT * FROM ignore", true)
	]);
	Container::get('template')->layout('config');
	Container::get('template')->render('config_ignored.tpl');

});


# ================================================================ #
# Regle de routing pour la page icones
# ================================================================ #
Routeur::connect('/icones', function () {

	Container::get('template')->layout('empty');
	Container::get('template')->render('icones.tpl');

});


# ================================================================ #
# On lance le routeur qui est en ecoute sur les urls
# ================================================================ #
Routeur::start($currentPage);
