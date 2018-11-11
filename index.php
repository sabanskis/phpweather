<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$loader = new Twig_Loader_Filesystem('View', __DIR__ . '/src/Weather');
$twig = new Twig_Environment($loader, ['cache' => __DIR__ . '/cache', 'debug' => true]);

$controller = new \Weather\Controller\StartPage();
switch ($request->getRequestUri()) {
    case '/google-api-w':
        $renderInfo = $controller->getWeekWeather('google-api');
        break;
    case '/google-api-t':
        $renderInfo = $controller->getTodayWeather('google-api');
        break;
    case '/weather-json-w':
        $renderInfo = $controller->getWeekWeather('json-db');
        break;
    case '/weather-json-t':
        $renderInfo = $controller->getTodayWeather('json-db');
        break;
    case '/':
    default:
        $renderInfo = $controller->getTodayWeather();
    break;
}
$renderInfo['context']['resources_dir'] = 'src/Weather/Resources';

$content = $twig->render($renderInfo['template'], $renderInfo['context']);

$response = new Response(
    $content,
    Response::HTTP_OK,
    array('content-type' => 'text/html')
);
$response->prepare($request);
$response->send();
