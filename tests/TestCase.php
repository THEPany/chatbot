<?php

namespace Tests;

use App\BotManTester;
use BotMan\BotMan\BotMan;
use PHPUnit\Framework\Assert;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestHelpers;

    /**
     * @var BotMan
     */
    protected $botman;

    /**
     * @var BotManTester
     */
    protected $bot;

    protected $defaultData = [];

    protected function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        TestResponse::macro('data', function ($key) {
            return $this->original->getData()[$key];
        });

        EloquentCollection::macro('assertEquals', function ($items) {
            Assert::assertCount(count($items), $this);

            $this->zip($items)->each(function ($itemPair) {
                Assert::assertTrue($itemPair[0]->is($itemPair[1]));
            });
        });
    }
}
