<?php
require_once __DIR__ . '/../vendor/autoload.php';

use \App\PdoUserRepository;
use \App\PdoTableRepository;
use \Klein\Exceptions\ValidationException;

$klein = new \Klein\Klein();

// init DB access
$klein->respond(function ($request, $response, $service, $app) {
    //parse config
    $config = parse_config_sh("../config.sh");
    $app->config = $config;
    // lazy load PDO
    $app->register('pdo', function() use ($config) {
        $dsn = "pgsql:host=". $config['PG_HOST'].";port=5432;dbname=". $config['PG_DB'].";";
        return new PDO($dsn,  $config['PG_USER'],  $config['PG_PASSWORD'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    });
});

// main page
$klein->respond('GET', '/', function ($request, $response, $service) {
    return $service->render('../resources/views/index.html');
});



//API routes
// add user
$klein->respond(['POST', 'GET'], '/api/users/add', function ($request, $response, $service, $app) {
    try {
        $service->validateParam('userAge', 'Please enter a valid age')->isInt();
        $service->validateParam('userFio', 'Please enter a valid FIO')->isAlpha()->notNull();
        $service->validateParam('userHobby', 'Please enter a valid hobby')->notNull();

        $user['fio'] = $request->param('userFio');
        $user['age'] = $request->param('userAge');
        $user['hobby'] = $request->param('userHobby');    

        $userRepo = new PdoUserRepository($app->pdo);
        $userId = $userRepo->create($user);

        $result['result'] = 'OK';
        $result['data']['message'] = "User $userId added";
        $result['data']['userId'] = $userId;
        return json_encode($result);
        
    } 
    catch (ValidationException $e) {
        $result['result'] = 'ERROR';
        // message from vaidationParam() above
        $result['data']['message'] = $e->getMessage(); 
        return json_encode($result);          
    } 
    catch (Exception $e) {
        $result['result'] = 'ERROR';
        $result['data']['message'] = "Error occured: ".$e->getMessage();
        return json_encode($result);        
    }
});

// get list of tables
$klein->respond('GET', '/api/tables', function ($request, $response, $service, $app) {
    $tableRepo = new PdoTableRepository($app->pdo);
    $schema = $app->config['PG_SCHEMA'];
    // get list of tables
    $sql = "select table_name from information_schema.tables where table_schema = '$schema' order by table_name"; 
    $tables = $tableRepo->query($sql); 
    
    $result['result'] = 'OK';
    $result['data']['tables'] = $tables;
    return json_encode($result);
});

// duplicate table
$klein->respond(['POST', 'GET'], '/api/tables/duplicate/[a:name]', function ($request, $response, $service, $app) {
    $tableRepo = new PdoTableRepository($app->pdo);
    $tableName = $tableRepo->duplicate($request->param('name'));

    $result['result'] = 'OK';
    $result['data']['message'] = "$tableName created.";
    $result['data']['tableName'] = $tableName;
    return json_encode($result);
});

// Handle errors
$klein->onHttpError(function ($code, $router) {
    switch ($code) {
        case 404:
            $router->response()->body('Y U so lost?!');
            break;
        case 405:
            $router->response()->body('You can\'t do that!');
            break;
        default:
            $router->response()->body('Oh no, a bad error happened that caused a ' . $code);
    }
});

$klein->dispatch();