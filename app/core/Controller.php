<?php

namespace diplomApp\core;

abstract class Controller
{
    // @todo убираем $start и добавляем свойство с объектом вьюхи для рендера шаблона
    abstract function actionIndex($model, $start);
}

