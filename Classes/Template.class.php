<?php

class Template 
{
    private $template;
    public $template_css;
    private $variables = array();
	
    function __construct($file = 'index.php')
    { 
        $this->template = ROOT . 'templates/' . TEMPLATE_FOLDER . '/' . $file;
        $this->setContent('template_css', TEMPLATE_URL . 'css/style.css');
        $this->setContent('content', '');
        $this->setContent('title', '');
    }
	
	
    public function setContent($section, $content)
    {
        $this->variables[$section] = $content;
        return true;    
    }
    
    public function addContent($section, $content)
    {
        $this->variables[$section] .= $content;
        return true;
    }
    
    public function addModule($section, $module_name, $view = "")
    {
        $location = dirname(dirname(__FILE__)) . "/modules/$module_name/index.php";
        $module_url = SITE_URL . "/modules/$module_name/";
        $module_location = dirname(dirname(__FILE__)) . "/modules/$module_name/";
        $data = array('view' => $view, 'module_url' => $module_url, 'module_location' => $module_location);
        $content = get_content($location, $data);
        $this->variables[$section] .= $content;
        return true;
    }
	
       
    public function display()
    {
        extract($this->variables);
        ob_start();
        include($this->template);
        $content = ob_get_clean();
        echo $content;
    }
}
?>
