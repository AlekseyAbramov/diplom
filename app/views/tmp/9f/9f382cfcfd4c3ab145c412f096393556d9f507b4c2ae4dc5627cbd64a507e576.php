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
        <div class=\"container\">
            <a class=\"waves-effect waves-light btn-small\" href=\"http://localhost/diplom/public/admin\">Администраторы</a>
            <a class=\"waves-effect waves-light btn-small\" href=\"http://localhost/diplom/public/admin/theme\">Темы</a>
            <a class=\"waves-effect waves-light btn-small\" href=\"http://localhost/diplom/public/admin/question\">Вопросы</a>
            <a class=\"waves-effect waves-light btn-small\" href=\"http://localhost/diplom/public/exit\">Выход</a>
            <div class=\"row\">
                <h2>Управление администраторами сайта</h2>
                <div class=\"col s3\">
                    <form method=\"POST\">
                        <input type=\"text\" name=\"login\" placeholder=\"Логин\" value=\"\" />
                        <input type=\"text\" name=\"password\" placeholder=\"Пароль\" value=\"\" />
                        <input type=\"submit\" name=\"adminAdd\" value=\"Добавить\" />
                    </form>
                </div>
                <div class=\"col s9\">
                    <table class=\"striped\">
                        <thead>
                           <tr>
                                <th>Логин</th>
                                <th>Изменить пароль</th>
                                <th>Удалить</th>
                            </tr>
                        </thead>
                        ";
        // line 39
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["users"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["admin"]) {
            // line 40
            echo "                        <tr>
                            <td>";
            // line 41
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["admin"], "login", array()), "html", null, true);
            echo "</td>
                            <td>
                                <form method=\"POST\">
                                    <input type=\"hidden\" name=\"editPass_id\" placeholder=\"\" value=\"";
            // line 44
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["admin"], "id", array()), "html", null, true);
            echo "\" />
                                    <input type=\"text\" name=\"newPassword\" placeholder=\"Пароль\" value=\"\" />
                                    <input type=\"submit\" name=\"passEdit\" value=\"Изменить\" />
                                </form>
                            </td>
                            <td>
                                <form method=\"POST\">
                                    <input type=\"hidden\" name=\"dell_id\" placeholder=\"\" value=\"";
            // line 51
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["admin"], "id", array()), "html", null, true);
            echo "\" />
                                    <input type=\"submit\" name=\"dell\" value=\"Удалить\" />
                                </form>
                            </td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['admin'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 57
        echo "                    </table>
                </div>
            </div>
        </div>
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

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 57,  86 => 51,  76 => 44,  70 => 41,  67 => 40,  63 => 39,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin.twig", "C:\\xampp\\htdocs\\diplom\\app\\views\\templates\\admin.twig");
    }
}
