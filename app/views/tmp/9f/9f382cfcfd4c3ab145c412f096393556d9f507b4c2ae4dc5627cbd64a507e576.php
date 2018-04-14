<?php

/* admin.twig */
class __TwigTemplate_303416e67524b8cdae36d049ad1230ae2d0a611e69f847e3f5fd0e98687e12cd extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset=\"UTF-8\">
        <title>Администрирование</title>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <!-- Compiled and minified CSS -->
        <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css\">
    </head>
    <body>
        Будет что-то для администрирования
        <?php
        // put your code here
        ?>
        
        <!-- Compiled and minified JavaScript -->
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js\"></script>
    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "admin.twig";
    }

    public function getDebugInfo()
    {
        return array (  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin.twig", "C:\\xampp\\htdocs\\diplom\\app\\views\\templates\\admin.twig");
    }
}
