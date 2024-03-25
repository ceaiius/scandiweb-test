<?php

namespace Module\Models;

use PDO;
use PDOException;

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

    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->get_table() . ' 
          SET
            SKU = :SKU,
            name = :name,
            price = :price,
            type = :type,
            size = :size,
            weight = :weight,
            height = :height,
            width = :width,
            length = :length
            ';
        $statement  = $this->db->prepare($query);

        $parameters = array(
            ':SKU' => $this->SKU,
            ':name' => $this->name,
            ':price' => $this->price,
            ':type' => $this->type,
            ':size' => $this->size,
            ':weight' => $this->weight,
            ':height' => $this->height,
            ':width' => $this->width,
            ':length' => $this->length
        );
        
        foreach ($parameters as $param => &$value) {
            $statement->bindParam($param, $value);
        }
        
        unset($value);

        try {
            $statement->execute();
            // Succesfull response
            echo json_encode(
                array('msg' => 'Product Added')
            );
            http_response_code(201);
        } catch (PDOException $e) {
            if ($e->getCode() == '23000' && $e->errorInfo[1] == 1062) {
                // Handle duplicate entry error
                echo json_encode(array('error' => 'Duplicate entry'));
                http_response_code(400); // Bad Request
            } else {
                // Handle other types of PDOException
                echo json_encode(array('error' => 'An error occurred'));
                http_response_code(500); // Internal Server Error
            }
        }
    }


    public function get(){
        
        $query = 'SELECT * FROM ' . $this->get_table() . '  ORDER BY id DESC';
        $statement  = $this->db->prepare($query);

        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($records);

    }

    public function delete($id)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ' . $id;

        $statement = $this->db->prepare($query);

        try {
            $statement->execute();
            echo json_encode(
                array('msg' => 'Product Deleted')
            );
            http_response_code(200);
        } catch (PDOException $e) {
            http_response_code(422);
            echo json_encode(
                array('msg' => 'Product Not Deleted')
            );
        }
    }

}
