<?php

namespace Tests;

use App\Shared\Traits\Tests\Assert;
use \Mockery;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, WithFaker, Assert;

    /**
     * The Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Mockery instance.
     *
     * @var mixed|\Mockery
     */
    protected $mockery;


    /**
     * Test set-up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
        $this->setUpMockery();

    }//end setUp()


    /**
     * Setup up the Mockery instance.
     *
     * @return void
     */
    protected function setUpMockery()
    {
        $this->mockery = new Mockery();

    }//end setUpMockery()


}//end class
