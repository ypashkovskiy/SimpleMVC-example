<?php
namespace application\models;
/* 
 * class Note
 * 
 * 
 */

class Subcategories extends BaseExampleModel {
    
    public string $tableName = "subcategories";
    
    public string $orderBy = 'id ASC';
    
    public ?int $id = null;

    public $categories_id= null;
    
    public $name = null;

    
    public $description = null;


        
    
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (categories_id, name, description) VALUES (:categories_id, :name, :description)"; 
        $st = $this->pdo->prepare ( $sql );

        $st->bindValue( ":categories_id", $this->categories_id, \PDO::PARAM_INT );
        
        $st->bindValue( ":name", $this->name, \PDO::PARAM_STR );

        $st->bindValue( ":description", $this->description, \PDO::PARAM_STR );
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    public function update()
    {
        $sql = "UPDATE $this->tableName SET categories_id=:categories_id, name=:name, description=:description WHERE id = :id";  
        $st = $this->pdo->prepare ( $sql );
        
      
        $st->bindValue( ":name", $this->name, \PDO::PARAM_STR );

        $st->bindValue( ":description", $this->description, \PDO::PARAM_STR );
        $st->bindValue( ":categories_id", $this->categories_id, \PDO::PARAM_INT );
        $st->bindValue( ":id", $this->id, \PDO::PARAM_INT );
        $st->execute();
    }
}
