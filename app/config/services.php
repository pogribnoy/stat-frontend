<?php
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;
use Phalcon\Mvc\View;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileAdapter;

//setlocale(LC_ALL, 'Russian_Russia.1251');
//date_default_timezone_set("Europe/Moscow");
//date_default_timezone_set("Asia/Baghdad");

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();
//$di = new Phalcon\Di();

$di->set('config', $config);

$di->set("request", "Phalcon\Http\Request", true);
//$di->set("response", "Phalcon\Http\Response", true);
//$di->set("sessionBag", "Phalcon\Http\Response", true);

//var_dump(APP_PATH);

$di->setShared('security', function(){
	$security = new SecurityPlugin();
	return $security;
});

$di->setShared('audit', function(){
	$audit = new AuditPlugin();
	return $audit;
});

// Регистрация диспетчера
// Настраиваем и регистрируем менеджер событий
$di->setShared('dispatcher', function() use ($di) {

	$eventsManager = new EventsManager;
	// Настройка сборщика ответов
	$eventsManager->collectResponses(true);
	
	// Проверка доступа пользователя к конкретному действию с помощтю SecurityPlugin
	$eventsManager->attach('dispatch:beforeDispatch', $di['security']);

	// Перехватчик исключений и исключений типа not-found с помощью NotFoundPlugin
	$eventsManager->attach('dispatch:beforeException', new NotFoundPlugin());
	
	$dispatcher = new Dispatcher;
	//$dispatcher->setDefaultNamespace('Base');
	$dispatcher->setEventsManager($eventsManager);
	
	//$dispatcher->setDefaultController('');

	return $dispatcher;
});

// Регистрация компонента представлений
$di->setShared('view', function() use ($config) {
	$view = new View();
	$view->setViewsDir(APP_PATH . $config->application->viewsDir);
	$view->setLayoutsDir(APP_PATH . $config->application->layoutsDir);
	
	return $view;
});


// Соединение с БД создается на основе параметров из конфигурационного файла
$di->setShared('db', function() use ($config) {

	
	$dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
	$connection = new $dbclass(array(
		"host"    	=> $config->database->host,
		"username"	=> $config->database->username,
		"password"	=> $config->database->password,
		"dbname"	=> $config->database->name,
		"charset"	=> $config->database->charset
	));
	
	// Слушаем все события БД
	/*$eventsManager = new EventsManager();
	$logger = new FileAdapter(APP_PATH . "/app/logs/db.log", array('mode' => 'a'));
	
	$eventsManager->attach('db', function($event, $connection) use ($logger) {
        if ($event->getType() == 'beforeQuery') {
            $logger->log($connection->getSQLStatement());
        }
    });
	// Привзываем eventsManager к адаптеру БД
    $connection->setEventsManager($eventsManager);*//**/
	
	return $connection;
});

$di->setShared('modelsManager', function() {
      return new Phalcon\Mvc\Model\Manager();
 });

// Если настройки предписывают использование metadata-адаптера, то необходимо его использовать, иначе следует использовать memory
$di->set('modelsMetadata', function() {
	return new Phalcon\Mvc\Model\Metadata\Files(array(
		'metaDataDir' => APP_PATH . 'app/cache/metadata/',
	));
});

$di->set('viewCache', function() use ($config) {
	// Создание frontend для выходных данных. Кэшируем файлы на 10 секунд
	$frontCache = new Phalcon\Cache\Frontend\Output([
		"lifetime" => $config->application->caching->viewCacheDedaultTime,
	]);

	// Создаем компонент, который будем кэшировать из "Выходных данных" в "Файл"
	// Устанавливаем папку для кэшируемых файлов - важно указать символ "/" в конце пути
	return new Phalcon\Cache\Backend\File($frontCache, [
		"cacheDir" => APP_PATH . 'app/cache/views/',
	]);
});

$di->set('dataCache', function() use ($config) {
	// Создание frontend для выходных данных.
	$cache = new Phalcon\Cache\Frontend\Data([
		"lifetime" => $config->application->caching->dataCacheDedaultTime,
	]);

	// Создаем компонент, который будем кэшировать из "Выходных данных" в "Файл"
	// Устанавливаем папку для кэшируемых файлов - важно указать символ "/" в конце пути
	return new Phalcon\Cache\Backend\File($cache, [
		"cacheDir" => APP_PATH . 'app/cache/',
	]);
});

// Создать сессию при первом обращении какого-либо компонента к сервису сессий
$di->set('session', function() {
	$session = new SessionAdapter();
	$session->start();
	return $session;
});

// Регистрируем сервис шифрования
$di->set('crypt', function() {

    $crypt = new Phalcon\Crypt();

    // Устанавливаем глобальный ключ шифрования
    $crypt->setKey('%31.1e$i86e$f!8jz');

    return $crypt;
}, true);

/**
 * Регистрируем пользовательские компоненты
 */
$di->setShared('translator', function(){
	$translator = new Translator();
	return $translator;
});

$di->setShared('tools', function(){
	$tools = new Tools();
	return $tools;
});

