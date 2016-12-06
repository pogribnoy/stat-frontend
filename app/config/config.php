<?php
use Phalcon\Config;

$config_array = array(
    "database" => array(
		"adapter" => "Mysql",
		"host" => "localhost",
		"username" => "root",
		"password" => "refaliu",
		"name" => "stat",
		"charset" => "UTF8",
    ),
	"application" => array(
		"module" => "frontend",
		"host" => "vhost.dlinkddns.com:82",
		"commonHost" => "http://vhost.dlinkddns.com:81",
		"commonControllersDir" => "../stat-backend/app/common/controllers/",
		"commonPluginsDir" => "../stat-backend/app/common/plugins/",
		"commonLibraryDir" => "../stat-backend/app/common/library/",
		"commonModelsDir" => "../stat-backend/app/common/models/",
		"commonTemplatesDir" => "../stat-backend/app/views/templates/",
		"commonUpploadURL" => "http://vhost.dlinkddns.com:81/public/",
		"noImage" => "no_image.jpg",
		"tablePageSizes" => "[30,50,100]", // Ограничение количества строк для таблиц
		"tableMaxPageSize" => "200", // Максимальное количество строк для таблиц
		
		"controllersDir" => "app/controllers/",
		"viewsDir" => "app/views/",
		"layoutsDir" => "app/views/layouts/",
		"partialsDir" => "app/views/partials/",
		"templatesDir" => "app/views/templates/",
	)
);
$config = new Config($config_array);
