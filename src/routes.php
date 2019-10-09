<?php

return [
    // Роут для главной страницы
    '~^$~' => [\App\Controllers\MainController::class, 'main'],

    // Роут для добавления ведомости
    '~^create$~' => [\App\Controllers\MainController::class, 'create'],

    // Роут для редактирования ведомости
    '~^(\d+)/edit$~' => [App\Controllers\MainController::class, 'edit'],

    // Роут для удаления ведомости
    '~^(\d+)/del$~' => [\App\Controllers\MainController::class, 'del'],

    //Роут для поиска по имени работника
    '~^search$~' => [\App\Controllers\MainController::class, 'search']
];