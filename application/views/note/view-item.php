<?php
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-notes-nav.php'); ?>

<h2><?= $viewNotes->title ?>
    <span>
        <?= $User->returnIfAllowed("admin/notes/edit", 
            "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/edit&id=". $viewNotes->id) 
            . ">[Редактировать]</a>");?>
        
        <?= $User->returnIfAllowed("admin/notes/delete",
                "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/delete&id=". $viewNotes->id)
            .    ">[Удалить]</a>"); ?>
    </span>
    
</h2> 

<p>Контент: <?= $viewNotes->content ?></p>
<p>Зарегестрирована: <?= $viewNotes->publicationDate ?></p>

<p> Категория: <?= $viewCategories->name ?> </p>
<p> Под Категория: <?= $viewsubcategories->name?> </p>

<p> Автор: 
<?php 
$userLogins = []; 
foreach ($viewUser as $user) { 
    $selected = false; 
    foreach ($viewNotesUser as $noteuser) { 
        if ($noteuser->users_id == $user->id) { 
            $selected = true; 
            break; 
        } 
    } 
    if ($selected) { 
        $userLogins[] = $user->login; 
    } 
} 
echo implode(', ', $userLogins); 
?> 
</p>

<p> Активный:
    <?php
          if($viewNotes->active==1){
            echo "Да";
          } else {
             echo "Нет";
          }
          
       ?>
      </td>  
</p>
