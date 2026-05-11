<div class="row">
    <div class="col"><h1 class="callAlert"><?php echo $homepageTitle ?></h1>
        </div>
</div>
<div class="row">
    <div class="col ">
      <p class="lead"> Добро пожаловать в SimpleMVC! </p>
    </div>
</div>


<div class="container">

 <ul id="headlines">

 <h1><?php echo $viewCategories->name; ?></h1>
   
 <?php foreach ($viewNotes as $note) { ?>
         <li class='<?php echo $note->id?>'> 
            
                
            <div class="content-wrapper"> 
               
                            
               <div> <?php if (isset($note->subcategoriesid)) { ?>
               <span class="subcategory">
                      in 
                      <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("homepage/subcategory&subcategoriesid=" . $note->subcategoriesid); ?>"> 
                       <?=$subcategoriesList[$note->subcategoriesid] ?? 'Без под категории' ?>
                      </a>  
                </span>    
                <?php } ?> 
                </div>

                <h1> <span class="title">
                     <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("homepage/edit&id=" . $note->id); ?>">
                        <?php echo htmlspecialchars($note->title); ?>
                     </a> 

                 </span>
                 </h1>



                <div> <span class="pubDate">
                      <?php echo date('j F Y', strtotime($note->publicationDate)); ?>
                      </span>
                </div>
            
                <div class="content">
                  <p> <?php echo htmlspecialchars(mb_substr($note->content, 0, 50) . "...")?></p>
                </div>  



                <div> <span class="users">
                   Автор: 
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
                </div>

                <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("homepage/edite", ['noteid' => $note->id]); ?>" 
                class="showContent" data-contentId="<?php echo $note->id?>">Показать полностью</a>
                 

            </div>
                       
                       
    <?php } ?>
    </ul>

      <p><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("homepage/index" ); ?>" class="all-notes-link">Return to Homepage</a></p>
    </div> 

