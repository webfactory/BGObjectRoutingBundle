<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function(ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();

    $services->defaults()
        ->private()
        ->autowire()
        ->autoconfigure();

    $services->alias(\JMS\ObjectRouting\RouterInterface::class, \JMS\ObjectRouting\Symfony\Symfony22Adapter::class);

    $services->set(\JMS\ObjectRouting\Symfony\Symfony22Adapter::class);

    $services->set(\JMS\ObjectRouting\ObjectRouter::class)
        ->public();

    $services->set(\JMS\ObjectRouting\Twig\RoutingExtension::class);

    $services->alias(\Metadata\Driver\DriverInterface::class, \Metadata\Driver\DriverChain::class)
        ->public();

    $services->set(\Metadata\Driver\DriverChain::class)
        ->args([['' => service(\JMS\ObjectRouting\Metadata\Driver\AttributeDriver::class)]]);

    $services->set(\JMS\ObjectRouting\Metadata\Driver\AttributeDriver::class);

    $services->alias(\Metadata\Cache\CacheInterface::class, \Metadata\Cache\FileCache::class);

    $services->set(\Metadata\Cache\FileCache::class)
        ->args([
            '%bg_object_routing.cache_dir%',
            '%kernel.debug%',
        ]);

    $services->set(\Metadata\MetadataFactory::class)
        ->args([
            '$driver' => inline_service(\Metadata\Driver\LazyLoadingDriver::class)
                ->args([
                    service('service_container'),
                    \Metadata\Driver\DriverInterface::class,
                ]),
            '$hierarchyMetadataClass' => \Metadata\ClassHierarchyMetadata::class,
            '$debug' => '%kernel.debug%',
        ])
        ->call('setCache', [service(\Metadata\Cache\CacheInterface::class)])
        ->call('setIncludeInterfaces', [true]);

    $services->alias(\Metadata\MetadataFactoryInterface::class, \Metadata\MetadataFactory::class);
};
