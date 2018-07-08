<?php

namespace diplomApp\core;

abstract class Controller
{
    abstract function actionIndex($model, $start);
}

