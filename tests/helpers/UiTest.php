<?php
namespace tests\helpers;

use dosamigos\semantic\helpers\Ui;
use tests\TestCase;

/**
 * @group helpers
 */
class UiTest extends TestCase
{

    /**
     * Mock application prior running tests.
     */
    public function setUp()
    {
        $this->mockWebApplication(
            [
                'components' => [
                    'request' => [
                        'class' => 'yii\web\Request',
                        'url' => '/test',
                        'enableCsrfValidation' => false,
                    ],
                    'response' => [
                        'class' => 'yii\web\Response',
                    ],
                ],
            ]
        );
    }

    public function testBeginForm()
    {
        $this->assertEquals('<form class="ui form" action="/test" method="post">', Ui::beginForm());
        $this->assertEquals('<form class="ui form" action="/example" method="get">', Ui::beginForm('/example', 'get'));
        $hiddens = [
            '<input type="hidden" name="id" value="1">',
            '<input type="hidden" name="title" value="&lt;">',
        ];
        $this->assertEquals(
            '<form class="ui form" action="/example" method="get">' . "\n" . implode("\n", $hiddens),
            Ui::beginForm('/example?id=1&title=%3C', 'get')
        );
    }

    public function testImg()
    {
        $this->assertEquals('<img class="ui image" src="/example" alt="">', Ui::img('/example'));
        $this->assertEquals('<img class="ui image" src="/test" alt="">', Ui::img(''));
        $this->assertEquals(
            '<img class="ui image" src="/example" width="10" alt="something">',
            Ui::img('/example', ['alt' => 'something', 'width' => 10])
        );
    }

    public function testButton()
    {
        $this->assertEquals('<button type="button" class="ui button">Button</button>', Ui::button());
        $this->assertEquals(
            '<button type="button" class="ui button" name="test" value="value">content<></button>',
            Ui::button('content<>', ['name' => 'test', 'value' => 'value'])
        );
        $this->assertEquals(
            '<button type="submit" class="t ui button" name="test" value="value">content<></button>',
            Ui::button('content<>', ['type' => 'submit', 'name' => 'test', 'value' => 'value', 'class' => "t"])
        );
    }

    public function testSubmitButton()
    {
        $this->assertEquals('<button type="submit" class="ui button">Submit</button>', Ui::submitButton());
        $this->assertEquals(
            '<button type="submit" class="t ui button" name="test" value="value">content<></button>',
            Ui::submitButton('content<>', ['name' => 'test', 'value' => 'value', 'class' => 't'])
        );
    }

    public function testResetButton()
    {
        $this->assertEquals('<button type="reset" class="ui button">Reset</button>', Ui::resetButton());
        $this->assertEquals(
            '<button type="reset" class="t ui button" name="test" value="value">content<></button>',
            Ui::resetButton('content<>', ['name' => 'test', 'value' => 'value', 'class' => 't'])
        );
    }

    public function testCheckbox()
    {
        $this->assertEquals(
            '<div id="w0-wrapper" class="ui checkbox"><input type="checkbox" id="w0" name="checkbox-test" value="1"></div>',
            Ui::checkbox('checkbox-test')
        );
    }
}
