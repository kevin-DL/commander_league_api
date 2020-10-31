<?php

namespace Http\Controllers;

use App\Http\Controllers\FormatsController;
use App\Model\Format;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class FormatsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetTheFormats()
    {
        $formats = factory(Format::class, 5)->create();
        $this->json('GET', route('formats.list'))->seeStatusCode(200)->seeJson($formats->all());
    }
}

