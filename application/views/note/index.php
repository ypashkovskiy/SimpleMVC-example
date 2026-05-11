<?php 
use ItForFree\SimpleMVC\Config;
use \ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-notes-nav.php'); ?>

<h2>List notes</h2>

<?php if (!empty($notes)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">Оглавление</th>
      <th scope="col">Посвящается</th>
      <th scope="col">Дата</th>
      <th scope="col">Категория</th>
      <th scope="col">Под Категория</th>
      <th scope="col">Пользователи</th>
      <th scope="col">Активный</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($notes as $note): ?>
    <tr>
        <td> <?= "<a href=" . WebRouter::link('admin/notes/index&id=' 
		. $note->id . ">{$note->title}</a>" ) ?> </td>
        <td>
           <p> <?php echo htmlspecialchars(mb_substr($note->content, 0, 20) . "...")?></p>
        </td>
        <td> <?= $note->publicationDate ?> </td>

        <td>
          <?= $categoriesList[$note->categoryId] ?? 'Без категории' ?>
        </td> 

        <td>
          <?= $subcategoriesList[$note->subcategoriesid] ?? 'Без под категории' ?>
        </td> 

      
        <td>
        <?php
        $userLogins = [];
        foreach ($viewUser as $user) {
        $selected = '';
        // Проверяем, привязана ли текущая заметка ($viewNotes->id) к этому пользователю
        foreach ($viewNotesUser as $noteuser) {
            if ($noteuser->users_id == $user->id && $noteuser->notes_id == $note->id) {
                $selected = 'selected';
                break; // Нашли совпадение — выходим из внутреннего цикла
            }
        }
        if ($selected) {
            $userLogins[] = $user->login;
        }
        }
       // Выводим логины через запятую
       echo implode(', ', $userLogins);
       ?>
       </td>
        

       <td>
       <?php
          if($note->active==1){
            echo "Да";
          } else {
             echo "Нет";
          }
          
       ?>
      </td>  

    </tr>
    <?php endforeach; ?>


    

    </tbody>
</table>

<?php else:?>
    <p> Список заметок пуст</p>
<?php endif; ?>

