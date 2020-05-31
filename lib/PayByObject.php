<?php

namespace PayBy;

use ArrayAccess;
use InvalidArgumentException;
use JsonSerializable;

class PayByObject implements ArrayAccess, JsonSerializable
{
    /**
     * @var array Attributes that should not be sent to the API because they're
     *    not updatable (e.g. API key, ID).
     */
    public static $permanentAttributes;
    /**
     * @var array Attributes that are nested but still updatable from the parent
     *    class's URL (e.g. metadata).
     */
    public static $nestedUpdatableAttributes;

    public static function init()
    {
        self::$permanentAttributes = new Util\Set(['id']);
        self::$nestedUpdatableAttributes = new Util\Set(['metadata']);
    }

    protected $_values;
    protected $_unsavedValues;
    protected $_transientValues;
    protected $_retrieveOptions;

    public function __construct($id = null)
    {
        $this->_values = [];
        $this->_unsavedValues = new Util\Set();
        $this->_transientValues = new Util\Set();

        $this->_retrieveOptions = [];
        if (is_array($id)) {
            foreach ($id as $key => $value) {
                if ($key != 'id') {
                    $this->_retrieveOptions[$key] = $value;
                }
            }
            $id = $id['id'];
        }

        $id !== null && $this->id = $id;
    }

    // Standard accessor magic methods
    public function __set($k, $v)
    {
        if ($v === "") {
            throw new InvalidArgumentException(
                'You cannot set \''.$k.'\'to an empty string. '
                .'We interpret empty strings as NULL in requests. '
                .'You may set obj->'.$k.' = NULL to delete the property'
            );
        }

        if (self::$nestedUpdatableAttributes->includes($k) && isset($this->$k) && is_array($v)) {
            $this->$k->replaceWith($v);
        } else {
            // TODO: may want to clear from $_transientValues.  (Won't be user-visible.)
            $this->_values[$k] = $v;
        }
        if (!self::$permanentAttributes->includes($k)) {
            $this->_unsavedValues->add($k);
        }
    }
    public function __isset($k)
    {
        return isset($this->_values[$k]);
    }
    public function __unset($k)
    {
        unset($this->_values[$k]);
        $this->_transientValues->add($k);
        $this->_unsavedValues->discard($k);
    }
    public function __get($k)
    {
        if (array_key_exists($k, $this->_values)) {
            return $this->_values[$k];
        } elseif ($this->_transientValues->includes($k)) {
            $class = get_class($this);
            $attrs = join(', ', array_keys($this->_values));
            $message = "PayBy Notice: Undefined property of $class instance: $k. "
                . "HINT: The $k attribute was set in the past, however. "
                . "It was then wiped when refreshing the object "
                . "with the result returned by PayBy's API, "
                . "probably as a result of a save(). The attributes currently "
                . "available on this object are: $attrs";
            error_log($message);
            return null;
        } else {
            $class = get_class($this);
            error_log("PayBy Notice: Undefined property of $class instance: $k");
            return null;
        }
    }

    // ArrayAccess methods
    public function offsetSet($k, $v)
    {
        $this->$k = $v;
    }

    public function offsetExists($k)
    {
        return array_key_exists($k, $this->_values);
    }

    public function offsetUnset($k)
    {
        unset($this->$k);
    }
    public function offsetGet($k)
    {
        return array_key_exists($k, $this->_values) ? $this->_values[$k] : null;
    }

    public function jsonSerialize()
    {
        return $this->__toStdObject();
    }

    public function __toJSON()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode($this->__toStdObject(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        } else {
            return json_encode($this->__toStdObject());
        }
    }

    public function __toString()
    {
        return $this->__toJSON();
    }

    public function __toArray($recursive = false)
    {
        if ($recursive) {
            return Util\Util::convertPayByObjectToArray($this->_values);
        } else {
            return $this->_values;
        }
    }

    public function __toStdObject()
    {
        return Util\Util::convertPayByObjectToStdObject($this->_values);
    }

    /**
     * This unfortunately needs to be public to be used in Util.php
     *
     * @param stdObject $values
     *
     * @return PayByObject The object constructed from the given values.
     */
    public static function constructFrom($values)
    {
        $obj = new static(isset($values->id) ? $values->id : null);
        $obj->refreshFrom($values);
        return $obj;
    }

    /**
     * Refreshes this object using the provided values.
     *
     * @param stdObject $values
     * @param boolean $partial Defaults to false.
     */
    public function refreshFrom($values, $partial = false)
    {
        // Wipe old state before setting new.  This is useful for e.g. updating a
        // customer, where there is no persistent card parameter.  Mark those values
        // which don't persist as transient
        if ($partial) {
            $removed = new Util\Set();
        } else {
            $removed = array_diff(array_keys($this->_values), array_keys(get_object_vars($values)));
        }

        foreach ($removed as $k) {
            if (self::$permanentAttributes->includes($k)) {
                continue;
            }
            unset($this->$k);
        }

        foreach ($values as $k => $v) {
            if (self::$permanentAttributes->includes($k)) {
                continue;
            }

            if (self::$nestedUpdatableAttributes->includes($k) && is_object($v)) {
                $this->_values[$k] = AttachedObject::constructFrom($v);
            } else {
                $this->_values[$k] = Util\Util::convertToPayByObject($v);
            }

            $this->_transientValues->discard($k);
            $this->_unsavedValues->discard($k);
        }
    }
}

PayByObject::init();
