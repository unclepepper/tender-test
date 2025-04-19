<?php

namespace App\Decorator\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\OpenApi\OpenApi;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class OpenApiFactory implements OpenApiFactoryInterface
{

    public function __construct(
        #[AutowireDecorated]
        private readonly OpenApiFactoryInterface $decorated,
        private readonly ParameterBagInterface $parameterBag
    ) {}

    /**
     * @param array<mixed> $context
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $schemas = $openApi->getComponents()->getSchemas();

        if(null === $schemas)
        {
            return $openApi;
        }

        $openApi = $openApi->withExtensionProperty('Accept-Language', 'ru');


        /** @var string $url */
        $url = $this->parameterBag->get('app.default_uri');

        return $openApi->withServers([
            new Model\Server($url),
        ]);
    }
}