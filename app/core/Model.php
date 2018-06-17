<?php

namespace diplomApp\core;

abstract class Model {
    abstract function startIndex($db);
    
    abstract function getData($db);
}
