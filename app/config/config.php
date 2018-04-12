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
	"email" => [
		"infoEmail" => "info@rashodygoroda.org",
	],
	"application" => array(
		"version" => "0.3",
		"module" => "frontend",
		"host" => "rashodygoroda.org",
		"commonHost" => "http://rs.rashodygoroda.org",
		"commonControllersDir" => "../stat-backend/app/common/controllers/",
		"commonPluginsDir" => "../stat-backend/app/common/plugins/",
		"commonLibraryDir" => "../stat-backend/app/common/library/",
		"commonModelsDir" => "../stat-backend/app/common/models/",
		//"commonPartialsDir" => "../../../stat-backend/app/views/partials/common/",
		"commonTemplatesDir" => "../stat-backend/public/templates/",
		//"commonUpploadURL" => "http://178.215.86.165:81/public/",
		"filesUploadDirectory" => "upload/files/", //Каталог, в который должны загружаться файлы сущностей. В конце обязательно указание символа "/";
		"noImage" => "no_image.jpg",
		"cacheACL" => 1, // кешировать ACL из БД
		"tablePageSizes" => "[30,50,100]", // Ограничение количества строк для таблиц
		"tableMaxPageSize" => "200", // максимальное количество строк для таблиц
		"sessionTimeout" => "600", // в секундах, время жизни сессии в секундах
		'caching' => [
			"aclCacheDedaultTime" => 20, // в секундах, используется для ACL
			'dataCacheDedaultTime' => 60, // в секундах, используется для структурированных данных
			'viewCacheDedaultTime' => 5, // в секундах, используется для представлений
		],
		
		"controllersDir" => "app/controllers/",
		"viewsDir" => "app/views/",
		"layoutsDir" => "app/views/layouts/",
		"partialsDir" => "app/views/partials/",
		"templatesDir" => "app/views/templates/",
		"adminRoleID" => "1",
		"guestRoleID" => "2",
		"orgadminRoleID" => '6',
		"requestStatus" => [
			"newStatusID" => '1',
			"processedStatusID" => '2',
			"doneStatusID" => '5',
		],
		// коды для тестирования
		//"reCaptchaPublicKey" => "6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI",
		//"reCaptchaSecretKey" => "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe",
		// реальные коды
		"reCaptchaPublicKey" => "6LdBTg8UAAAAABPJQ5TBv1X-aX6p0KhkORpd7JAl",
		"reCaptchaSecretKey" => "6LdBTg8UAAAAABEspdEcFpSwj0YBIFJp4iJe_LF3",
	)
));
