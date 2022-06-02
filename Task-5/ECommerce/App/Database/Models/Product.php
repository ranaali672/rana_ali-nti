<?php

namespace App\Database\Models;

use App\Database\Models\Model;
use App\Database\Contracts\ConnectTo;

class Product extends Model implements ConnectTo
{
    private const table = "products";
    private int $id;
    private string $name_en;
    private string $name_ar;
    private float $price;
    private int $quantity;
    private int $code;
    private int $status;
    private string $image;
    private string $details_en;
    private string $details_ar;
    private int $subcategory_id;
    private int $brand_id;
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
     * Get the value of name_en
     */
    public function getName_en()
    {
        return $this->name_en;
    }

    /**
     * Set the value of name_en
     *
     * @return  self
     */
    public function setName_en($name_en)
    {
        $this->name_en = $name_en;

        return $this;
    }

    /**
     * Get the value of name_ar
     */
    public function getName_ar()
    {
        return $this->name_ar;
    }

    /**
     * Set the value of name_ar
     *
     * @return  self
     */
    public function setName_ar($name_ar)
    {
        $this->name_ar = $name_ar;

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

    /**
     * Get the value of category_id
     */
    public function getSubcategory_id()
    {
        return $this->subcategory_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setSubcategory_id($subcategory_id)
    {
        $this->subcategory_id = $subcategory_id;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

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
     * Get the value of brand_id
     */
    public function getBrand_id()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @return  self
     */
    public function setBrand_id($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Get the value of details_ar
     */
    public function getDetails_ar()
    {
        return $this->details_ar;
    }

    /**
     * Set the value of details_ar
     *
     * @return  self
     */
    public function setDetails_ar($details_ar)
    {
        $this->details_ar = $details_ar;

        return $this;
    }

    /**
     * Get the value of details_en
     */
    public function getDetails_en()
    {
        return $this->details_en;
    }

    /**
     * Set the value of details_en
     *
     * @return  self
     */
    public function setDetails_en($details_en)
    {
        $this->details_en = $details_en;

        return $this;
    }

    public function all($status = 1)
    {
        $query = "SELECT `id`,`name_en`,`image`,`details_en`,`price` FROM `product_details` WHERE `status` = ? ORDER BY `price` ASC , `name_en` ASC";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $status);
        $stmt->execute();
        return $stmt;
    }
    public function getProductsBySub($status = 1)
    {
        $query = "SELECT `id`,`name_en`,`image`,`details_en`,`price` FROM `product_details` WHERE `status` = ? AND `subcategory_id` = ? ORDER BY `price` ASC , `name_en` ASC";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ii', $status, $this->subcategory_id);
        $stmt->execute();
        return $stmt;
    }
    public function getProductsByBrand($status = 1)
    {
        $query = "SELECT `id`,`name_en`,`image`,`details_en`,`price` FROM `product_details` WHERE `status` = ? AND `brand_id` = ? ORDER BY `price` ASC , `name_en` ASC";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ii', $status, $this->brand_id);
        $stmt->execute();
        return $stmt;
    }
    public function getProductsByCategory($status = 1)
    {
        $query = "SELECT `id`,`name_en`,`image`,`details_en`,`price` FROM `product_details` WHERE `status` = ? AND `category_id` = ? ORDER BY `price` ASC , `name_en` ASC";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ii', $status, $this->category_id);
        $stmt->execute();
        return $stmt;
    }
    public function find()
    {
        $query = "SELECT * FROM `product_details` WHERE `id` = ? ";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        return $stmt;
    }


    public function getSpecs()
    {
        $query = "SELECT
                    `products_specs`.*,
                    `specs`.`name`
                FROM
                    `products_specs`
                JOIN `specs` ON `specs`.`id` = `products_specs`.`spec_id`
                WHERE `products_specs`.`product_id` = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function getReviews()
    {
        $query = "SELECT
                        `reviews`.*,
                        CONCAT(`users`.`first_name` , ' ' , `users`.`last_name`) AS `full_name`
                    FROM
                        `reviews`
                    JOIN `users`
                    ON `users`.`id` = `reviews`.`user_id`
                    WHERE
                        `reviews`.`product_id` = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        return $stmt;
    }
}
