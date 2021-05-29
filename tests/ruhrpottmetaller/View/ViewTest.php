<?php

namespace ruhrpottmetaller\View;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    protected function setUp(): void
    {
        chdir('deploy/');
        parent::setUp();
    }

    public function testGetOutput_InitViewObjectWithoutParameterReceiveEmptyOutput()
    {
        $view = new View();
        self::assertEquals('', $view->getOutput());
    }

    public function testGetOutput_InitViewObjectWithNonExistingTemplateReceiveErrorMessage()
    {
        $view = new View(template: 'non_existent');
        self::assertEquals('Template not found!', $view->getOutput());
    }

    public function testGetOutput_InitViewObjectWithTestTemplateReceiveTemplateContent()
    {
        $view = new View(template: 'test');
        self::assertEquals('Test template found!', $view->getOutput());
    }

    public function testGetOutput_PassVariableToObjectAndGetItBackInATestTemplate()
    {
        $view = new View(template: 'variable_test');
        $view->setData('variable', '99');
        self::assertEquals('Variable "99" submitted!', $view->getOutput());
    }
}