<?php

namespace Runroom\StaticPageBundle\Tests\Unit;

use Prophecy\Argument;
use Runroom\StaticPageBundle\Controller\StaticPageController;

class StaticPageControllerTest extends \PHPUnit_Framework_TestCase
{
    const STATICS = 'pages/static.html.twig';
    const STATIC_SLUG = 'slug';

    public function setUp()
    {
        $this->renderer = $this->prophesize('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $this->service = $this->prophesize('Runroom\StaticPageBundle\Service\StaticPageService');

        $this->controller = new StaticPageController(
            $this->renderer->reveal(),
            $this->service->reveal()
        );
    }

    /**
     * @test
     */
    public function itRendersStatic()
    {
        $static_page_view_model = new \stdClass();
        $expected_response = 'static';

        $this->service->getStaticPageViewModel(self::STATIC_SLUG)
            ->willReturn($static_page_view_model);

        $this->renderer->renderResponse(self::STATICS, Argument::type('array'), null)
            ->willReturn($expected_response);

        $response = $this->controller->staticPage(self::STATIC_SLUG);

        $this->assertSame($expected_response, $response);
    }
}