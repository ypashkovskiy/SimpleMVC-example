<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<?php include('includes/admin-notes-nav.php'); ?>
<h2><?= $addNoteTitle ?></h2>

<form id="addNote" method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/add")?>"> 
    <div class="form-group">
        <label for="title">Название новой заметки</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="имя заметки" required>
    </div>
    <div class="form-group">
        <label for="content">Содержание</label><br>
        <textarea type="description" name="content" placeholred="описание заметки"  value=></textarea>
    </div>


     
    <h5>Категории</h5>
    <select id="categorySelect" name="categoryId"  required>
   
    <option value="">Выберите категорию</option>
    <?php foreach ($viewCategories as $category): ?>
    <option value="<?= htmlspecialchars($category->id) ?>">
        <?= htmlspecialchars($category->name) ?>
    </option>
    <?php endforeach; ?>     
   
    </select>

<!-- Подкатегории (изначально пуст или отфильтрован) -->

    <h5>Под категории</h5> 
    <select id="subcategorySelect" name="subcategoriesid" required >
      
      <option value="">Сначала выберите категорию</option>
    </select>


    <h5>Авторы</h5>
    <select name="notes[]" multiple>
    <?php foreach($viewUser as $user): ?>
       
        <option value="<?= $user->id ?>">
            <?= $user->login ?>
        </option>
    <?php endforeach; ?>
    </select>
 

 <h5>Активность заметки</h5> 
<label>
    <input type="checkbox" name="active" value="1" >
    Активно
</label>

<h5> </h5>

    <input type="submit" class="btn btn-primary" name="saveNewNote" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>   


<script>
    // Передаем массив подкатегорий из PHP в JS
    const subcategories = <?= json_encode($viewsubcategories) ?>;
    
    // Имена должны СТРОГО совпадать с id в HTML
    const catSelect = document.getElementById('categorySelect'); 
    const subSelect = document.getElementById('subcategorySelect');

    catSelect.addEventListener('change', function() {
        const categoryId = this.value;
        
        // Очищаем второй селект
        subSelect.innerHTML = '<option value="">Выберите подкатегорию</option>';
        
        if (categoryId) {

              // Фильтруем подкатегории
            const filtered = subcategories.filter(sub => sub.categories_id == categoryId);
            
            filtered.forEach(sub => {
                const opt = document.createElement('option');
                opt.value = sub.id;
                opt.textContent = sub.name;
                subSelect.appendChild(opt);
            });
            subSelect.disabled = false;
        } else {
            subSelect.disabled = true;
        }
    });
</script>
