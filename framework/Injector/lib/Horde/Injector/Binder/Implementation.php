<?php
/**
 * TODO
 *
 * @author   Bob Mckee <bmckee@bywires.com>
 * @author   James Pepin <james@jamespepin.com>
 * @category Horde
 * @package  Horde_Injector
 */
class Horde_Injector_Binder_Implementation implements Horde_Injector_Binder
{
    /**
     * TODO
     */
    protected $_implementation;

    /**
     * TODO
     */
    protected $_setters;

    /**
     * TODO
     */
    public function __construct($implementation)
    {
        $this->_implementation = $implementation;
        $this->_setters = array();
    }

    /**
     * TODO
     */
    public function getImplementation()
    {
        return $this->_implementation;
    }

    /**
     * TODO
     */
    public function bindSetter($method)
    {
        $this->_setters[] = $method;
        return $this;
    }

    /**
     * TODO
     */
    public function equals(Horde_Injector_Binder $otherBinder)
    {
        return (($otherBinder instanceof Horde_Injector_Binder_Implementation) &&
                ($otherBinder->getImplementation() == $this->_implementation));
    }

    /**
     * TODO
     */
    public function create(Horde_Injector $injector)
    {
        $reflectionClass = new ReflectionClass($this->_implementation);
        $this->_validateImplementation($reflectionClass);
        $instance = $this->_getInstance($injector, $reflectionClass);
        $this->_callSetters($injector, $instance);
        return $instance;
    }

    /**
     * TODO
     */
    protected function _validateImplementation(ReflectionClass $reflectionClass)
    {
        if ($reflectionClass->isAbstract() || $reflectionClass->isInterface()) {
            throw new Horde_Injector_Exception('Cannot bind interfaces or abstract classes "' . $this->_implementation . '" to an interface.');
        }
    }

    /**
     * TODO
     */
    protected function _getInstance(Horde_Injector $injector, ReflectionClass $class)
    {
        return $class->getConstructor()
            ? $class->newInstanceArgs($this->_getMethodDependencies($injector, $class->getConstructor()))
            : $class->newInstance();
    }

    /**
     * TODO
     */
    protected function _callSetters(Horde_Injector $injector, $instance)
    {
        foreach ($this->_setters as $setter) {
            $reflectionMethod = new ReflectionMethod($instance, $setter);
            $reflectionMethod->invokeArgs(
                $instance,
                $this->_getMethodDependencies($injector, $reflectionMethod)
            );
        }
    }

    /**
     */
    protected function _getMethodDependencies(Horde_Injector $injector, ReflectionMethod $method)
    {
        $dependencies = array();

        try {
            foreach ($method->getParameters() as $parameter) {
                $dependencies[] = $this->_getParameterDependency($injector, $parameter);
            }
        } catch (Horde_Injector_Exception $e) {
            throw new Horde_Injector_Exception("$method has unfulfilled dependencies ($parameter)", 0, $e);
        }

        return $dependencies;
    }

    /**
     */
    protected function _getParameterDependency(Horde_Injector $injector, ReflectionParameter $parameter)
    {
        if ($parameter->getClass()) {
            return $injector->getInstance($parameter->getClass()->getName());
        } elseif ($parameter->isOptional()) {
            return $parameter->getDefaultValue();
        }

        throw new Horde_Injector_Exception("Untyped parameter \$" . $parameter->getName() . "can't be fulfilled");
    }
}
