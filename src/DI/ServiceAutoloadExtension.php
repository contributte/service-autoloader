<?php

namespace Minetro\Autoloader\DI;

use Minetro\Autoloader\AutoloadService;
use Nette\Caching\IStorage;
use Nette\Caching\Storages\DevNullStorage;
use Nette\DI\CompilerExtension;
use Nette\DI\Helpers;
use Nette\Loaders\RobotLoader;
use Nette\Reflection\ClassType;
use Nette\Utils\Validators;

final class ServiceAutoloadExtension extends CompilerExtension
{

    /** @var array */
    private $defaults = [
        'dirs' => [
            '%appDir%',
        ],
        'annotations' => [
            '@Service',
        ],
        'interfaces' => [
            AutoloadService::class,
        ],
        'decorator' => [
            'inject' => FALSE,
        ],
    ];

    public function loadConfiguration()
    {
        // Cause we don't want merge arrays (annotations, interfaces, etc..)
        $config = $this->getCustomConfig($this->defaults);

        // Validate config
        Validators::assertField($config, 'dirs', 'array');
        Validators::assertField($config, 'annotations', 'array|null');
        Validators::assertField($config, 'interfaces', 'array|null');
        Validators::assertField($config, 'decorator', 'array');

        // Expand config (cause %appDir% etc..)
        $this->config = Helpers::expand($config, $this->getContainerBuilder()->parameters);
    }


    /**
     * Tweak DI container
     */
    public function beforeCompile()
    {
        $config = $this->getConfig();

        // No folders to scan
        if (!$config['dirs']) {
            return;
        }

        // Find services
        $classes = [];
        if ($config['annotations']) {
            $classes = array_merge($classes, $this->findByAnnotations($config['dirs'], $config['annotations']));
        }

        if ($config['interfaces']) {
            $classes = array_merge($classes, $this->findByInterfaces($config['dirs'], $config['interfaces']));
        }

        // Autoload services
        if ($classes) {
            $this->autoloadServices($classes, $config['decorator']);
        }
    }

    /**
     * @param array $dirs
     * @param array $annotations
     * @return array
     */
    private function findByAnnotations(array $dirs, array $annotations)
    {
        $loader = $this->createLoader();
        $loader->addDirectory($dirs);
        $loader->rebuild();
        $loader->register();

        $classes = [];
        foreach (array_keys($loader->getIndexedClasses()) as $class) {
            // Skip not existing class
            if (!class_exists($class, TRUE)) continue;

            // Detect by reflection
            $ct = new ClassType($class);

            // Skip abstract
            if ($ct->isAbstract()) continue;

            // Does class has one of the annotation?
            foreach ($annotations as $annotation) {
                if ($ct->hasAnnotation(trim($annotation, '@'))) {
                    $classes[] = $ct->getName();
                }
            }
        }

        return $classes;
    }

    /**
     * @param array $dirs
     * @param array $interfaces
     * @return array
     */
    private function findByInterfaces(array $dirs, array $interfaces)
    {
        $loader = $this->createLoader();
        $loader->addDirectory($dirs);
        $loader->rebuild();
        $loader->register();

        $classes = [];
        foreach (array_keys($loader->getIndexedClasses()) as $class) {
            // Skip not existing class
            if (!class_exists($class, TRUE)) continue;

            // Detect by reflection
            $ct = new ClassType($class);

            // Skip abstract
            if ($ct->isAbstract()) continue;

            // Does class implement one of given interface
            foreach ($interfaces as $interface) {
                if ($ct->implementsInterface($interface)) {
                    $classes[] = $ct->getName();
                }
            }
        }

        return $classes;
    }

    /**
     * @param array $classes
     * @param array $decorator
     * @return void
     */
    private function autoloadServices(array $classes, array $decorator)
    {
        $builder = $this->getContainerBuilder();

        // Remove duplicities
        $services = array_unique($classes);

        // Register as services
        $pointer = 1;
        foreach ($services as $service) {
            $def = $builder->addDefinition($this->prefix($pointer++))
                ->setClass($service);

            // Should has inject attribute?
            $def->setInject((bool) $decorator['inject']);
        }
    }

    /**
     * @return RobotLoader
     */
    private function createLoader()
    {
        $builder = $this->getContainerBuilder();
        $cacheStorage = $builder->getByType(IStorage::class);

        // Fallback to DevNullStorage
        if (!$cacheStorage) {
            $cacheStorage = new DevNullStorage();
        }

        $robot = new RobotLoader();
        $robot->setCacheStorage($cacheStorage);

        return $robot;
    }

    /**
     * @param array $defaults
     * @return array
     */
    private function getCustomConfig($defaults)
    {
        // Clear default values, because nette merge config arrays
        if (isset($this->config['dirs'])) {
            $defaults['dirs'] = [];
        }

        if (isset($this->config['annotations'])) {
            $defaults['annotations'] = [];
        }

        if (isset($this->config['interfaces'])) {
            $defaults['interfaces'] = [];
        }

        // Merge with defaults
        return $this->validateConfig($defaults);
    }

}
