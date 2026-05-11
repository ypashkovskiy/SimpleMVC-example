<?php
namespace application\controllers\admin;
use application\models\Note;
use application\models\NotesUser;
use application\models\UserModel;
use ItForFree\SimpleMVC\Config;
use application\models\Categories;
use application\models\Subcategories;

/* 
 *   Class-controller notes
 * 
 * 
 */

class NotesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    
    public string $layoutPath = 'admin-main.php';
    
    
    public function indexAction()
    {
        $Note = new Note();

        $noteId = $_GET['id'] ?? null;
        
        if ($noteId) { // если указан конктреный пользователь
            $viewNotes = $Note->getById($_GET['id']);
            $this->view->addVar('viewNotes', $viewNotes);

            $Category = new Categories();
            $viewCategories = $Category->getById($viewNotes->categoryId);
            $this->view->addVar('viewCategories', $viewCategories);


            $Subcategories = new Subcategories();
            $viewsubcategories = $Subcategories->getById($viewNotes->subcategoriesid);
            $this->view->addVar('viewsubcategories', $viewsubcategories);


            $User = new UserModel();
            $viewUser = $User->getList()['results'];
            $this->view->addVar('viewUser', $viewUser);

            $NotesUser = new NotesUser();
            $viewNotesUser = $NotesUser->getByIdNotesUser($viewNotes->id)['results'];
            $this->view->addVar('viewNotesUser', $viewNotesUser);


            $this->view->render('note/view-item.php');
        } else { // выводим полный список
            
            $notes = $Note->getList()['results'];

            $Category = new Categories();
            $viewCategories = $Category->getList()['results'];
            $categoriesList = array_column($viewCategories, 'name', 'id');

            $Subcategories = new Subcategories();
            $viewsubcategories = $Subcategories->getList()['results'];
            $subcategoriesList = array_column($viewsubcategories, 'name', 'id');
          
            $User = new UserModel();
            $viewUser = $User->getList()['results'];

            $NotesUser = new NotesUser();
            $viewNotesUser = $NotesUser->getList()['results'];

            
            $this->view->addVar('viewUser', $viewUser);
            $this->view->addVar('viewNotesUser', $viewNotesUser);
            $this->view->addVar('categoriesList', $categoriesList);
            $this->view->addVar('subcategoriesList', $subcategoriesList);
            $this->view->addVar('notes', $notes);
            $this->view->render('note/index.php');
        }
    }
    
    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewNote'])) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->insert(); 

                $NotesUser = new NotesUser();
                $id = $newNotes->id;
                $notes = $_POST['notes'];
                
                foreach ($notes as $key => $users_id){
                         $NotesUser->insert($id, $users_id);
                 }

                $this->redirect($Url::link("admin/notes/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/index"));
            }
        }
        else {

            $Subcategories = new Subcategories();
            $viewsubcategories = $Subcategories->getList()['results'];

            $Category = new Categories();
            $viewCategories = $Category->getList()['results'];

            $User = new UserModel();
            $viewUser = $User->getList()['results'];

            $this->view->addVar('viewUser', $viewUser);

            $this->view->addVar('viewCategories', $viewCategories);
            $this->view->addVar('viewsubcategories', $viewsubcategories);

            $addNoteTitle = "Добавление новой заметки";
            $this->view->addVar('addNoteTitle', $addNoteTitle);
            
            $this->view->render('note/add.php');
        }
    }
    
    /**
     * Выводит на экран форму для редактирования статьи (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) { // это выполняется нормально.
            
            if (!empty($_POST['saveChanges'] )) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->update();

                $notescurrent = $_POST['notes'];

                $NotesUser = new NotesUser();
                $viewNotesUser = $NotesUser->getByIdNotesUser($id)['results'];

                $notespresenter=[];

                 foreach ($viewNotesUser as $key => $value) {
                         $notespresenter[$key] = $value->users_id;
                   
                 }

                 $result = array_diff($notescurrent, $notespresenter);

                 foreach ($result as $key => $users_id){
                         $NotesUser->insert($id, $users_id);
                 }
                

                 $result = array_diff($notespresenter, $notescurrent);

                 foreach ($result as $key => $users_id){
                         $NotesUser->deleteNotesUser($id, $users_id);
                 }


                $this->redirect($Url::link("admin/notes/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/index&id=$id"));
            }
        }
        else {
            $Note = new Note();
            $viewNotes = $Note->getById($id);

            $Subcategories = new Subcategories();
            $viewsubcategories = $Subcategories->getList()['results'];

            $Category = new Categories();
            $viewCategories = $Category->getList()['results'];

            $NotesUser = new NotesUser();
            $viewNotesUser = $NotesUser->getList()['results'];

            $User = new UserModel();
            $viewUser = $User->getList()['results'];
                        
            $editNoteTitle = "Редактирование заметки";
            
            $this->view->addVar('viewNotes', $viewNotes);
            $this->view->addVar('editNoteTitle', $editNoteTitle);
            
            $this->view->addVar('viewUser', $viewUser);
            $this->view->addVar('viewCategories', $viewCategories);
            $this->view->addVar('viewsubcategories', $viewsubcategories);
            $this->view->addVar('viewNotesUser', $viewNotesUser);
            
            $this->view->render('note/edit.php');   
        }
        
    }
    
    /**
     * Выводит на экран предупреждение об удалении данных (только для Администратора)
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteNote'])) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->delete();
                
                $this->redirect($Url::link("admin/notes/index"));
              
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/edit&id=$id"));
            }
        }
        else {
            
            $Note = new Note();
            $deletedNote = $Note->getById($id);
            $deleteNoteTitle = "Удалить заметку?";
            
            $this->view->addVar('deleteNoteTitle', $deleteNoteTitle);
            $this->view->addVar('deletedNote', $deletedNote);
            
            $this->view->render('note/delete.php');
        }
    }
    
    
}