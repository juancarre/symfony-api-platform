<?php


namespace App\Tests\Functional\User;


use App\Tests\Functional\TestBase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

class UserTestBase extends TestBase
{
    protected string $endpoint;

    protected function setUp(): void
    {
        parent::setUp();
        $this->databaseTool = $this->getContainer()->get(DatabaseToolCollection::class)->get();
        $this->endpoint = '/api/v1/users';
    }
}