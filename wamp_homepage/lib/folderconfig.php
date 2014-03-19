<?php

class FolderConfig
{
	public $default = [
		"title"		=> 'Default',
		"couleur"	=> 'blue',
		"text"		=> 'white',
		"icone"		=> 'folder',
		"span"		=> '2',
		"link"		=> '/index.php/folder/'
	];

	public function getFromFolder($folder)
	{
		if (!is_dir($folder)) {
			return false;
		}

		$configFile = $folder ."/home.json";

		$this->exists($configFile, $folder);

		return $this->decode($configFile);
	}

	public function getRecursive($dir, $folders)
	{
		$config = [];
		
		foreach ($folders as $key => $folder) {
			if ($folder == 'index.php' || $folder == 'index.html') {
				$config[$folder] = $this->default;
				
                $config[$folder]['title'] = $folder;
                $config[$folder]['icone'] = "file3";
                $config[$folder]['couleur'] = "orange";
                $config[$folder]['link'] = "fichier";
            } else {
            	$config[$folder] = $this->default;

                $config[$folder]['title'] = $folder;
                $config[$folder]['link'] = "folder";
            }
		}

		return $config;
	}

	public function exists($configFile, $folder)
	{
		if (!file_exists($configFile)) {
			if (strpos($folder, DIRECTORY_SEPARATOR)) {
				$folder = explode(DIRECTORY_SEPARATOR, $folder);
				$folder = $folder[count($folder) - 1];
			}

			$this->create($folder);
		}
	}

	public function get($dir, $folders)
	{
		$config = [];

		foreach ($folders as $key => $folder) {
			$configFile = $dir .'/'. $folder ."/home.json";

			$this->exists($configFile, $folder);

			$config[$folder] = $this->decode($configFile);
		}

		return $config;
	}

	public function create($dir)
	{
		$default = $this->default;
		$default['title'] = $dir;
		$default['link'] = $default['link']. $dir;
		$default = json_encode($default, JSON_PRETTY_PRINT);

		file_put_contents($dir .'/home.json', $default);
	}

	public function update($dir, $config)
	{
		$config = json_encode($config, JSON_PRETTY_PRINT);

		file_put_contents($dir .'/home.json', $config);
	}

	public function decode($configFile)
	{
		return json_decode(
			file_get_contents($configFile),
			true
		);
	}
}