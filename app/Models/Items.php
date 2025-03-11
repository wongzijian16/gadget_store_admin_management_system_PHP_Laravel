<?php
// FOR TEMPORARY DEVELOPMENT
namespace App\Models;

class Items {
    private $itemCode;
    private $itemName;
    private $itemDesc;
    private $itemPrice = 0.00;
    
    public function __construct($code, $name, $desc, $price) {
        $this->itemCode = $code;
        $this->itemName = $name;
        $this->itemDesc = $desc;
        $this->itemPrice = $price;
    }
    
    public function setItemName($name) {
        $this->itemName = $name;
    }
    
    public function setItemDesc($desc) {
        $this->itemDesc = $desc;
    }
    
    public function setItemPrice($price) {
        $this->itemPrice = $price;
    }
    
    public function getItemCode() {
        return $this->itemCode;
    }
    
    public function getItemName() {
        return $this->itemName;
    }
    
    public function getItemDesc() {
        return $this->itemDesc;
    }
    
    public function getItemPrice() {
        return $this->itemPrice;
    }
}