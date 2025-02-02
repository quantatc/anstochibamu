<?php

namespace GoDaddy\WordPress\MWC\Common\Components\Traits;

use GoDaddy\WordPress\MWC\Common\Components\Contracts\ComponentContract;
use GoDaddy\WordPress\MWC\Common\Components\Contracts\ConditionalComponentContract;
use GoDaddy\WordPress\MWC\Common\Components\Exceptions\ComponentClassesNotDefinedException;
use GoDaddy\WordPress\MWC\Common\Components\Exceptions\ComponentLoadFailedException;
use GoDaddy\WordPress\MWC\Common\Features\AbstractFeature;
use GoDaddy\WordPress\MWC\Common\Features\EnabledFeaturesCache;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;

/**
 * Common functionality for classes that need to load one or more components.
 */
trait HasComponentsTrait
{
    /**
     * Gets an array of fully qualified names of components classes to instantiate.
     *
     * @return array
     * @throws ComponentClassesNotDefinedException
     */
    protected function getComponentClasses() : array
    {
        if (! property_exists($this, 'componentClasses')) {
            throw new ComponentClassesNotDefinedException(get_class($this).' must define a componentClasses property with a list of component classes to instantiate.');
        }

        return ArrayHelper::wrap($this->componentClasses);
    }

    /**
     * Instantiates all registered components.
     *
     * @return ComponentContract[]
     * @throws ComponentClassesNotDefinedException|ComponentLoadFailedException
     */
    protected function loadComponents() : array
    {
        /** @throws ComponentClassesNotDefinedException|ComponentLoadFailedException */
        return ArrayHelper::whereNotNull(array_map([static::class, 'maybeLoadComponent'], $this->getComponentClasses()), false);
    }

    /**
     * Maybe loads a component that can be instantiated.
     *
     * @param string $componentClassName
     * @return ComponentContract|null
     * @throws ComponentLoadFailedException
     */
    public static function maybeLoadComponent(string $componentClassName)
    {
        if ($component = static::maybeInstantiateComponent($componentClassName)) {
            $component->load();
            static::maybeCacheEnabledFeature($component);
        }

        return $component;
    }

    /**
     * Attempts to create an instance of the given class name.
     *
     * Throws an exception if the given class name is not a component.
     *
     * @param string $className the name of the class to instantiate
     * @return ComponentContract|null
     * @throws ComponentLoadFailedException
     */
    public static function maybeInstantiateComponent(string $className)
    {
        if (! is_a($className, ComponentContract::class, true)) {
            throw new ComponentLoadFailedException("{$className} does not implement the ComponentContract interface.");
        }

        if (is_a($className, ConditionalComponentContract::class, true) && ! $className::shouldLoad()) {
            return null;
        }

        return new $className();
    }

    /**
     * Adds a feature to the Enabled Features Cache if it isn't already in there.
     *
     * @param ComponentContract $component
     * @return void
     */
    public static function maybeCacheEnabledFeature(ComponentContract $component)
    {
        if (is_a($component, AbstractFeature::class)) {
            $enabledFeaturesCache = EnabledFeaturesCache::getNewInstance();
            $cache = (array) $enabledFeaturesCache->get();
            if (! ArrayHelper::contains($cache, $component::getName())) {
                $cache[] = $component::getName();
                $enabledFeaturesCache->set($cache);
            }
        }
    }
}
