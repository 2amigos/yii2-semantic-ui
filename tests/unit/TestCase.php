<?php
/**
 *
 * TestCase.php
 *
 * Date: 13/02/15
 * Time: 20:12
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */
namespace tests;

use yii\helpers\ArrayHelper;

/**
 * This is the base class for all yii framework unit tests.
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    public static $params;

    /**
     * Mock application prior running tests.
     */
    public function setUp()
    {
        $this->mockApplication();
    }

    /**
     * Clean up after test.
     * By default the application created with [[mockApplication]] will be destroyed.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyApplication();
    }

    /**
     * Mocks a Yii application
     *
     * @param array $config
     * @param string $appClass
     */
    protected function mockApplication($config = [], $appClass = '\yii\console\Application')
    {
        new $appClass(
            ArrayHelper::merge(
                [
                    'id' => 'testapp',
                    'basePath' => __DIR__,
                    'vendorPath' => $this->getVendorPath(),
                ],
                $config
            )
        );
    }

    /**
     * Mocks a Yii web application
     *
     * @param array $config
     * @param string $appClass
     */
    protected function mockWebApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(
            ArrayHelper::merge(
                [
                    'id' => 'testapp',
                    'basePath' => __DIR__,
                    'vendorPath' => $this->getVendorPath(),
                    'components' => [
                        'request' => [
                            'cookieValidationKey' => 'wefJDF8sfdsfSDefwqdxj9oq',
                            'scriptFile' => __DIR__ . '/index.php',
                            'scriptUrl' => '/index.php',
                        ],
                    ]
                ],
                $config
            )
        );
    }

    /**
     * Returns the vendor path
     *
     * @return string
     */
    protected function getVendorPath()
    {
        return dirname(dirname(__DIR__)) . '/vendor';
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        \Yii::$app = null;
    }
}
