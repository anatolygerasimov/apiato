<?php

namespace App\Containers\Localization\UI\API\Tests\Functional;

use App\Containers\Localization\Tests\ApiTestCase;

/**
 * Class CheckLocalizationMiddlewareTest.
 *
 * @group localization
 * @group api
 */
class CheckLocalizationMiddlewareTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'get@v1/localizations';

    /**
     * @var array
     */
    protected $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testIfMiddlewareSetsDefaultAppLanguage(): void
    {
        $data           = [];
        $requestHeaders = [];

        // send the HTTP request
        $response = $this->makeCall($data, $requestHeaders);

        // assert the response status
        $response->assertStatus(200);

        $defaultLanguage = config('app.locale');

        // check if the header is properly set
        $response->assertHeader('content-language', $defaultLanguage);
    }

    public function testIfMiddlewareSetsCustomLanguage(): void
    {
        $language = 'fr';

        $data           = [];
        $requestHeaders = [
            'accept-language' => $language,
        ];

        // send the HTTP request
        $response = $this->makeCall($data, $requestHeaders);

        // assert the response status
        $response->assertStatus(200);

        // check if the header is properly set
        $response->assertHeader('content-language', $language);
    }

    public function testIfMiddlewareThrowsErrorOnWrongLanguage(): void
    {
        $language = 'xxx';

        $data           = [];
        $requestHeaders = [
            'accept-language' => $language,
        ];

        // send the HTTP request
        $response = $this->makeCall($data, $requestHeaders);

        // assert the response status
        $response->assertStatus(412);
    }
}
