<?php

/**
 * Используется для передачи глобальных значений
 *
 * @author capit
 */
namespace diplomApp\classes;

class Registry implements \ArrayAccess {
    private $vars = array();
    
    public function set($key, $var) {
        if (isset($this->vars[$key])) {
            throw new Exception('Невозможно присвоить значение '. $var. '['. $key. ']. Уже присвоено.');
        }
        $this->vars[$key] = $var;
        return TRUE;
    }
    
    public function get($key) {
        if (!isset($this->vars[$key])) {
            return NULL;
        }
        return $this->vars[$key];
    }
    
    public function del($key) {
        unset($this->vars[$key]);
    }
    
    public function offsetExists($offset) {
        return isset($this->vars[$offset]);
    }
    
    public function offsetGet($offset) {
        return $this->get($offset);
    }
    
    public function offsetSet($offset, $value) {
        $this->set($offset, $value);
    }
    
    public function offsetUnset($offset) {
        unset($this->vars[$offset]);
    }
}
