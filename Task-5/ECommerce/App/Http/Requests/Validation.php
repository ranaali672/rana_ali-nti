<?php

namespace App\Http\Requests;

use App\Database\Models\Model;

class Validation
{
    private array $errors = [];
    private string $value;
    private string $key;

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the value of key
     *
     * @return  self
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function getError(string $error)
    {
        // first_name
        if(isset($this->errors[$error])){
            foreach($this->errors[$error] AS $error){
                return $error;
            }
        }
        return false;
    }

    public function required(): self
    {
        if (empty($this->value)) {
            $this->errors[$this->key][__FUNCTION__] = GetError::message("{$this->key} is required");
        }
        return $this;
    }
    public function string(): self
    {
        if (!is_string($this->value)) {
            $this->errors[$this->key][__FUNCTION__] = GetError::message("{$this->key} must be string");
        }
        return $this;
    }
    public function min(int $min): self
    {
        if (strlen($this->value) < $min) {
            $this->errors[$this->key][__FUNCTION__] = GetError::message("{$this->key} must be more than {$min} characters");
        }
        return $this;
    }
    public function max(int $max): self
    {
        if (strlen($this->value) > $max) {
            $this->errors[$this->key][__FUNCTION__] = GetError::message("{$this->key} must be less than {$max} characters");
        }
        return $this;
    }

    public function digits(int $digits): self
    {
        if (strlen($this->value) != $digits) {
            $this->errors[$this->key][__FUNCTION__] = GetError::message("{$this->key} must be {$digits} digits");
        }
        return $this;
    }

    public function in(array $array): self
    {
        if (!in_array($this->value, $array)) {
            $this->errors[$this->key][__FUNCTION__] = GetError::message("{$this->key} must be " . implode(',', $array));
        }
        return $this;
    }

    public function regex(string $pattern, string $message = NULL): self
    {
        if(!$message){
           $message = "{$this->key} invalid"; 
        } 
        if (!preg_match($pattern, $this->value)) {
            $this->errors[$this->key][__FUNCTION__] = GetError::message($message);
        }
        return $this;
    }

    public function confirmed(string $comparedValue): self
    {
        if ($this->value != $comparedValue) {
            $this->errors[$this->key][__FUNCTION__] = GetError::message("{$this->key} dosen't match {$this->key} confirmation}");
        }
        return $this;
    }

    public function unique(string $table, string $column)
    {
        $model = new Model;
        $stmt = $model->con->prepare("SELECT * FROM `{$table}` WHERE `{$column}` = ?");
        $stmt->bind_param('s',$this->value);
        $stmt->execute();
        if($stmt->get_result()->num_rows == 1){
            $this->errors[$this->key][__FUNCTION__] = GetError::message("{$column} is already exists");
        }
        return $this;
    }

    public function exists(string $table, string $column)
    {
        $model = new Model;
        $stmt = $model->con->prepare("SELECT * FROM `{$table}` WHERE `{$column}` = ?");
        $stmt->bind_param('s',$this->value);
        $stmt->execute();
        if($stmt->get_result()->num_rows == 0){
            $this->errors[$this->key][__FUNCTION__] = GetError::message("this {$column} dosen't match our records");
        }
        return $this;
    }
}
