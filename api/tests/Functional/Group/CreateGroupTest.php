<?php


namespace App\Tests\Functional\Group;


use Symfony\Component\HttpFoundation\JsonResponse;

class CreateGroupTest extends GroupTestBase
{
    public function testCreateGroup(): void
    {
        $payload = [
            'name' => 'My new group',
            'owner' => sprintf('api/v1/users/%s', $this->getPeterId())
        ];

        self::$peter->request(
            'POST',
            sprintf('%s', $this->endpoint),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testCreateGroupForAnotherUser(): void
    {
        $payload = [
            'name' => 'My new group',
            'owner' => sprintf('api/v1/users/%s', $this->getPeterId())
        ];

        self::$brian->request(
            'POST',
            sprintf('%s', $this->endpoint),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can not create group for another user', $responseData['message']);
    }
}