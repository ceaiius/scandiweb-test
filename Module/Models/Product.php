<?php

namespace Module\Models;

use PDO;
class Product
{
    // DB
    protected $db;
    protected $table = 'products';

    // Product Properties
    public $id;
    public $SKU;
    public $name;
    public $price;
    public $type;
    public $size;
    public $weight;
    public $height;
    public $width;
    public $length;

    /**
     * @return string
     */
    public function get_table(): string
    {
        return $this->table;
    }

    // Constructor with DB
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function get(){
        
        $query = 'SELECT * FROM ' . $this->get_table() . '  ORDER BY id DESC';
        $statement  = $this->db->prepare($query);

        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Return the records as JSON
        header('Content-Type: application/json');
        echo json_encode($records);

    }

}
