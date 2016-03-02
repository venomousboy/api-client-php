<?php

namespace RetailCrm\Tests;

use RetailCrm\Test\TestCase;

class ApiClientDeliveryTest extends TestCase
{
    /**
     * @group integration
     */
    public function testdeliverySettingEdit()
    {
        $client = static::getApiClient();

        $response = $client->deliverySettingEdit([
            'clientId'  => '123',
            'code'      => 'test',
            'name'      => 'Тестовая служба',
            'baseUrl'   => 'http://delivery-service.com/api/',
            'actions'   => [
                'calculate' => 'calculate',
                'save' => 'save.json',
                'delete' => 'delete.json'
            ],
            'payerType'     => ['sender', 'receiver'],
            'codAvailable'  => true,
            'requiredFields' => [],
            'platePrintLimit'   => 100,
            'statusList'    => [
                [
                    'code' => "new",
                    'name' => 'Доставка оформлена',
                    'isEditable' => true
                ],
                [
                    'code' => "delivering",
                    'name' => 'Доставляется',
                    'isEditable' => false
                ],
            ],
            'deliveryDataFieldList' => [
                [
                    'code' => 'passport',
                    'label' => 'Номер паспорта',
                    'type' => 'text',
                    'multiple' => false,
                    'required' => true,
                    'affectsCost' => false,
                    'editable' => true
                ],
                [
                    'code' => 'count',
                    'label' => 'Число мест',
                    'type' => 'integer',
                    'multiple' => false,
                    'required' => true,
                    'affectsCost' => true,
                    'editable' => true
                ],
            ]
        ]);

        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->success);
        $this->assertTrue(
            isset($response['code']),
            'API returns integration code'
        );
    }

    /**
     * @group integration
     */
    public function testDeliverySettingGet()
    {
        $client = static::getApiClient();

        $response = $client->deliverySettingGet('test');
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->success);
        $this->assertTrue(
            isset($response['configuration']),
            'API returns integration configuration'
        );
    }

    /**
     * @group integration
     */
    public function testDeliveryTracking()
    {
        $client = static::getApiClient();

        $response = $client->deliveryTracking('test', [
            [
                'deliveryId' => '45327',
                'history'   => [
                    [
                        'code' => 'delivering',
                        'updatedAt' => '2015-03-13T21:24:00+03:00',
                        'comment' => 'Передан в обработку'
                    ]
                ],
                'extraData' => [
                    'insuranceValue' => 120
                ]
            ], [
                'deliveryId' => '64587_fd',
                'history'   => [
                    [
                        'code'  => 'new',
                        'updatedAt' => '2015-08-01T15:23:00+03:00'
                    ], [
                        'code'  => 'delivering',
                        'updatedAt' => '2015-08-05T15:00:00+03:00'
                    ], [
                        'code'  => 'arrived',
                        'updatedAt' => '2015-08-06T15:23:00+03:00'
                    ], [
                        'code'  => 'delivered',
                        'updatedAt' => '2015-08-23T15:23:00+03:00'
                    ]
                ]
            ]
        ]);
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->success);
    }
}
