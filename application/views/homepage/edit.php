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

<h1><?php echo $viewNotes->title; ?></h1>
   
         <li class='<?php echo $viewNotes->id?>'> 
            
                
            <div class="content-wrapper"> 
               

               <div> <?php if (isset($viewNotes->categoryId)) { ?>
               <span class="category">
                      in 
                      <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("homepage/category&categoryid=" . $viewNotes->categoryId); ?>"> 
                       <?= isset($viewCategories->name) ? $viewCategories->name : 'Без категории' ?>
                      </a>  
                </span>    
                <?php } ?>
                </div>
               
                

                <div> <span class="pubDate">
                      <?php echo date('j F Y', strtotime($viewNotes->publicationDate)); ?>
                      </span>
                </div>
            
                <div class="content">
                  <p> <?php echo htmlspecialchars($viewNotes->content)?></p>
                </div>  



                <div> <span class="users">
                   Автор: 
                   <?php
                    $userLogins = [];
                    foreach ($viewUser as $user) {
                    $selected = '';
                   // Проверяем, привязана ли текущая заметка ($viewNotes->id) к этому пользователю
                    foreach ($viewNotesUser as $noteuser) {
                    if ($noteuser->users_id == $user->id) {
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

               
                 

            </div>
                       
                       
    </ul>

      <p><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("homepage/index" ); ?>" class="all-notes-link">Return to Homepage</a></p>
    </div> 