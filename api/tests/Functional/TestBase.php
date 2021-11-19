<?php

namespace App\Tests\Functional;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TestBase extends WebTestCase
{
    use RecreateDatabaseTrait;
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    protected static ?KernelBrowser $client = null;
    protected static ?KernelBrowser $peter = null;
    protected static ?KernelBrowser $brian = null;
    protected static ?KernelBrowser $roger = null;

    protected function setUp(): void
    {
        if (null === self::$client) {
            self::$client = static::createClient();
            self::$client->setServerParameters(
                [
                    'CONTENT_TYPE' => 'application/json',
                    'HTTP_ACCEPT' => 'application/ld+json',
                ]
            );
        }

        if (null === self::$peter) {
            self::$peter = clone self::$client;
            $this->createAuthenticatedUser(self::$peter, 'peter@api.com');
        }

        if (null === self::$brian) {
            self::$brian = clone self::$client;
            $this->createAuthenticatedUser(self::$brian, 'brian@api.com');
        }

        if (null === self::$roger) {
            self::$roger = clone self::$client;
            $this->createAuthenticatedUser(self::$roger, 'roger@api.com');
        }


    }

    private function createAuthenticatedUser(KernelBrowser &$client, string $email): void
    {
        $user = $this->getContainer()->get('App\Repository\UserRepository')->findOneByEmailOrFail($email);
        $token = $this
            ->getContainer()
            ->get('Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface')
            ->create($user);

        $client->setServerParameters(
            [
                'HTTP_Authorization' => \sprintf('Bearer %s', $token),
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json',
            ]
        );
    }

    protected function getResponseData(Response $response): array
    {
        return \json_decode($response->getContent(), true);
    }

    protected function initDbConnection(): Connection
    {
        return $this->getContainer()->get('doctrine')->getConnection();
    }

    /**
     * @throws Exception
     */
    protected function getPeterId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM user WHERE email = "peter@api.com"')->fetchFirstColumn()[0];
    }

    /**
     * @throws Exception
     */
    protected function getPeterGroupId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM user_group WHERE name = "Peter Group"')->fetchFirstColumn()[0];
    }


    /**
     * @return mixed
     * @throws Exception
     */
    protected function getPeterExpenseCategoryId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM category WHERE name = "Peter Expense Category"')->fetchFirstColumn()[0];
    }


    /**
     * @return mixed
     * @throws Exception
     */
    protected function getPeterGroupExpenseCategoryId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM category WHERE name = "Peter Group Expense Category"')->fetchFirstColumn()[0];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getPeterMovementId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM movement WHERE amount = 100')->fetchFirstColumn()[0];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getPeterGroupMovementId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM movement WHERE amount = 1000')->fetchFirstColumn()[0];
    }

    /**
     * @throws Exception
     */
    protected function getBrianId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM user WHERE email = "brian@api.com"')->fetchFirstColumn()[0];
    }

    /**
     * @throws Exception
     */
    protected function getBrianGroupId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM user_group WHERE name = "Brian Group"')->fetchFirstColumn()[0];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getBrianExpenseCategoryId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM category WHERE name = "Brian Expense Category"')->fetchFirstColumn()[0];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getBrianGroupExpenseCategoryId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM category WHERE name = "Brian Group Expense Category"')->fetchFirstColumn()[0];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getBrianMovementId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM movement WHERE amount = 200')->fetchFirstColumn()[0];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getBrianGroupMovementId()
    {
        return $this->initDbConnection()->executeQuery('SELECT id FROM movement WHERE amount = 2000')->fetchFirstColumn()[0];
    }
}
