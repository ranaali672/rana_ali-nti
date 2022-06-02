<?php
namespace App\Helpers;
class Media {
    private array $file;
    private string $extension;
    private string $fileName;
    private float $size;
    private array $errors = [];
    public function __construct(array $file) {
        $this->file = $file;
        $this->extension = explode('/',$file['type'])[1];
        $this->fileName = $file['name']; 
        $this->size = $file['size'];
    }
    public function validateOnSize(int $maxSize) :self
    {
        if($this->size > $maxSize){
            $this->errors['size'] = "Maximum Size Must Be Less Than {$maxSize} Bytes";
        }
        return $this;
    }
    public function validateOnExtension(array $availableExtensions) :self
    {
        if(!in_array($this->extension,$availableExtensions)){
            $this->errors['extension'] = "Available Extensions Are: ".implode(',',$availableExtensions);
        }
        return $this;
    }

    public function upload(string $assets_path) :bool
    {
        // assets/img/users/
        $this->fileName = uniqid() . '.' . $this->extension; // as23df1d23sfsa21223.jpg
        $permenatPath = $assets_path . $this->fileName;  // assets/img/users/as23df1d23sfsa21223.jpg
        try{
            move_uploaded_file($this->file['tmp_name'],$permenatPath);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFileName()
    {
        return $this->fileName;
    }
}