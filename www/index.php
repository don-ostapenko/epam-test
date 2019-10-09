<?php
try {
    // Автоподключение классов
    spl_autoload_register(function (string $className) {
        require_once __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
    });

// В переменную $routeFromAddressBar кладем значение GET-параметра, взятое из адресной строки. После подключаем файл с роутами
    $routeFromAddressBar = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/../src/routes.php';

// Начинаем перебирать наши роуты и ищем совпадения с тем, что был передан в GET параметре выше
    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $routeFromAddressBar, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

// Если нужный роут не найден бросаем исключение, которое поймается и обработается ниже (страница не найдена)
    if (!$isRouteFound) {
        //throw new \MyProject\Exceptions\NotFoundException();
        false;
    }

// Удаляем элемент массива соотвутствующий вхождению всего шаблона по регулярке
    unset($matches[0]);

// Создаем две переменные, первая содержит ИМЯ КОНТРОЛЛЕРА а вторая ИМЯ ЭКШЕНА (метода)
    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

// Создаем объект контроллера, соответствовавший нашему роуту и вызываем необходимый экшен (метод)
    $controller = new $controllerName();
    $controller->$actionName(...$matches);
} catch (\App\Exceptions\NotFoundException $e) {
    $view = new \App\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
} catch (\App\Exceptions\DbException $e) {
    $view = new App\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
}
