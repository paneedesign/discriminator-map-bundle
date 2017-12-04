<?php
/**
 * Created by PhpStorm.
 * User: fabianoroberto
 * Date: 04/12/17
 * Time: 12:51
 */

namespace PaneeDesign\DiscriminatorMapBundle\EventListener;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class DiscriminatorMapListener
{
    private $maps;

    /**
     * Constructor
     *
     * @param array $maps
     */
    public function __construct($maps)
    {
        $this->maps = $maps;
    }

    /**
     * Sets the discriminator map according to the config
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $metadata = $eventArgs->getClassMetadata();
        $class    = $metadata->getReflectionClass();

        if ($class === null) {
            $class = new \ReflectionClass($metadata->getName());
        }

        foreach ($this->maps as $table => $config) {
            if ($class->getName() == $config['entity']) {
                $reader = new AnnotationReader;
                $maps = array();

                if ($mapsAnnotation = $reader->getClassAnnotation(
                    $class,
                    'Doctrine\ORM\Mapping\DiscriminatorMap'
                )) {
                    $maps = $mapsAnnotation->value;
                }

                $maps = array_merge($maps, $config['children']);
                $maps = array_merge($maps, array($table => $config['entity']));

                $metadata->setDiscriminatorMap($maps);
            }
        }
    }
}