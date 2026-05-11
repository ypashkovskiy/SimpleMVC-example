<?php
namespace application\models;
/* 
 * class Note
 * 
 * 
 */

class NotesUser extends BaseExampleModel {
    
    public string $tableName = "notes_user";
    
    public string $orderBy = 'notes_id ASC';
         
    public ?int $notes_id = null;

    public ?int $users_id= null;



    public function getByIdNotesUser(int $id, string $tableName = '')
    {  
        $tableName = !empty($tableName) ? $tableName : $this->tableName;
        
        $sql = "SELECT * FROM $tableName where notes_id = :id";      
              
        $st = $this->pdo->prepare($sql); 
        
        $st->bindValue(":id", $id, \PDO::PARAM_INT);
        $st->execute();

        
        $modelClassName = static::class;
        while ($row = $st->fetch()) {
            $example = new $modelClassName($row);
            $list[] = $example;
        }
        
     
            return array("results" => $list);
      }    
    
    
    public function insert($notes_id,$users_id)
    {
        $sql = "INSERT INTO $this->tableName (notes_id, users_id) VALUES (:notes_id, :users_id)"; 
        $st = $this->pdo->prepare ( $sql );
        
        $st->bindValue( ":notes_id", $notes_id, \PDO::PARAM_INT );
        $st->bindValue( ":users_id", $users_id, \PDO::PARAM_INT );

        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
   public function deleteNotesUser($notes_id, $users_id)
    {
        $st = $this->pdo->prepare("DELETE FROM $this->tableName WHERE notes_id = :notes_id and users_id=:users_id LIMIT 1" );
        $st->bindValue( ":notes_id", $notes_id, \PDO::PARAM_INT );
        $st->bindValue( ":users_id", $users_id, \PDO::PARAM_INT );
        $st->execute();
    }   

  }