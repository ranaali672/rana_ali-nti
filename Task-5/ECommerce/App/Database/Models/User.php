<?php
namespace App\Database\Models;

use App\Database\Contracts\ConnectTo;
use App\Database\Models\Model;

class User extends Model implements ConnectTo {
    private const table = "users";
    private int $id;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;
    private string $phone;
    private string $gender;
    private int $code;
    private  $image;
    private int $status;
    private string $email_verified_at;
    private string $phone_verified_at;
    private string $created_at;
    private string $updated_at;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of first_name
     */ 
    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */ 
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */ 
    public function getLast_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */ 
    public function setLast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = password_hash($password,PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of gender
     */ 
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */ 
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of email_verified_at
     */ 
    public function getEmail_verified_at()
    {
        return $this->email_verified_at;
    }

    /**
     * Set the value of email_verified_at
     *
     * @return  self
     */ 
    public function setEmail_verified_at($email_verified_at)
    {
        $this->email_verified_at = $email_verified_at;

        return $this;
    }

    /**
     * Get the value of phone_verified_at
     */ 
    public function getPhone_verified_at()
    {
        return $this->phone_verified_at;
    }

    /**
     * Set the value of phone_verified_at
     *
     * @return  self
     */ 
    public function setPhone_verified_at($phone_verified_at)
    {
        $this->phone_verified_at = $phone_verified_at;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function insert()
    {
        $query = "INSERT INTO ".self::table." (first_name,last_name,email,phone,password,gender,code) 
        VALUES (? , ? , ? , ? , ?, ? , ?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ssssssi',$this->first_name,$this->last_name,$this->email,$this->phone,$this->password,$this->gender,$this->code);
        return $stmt->execute();
    }

    public function checkUserCode()
    {
        $query = "SELECT * FROM ".self::table." WHERE `email` = ? AND `code` = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('si',$this->email,$this->code);
        $stmt->execute();
        return $stmt;
    }

    public function makeUserVerified() {
        $query = "UPDATE ".self::table." SET email_verified_at = ? WHERE email = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss',$this->email_verified_at,$this->email);
        return $stmt->execute();
    }

    public function updateCodeByEamil() {
        $query = "UPDATE ".self::table." SET code = ? WHERE email = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss',$this->code,$this->email);
        return $stmt->execute();
    }

    public function updatePasswordByEmail() {
        $query = "UPDATE ".self::table." SET password = ? WHERE email = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss',$this->password,$this->email);
        return $stmt->execute();
    }

    public function update() {
        $image = "default.jpg";
        if($this->image){
            $image = $this->image;
        }
        $query = "UPDATE ".self::table." SET first_name = ?,last_name = ?,gender = ?, phone = ? ,image = ? WHERE email = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ssssss',$this->first_name,$this->last_name,$this->gender,$this->phone,$image,$this->email);
        return $stmt->execute();
    }

    public function getUserByEmail()
    {
        $query = "SELECT * FROM ".self::table." WHERE `email` = ? ";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$this->email);
        $stmt->execute();
        return $stmt;
    }
    

    
}