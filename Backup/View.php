<?php

namespace ruhrpottmetaller;


class   View
{
    private $template_path = 'templates';
    private $image_path = 'images';
    private $template = 'default';
    private $_ = array();

    public function assign($key, $value)
    {
        $this->_[$key] = $value;
    }

    public function setTemplate($template = 'default')
    {
        $this->template = $template;
    }

    public function getOutput()
    {
        $tpl = $this->template;
        $file = $this->template_path . DIRECTORY_SEPARATOR . $tpl . '.inc.php';
        $exists = file_exists($file);

        if ($exists) {
            ob_start();
            include($file);
            $output = ob_get_contents();
            ob_end_clean();
            return $output;

        }
        else {
            return '<div class="inhalt_large">Could not found template "' . $tpl . '".</div>';
        }
    }

}
