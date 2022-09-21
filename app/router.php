<?php

use App\Controller\DefaultController;

$controller = new DefaultController();

try {
    switch (true) {

        // анализ текста
        case isset($_POST['text']):
            $controller->analyzeAction();
            break;

        // отображение страницы
        default:
            $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'index';
            $controller->page($view);
            break;
    }
} catch (ErrorException $e) {

    return die($e->getMessage());
}