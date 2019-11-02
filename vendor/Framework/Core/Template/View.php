<?php
/**
 * Created by PhpStorm.
 * User: daniu
 * Date: 21.10.2019
 * Time: 21:54
 */

namespace Engine\Core\Template;

use Engine\Core\Template\Theme;


class View
{

    protected $theme;
    protected $env;

    public function __construct($env = 'Main')
    {
        $this->theme = new Theme();
        $this->env = $env;
    }

    public function render($template, $vars = [])
    {

        $templatePath = $this->getTemplatePath($template);

        if (!is_file($templatePath)) {
            throw new \InvalidArgumentException(sprintf('Template "%s" not found in "%s"', $template, $templatePath));
        }

        extract($vars);

        ob_start();
        ob_implicit_flush(0);

        try{

            require $templatePath;
            
        }catch (\Exception $e)
        {
            ob_end_clean();
            throw $e;

        }

        echo ob_get_clean();
    }


    private function getTemplatePath($template)
    {
        $template = str_replace('.','/',$template);

        return ROOT_DIR.'/view/' .$template. '.php';
    }

}
