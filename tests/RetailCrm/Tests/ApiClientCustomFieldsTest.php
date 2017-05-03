<?php

/**
 * PHP version 5.3
 *
 * API client users test class
 *
 * @category RetailCrm
 * @package  RetailCrm
 * @author   RetailCrm <integration@retailcrm.ru>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.retailcrm.ru/docs/Developers/ApiVersion4
 */

namespace RetailCrm\Tests;

use RetailCrm\Test\TestCase;

/**
 * Class ApiClientCustomFieldsTest
 *
 * @category RetailCrm
 * @package  RetailCrm
 * @author   RetailCrm <integration@retailcrm.ru>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.retailcrm.ru/docs/Developers/ApiVersion4
 */
class ApiClientCustomFieldsTest extends TestCase
{
    const FIELD_NAME = 'кастомное_поле_1';
    const FIELD_CODE = 'cust_field_1';
    const DICTIONARY_NAME = 'справочник_1';

    /**
     * @group customFields
     */
    public function testCustomFieldsList()
    {
        $client = static::getApiClient();

        $response = $client->customFieldsList();
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertTrue(in_array($response->getStatusCode(), array(200, 201)));
        $this->assertTrue($response->isSuccessful());

        $response = $client->customFieldsList(array(), 1, 300);
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertFalse(
            $response->isSuccessful(),
            'Pagination error'
        );

        $response = $client->customFieldsList(array('entity' => 'customer'), 1);
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertTrue(
            $response->isSuccessful(),
            'API returns custom fields list'
        );
    }

    /**
     * @group customFields
     */
    public function testCustomFieldsCreate()
    {
        $client = static::getApiClient();

        $response = $client->customFieldsCreate(array(
            'name' => self::FIELD_NAME,
            'code' => self::FIELD_CODE,
            'required' => true,
            'inFilter' => true,
            'inList' => true,
            'type' => 'integer',
            'entity' => 'order',
            'ordering' => 50,
            'viewMode' => 'editable'
        ));

        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue(is_int($response->getId()));

        return array(
            'id' => $response->getId(),
        );
    }

    /**
     * @group customFields
     * @expectedException \InvalidArgumentException
     */
    public function testCustomFieldsCreateExceptionEmpty()
    {
        $client = static::getApiClient();

        $response = $client->customersCreate(array());
    }

    /**
     * @group customFields
     * @depends testCustomFieldsCreate
     */
    public function testCustomFieldsGet()
    {
        $client = static::getApiClient();

        $response = $client->customFieldsGet(10);

        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertFalse($response->isSuccessful());

        $response = $client->customFieldsGet(10);
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(self::FIELD_CODE, $response->customField['code']);
    }

    /**
     * @group customFields
     * @expectedException \InvalidArgumentException
     */
    public function testCustomFieldsGetException()
    {
        $client = static::getApiClient();

        $response = $client->customersGet('sfds');
    }

    /**
     * @group customFields
     * @depends testCustomFieldsGet
     */
    public function testCustomFieldsEdit()
    {
        $client = static::getApiClient();

        $response = $client->customFieldsEdit(array(
            'id' => 10,
            'name' => 'кастомное_поле_new',
            'code' => 'cust_field_new',
            'required' => true,
            'inFilter' => true,
            'inList' => true,
            'type' => 'string',
            'entity' => 'order',
            'ordering' => 50,
            'viewMode' => 'editable'
        ));
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(404, $response->getStatusCode());

        $response = $client->customersEdit(array(
            'id' => 10,
            'name' => '12345',
        ));
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->isSuccessful());
    }

    /**
     * @group customDictionaries
     */
    public function testCustomDictionariesList()
    {
        $client = static::getApiClient();

        $response = $client->customDictionariesList();
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertTrue(in_array($response->getStatusCode(), array(200, 201)));
        $this->assertTrue($response->isSuccessful());

        $response = $client->customDictionariesList(array(), 1, 300);
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertTrue(
            $response->isSuccessful(),
            'Pagination error'
        );
    }

    /**
     * @group customDictionaries
     */
    public function testCustomDictionariesCreate()
    {
        $client = static::getApiClient();

        $response = $client->customDictionariesCreate(array(
            'name' => self::DICTIONARY_NAME,
            'elements' => array(
                array(
                    'name' => 'значение_1',
                    'code' => 'code_1',
                    'ordering' => 50
                ), array(
                    'name' => 'значение_2',
                    'code' => 'code_2',
                    'ordering' => 50
                ), array(
                    'name' => 'значение_3',
                    'code' => 'code_3',
                    'ordering' => 50
            )),
        ));

        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue(is_int($response->getId()));

        return array(
            'id' => $response->getId(),
        );
    }

    /**
     * @group customDictionaries
     * @expectedException \InvalidArgumentException
     */
    public function testCustomDictionariesCreateExceptionEmpty()
    {
        $client = static::getApiClient();

        $response = $client->customDictionariesCreate(array());
    }

    /**
     * @group customDictionaries
     * @depends testCustomDictionariesCreate
     */
    public function testCustomDictionariesGet()
    {
        $client = static::getApiClient();

        $response = $client->customFieldsGet(7);

        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertFalse($response->isSuccessful());

        $response = $client->customFieldsGet(7);
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->isSuccessful());
    }

    /**
     * @group customDictionaries
     * @expectedException \InvalidArgumentException
     */
    public function testCustomDictionariesGetException()
    {
        $client = static::getApiClient();

        $response = $client->customDictionariesGet('sfds');
    }

    /**
     * @group customDictionaries
     * @depends testCustomDictionariesGet
     */
    public function testCustomDictionariesEdit()
    {
        $client = static::getApiClient();

        $dictionary = array(
            'id' => 7,
            'name' => 'справочник_new',
            'elements' => array(
                array(
                    'name' => 'значение_1_new',
                    'code' => 'code_1_new',
                    'ordering' => 50
                ), array(
                    'name' => 'значение_2_new',
                    'code' => 'code__2_new',
                    'ordering' => 50
                ), array(
                    'name' => 'значение_2_new',
                    'code' => 'code_2_new',
                    'ordering' => 50
                )),
        );

        $response = $client->customDictionariesEdit($dictionary);
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(404, $response->getStatusCode());

        $response = $client->customDictionariesEdit($dictionary);
        $this->assertInstanceOf('RetailCrm\Response\ApiResponse', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->isSuccessful());
    }
}
