<?php


namespace ruhrpottmetaller\View;


class View implements IView
{
    protected string $template;
    protected array $template_data;
    protected const TEMPLATE_FOLDER = 'templates/';

    public function __construct(string $template = 'empty')
    {
        $this->template = $template;
    }

    public function setData(string $key, mixed $value): void
    {
        $this->template_data[$key] = $value;
    }

    public function getOutput(): string
    {
        $template_file_name = $this->getTemplateFileName();
        if (!file_exists($template_file_name)) {
            return 'Template not found!';
        }

        ob_start();
        require $template_file_name;
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    private function getTemplateFileName(): string
    {
        return self::TEMPLATE_FOLDER . $this->template . '.inc.php';
    }
}