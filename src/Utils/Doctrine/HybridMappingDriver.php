<?php

namespace Utils\Doctrine;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\Mapping\Driver\AnnotationDriver as AbstractAnnotationDriver;
use Tracy\ILogger;

class HybridMappingDriver extends AbstractAnnotationDriver
{
    public function __construct(
        private AnnotationDriver $annotationDriver,
        private AttributeDriver $attributeDriver,
        private ILogger $logger,
        private bool $devMode,
    ) {
    }

    public function loadMetadataForClass($className, ClassMetadata $metadata): void
    {
        try {
            $this->attributeDriver->loadMetadataForClass($className, $metadata);
            $this->logEvent(sprintf('AttrDriver utilized: %s', $className));
            return;
        } catch (MappingException $me) {
            // Class X is not a valid entity, so try the other driver
            if (!preg_match('/^Class(.)*$/', $me->getMessage())) {// meh
                $this->logEvent('different MappingException: ' . $me->getMessage());
                throw $me;
            }
        }
        $this->annotationDriver->loadMetadataForClass($className, $metadata);
        $this->logEvent(sprintf('AnnotDriver utilized: %s', $className));
    }

    public function isTransient($className): bool
    {
        return $this->attributeDriver->isTransient($className)
            || $this->annotationDriver->isTransient($className);
    }

    private function logEvent(string $message): void
    {
        if (!$this->devMode) {
            return;
        }
        $this->logger->log($message, 'hybrid_mapping_driver');
    }
}
