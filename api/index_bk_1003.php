<?php

/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Propel\Runtime\Propel;

require 'vendor/autoload.php';
require_once 'classes/conf/config.php';
require_once '../app/assets/authenticate.php';
require_once '../app/assets/functions.video.php';
require_once '../app/assets/functions.php';
require_once '../app/assets/mail.php';

spl_autoload_register(function ($classname) {
    //require ("classes/" . $classname . ".php");
});
//$propel = new \nubia\nubia\About();
/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new Slim\App($c);

$secret = getenv('JWT_Token');

$app->add(new \Slim\Middleware\JwtAuthentication([
    "secret" => $secret,
    "secure" => false,
    "rules" => [
        new \Slim\Middleware\JwtAuthentication\RequestPathRule([
            "path" => "/",
            "passthrough" => ["/*","/auth","/login.*","/user.*","/nearby.*"]
        ])
    ],"callback" => function ($request, $response, $arguments) use ($app) {
//        error_log(print_r($arguments,true),3,'dump.txt');
        $app->jwt = $arguments["decoded"];
    },
    "error" => function ($request, $response, $arguments) {
        $data["status"] = "error";
        $data["value"] = 0;
        $data["message"] = $arguments["message"];
        error_log(print_r($arguments,true),3,'dump.txt');
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */
$app->get('/', function ($request, $response, $args) {

    $response->write("Welcome to Churchlify API!");

    return $response;
});

$app->get('/nearby[/{lat}/{lng}[/{radius}]]', function (Request $request, Response $response, $args) {
    //$req = $request->getParsedBody();
    error_log(print_r($args,true),3,'nearby.txt');
    //Get the variables
    $search_lat = isset($args['lat']) ? filter_var($args['lat'], FILTER_SANITIZE_STRING):'30.3511262';
    $search_lng = isset($args['lng']) ? filter_var($args['lng'], FILTER_SANITIZE_STRING):'-97.716539';
    $radius = isset($args['radius']) ? filter_var($args['radius'], FILTER_SANITIZE_NUMBER_INT):25;
    $option = isset($args['opt']) ? filter_var($args['opt'], FILTER_SANITIZE_STRING):'m';
    $factor = ($option == 'm') ? 3959:6371;
    //Propel to db
    $con = \Propel\Runtime\Propel::getConnection();
    $query = 'SELECT value,lat, lng, name, formatted_address, ROUND(('.$factor.'* acos( cos( radians('.$search_lat.') ) * cos( radians( lat ) ) * cos( radians( lng )- radians('.
        $search_lng.') ) + sin( radians('.$search_lat.') ) * sin( radians( lat ) ) ) ),2) AS distance
        FROM parish HAVING distance < '.$radius.' ORDER BY distance LIMIT 0 , 20';
//
    $stmt = $con->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $response->withJson($res,200);
});


$app->post('/auth', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $user = UserLoginQuery::create()->findPk($user_id);
    $token = jwt_encode($user);
    $data["status"] = "ok";
    $data["token"] = $token;
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});





/********************************
 * ROUTES FOR MANAGING ABOUT    *
 ********************************/

// Get list of records
$app->get('/abouts[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new AboutQuery();
//    $data = AboutQuery::create()->useParishQuery()->endUse()->filterByParishId($parish_id)
//        ->withColumn('parish.name', 'Parish')->find();
    $data = $parish_id ? $q->useParishQuery()->endUse()->withColumn('parish.name', 'Parish')->
    withColumn('parish.logo', 'Logo')->findByParishId($parish_id) :  $q->useParishQuery()->endUse()->
    withColumn('parish.name', 'Parish')->withColumn('parish.logo', 'Logo')->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/about/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new AboutQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('about-detail');

// Get existing record using Parish ID
$app->get('/aboutparish/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new AboutQuery();
    $data = $q->findOneByParishId($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('about-parish');


//create a new entry
$app->post('/about/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $about= filter_var($req['About'], FILTER_SANITIZE_STRING);
    $data = new About();
    $data->setParishId($parish_id);
    $data->setAbout($about);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/about/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $about= filter_var($req['About'], FILTER_SANITIZE_STRING);
    $q = new AboutQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)){
        $data->setParishId($parish_id);
        $data->setAbout($about);
        $submit =  $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});



/********************************
 * ROUTES FOR MANAGING BIBLES    *
 ********************************/
// Get list of Bible Books
$app->get('/books', function (Request $request, Response $response, $args) {
    $q = new BibleBooksQuery();
    $data = $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get one Bible Book
$app->get('/book/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new BibleBooksQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('bible-book');


$app->get('/chapters[/{book}]', function (Request $request, Response $response, $args) {
    $book_id = isset($args['book']) ? (int)$args['book'] : 0;
    $q = new BibleChaptersQuery();
    $data = $book_id ? $q->findByBookId($book_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get one Bible Chapter
$app->get('/chapter/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new BibleChaptersQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('bible-chapter');

$app->get('/verses[/{chapter}]', function (Request $request, Response $response, $args) {
    $chapter_id = isset($args['chapter']) ? (int)$args['chapter'] : 0;
    //$q = new BibleVersesQuery();
    $data = BibleVersesQuery::create()->useBibleChaptersQuery()->endUse()
        ->withColumn('bible_chapters.chapter', 'Chapter')->findByChapterId($chapter_id);
    //$data = $chapter_id ? $q->findByChapterId($chapter_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});



/*********************************
 * ROUTES FOR MANAGING CHURCHES
 **********************************/

// Get list of records
$app->get('/churches[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new ChurchQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/church/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new ChurchQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('church-detail');


//create a new entry
$app->post('/church/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $short_name= filter_var($req['ShortName'], FILTER_SANITIZE_STRING);
    $logo = isset($req['Logo']) ? filter_var($req['Logo'], FILTER_SANITIZE_STRING) : '';
    $data = new Church();
    $data->setName($name);
    $data->setShortName($short_name);
    $data->setLogo($logo);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/church/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $short_name= filter_var($req['ShortName'], FILTER_SANITIZE_STRING);
    $logo = isset($req['Logo']) ? filter_var($req['Logo'], FILTER_SANITIZE_STRING) : '';
    $q = new ChurchQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setName($name);
        $data->setShortName($short_name);
        $data->setLogo($logo);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Deletes existing record
$app->delete('/church/destroy/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $q = new ChurchQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $submit = $data->delete();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/*********************************
 * ROUTES FOR MANAGING DEVOTIONS
 **********************************/
// Get list of records
$app->get('/devotions[/{parish}[/{start}[/{end}]]]', function (Request $request, Response $response, $args) {
    $req = $request->getParams();
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    //$start = isset($args['start']) ? $args['start'] : '';
    //$end = isset($args['end']) ? $args['end'] : '';
    $start = isset($req['Start']) ? filter_var($req['Start'], FILTER_SANITIZE_STRING): " ";
    $end = isset($req['End']) ? filter_var($req['End'], FILTER_SANITIZE_STRING): " ";
    $q = new DevotionsQuery();
    if(isset($req['Start']) && isset($req['End']) ){
        $data = $q->filterByDevotionDate(array("min"=>$start." 00:00:00","max"=>$end." 23:59:59"))->findByParishId($parish_id);
    }elseif ($parish_id){
        $data = $q->findByParishId($parish_id);
    }else{
        $data =  $q->find();
    }

    $temp = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    $res = getVideoApiData($temp);
    return $response->withJson($res,200);

});

// Get existing record using ID
$app->get('/devotion/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new DevotionsQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('devotion-detail');


//create a new entry
$app->post('/devotion/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $topic = filter_var($req['Topic'], FILTER_SANITIZE_STRING);
    $verse = isset($req['Verse']) ? filter_var($req['Verse'], FILTER_SANITIZE_STRING): " ";
    $content = filter_var($req['Content'], FILTER_SANITIZE_STRING);
    $date = filter_var($req['DevotionDate'], FILTER_SANITIZE_STRING);
    $hasmedia = isset($req['HasMedia']) ? filter_var($req['HasMedia'], FILTER_VALIDATE_BOOLEAN): false;
    $type = isset($req['Type']) ? filter_var($req['Type'], FILTER_SANITIZE_STRING): " ";
    $url = isset($req['Url']) ? filter_var($req['Url'], FILTER_SANITIZE_STRING): " ";
    $data = new Devotions();
    $data->setParishId($parish_id);
    $data->setTopic($topic);
    $data->setVerse($verse);
    $data->setHasMedia($hasmedia);
    $data->setContent($content);
    $data->setType($type);
    $data->setUrl($url);
    $data->setDevotionDate($date);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/devotion/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $topic = filter_var($req['Topic'], FILTER_SANITIZE_STRING);
    $verse = isset($req['Verse']) ? filter_var($req['Verse'], FILTER_SANITIZE_STRING): " ";
    $content = filter_var($req['Content'], FILTER_SANITIZE_STRING);
    $date = filter_var($req['DevotionDate'], FILTER_SANITIZE_STRING);
    $hasmedia = isset($req['HasMedia']) ? filter_var($req['HasMedia'], FILTER_VALIDATE_BOOLEAN): false;
    $type = isset($req['Type']) ? filter_var($req['Type'], FILTER_SANITIZE_STRING): " ";
    $url = isset($req['Url']) ? filter_var($req['Url'], FILTER_SANITIZE_STRING): " ";
    $q = new DevotionsQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setTopic($topic);
        $data->setVerse($verse);
        $data->setHasMedia($hasmedia);
        $data->setContent($content);
        $data->setType($type);
        $data->setUrl($url);
        $data->setDevotionDate($date);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING E-CONNECT
 **********************************/
// Get list of records
$app->get('/econnects[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new EconnectQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/econnect/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new EconnectQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('econnect-detail');


//create a new entry
$app->post('/econnect/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $gender_category= isset($req['GenderCategory']) ? filter_var($req['GenderCategory'], FILTER_SANITIZE_STRING):" ";
    $age_category= isset($req['AgeCategory']) ? filter_var($req['AgeCategory'], FILTER_SANITIZE_STRING):" ";
    $data = new Econnect();
    $data->setParishId($parish_id);
    $data->setName($name);
    $data->setGenderCategory($gender_category);
    $data->setAgeCategory($age_category);
    $submit =  $data->save();
    if ($submit){
        initializePushRegister($data->getValue(), $parish_id, false);
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/econnect/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $gender_category= isset($req['GenderCategory']) ? filter_var($req['GenderCategory'], FILTER_SANITIZE_STRING):" ";
    $age_category= isset($req['AgeCategory']) ? filter_var($req['AgeCategory'], FILTER_SANITIZE_STRING):" ";
    $q = new EconnectQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setName($name);
        $data->setGenderCategory($gender_category);
        $data->setAgeCategory($age_category);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});



/*********************************
 * ROUTES FOR MANAGING EVENTS
 **********************************/
// Get list of records
$app->get('/events[/{parish}[/{start}[/{end}]]]', function (Request $request, Response $response, $args) {
    $req = $request->getParams();
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
//    $start = isset($args['start']) ? $args['start'] : '';
//    $end = isset($args['end']) ? $args['end'] : '';
    $start = isset($req['Start']) ? filter_var($req['Start'], FILTER_SANITIZE_STRING): "";
    $end = isset($req['End']) ? filter_var($req['End'], FILTER_SANITIZE_STRING): "";
    $q = new EventsQuery();
    if(isset($req['Start']) && isset($req['End']) ){
        $date = DateTime::createFromFormat('Y-m-d',$start);
        //$data = $q->filterByStartDate(array("min"=>$start))->filterByEndDate(array("max"=>$end))->findByParishId($parish_id);
        $data = $q->filterByStartDate(array("min"=>$start." 00:00:00"))->filterByEndDate(array("max"=>$end." 23:59:59"))->findByParishId($parish_id);
    }elseif ($parish_id){
        $data = $q->findByParishId($parish_id);
    }else{
        $data =  $q->find();
    }
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/event/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new EventsQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('event-detail');


//create a new entry
$app->post('/event/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $venue = filter_var($req['Venue'], FILTER_SANITIZE_STRING);
    $start_date = filter_var($req['StartDate'], FILTER_SANITIZE_STRING);
    $start_time = filter_var($req['StartTime'], FILTER_SANITIZE_STRING);
    $end_date = filter_var($req['EndDate'], FILTER_SANITIZE_STRING);
    $end_time = filter_var($req['EndTime'], FILTER_SANITIZE_STRING);
    $data = new Events();
    $data->setParishId($parish_id);
    $data->setName($name);
    $data->setVenue($venue);
    $data->setStartDate($start_date);
    $data->setStartTime($start_time);
    $data->setEndDate($end_date);
    $data->setEndTime($end_time);

    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/event/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $venue = filter_var($req['Venue'], FILTER_SANITIZE_STRING);
    $start_date = filter_var($req['StartDate'], FILTER_SANITIZE_STRING);
    $start_time = filter_var($req['StartTime'], FILTER_SANITIZE_STRING);
    $end_date = filter_var($req['EndDate'], FILTER_SANITIZE_STRING);
    $end_time = filter_var($req['EndTime'], FILTER_SANITIZE_STRING);
    $q = new EventsQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setName($name);
        $data->setVenue($venue);
        $data->setStartDate($start_date);
        $data->setStartTime($start_time);
        $data->setEndDate($end_date);
        $data->setEndTime($end_time);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});




/*********************************
 * ROUTES FOR MANAGING FACEBOOK
 **********************************/
// Get list of records
$app->get('/facebooks[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new FacebookQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/facebook/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new FacebookQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('facebook-detail');


//create a new entry
$app->post('/facebook/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $api_key = filter_var($req['ApiKey'], FILTER_SANITIZE_STRING);
    $secret_key = filter_var($req['SecretKey'], FILTER_SANITIZE_STRING);
    $page_id = filter_var($req['PageId'], FILTER_SANITIZE_STRING);
    $data = new Facebook();
    $data->setParishId($parish_id);
    $data->setApiKey($api_key);
    $data->setSecretKey($secret_key);
    $data->setPageId($page_id);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/facebook/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $api_key = filter_var($req['ApiKey'], FILTER_SANITIZE_STRING);
    $secret_key = filter_var($req['SecretKey'], FILTER_SANITIZE_STRING);
    $page_id = filter_var($req['PageId'], FILTER_SANITIZE_STRING);
    $q = new FacebookQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setApiKey($api_key);
        $data->setSecretKey($secret_key);
        $data->setPageId($page_id);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/*********************************
 * ROUTES FOR MANAGING INSPIRED LIFE
 **********************************/
// Get list of records
$app->get('/inspireds[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new InspiredLifeQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
    //[/{parish}]
});

// Get existing record using ID
$app->get('/inspired/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new InspiredLifeQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('inspired-detail');


//create a new entry
$app->post('/inspired/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $topic = filter_var($req['Topic'], FILTER_SANITIZE_STRING);
    $verse = isset($req['Verse']) ? filter_var($req['Verse'], FILTER_SANITIZE_STRING): " ";
    $content = filter_var($req['Content'], FILTER_SANITIZE_STRING);
    $media = isset($req['Media']) ? filter_var($req['Media'], FILTER_SANITIZE_STRING): " ";
    $data = new InspiredLife();
    $data->setParishId($parish_id);
    $data->setTopic($topic);
    $data->setVerse($verse);
    $data->setContent($content);
    $data->setMedia($media);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/inspired/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $topic = filter_var($req['Topic'], FILTER_SANITIZE_STRING);
    $verse = isset($req['Verse']) ? filter_var($req['Verse'], FILTER_SANITIZE_STRING): " ";
    $content = filter_var($req['Content'], FILTER_SANITIZE_STRING);
    $media = isset($req['Media']) ? filter_var($req['Media'], FILTER_SANITIZE_STRING): " ";
    $q = new InspiredLifeQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setParishId($parish_id);
        $data->setTopic($topic);
        $data->setVerse($verse);
        $data->setContent($content);
        $data->setMedia($media);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/*********************************
 * ROUTES FOR MANAGING MEDIA
 **********************************/
// Get list of records
$app->get('/medias[/{cat}[/{parish}]]', function (Request $request, Response $response, $args) {
    $req = $request->getParams();
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $category = isset($args['cat']) ? $args['cat'] : '';
    $start = isset($req['Start']) ? filter_var($req['Start'], FILTER_SANITIZE_STRING): " ";
    $end = isset($req['End']) ? filter_var($req['End'], FILTER_SANITIZE_STRING): " ";
    $q = new MediaQuery();
    if(isset($req['Start']) && isset($req['End']) ){
        $data = $q->filterByPublishOn(array("min"=>$start." 00:00:00","max"=>$end." 23:59:59"))->
        useMediaCategoriesQuery()->filterByName($category)->endUse()->findByParishId($parish_id);
    }elseif ($parish_id){
        $data = $q->findByParishId($parish_id);
    }else{
        $data =  $q->find();
    }

    $temp = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    $res = getVideoApiData($temp);
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/media/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new MediaQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('media-detail');


//create a new entry
$app->post('/media/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $category = filter_var($req['Category'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($req['Title'], FILTER_SANITIZE_STRING);
    $type = filter_var($req['Type'], FILTER_SANITIZE_STRING);
    $url = filter_var($req['Url'], FILTER_SANITIZE_STRING);
    $data = new Media();
    $data->setParishId($parish_id);
    $data->setCategory($category);
    $data->setTitle($title);
    $data->setType($type);
    $data->setUrl($url);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/media/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $category = filter_var($req['Category'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($req['Title'], FILTER_SANITIZE_STRING);
    $type = filter_var($req['Type'], FILTER_SANITIZE_STRING);
    $url = filter_var($req['Url'], FILTER_SANITIZE_STRING);
    $q = new MediaQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setCategory($category);
        $data->setTitle($title);
        $data->setType($type);
        $data->setUrl($url);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING MESSAGES (SKIPPED INTENTIONALLY)
 **********************************/
// Get list of records
$app->get('/messages[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new MessagesQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/message/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new MessagesQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('message-detail');

//create a new entry
$app->post('/message/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $group_id = filter_var($req['GroupId'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($req['Title'], FILTER_SANITIZE_STRING);
    $message = filter_var($req['Message'], FILTER_SANITIZE_STRING);
    $payload = isset($req['Payload'])? filter_var($req['Payload'], FILTER_SANITIZE_STRING):'';
    $scheduled_time = isset($req['ScheduledTime'])? filter_var($req['ScheduledTime'], FILTER_SANITIZE_STRING):'';
    $status = isset($req['Status'])? filter_var($req['Status'], FILTER_SANITIZE_NUMBER_INT):'';
    $data = new Messages();
    $data->setGroupId($group_id);
    $data->setTitle($title);
    $data->setMessage($message);
    $data->setPayload($payload);
    $data->setScheduledTime($scheduled_time);
    $data->setStatus($status);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/message/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $group_id = filter_var($req['GroupId'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($req['Title'], FILTER_SANITIZE_STRING);
    $message = filter_var($req['Message'], FILTER_SANITIZE_STRING);
    $payload = isset($req['Payload'])? filter_var($req['Payload'], FILTER_SANITIZE_STRING):'';
    $scheduled_time = isset($req['ScheduledTime'])? filter_var($req['ScheduledTime'], FILTER_SANITIZE_STRING):'';
    $status = isset($req['Status'])? filter_var($req['Status'], FILTER_SANITIZE_NUMBER_INT):'';
    $last_run = isset($req['LastRun'])? filter_var($req['LastRun'], FILTER_SANITIZE_STRING):'';
    $last_device_id = isset($req['LastDeviceId'])? filter_var($req['LastDeviceId'], FILTER_SANITIZE_STRING):'';
    $locked_out = isset($req['LockedOut'])? filter_var($req['LockedOut'], FILTER_SANITIZE_STRING):'';
    $locked_out_time = isset($req['LockedOutTime'])? filter_var($req['LockedOutTime'], FILTER_SANITIZE_STRING):'';
    $q = new MessagesQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setGroupId($group_id);
        $data->setTitle($title);
        $data->setMessage($message);
        $data->setPayload($payload);
        $data->setScheduledTime($scheduled_time);
        $data->setStatus($status);
        $data->setLastRun($last_run);
        $data->setLastDeviceId($last_device_id);
        $data->setLockedOut($locked_out);
        $data->setLockedOutTime($locked_out_time);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});



/*********************************
 * ROUTES FOR MANAGING MINISTRY
 **********************************/
// Get list of records
$app->get('/ministries[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new MinistryQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/ministry/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new MinistryQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('ministry-detail');


//create a new entry
$app->post('/ministry/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $contact_person = filter_var($req['ContactPerson'], FILTER_SANITIZE_STRING);
    $phone = filter_var($req['Phone'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $data = new Ministry();
    $data->setParishId($parish_id);
    $data->setName($name);
    $data->setContactPerson($contact_person);
    $data->setPhone($phone);
    $data->setEmail($email);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/ministry/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $contact_person = filter_var($req['ContactPerson'], FILTER_SANITIZE_STRING);
    $phone = filter_var($req['Phone'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $q = new MinistryQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setName($name);
        $data->setContactPerson($contact_person);
        $data->setPhone($phone);
        $data->setEmail($email);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});



/*********************************
 * ROUTES FOR MANAGING PARISHES
 **********************************/
// Get list of records
$app->get('/parishes[/{church}]', function (Request $request, Response $response, $args) {
    $church_id = isset($args['church']) ? (int)$args['church'] : 0;
    $q = new ParishQuery();
    $data = $church_id ? $q->findByChurchId($church_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/parish/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new ParishQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('parish-detail');

//create a new entry
$app->post('/parish/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $church_id = filter_var($req['ChurchId'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $address = filter_var($req['Address'], FILTER_SANITIZE_STRING);
    $city = filter_var($req['City'], FILTER_SANITIZE_STRING);
    $state = filter_var($req['State'], FILTER_SANITIZE_STRING);
    $zip = filter_var($req['Zip'], FILTER_SANITIZE_STRING);
    $country = filter_var($req['Country'], FILTER_SANITIZE_STRING);
    $phone = filter_var($req['Phone'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $pastor = isset($req['Overseer']) ? filter_var($req['Overseer'], FILTER_SANITIZE_STRING) : '';
    $logo = isset($req['logo']) ? filter_var($req['logo'], FILTER_SANITIZE_STRING) : '';
    $data = new Parish();
    $data->setChurchId($church_id);
    $data->setName($name);
    $data->setAddress($address);
    $data->setCity($city);
    $data->setState($state);
    $data->setZip($zip);
    $data->setCountry($country);
    $data->setPhone($phone);
    $data->setEmail($email);
    $data->setLogo($logo);
    $data->setOverseer($pastor);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/parish/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];

    $req = $request->getParsedBody();
    $church_id = filter_var($req['ChurchId'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $address = filter_var($req['Address'], FILTER_SANITIZE_STRING);
    $city = filter_var($req['City'], FILTER_SANITIZE_STRING);
    $state = filter_var($req['State'], FILTER_SANITIZE_STRING);
    $zip = filter_var($req['Zip'], FILTER_SANITIZE_STRING);
    $country = filter_var($req['Country'], FILTER_SANITIZE_STRING);
    $phone = filter_var($req['Phone'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $pastor = isset($req['Overseer']) ? filter_var($req['Overseer'], FILTER_SANITIZE_STRING) : '';
    $logo = isset($req['logo']) ? filter_var($req['logo'], FILTER_SANITIZE_STRING) : '';
    $q = new ParishQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setChurchId($church_id);
        $data->setName($name);
        $data->setAddress($address);
        $data->setCity($city);
        $data->setState($state);
        $data->setZip($zip);
        $data->setCountry($country);
        $data->setPhone($phone);
        $data->setEmail($email);
        $data->setLogo($logo);
        $data->setOverseer($pastor);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING PASTOR 1 ON 1
 **********************************/
// Get list of records
$app->get('/pastors[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new PastorQuery();
    //$data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $data = $parish_id ? $q->useUserProfileQuery()->filterByParishId($parish_id)->endUse()->find() :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/pastor/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new PastorQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('pastor-detail');

//create a new entry
$app->post('/pastor/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $fname = filter_var($req['Fname'], FILTER_SANITIZE_STRING);
    $lname = filter_var($req['Lname'], FILTER_SANITIZE_STRING);
    $phone = filter_var($req['Phone'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $comment = filter_var($req['Comment'], FILTER_SANITIZE_STRING);
    $contact_date = filter_var($req['ContactDate'], FILTER_SANITIZE_STRING);
    $contact_time = filter_var($req['ContactTime'], FILTER_SANITIZE_STRING);

    $data = new Pastor();
    $data->setUserId($user_id);
    $data->setFname($fname);
    $data->setLname($lname);
    $data->setPhone($phone);
    $data->setEmail($email);
    $data->setComment($comment);
    $data->setContactDate($contact_date);
    $data->setContactTime($contact_time);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/pastor/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $fname = filter_var($req['Fname'], FILTER_SANITIZE_STRING);
    $lname = filter_var($req['Lname'], FILTER_SANITIZE_STRING);
    $phone = filter_var($req['Phone'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $comment = filter_var($req['Comment'], FILTER_SANITIZE_STRING);
    $contact_date = filter_var($req['ContactDate'], FILTER_SANITIZE_STRING);
    $contact_time = filter_var($req['ContactTime'], FILTER_SANITIZE_STRING);
    $q = new PastorQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setFname($fname);
        $data->setLname($lname);
        $data->setPhone($phone);
        $data->setEmail($email);
        $data->setComment($comment);
        $data->setContactDate($contact_date);
        $data->setContactTime($contact_time);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING PRAYERS
 **********************************/
// Get list of records
$app->get('/prayers[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new PrayerQuery();
    $data = $parish_id ? $q->useUserProfileQuery()->filterByParishId($parish_id)->endUse()->find() :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/prayer/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new PrayerQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('prayer-detail');

//create a new entry
$app->post('/prayer/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $full_name = filter_var($req['FullName'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $prayer = filter_var($req['Prayer'], FILTER_SANITIZE_STRING);
    $data = new Prayer();
    $data->setUserId($user_id);
    $data->setFullName($full_name);
    $data->setEmail($email);
    $data->setPrayer($prayer);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/prayer/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $full_name = filter_var($req['FullName'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $prayer = filter_var($req['Prayer'], FILTER_SANITIZE_STRING);
    $q = new PrayerQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($user_id);
        $data->setFullName($full_name);
        $data->setEmail($email);
        $data->setPrayer($prayer);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING TESTIMONIALS
 **********************************/
// Get list of records
$app->get('/testimonials[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new TestimonialsQuery();
    $data = $parish_id ? $q->useUserProfileQuery()->filterByParishId($parish_id)->endUse()->find() :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/testimonial/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new TestimonialsQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('testimonial-detail');

//create a new entry
$app->post('/testimonial/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $full_name = filter_var($req['FullName'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $testimony = filter_var($req['Testimony'], FILTER_SANITIZE_STRING);
    $data = new Testimonials();
    $data->setUserId($user_id);
    $data->setFullName($full_name);
    $data->setEmail($email);
    $data->setTestimony($testimony);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/testimonial/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $full_name = filter_var($req['FullName'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_EMAIL);
    $testimony = filter_var($req['Testimony'], FILTER_SANITIZE_STRING);
    $q = new TestimonialsQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($user_id);
        $data->setFullName($full_name);
        $data->setEmail($email);
        $data->setTestimony($testimony);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING TWITTER
 **********************************/
// Get list of records
$app->get('/twitters[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new TwitterQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/twitter/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new TwitterQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('twitter-detail');

//create a new entry
$app->post('/twitter/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $handle_id = filter_var($req['HandleId'], FILTER_SANITIZE_STRING);
    $data = new Twitter();
    $data->setParishId($parish_id);
    $data->setHandleId($handle_id);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/twitter/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $handle_id = filter_var($req['HandleId'], FILTER_SANITIZE_STRING);
    $q = new TestimonialsQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setHandleId($handle_id);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/*********************************
 * ROUTES FOR MANAGING USER FAMILY
 **********************************/
// Get list of records
$app->get('/families[/{user}]', function (Request $request, Response $response, $args) {
    $user_id = isset($args['user']) ? (int)$args['user'] : 0;
    $q = new UserFamilyQuery();
    $data = $user_id ? $q->findByUserId($user_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/family/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new UserFamilyQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('family-detail');

//create a new entry
$app->post('/family/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $fname = filter_var($req['Fname'], FILTER_SANITIZE_STRING);
    $lname = filter_var($req['Lname'], FILTER_SANITIZE_STRING);
    $relationship = filter_var($req['Relationship'], FILTER_SANITIZE_STRING);
    $data = new UserFamily();
    $data->setUserId($user_id);
    $data->setFname($fname);
    $data->setLname($lname);
    $data->setRelationship($relationship);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/family/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $fname = filter_var($req['Fname'], FILTER_SANITIZE_STRING);
    $lname = filter_var($req['Lname'], FILTER_SANITIZE_STRING);
    $relationship = filter_var($req['Relationship'], FILTER_SANITIZE_STRING);
    $q = new UserFamilyQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setUserId($user_id);
        $data->setFname($fname);
        $data->setLname($lname);
        $data->setRelationship($relationship);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING USER PROFILE
 **********************************/
// Get list of records
$app->get('/users[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new UserProfileQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/user[/{id}]', function (Request $request, Response $response, $args) {
    $pk_id = isset($args['id']) ? (int)$args['id'] : 0;
    $req = $request->getParams();
    $q = new UserProfileQuery();
    $phone = isset($req['Phone']) ? filter_var($req['Phone'], FILTER_SANITIZE_STRING): " ";
    $email = isset($req['Email']) ? filter_var($req['Email'], FILTER_SANITIZE_STRING): " ";
    //$data = $q->findPk($pk_id);
    $data = isset($req['Phone']) ? $q->findOneByPhone($phone):isset($req['Email']) ? $q->findOneByEmail($email):$q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('user-detail');

//create a new entry
$app->post('/user/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $token = isset($req['Token'])? filter_var($req['Token'], FILTER_SANITIZE_STRING):'';
    $platform = isset($req['Platform'])?filter_var($req['Platform'], FILTER_SANITIZE_STRING):'';
    $fname = isset($req['Fname'])? filter_var($req['Fname'], FILTER_SANITIZE_STRING):'';
    $lname = isset($req['Lname'])? filter_var($req['Lname'], FILTER_SANITIZE_STRING):'';
    $address = isset($req['Address'])? filter_var($req['Address'], FILTER_SANITIZE_STRING):'';
    $city = isset($req['City'])? filter_var($req['City'], FILTER_SANITIZE_STRING):'';
    $state = isset($req['State'])? filter_var($req['State'], FILTER_SANITIZE_STRING):'';
    $zip = isset($req['Zip'])? filter_var($req['Zip'], FILTER_SANITIZE_STRING):'';
    $country = isset($req['Country'])? filter_var($req['Country'], FILTER_SANITIZE_STRING):'';
    $phone = isset($req['Phone'])? filter_var($req['Phone'], FILTER_SANITIZE_STRING):'';
    $email = isset($req['Email'])? filter_var($req['Email'], FILTER_SANITIZE_EMAIL):'';
    $dob = isset($req['Dob'])? filter_var($req['Dob'], FILTER_SANITIZE_STRING):'';
    $wedding = isset($req['Wedding'])? filter_var($req['Wedding'], FILTER_SANITIZE_STRING):'';
    $married = isset($req['Married']) ? filter_var($req['Married'], FILTER_VALIDATE_BOOLEAN) : 0;
    $data = new UserProfile();
    $data->setParishId($parish_id);
    $data->setFname($fname);
    $data->setLname($lname);
    $data->setAddress($address);
    $data->setCity($city);
    $data->setState($state);
    $data->setZip($zip);
    $data->setCountry($country);
    $data->setPhone($phone);
    $data->setMarried($married);
    $data->setEmail($email);
    $data->setDob($dob);
    $data->setWedding($wedding);
    $data->setToken($token);
    $data->setPlatform($platform);
    $submit =  $data->save();
    if ($submit){
        initializePushRegister($data->getValue(), $parish_id, true);
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/user/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $token = filter_var($req['Token'], FILTER_SANITIZE_STRING);
    $platform = filter_var($req['Platform'], FILTER_SANITIZE_STRING);
    $fname = isset($req['Fname'])? filter_var($req['Fname'], FILTER_SANITIZE_STRING):'';
    $lname = isset($req['Lname'])? filter_var($req['Lname'], FILTER_SANITIZE_STRING):'';
    $address = isset($req['Address'])? filter_var($req['Address'], FILTER_SANITIZE_STRING):'';
    $city = isset($req['City'])? filter_var($req['City'], FILTER_SANITIZE_STRING):'';
    $state = isset($req['State'])? filter_var($req['State'], FILTER_SANITIZE_STRING):'';
    $zip = isset($req['Zip'])? filter_var($req['Zip'], FILTER_SANITIZE_STRING):'';
    $country = isset($req['Country'])? filter_var($req['Country'], FILTER_SANITIZE_STRING):'';
    $phone = isset($req['Phone'])? filter_var($req['Phone'], FILTER_SANITIZE_STRING):'';
    $email = isset($req['Email'])? filter_var($req['Email'], FILTER_SANITIZE_EMAIL):'';
    $dob = isset($req['Dob'])? filter_var($req['Dob'], FILTER_SANITIZE_STRING):'';
    $wedding = isset($req['Wedding'])? filter_var($req['Wedding'], FILTER_SANITIZE_STRING):'';
    $married = isset($req['Married']) ? filter_var($req['Married'], FILTER_VALIDATE_BOOLEAN) : 0;
    $q = new UserProfileQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        if(isset($req['ParishId'])) $data->setParishId($parish_id);
        if(isset($req['Fname'])) $data->setFname($fname);
        if(isset($req['Lname'])) $data->setLname($lname);
        if(isset($req['Address'])) $data->setAddress($address);
        if(isset($req['City'])) $data->setCity($city);
        if(isset($req['State']))  $data->setState($state);
        if(isset($req['Zip'])) $data->setZip($zip);
        if(isset($req['Country'])) $data->setCountry($country);
        if(isset($req['Phone'])) $data->setPhone($phone);
        if(isset($req['Married'])) $data->setMarried($married);
        if(isset($req['Email']))  $data->setEmail($email);
        if(isset($req['Dob'])) $data->setDob($dob);
        if(isset($req['Wedding'])) $data->setWedding($wedding);
        if(isset($req['Token'])) $data->setToken($token);
        if(isset($req['Platform'])) $data->setPlatform($platform);
        $submit = $data->save();
    }
    if ($submit){
        initializePushRegister($data->getValue(), $parish_id, true);
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
//    if ($submit){
//        $res = array("value"=>$data->getValue());
//    }else{
//        $res = array("value"=>0);
//    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING LIVE STREAM
 **********************************/
// Get list of records
$app->get('/livestreams[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new LiveStreamQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/livestream/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new LiveStreamQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('media-type-detail');

//create a new entry
$app->post('/livestream/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $url= filter_var($req['Url'], FILTER_SANITIZE_STRING);
    $data = new LiveStream();
    $data->setUrl($url);
    $data->setParishId($parish_id);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/live/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $url= filter_var($req['Url'], FILTER_SANITIZE_STRING);
    $q = new LiveStreamQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setUrl($url);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/*********************************
 * ROUTES FOR MANAGING SEGMENT
 **********************************/
// Get list of records
$app->get('/segments[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new SegmentQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/segment/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new SegmentQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('segment-detail');

//create a new entry
$app->post('/segment/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $code = filter_var($req['Code'], FILTER_SANITIZE_STRING);
    $description= filter_var($req['Description'], FILTER_SANITIZE_STRING);
    $project_id = isset($req['ProjectId'])? filter_var($req['ProjectId'], FILTER_SANITIZE_STRING):'';
    $project_number  = isset($req['ProjectNumber'])? filter_var($req['ProjectNumber'], FILTER_SANITIZE_STRING):'';
    $api_key = isset($req['ApiKey'])? filter_var($req['ApiKey'], FILTER_SANITIZE_STRING):'';
    $ssl_cert = isset($req['SslCert'])? filter_var($req['SslCert'], FILTER_SANITIZE_STRING):'';
    $pwd_cert  = isset($req['PwdCert'])? filter_var($req['PwdCert'], FILTER_SANITIZE_STRING):'';
    $send_limit = isset($req['SendLimit'])? filter_var($req['SendLimit'], FILTER_SANITIZE_NUMBER_INT):0;
    $data = new Segment();
    $data->setCode($code);
    $data->setDescription($description);
    $data->setProjectId($project_id);
    $data->setProjectNumber($project_number);
    $data->setApiKey($api_key);
    $data->setSslCert($ssl_cert);
    $data->setPwdCert($pwd_cert);
    $data->setSendLimit($send_limit);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/segment/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $code = filter_var($req['Code'], FILTER_SANITIZE_STRING);
    $description= filter_var($req['Description'], FILTER_SANITIZE_STRING);
    $project_id = isset($req['ProjectId'])? filter_var($req['ProjectId'], FILTER_SANITIZE_STRING):'';
    $project_number  = isset($req['ProjectNumber'])? filter_var($req['ProjectNumber'], FILTER_SANITIZE_STRING):'';
    $api_key = isset($req['ApiKey'])? filter_var($req['ApiKey'], FILTER_SANITIZE_STRING):'';
    $ssl_cert = isset($req['SslCert'])? filter_var($req['SslCert'], FILTER_SANITIZE_STRING):'';
    $pwd_cert  = isset($req['PwdCert'])? filter_var($req['PwdCert'], FILTER_SANITIZE_STRING):'';
    $send_limit = isset($req['SendLimit'])? filter_var($req['SendLimit'], FILTER_SANITIZE_NUMBER_INT):0;
    $q = new SegmentQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setCode($code);
        $data->setDescription($description);
        $data->setProjectId($project_id);
        $data->setProjectNumber($project_number);
        $data->setApiKey($api_key);
        $data->setSslCert($ssl_cert);
        $data->setPwdCert($pwd_cert);
        $data->setSendLimit($send_limit);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING MEDIA CATEGORIES
 **********************************/
// Get list of records
$app->get('/categories[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new MediaCategoriesQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/category/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new MediaCategoriesQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('category-detail');

//create a new entry
$app->post('/category/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $name= filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $data = new MediaCategories();
    $data->setName($name);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/category/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $name= filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $q = new MediaCategoriesQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setName($name);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING MEDIA TYPES
 **********************************/
// Get list of records
$app->get('/mediatypes[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new MediaTypeQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/mediatype/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new MediaTypeQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('media-type-detail');

//create a new entry
$app->post('/mediatypes/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $name= filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $data = new MediaType();
    $data->setName($name);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/mediatypes/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $name= filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $q = new MediaTypeQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setName($name);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});




/*********************************
 * ROUTES FOR MANAGING PARISH SEGMENT
 **********************************/
// Get list of records
$app->get('/partitions[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new ParishSegmentQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/partition/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new ParishSegmentQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('partition-detail');

//create a new entry
$app->post('/partition/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $segment_id = filter_var($req['SegmentId'], FILTER_SANITIZE_NUMBER_INT);
    $data = new ParishSegment();
    $data->setParishId($parish_id);
    $data->setSegmentId($segment_id);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/partition/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $segment_id = filter_var($req['SegmentId'], FILTER_SANITIZE_NUMBER_INT);
    $q = new ParishSegmentQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setSegmentId($segment_id);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*************************************
 * ROUTES FOR MANAGING PUSH REGISTER *
 *************************************/
// Get list of records
$app->get('/registers[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new PushRegisterQuery();
    $data = $parish_id ? $q->useUserProfileQuery()->filterByParishId($parish_id)->endUse()->find() :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get list of records
$app->get('/groupsbyuser[/{user}]', function (Request $request, Response $response, $args) {
    $user_id = isset($args['user']) ? (int)$args['user'] : 0;
    $q = new PushRegisterQuery();
    $data = PushRegisterQuery::create()->useEconnectQuery()->endUse()->filterByUserId($user_id)
        ->withColumn('econnect.name', 'Name')->withColumn('econnect.gender_category', 'GenderCategory')
        ->withColumn('econnect.age_category', 'AgeCategory')->find();
       //->select(array('value','enabled','user_id','group_id','econnect.name','econnect.gender_category','econnect.age_category'))->find();
    //$data = $user_id ? $q->useUserProfileQuery()->filterByParishId($user_id)->endUse()->find() :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});



// Get existing record using ID
$app->get('/register/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new PushRegisterQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('register-detail');

//create a new entry
$app->post('/register/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $group_id = filter_var($req['GroupId'], FILTER_SANITIZE_NUMBER_INT);
    $enabled = isset($req['Enabled']) ? filter_var($req['Enabled'], FILTER_VALIDATE_BOOLEAN) : 0;
    $data = new PushRegister();
    $data->setUserId($user_id);
    $data->setGroupId($group_id);
    $data->setEnabled($enabled);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/register/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $user_id = filter_var($req['UserId'], FILTER_SANITIZE_NUMBER_INT);
    $group_id = filter_var($req['GroupId'], FILTER_SANITIZE_NUMBER_INT);
    $enabled = isset($req['Enabled']) ? filter_var($req['Enabled'], FILTER_VALIDATE_BOOLEAN) : 0;
    $q = new PushRegisterQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setUserId($user_id);
        $data->setGroupId($group_id);
        $data->setEnabled($enabled);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*********************************
 * ROUTES FOR MANAGING MENUS
 **********************************/
// Get list of records
$app->get('/menus[/{parent}]', function (Request $request, Response $response, $args) {
    $parent_id =  $args['parent'] ;
    $q = new MenuQuery();
    $data = (isset($parent_id))? $q->findByParent($parent_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/menu/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new MenuQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('menu-detail');

//create a new entry
$app->post('/menu/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $link = filter_var($req['Link'], FILTER_SANITIZE_STRING);
    $parent = isset($req['Parent']) ? filter_var($req['Parent'], FILTER_SANITIZE_NUMBER_INT) : 0;

    $data = new Menu();
    $data->setName($name);
    $data->setLink($link);
    $data->setParent($parent);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/menu/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $name= filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $link = filter_var($req['Link'], FILTER_SANITIZE_STRING);
    $parent = isset($req['Parent']) ? filter_var($req['Parent'], FILTER_SANITIZE_NUMBER_INT) : 0;
    $q = new MenuQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setName($name);
        $data->setLink($link);
        $data->setParent($parent);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/*********************************
 * ROUTES FOR MANAGING  ROLES
 **********************************/
// Get list of records
$app->get('/roles[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new RolesQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/role/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new RolesQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('role-detail');

//create a new entry
$app->post('/roles/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $name= filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $data = new Roles();
    $data->setName($name);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/roles/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $name= filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $q = new RolesQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setName($name);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/*********************************
 * ROUTES FOR MANAGING USER PERMISSIONS
 **********************************/
// Get list of records
$app->get('/menuroles[/{role}]', function (Request $request, Response $response, $args) {
    $role_id = isset($args['role']) ? (int)$args['role'] : 0;
    $q = new MenuRolesQuery();
    $data = $role_id ? $q->findByRoleId($role_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/menurole/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new MenuRolesQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('menu-role-detail');

//create a new entry
$app->post('/menurole/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $role_id = filter_var($req['RoleId'], FILTER_SANITIZE_NUMBER_INT);
    $menu_id = filter_var($req['MenuId'], FILTER_SANITIZE_NUMBER_INT);
    $access = filter_var($req['Access'], FILTER_VALIDATE_BOOLEAN);
    $data = new MenuRoles();
    $data->setRoleId($role_id);
    $data->setMenuId($menu_id);
    $data->setAccess($access);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/menurole/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $role_id = filter_var($req['RoleId'], FILTER_SANITIZE_NUMBER_INT);
    $menu_id = filter_var($req['MenuId'], FILTER_SANITIZE_NUMBER_INT);
    $access = filter_var($req['Access'], FILTER_VALIDATE_BOOLEAN);
    $q = new MenuRolesQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setRoleId($role_id);
        $data->setMenuId($menu_id);
        $data->setAccess($access);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/*********************************
 * ROUTES FOR MANAGING LETTERS   *
 **********************************/
// Get list of records
$app->get('/letters[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new LettersQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/letter/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new LettersQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $temp = $data->toArray();
        $res = $temp;
        $res['Letter'] = html_entity_decode(htmlspecialchars_decode($temp['Letter']));
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('letter-detail');

//create a new entry
$app->post('/letter/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $subject = filter_var($req['Subject'], FILTER_SANITIZE_STRING);
    $published = filter_var($req['Published'], FILTER_VALIDATE_BOOLEAN);
    $type_id = filter_var($req['TypeId'], FILTER_SANITIZE_NUMBER_INT);
    $msg = filter_var($req['Letter'], FILTER_SANITIZE_STRING);
    $letter = htmlentities(htmlspecialchars($msg));
    $sender_email = filter_var($req['SenderEmail'], FILTER_SANITIZE_STRING);
    $sender_name = filter_var($req['SenderName'], FILTER_SANITIZE_STRING);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);

    $data = new Letters();
    $data->setParishId($parish_id);
    $data->setSubject($subject);
    $data->setPublished($published);
    $data->setTypeId($type_id);
    $data->setLetter($letter);
    $data->setSenderEmail($sender_email);
    $data->setSenderName($sender_name);
    $data->setName($name);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/letter/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $subject = filter_var($req['Subject'], FILTER_SANITIZE_STRING);
    $published = filter_var($req['Published'], FILTER_VALIDATE_BOOLEAN);
    $type_id = filter_var($req['TypeId'], FILTER_SANITIZE_NUMBER_INT);
    $msg = filter_var($req['Letter'], FILTER_SANITIZE_STRING);
    $letter = htmlentities(htmlspecialchars($msg));
    $sender_email = filter_var($req['SenderEmail'], FILTER_SANITIZE_STRING);
    $sender_name = filter_var($req['SenderName'], FILTER_SANITIZE_STRING);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $q = new LettersQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setSubject($subject);
        $data->setPublished($published);
        $data->setTypeId($type_id);
        $data->setLetter($letter);
        $data->setSenderEmail($sender_email);
        $data->setSenderName($sender_name);
        $data->setName($name);
        $submit =  $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/************************************************
 * NOW LETS IMPLEMENT SAME FOR PAYMENTS / GIVE *
 ***********************************************/

/**************************************
 * ROUTES FOR MANAGING GIVE *
 **************************************/
// Get list of records
$app->get('/gives[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new GiveQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/give/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new GiveQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('give-detail');

//create a new entry
$app->post('/give/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $currency = filter_var($req['CurrencyId'], FILTER_SANITIZE_NUMBER_INT);
    $profile_id = filter_var($req['LoginId'], FILTER_SANITIZE_NUMBER_INT);
    $card_id = isset($req['CardId']) ? filter_var($req['CardId'], FILTER_SANITIZE_STRING) : '';
    $method_id = filter_var($req['MethodId'], FILTER_SANITIZE_NUMBER_INT);
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $date_added = isset($req['DateAdded']) ? filter_var($req['DateAdded'], FILTER_SANITIZE_STRING) : '';
    $description = filter_var($req['Description'], FILTER_SANITIZE_STRING);
    $total = filter_var($req['Total'], FILTER_SANITIZE_NUMBER_FLOAT);
    $txn_ref = isset($req['TxnRef']) ? filter_var($req['TxnRef'], FILTER_SANITIZE_STRING) : '';
    $txn_status = isset($req['TxnStatus']) ? filter_var($req['TxnStatus'], FILTER_SANITIZE_STRING) : '';
    $data = new Give();
    $data->setCurrency($currency);
    $data->setProfileId($profile_id);
    $data->setCardId($card_id);
    $data->setMethodId($method_id);
    $data->setParishId($parish_id);
    $data->setCreatedAt($date_added);
    $data->setDescription($description);
    $data->setTotal($total);
    $data->setTxnRef($txn_ref);
    $data->setTxnStatus($txn_status);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/give/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $currency = filter_var($req['CurrencyId'], FILTER_SANITIZE_NUMBER_INT);
    $profile_id = filter_var($req['LoginId'], FILTER_SANITIZE_NUMBER_INT);
    $card_id = isset($req['CardId']) ? filter_var($req['CardId'], FILTER_SANITIZE_STRING) : '';
    $method_id = filter_var($req['MethodId'], FILTER_SANITIZE_NUMBER_INT);
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $date_added = isset($req['DateAdded']) ? filter_var($req['DateAdded'], FILTER_SANITIZE_STRING) : '';
    $description = filter_var($req['Description'], FILTER_SANITIZE_STRING);
    $total = filter_var($req['Total'], FILTER_SANITIZE_NUMBER_FLOAT);
    $txn_ref = isset($req['TxnRef']) ? filter_var($req['TxnRef'], FILTER_SANITIZE_STRING) : '';
    $txn_status = isset($req['TxnStatus']) ? filter_var($req['TxnStatus'], FILTER_SANITIZE_STRING) : '';
    $q = new GiveQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setCurrencyId($currency);
        $data->setLoginId($profile_id);
        $data->setCardId($card_id);
        $data->setMethodId($method_id);
        $data->setParishId($parish_id);
        $data->setCreatedAt($date_added);
        $data->setDescription($description);
        $data->setTotal($total);
        $data->setTxnRef($txn_ref);
        $data->setTxnStatus($txn_status);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/**************************************
 * ROUTES FOR MANAGING GIVE CURRENCY *
 **************************************/
// Get list of records
$app->get('/currencies[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new GiveCurrencyQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/currency/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new GiveCurrencyQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('currency-detail');

//create a new entry
$app->post('/currency/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $code = filter_var($req['Code'], FILTER_SANITIZE_STRING);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $data = new GiveCurrency();
    $data->setCode($code);
    $data->setName($name);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/currency/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $code = filter_var($req['Code'], FILTER_SANITIZE_STRING);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $q = new GiveCurrencyQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setCode($code);
        $data->setName($name);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/**************************************
 * ROUTES FOR MANAGING GIVE CURRENCY BY PARISH*
 **************************************/
// Get list of records
$app->get('/pcurrencies[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new GiveParishCurrencyQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/pcurrency/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new GiveParishCurrencyQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('currency-detail');

//create a new entry
$app->post('/pcurrency/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $currency_id = filter_var($req['CurrencyId'], FILTER_SANITIZE_NUMBER_INT);
    $data = new GiveParishCurrency();
    $data->setParishId($parish_id);
    $data->setCurrencyId($currency_id);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/pcurrency/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $currency_id = filter_var($req['CurrencyId'], FILTER_SANITIZE_NUMBER_INT);
    $q = new GiveParishCurrencyQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setCurrencyId($currency_id);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


/**************************************
 * ROUTES FOR MANAGING GIVE LOGIN *
 **************************************/
// Get list of records
$app->get('/logins[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new UserLoginQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/login/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new UserLoginQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('login-detail');

//create a new entry
$app->post('/login/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $role_id = filter_var($req['RoleId'], FILTER_SANITIZE_NUMBER_INT);
    $envelope = isset($req['Envelope']) ? filter_var($req['Envelope'], FILTER_SANITIZE_STRING):'';
    $email = filter_var($req['Email'], FILTER_SANITIZE_STRING);
    $salt = filter_var($req['Salt'], FILTER_SANITIZE_STRING);
    $password = filter_var($req['Password'], FILTER_SANITIZE_STRING);
    $last_login = isset($req['LastLogin']) ? filter_var($req['LastLogin'], FILTER_SANITIZE_STRING) : '';
    $enabled = isset($req['Enabled']) ? filter_var($req['Enabled'], FILTER_VALIDATE_BOOLEAN) : 0;
    $data = new UserLogin();
    $data->setParishId($parish_id);
    $data->setRoleId($role_id);
    $data->setEnvelope($envelope);
    $data->setEmail($email);
    $data->setSalt($salt);
    $data->setPassword($password);
    $data->setLastLogin($last_login);
    $data->setEnabled($enabled);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/login/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $role_id = filter_var($req['RoleId'], FILTER_SANITIZE_NUMBER_INT);
    $fname = filter_var($req['Fname'], FILTER_SANITIZE_STRING);
    $lname = filter_var($req['Lname'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_STRING);
    $phone = filter_var($req['Phone'], FILTER_SANITIZE_STRING);
    $token = isset($req['Token']) ? filter_var($req['Token'], FILTER_SANITIZE_STRING) : '';
    $salt = filter_var($req['Salt'], FILTER_SANITIZE_STRING);
    $password = filter_var($req['Password'], FILTER_SANITIZE_STRING);
    $last_login = isset($req['LastLogin']) ? filter_var($req['LastLogin'], FILTER_SANITIZE_STRING) : '';
    $enabled = isset($req['Enabled']) ? filter_var($req['Enabled'], FILTER_SANITIZE_NUMBER_INT) : 0;
    $q = new UserLoginQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setRoleId($role_id);
        $data->setFname($fname);
        $data->setLname($lname);
        $data->setEmail($email);
        $data->setPhone($phone);
        $data->setToken($token);
        $data->setSalt($salt);
        $data->setPassword($password);
        $data->setLastLogin($last_login);
        $data->setEnabled($enabled);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/**************************************
 * ROUTES FOR MANAGING GIVE METHODS *
 **************************************/
// Get list of records
$app->get('/methods[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new GiveMethodsQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/method/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new GiveMethodsQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('register-detail');

//create a new entry
$app->post('/method/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $code = filter_var($req['Code'], FILTER_SANITIZE_STRING);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $data = new GiveMethods();
    $data->setCode($code);
    $data->setName($name);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/method/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $code = filter_var($req['Code'], FILTER_SANITIZE_STRING);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $q = new GiveMethodsQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setCode($code);
        $data->setName($name);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/*******************************************
 * ROUTES FOR MANAGING GIVE PARISH METHODS *
 *******************************************/
// Get list of records
$app->get('/pmethods[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new GiveParishMethodsQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/pmethod/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new GiveParishMethodsQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('register-detail');

//create a new entry
$app->post('/pmethod/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $method_id = filter_var($req['MethodId'], FILTER_SANITIZE_NUMBER_INT);
    $settings = filter_var($req['Settings'], FILTER_SANITIZE_STRING);
    $enabled = isset($req['Enabled']) ? filter_var($req['Enabled'], FILTER_SANITIZE_NUMBER_INT) : 1;
    $data = new GiveParishMethods();
    $data->setParishId($parish_id);
    $data->setMethodId($method_id);
    $data->setSettings($settings);
    $data->setEnabled($enabled);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/pmethod/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $method_id = filter_var($req['MethodId'], FILTER_SANITIZE_NUMBER_INT);
    $settings = filter_var($req['Settings'], FILTER_SANITIZE_STRING);
    $enabled = isset($req['Enabled']) ? filter_var($req['Enabled'], FILTER_VALIDATE_BOOLEAN) : 1;
    $q = new GiveParishMethodsQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setMethodId($method_id);
        $data->setSettings($settings);
        $data->setEnabled($enabled);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/**************************************
 * ROUTES FOR MANAGING GIVE SPLITS*
 **************************************/
// Get list of records
$app->get('/splits[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new GiveSplitQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/split/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new GiveSplitQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('give-split-detail');

//create a new entry
$app->post('/split/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $give_id = filter_var($req['GiveId'], FILTER_SANITIZE_NUMBER_INT);
    $item = filter_var($req['Item'], FILTER_SANITIZE_STRING);
    $amount = isset($req['Amount'])? filter_var($req['Amount'], FILTER_SANITIZE_NUMBER_FLOAT) :'0.00';
    $data = new GiveSplit();
    $data->setGiveId($give_id);
    $data->setItem($item);
    $data->setAmount($amount);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/split/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $give_id = filter_var($req['GiveId'], FILTER_SANITIZE_NUMBER_INT);
    $item = filter_var($req['Item'], FILTER_SANITIZE_STRING);
    $amount = isset($req['Amount'])? filter_var($req['Amount'], FILTER_SANITIZE_NUMBER_FLOAT) :'0.00';
    $q = new GiveSplitQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setGiveId($give_id);
        $data->setItem($item);
        $data->setAmount($amount);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/**************************************
 * ROUTES FOR MANAGING GIVE TYPE *
 **************************************/

// Get list of records
$app->get('/types[/{parish}]', function (Request $request, Response $response, $args) {
    $parish_id = isset($args['parish']) ? (int)$args['parish'] : 0;
    $q = new GiveTypeQuery();
    $data = $parish_id ? $q->findByParishId($parish_id) :  $q->find();
    $res = empty($data->toArray()) ? array("value"=>0) : $data->toArray();
    return $response->withJson($res,200);
});

// Get existing record using ID
$app->get('/type/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $q = new GiveTypeQuery();
    $data = $q->findPk($pk_id);
    if (!is_null($data)){
        $res = $data->toArray();
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
})->setName('give-type-detail');

//create a new entry
$app->post('/type/new', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $code = filter_var($req['Code'], FILTER_SANITIZE_STRING);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $data = new GiveType();
    $data->setParishId($parish_id);
    $data->setCode($code);
    $data->setName($name);
    $submit =  $data->save();
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

//Update existing record
$app->put('/type/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $parish_id = filter_var($req['ParishId'], FILTER_SANITIZE_NUMBER_INT);
    $code = filter_var($req['Code'], FILTER_SANITIZE_STRING);
    $name = filter_var($req['Name'], FILTER_SANITIZE_STRING);
    $q = new GiveTypeQuery();
    $data = $q->findPk($pk_id);
    $submit = 0;
    if(is_object($data)) {
        $data->setParishId($parish_id);
        $data->setCode($code);
        $data->setName($name);
        $submit = $data->save();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


$app->post('/verify', function (Request $request, Response $response, $args) {
    $req = $request->getParsedBody();
    $to = filter_var($req['To'], FILTER_SANITIZE_STRING);
    $msg = filter_var($req['Msg'], FILTER_SANITIZE_STRING);
    $email = filter_var($req['Email'], FILTER_SANITIZE_STRING);
    $sent = 0;// (isset($req['To']) && isset($req['Msg'])) ? sendSMS($to,$msg) : false;
    $subject = "Churchlify - Verification Code";
    $sent_email = send_email($to,$email,$subject,$msg);
    if ($sent || $sent_email){
        $res = array("value"=>1);
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});


//Deletes any existing record using the ID
$app->delete('/destroy/{id}', function (Request $request, Response $response, $args) {
    $pk_id = (int)$args['id'];
    $req = $request->getParsedBody();
    $obj = filter_var($req['Object'], FILTER_SANITIZE_STRING);
    switch ($obj){
        case('about') :
            $q = new AboutQuery();
            break;
        case('church') :
            $q = new ChurchQuery();
            break;
        case('devotions') :
            $q = new DevotionsQuery();
            break;
        case('econnect') :
            $q = new EconnectQuery();
            break;
        case('events') :
            $q = new EventsQuery();
            break;
        case('facebook') :
            $q = new FacebookQuery();
            break;
        case('give') :
            $q = new GiveQuery();
            break;
        case('give_currency') :
            $q = new GiveCurrencyQuery();
            break;
        case('give_parish_currency') :
            $q = new GiveParishCurrencyQuery();
            break;
        case('give_methods') :
            $q = new GiveMethodsQuery();
            break;
        case('give_parish_methods') :
            $q = new GiveParishMethodsQuery();
            break;
        case('give_split') :
            $q = new GiveSplitQuery();
            break;
        case('give_type') :
            $q = new GiveTypeQuery();
            break;
        case('letters') :
            $q = new LettersQuery();
            break;
        case('push_register') :
            $q = new PushRegisterQuery();
            break;
        case('media') :
            $q = new MediaQuery();
            break;
        case('media_categories') :
            $q = new MediaCategoriesQuery();
            break;
        case('messages') :
            $q = new MessagesQuery();
            break;
        case('ministry') :
            $q = new MinistryQuery();
            break;
        case('parish') :
            $q = new ParishQuery();
            break;
        case('parish_segment') :
            $q = new ParishSegmentQuery();
            break;
        case('pastor') :
            $q = new PastorQuery();
            break;
        case('prayer') :
            $q = new PrayerQuery();
            break;
        case('roles') :
            $q = new RolesQuery();
            break;
        case('menus') :
            $q = new MenuQuery();
            break;
        case('menuroles') :
            $q = new MenuRolesQuery();
            break;
        case('segment') :
            $q = new SegmentQuery();
            break;
        case('settings') :
            $q = new SettingsQuery();
            break;
        case('testimonials') :
            $q = new TestimonialsQuery();
            break;
        case('twitter') :
            $q = new TwitterQuery();
            break;
        case('user_profile') :
            $q = new UserProfileQuery();
            break;
        case('user_family') :
            $q = new UserFamilyQuery();
            break;
        case('user_login') :
            $q = new UserLoginQuery();
            break;
        default:
            break;

    }
    $data = isset($q) ? $q->findPk($pk_id) :'';
    $submit = 0;
    if(is_object($data)) {
        if($obj == 'econnect'){
            $pr = PushRegisterQuery::create()->filterByGroupId($pk_id)->find();
            $pr->delete();
        }
        if($obj == 'user_profile'){
            $pr = PushRegisterQuery::create()->filterByUserId($pk_id)->find();
            $pr->delete();
        }
        $submit = $data->delete();
    }
    if ($submit){
        $res = array("value"=>$data->getValue());
    }else{
        $res = array("value"=>0);
    }
    return $response->withJson($res,200);
});

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();