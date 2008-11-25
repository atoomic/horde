<?php
/**
 * TODO
 *
 * Copyright 2005-2008 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * @author  Michael Slusarz <slusarz@horde.org>
 * @package IMP
 */
class Imple
{
    /**
     * Parameters needed by the subclasses.
     *
     * @var array
     */
    protected $_params = array();

    /**
     * Attempts to return a concrete Imple instance based on $imple.
     *
     * @param string $imple  The type of concrete Imple subclass to return based
     *                       on the imple type indicated. The code is
     *                       dynamically included.
     * @param array $params  The configuration parameter array.
     *
     * @return mixed  The newly created concrete Imple instance, or false on
     *                error.
     */
    static public function factory($imple, $params = array())
    {
        $imple = basename($imple);
        if (!$imple) {
            return false;
        }

        $class = 'Imple_' . $imple;
        if (!class_exists($class)) {
            include_once dirname(__FILE__) . '/Imple/' . $imple . '.php';
            if (!class_exists($class)) {
                return false;
            }
        }

        return new $class($params);
    }

    /**
     * Constructor.
     *
     * @param array $params  Any parameters needed by the class.
     */
    function __construct($params)
    {
        $this->_params = $params;
        $this->attach();
    }

    /**
     * Attach the Imple object to a javascript event.
     */
    public function attach()
    {
        Horde::addScriptFile('prototype.js', 'horde', true);
        Horde::addScriptFile('effects.js', 'horde', true);
    }

    /**
     * TODO
     *
     * @param TODO
     */
    public function handle($args)
    {
    }

    /**
     * Return the rendered HTML code.
     *
     * @return string  The HTML code.
     */
    public function html()
    {
    }

    /**
     * Generate a random ID string.
     *
     * @return string  The random ID string.
     */
    protected function _randomid()
    {
        return 'imple_' . uniqid(mt_rand());
    }

}
