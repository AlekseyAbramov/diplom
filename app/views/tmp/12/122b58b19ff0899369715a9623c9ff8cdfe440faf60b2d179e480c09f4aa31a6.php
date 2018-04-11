<?php

/* template.twig */
class __TwigTemplate_ffebf254ce7847db124784b6f507e83ec73a0e0497d8a5b067637b7e446d75db extends Twig_Template
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
<html>
    <head>
        <title>Главная</title>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
        <link rel=\"stylesheet\" href=\"css/reset.css\"> <!-- CSS reset -->
        <link rel=\"stylesheet\" href=\"css/style.css\"> <!-- Resource style -->
        <script src=\"js/modernizr.js\"></script> <!-- Modernizr -->
    </head>
    <body>
        <header>
            <h1>FAQ</h1>
        </header>
        <a href=\"http://localhost/diplom/public/user\">Войти(Зарегистрироваться)</a>
        <a href=\"http://localhost/diplom/public/question\">Задать вопрос</a>
        <section class=\"cd-faq\">
            <ul class=\"cd-faq-categories\">
                ";
        // line 20
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["menus"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["menu"]) {
            // line 21
            echo "                    <li><a href=\"#";
            echo twig_escape_filter($this->env, $context["menu"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["menu"], "html", null, true);
            echo "</a></li> 
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['menu'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        echo "            </ul>
            
            <div class=\"cd-faq-items\">
                \$content_view
            </div>
        </section>
        <script src=\"js/jquery-2.1.1.js\"></script>
        <script src=\"js/jquery.mobile.custom.min.js\"></script>
        <script src=\"js/main.js\"></script> <!-- Resource jQuery -->
    </body>
</html>

";
    }

    public function getTemplateName()
    {
        return "template.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 23,  48 => 21,  44 => 20,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "template.twig", "C:\\xampp\\htdocs\\diplom\\app\\views\\templates\\template.twig");
    }
}
