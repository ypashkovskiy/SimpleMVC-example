<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-notes-nav.php'); ?>

<h2><?= $editNoteTitle ?></h2>

<form id="editNote" method="post" action="<?= $Url::link("admin/notes/edit&id=" . $_GET['id'])?>">
    <h5>Note title</h5> 
    <input type="text" name="title" placeholder="name note" value="<?= $viewNotes->title?>"><br>
    
    <h5>Note content</h5>
    <textarea type="description" name="content" placeholred="контент"   value=><?= $viewNotes->content ?></textarea><br>


    <!-- Категории -->

     <h5>Note category</h5> 
<select id="categorySelect" name="categoryId"  required>
    <option value="">Выберите категорию</option>
    <?php 
     foreach ($viewCategories as $category): ?>
            <option value="<?= htmlspecialchars($category->id) ?>"
                <?= ($category->id == $viewNotes->categoryId)? 'selected' : '' ?>>
                <?= htmlspecialchars($category->name) ?>
            </option>
      <?php endforeach; ?>      
   
</select>

<!-- Подкатегории (изначально пуст или отфильтрован) -->

<h5>Note sub category</h5>
<select id="subcategorySelect" name="subcategoriesid" required >
    <option value="">Сначала выберите категорию</option>
    <?php foreach ($viewsubcategories as $category): ?>
    <option value="<?= htmlspecialchars($category->id) ?>" 
        <?= ($category->id == $viewNotes->subcategoriesid) ? 'selected' : '' ?>>
        
     <!--   <?php if ($category->id == $viewNotes->subcategoriesid): ?>
            <?= htmlspecialchars($category->name) ?>
        <?php endif; ?>-->


        <?php if ($category->categories_id== $viewNotes->categoryId): ?>
            <?= htmlspecialchars($category->name) ?>
        <?php endif; ?>
     </option>
    <?php endforeach; ?>
        
</select>

<h5>Users</h5>
<select name="notes[]" multiple>
    <?php foreach($viewUser as $user): ?>
        <?php 
        $selected = '';
        // Проверяем, привязана ли текущая заметка ($viewNotes->id) к этому пользователю
        foreach($viewNotesUser as $note) {
            if ($note->users_id == $user->id && $note->notes_id == $viewNotes->id) {
                $selected = 'selected';
                break; // Нашли совпадение — выходим из внутреннего цикла
            }
        }
        ?>
        <option value="<?= $user->id ?>" <?= $selected ?>>
            <?= $user->login ?>
        </option>
    <?php endforeach; ?>
</select>



<h5>Note active</h5>
<label>
    <input type="checkbox" name="active" value="1" <?php echo $viewNotes->active == 1 ? 'checked' : ''; ?>>
    Активно
</label>

<h5> </h5>

<input type="hidden" name="id" value="<?= $_GET['id']; ?>">
<input type="submit" name="saveChanges" value="Сохранить">
<input type="submit" name="cancel" value="Назад">
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