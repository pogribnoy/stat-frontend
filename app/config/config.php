<?php
use Phalcon\Config;

$config = new Config(array(
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
		"host" => "178.215.86.165:82",
		"commonHost" => "http://178.215.86.165:81",
		"commonControllersDir" => "../stat-backend/app/common/controllers/",
		"commonPluginsDir" => "../stat-backend/app/common/plugins/",
		"commonLibraryDir" => "../stat-backend/app/common/library/",
		"commonModelsDir" => "../stat-backend/app/common/models/",
		"commonTemplatesDir" => "../stat-backend/app/views/templates/",
		"commonUpploadURL" => "http://178.215.86.165:81/public/",
		"noImage" => "no_image.jpg",
		"cacheACL" => 1, // кешировать ACL из БД
		"tablePageSizes" => "[30,50,100]", // Ограничение количества строк для таблиц
		"tableMaxPageSize" => "200", // Максимальное количество строк для таблиц
		"sessionTimeout" => "600", // Время жизни сессии в минутах
		
		"controllersDir" => "app/controllers/",
		"viewsDir" => "app/views/",
		"layoutsDir" => "app/views/layouts/",
		"partialsDir" => "app/views/partials/",
		"templatesDir" => "app/views/templates/",
	)
));
