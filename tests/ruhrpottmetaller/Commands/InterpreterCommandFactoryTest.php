<?php

namespace ruhrpottmetaller\Commands;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Products\ProductFactory;
use ruhrpottmetaller\Storage\Storage;

class InterpreterCommandFactoryTest extends TestCase
{
    protected ProductFactory $productFactory;
    protected Storage $commandStorage;

    protected function setUp(): void
    {
        parent::setUp();
        chdir('deploy/');

        $this->productFactory = new ProductFactory();
        $this->commandStorage = new Storage();
    }

    public function testFactoryMethod_addEmptyRequestArrayAndGetACommandStorage(): void
    {
        $interpreterCommandFactory = new InterpreterCommandFactory(
            $this->commandStorage,
            array(),
            $this->productFactory,
        );
        $commandStorage = $interpreterCommandFactory->factoryMethod();
        self::assertInstanceOf(Storage::class, $commandStorage);
    }

    public function testFactoryMethod_addEmptyRequestAndGetACommandStorageContainingAGetCommand()
    {
        $interpreterCommandFactory = new InterpreterCommandFactory(
            $this->commandStorage,
            array(),
            $this->productFactory,
        );
        $commandStorage = $interpreterCommandFactory->factoryMethod();
        self::assertInstanceOf(GetCommand::class, $commandStorage->getCurrentItem());
    }

    public function testFactoryMethod_provideRequestWithDisplayEqualsBandAndGetACommandStorageContainingAGetCommand()
    {
        $interpreterCommandFactory = new InterpreterCommandFactory(
            $this->commandStorage,
            array('display' => 'band'),
            $this->productFactory,
        );
        $commandStorage = $interpreterCommandFactory->factoryMethod();
        self::assertInstanceOf(GetCommand::class, $commandStorage->getCurrentItem());
    }

    public function testFactoryMethod_provideRequestWithEditEqualsBandAndGetACommandStorageContainingAGetCommand()
    {
        $interpreterCommandFactory = new InterpreterCommandFactory(
            $this->commandStorage,
            array('edit' => 'band'),
            $this->productFactory,
        );
        $commandStorage = $interpreterCommandFactory->factoryMethod();
        self::assertInstanceOf(GetCommand::class, $commandStorage->getCurrentItem());
    }

    public function testFactoryMethod_provideRequestWithADisplayFilterAndGetACommandStorageContainingAGetCommand()
    {
        $interpreterCommandFactory = new InterpreterCommandFactory(
            $this->commandStorage,
            array('display_id' => 44),
            $this->productFactory,
        );
        $commandStorage = $interpreterCommandFactory->factoryMethod();
        self::assertInstanceOf(GetCommand::class, $commandStorage->getCurrentItem());
    }
}
