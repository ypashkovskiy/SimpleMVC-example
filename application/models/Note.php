<?php
namespace application\models;
/* 
 * class Note
 * 
 * 
 */

class Note extends BaseExampleModel {
    
    public string $tableName = "notes";
    
    public string $orderBy = 'publicationDate ASC';
    
    public ?int $id = null;
    
    public $title = null;
    
    public $content = null;
    
    public $publicationDate = null;

    public $categoryId = null;

    public $subcategoriesid = null;

    public $active = 0;
    
    
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (title, content, publicationDate, categoryId, subcategoriesid, active ) 
        VALUES (:title, :content, :publicationDate, :categoryId,:subcategoriesid, :active)"; 
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":publicationDate", (new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STMT);
        $st->bindValue( ":title", $this->title, \PDO::PARAM_STR );

        $st->bindValue( ":content", $this->content, \PDO::PARAM_STR );
        $st->bindValue( ":categoryId", $this->categoryId, \PDO::PARAM_INT );
        $st->bindValue( ":subcategoriesid", $this->subcategoriesid, \PDO::PARAM_INT );
        $st->bindValue( ":active", $this->active, \PDO::PARAM_INT );
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    public function update()
    {

    $fields = [
      "publicationDate = :publicationDate",
      "title = :title",
      "content = :content",
      "active = :active"
    ];

// 2. Подготавливаем значения для bindValue
    $params = [
      ":publicationDate" => [(new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STR],
      ":title" => [$this->title, \PDO::PARAM_STR],
      ":content" => [$this->content, \PDO::PARAM_STR],
      ":active" => [$this->active, \PDO::PARAM_INT],
      ":id" => [$this->id, \PDO::PARAM_INT]
    ];

// 3. Условно добавляем категории, если они не ""
    if ($this->categoryId != "") {
      $fields[] = "categoryId = :categoryId";
      $params[":categoryId"] = [$this->categoryId, \PDO::PARAM_INT];
    }

    if ($this->subcategoriesid != "") {
      $fields[] = "subcategoriesid = :subcategoriesid";
      $params[":subcategoriesid"] = [$this->subcategoriesid, \PDO::PARAM_INT];
    }

// 4. Собираем SQL
     $sql = "UPDATE {$this->tableName} SET " . implode(", ", $fields) . " WHERE id = :id";

     $st = $this->pdo->prepare($sql);

// 5. Привязываем все параметры из массива
    foreach ($params as $placeholder => $data) {
        $st->bindValue($placeholder, $data[0], $data[1]);
     }

    $st->execute();

    
    }


  
}

