<?php
namespace Engine\Core\Template;

class Theme
{
    
    // const RULES_NAME_FILE =[
    //     'header' => 'header-%s',
    //     'footer' => 'footer-%s',
    //     'sidebar' => 'sidebar-%s',
    // ];

    public $url = '';

    public function header($name = null,$data=[])
    {
        $name= (string) $name;
        $file = 'header';

        $this->loadTemplateFile($file,$data);
    }

    public function footer($name = '',$data=[])
    {
        $name= (string) $name;
        $file = 'footer';

        $this->loadTemplateFile($file,$data);
    }
    
    public function sidebar($name = '',$data=[])
    {
        $name= (string) $name;
        $file = 'sidebar';

        $this->loadTemplateFile($file,$data);
    }

    public function block($name = '', $data = [])
    {
        $name= (string) $name;
        $file = 'block';

        $this->loadTemplateFile($file,$data);
    }

    public function loadTemplateFile($Filename,$data=[])
    {
        $Filename = str_replace('.','/',$Filename);
        $Templatefile = ROOT_DIR.'/view/' .$Filename. '.php';

        if (is_file($Templatefile)) {
            extract($data);
            require_once $Templatefile;
        }else{
            throw new \Exception(sprintf('View file %s does not exist!', $Templatefile));
        }
    }
}


?>