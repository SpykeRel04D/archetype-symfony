<?php

namespace Runroom\StaticPageBundle\Service;

use Runroom\BaseBundle\Service\AlternateLinksProvider\AbstractAlternateLinksProvider;

class StaticPageAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    protected static $routes = ['runroom.static_page.route.static.static'];

    public function getRouteParameters($model, $locale)
    {
        return [
            'static_page_slug' => $model->getStaticPage()->translate($locale)->getSlug(),
        ];
    }
}