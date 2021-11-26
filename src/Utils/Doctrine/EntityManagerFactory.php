<?php

namespace Utils\Doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Proxy\AbstractProxyFactory as APF;
use Doctrine\Persistence\Mapping\Driver\MappingDriver;

class EntityManagerFactory
{
    public static function create(
        array $params,
        MappingDriver $mappingDriver,
        bool $devMode,
    ): EntityManager {
        AnnotationRegistry::registerLoader('class_exists');
        $config = Setup::createConfiguration(
            $devMode,
            $params['proxy_dir'],
            new NullCache(),
        );
        $config->setMetadataDriverImpl($mappingDriver);
        if (!$devMode) {
            $config->setAutoGenerateProxyClasses(APF::AUTOGENERATE_FILE_NOT_EXISTS);
        }

        return EntityManager::create($params['database'], $config);
    }
}
