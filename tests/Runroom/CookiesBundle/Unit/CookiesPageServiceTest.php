<?php

namespace Tests\Runroom\CookiesBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Runroom\CookiesBundle\Entity\CookiesPage;
use Runroom\CookiesBundle\Form\Type\CookiesFormType;
use Runroom\CookiesBundle\Repository\CookiesPageRepository;
use Runroom\CookiesBundle\Service\CookiesPageService;
use Runroom\CookiesBundle\ViewModel\CookiesPageViewModel;
use Runroom\FormHandlerBundle\FormHandler;

class CookiesPageServiceTest extends TestCase
{
    use ProphecyTrait;

    protected const COOKIES = [];

    protected $repository;
    protected $handler;
    protected $service;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(CookiesPageRepository::class);
        $this->handler = $this->prophesize(FormHandler::class);

        $this->service = new CookiesPageService(
            $this->repository->reveal(),
            $this->handler->reveal(),
            self::COOKIES
        );
    }

    /**
     * @test
     */
    public function itGetsViewModel()
    {
        $cookiesPage = $this->prophesize(CookiesPage::class);
        $this->repository->find(1)->shouldBeCalled()->willReturn($cookiesPage->reveal());

        $this->handler
            ->handleForm(CookiesFormType::class, Argument::type(CookiesPageViewModel::class))
            ->shouldBeCalled()
            ->willReturnArgument(1);

        $viewModel = $this->service->getViewModel();

        $this->assertInstanceOf(CookiesPageViewModel::class, $viewModel);
        $this->assertSame($viewModel->getCookiesPage(), $cookiesPage->reveal());
    }
}
