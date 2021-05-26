<?php


namespace ruhrpottmetaller\View;


interface IView
{
    public function __construct(string $template);
    public function setData(string $key, mixed $value): void;
    public function getOutput(): string;
}