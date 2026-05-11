<?php

namespace application\controllers;

use application\models\Note;
use application\models\NotesUser;
use application\models\UserModel;
use application\models\Categories;
use application\models\Subcategories;
/**
 * Контроллер для домашней страницы
 */
class HomepageController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Домашняя страница";
    
    /**
     * @var string Пусть к файлу макета 
     */
    public string $layoutPath = 'main.php';
      
    /**
     * Выводит на экран страницу "Домашняя страница"
     */
    public function indexAction()
    {
        $Note = new Note();
        $numRows = 2;
        $viewNotes = $Note->getList(1, "active","",$numRows);
        $this->view->addVar('viewNotes', $viewNotes);

        $Category = new Categories();
        $viewCategories = $Category->getList()['results'];
        $categoriesList = array_column($viewCategories, 'name', 'id');
        $this->view->addVar('categoriesList', $categoriesList);


        $Subcategories = new Subcategories();
        $viewsubcategories = $Subcategories->getList()['results'];
        $subcategoriesList = array_column($viewsubcategories, 'name', 'id');
        $this->view->addVar('subcategoriesList', $subcategoriesList);


        $User = new UserModel();
        $viewUser = $User->getList()['results'];
        $this->view->addVar('viewUser', $viewUser);

        $NotesUser = new NotesUser();
        $viewNotesUser = $NotesUser->getList()['results'];
        $this->view->addVar('viewNotesUser', $viewNotesUser);

        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/index.php');
    }


    public function allnotesAction(){


        $Note = new Note();
        $viewNotes = $Note->getList();
        $this->view->addVar('viewNotes', $viewNotes);

        $Category = new Categories();
        $viewCategories = $Category->getList()['results'];
        $categoriesList = array_column($viewCategories, 'name', 'id');
        $this->view->addVar('categoriesList', $categoriesList);


        $Subcategories = new Subcategories();
        $viewsubcategories = $Subcategories->getList()['results'];
        $subcategoriesList = array_column($viewsubcategories, 'name', 'id');
        $this->view->addVar('subcategoriesList', $subcategoriesList);


        $User = new UserModel();
        $viewUser = $User->getList()['results'];
        $this->view->addVar('viewUser', $viewUser);

        $NotesUser = new NotesUser();
        $viewNotesUser = $NotesUser->getList()['results'];
        $this->view->addVar('viewNotesUser', $viewNotesUser);

        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/allnotes.php');
}



public function categoryAction(){

        $Note = new Note();
        $viewNotes = $Note->getList($_GET['categoryid'],'categoryid')['results'];
        $this->view->addVar('viewNotes', $viewNotes);

        $Category = new Categories();
        $viewCategories = $Category->getById($_GET['categoryid']);
        $this->view->addVar('viewCategories', $viewCategories);


        $Subcategories = new Subcategories();
        $viewsubcategories = $Subcategories->getList()['results'];
        $subcategoriesList = array_column($viewsubcategories, 'name', 'id');
        $this->view->addVar('subcategoriesList', $subcategoriesList);


        $User = new UserModel();
        $viewUser = $User->getList()['results'];
        $this->view->addVar('viewUser', $viewUser);

        $NotesUser = new NotesUser();
        $viewNotesUser = $NotesUser->getList()['results'];
        $this->view->addVar('viewNotesUser', $viewNotesUser);

        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/category.php');

}

public function subcategoryAction(){

        $Note = new Note();
        $viewNotes = $Note->getList($_GET['subcategoriesid'],'subcategoriesid',)['results'];
        $this->view->addVar('viewNotes', $viewNotes);

        $Category = new Categories();
        $viewCategories = $Category->getList()['results'];
        $categoriesList = array_column($viewCategories, 'name', 'id');
        $this->view->addVar('categoriesList', $categoriesList);


        $Subcategories = new Subcategories();
        $viewsubcategories = $Subcategories->getById($_GET['subcategoriesid']);;
        $this->view->addVar('viewsubcategories', $viewsubcategories);


        $User = new UserModel();
        $viewUser = $User->getList()['results'];
        $this->view->addVar('viewUser', $viewUser);

        $NotesUser = new NotesUser();
        $viewNotesUser = $NotesUser->getList()['results'];
        $this->view->addVar('viewNotesUser', $viewNotesUser);

        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/subcategory.php');

}

public function editAction(){
 
        $Note = new Note();
        $viewNotes = $Note->getById($_GET['id']);
        $this->view->addVar('viewNotes', $viewNotes);

        $Category = new Categories();
        $viewCategories = $Category->getById($viewNotes->categoryId);
        $this->view->addVar('viewCategories', $viewCategories);

       
        $User = new UserModel();
        $viewUser = $User->getList()['results'];
        $this->view->addVar('viewUser', $viewUser);

        $NotesUser = new NotesUser();
        $viewNotesUser = $NotesUser->getByIdNotesUser($_GET['id'])['results'];
        $this->view->addVar('viewNotesUser', $viewNotesUser);

        $this->view->addVar('homepageTitle', $this->homepageTitle); // передаём переменную по view
        $this->view->render('homepage/edit.php');

}

public function notepostAction()
{
    // Проверяем, пришел ли ID через POST
    $id = $_POST['id'] ?? null;

    if ($id) {
        $Note = new Note(); // Ваша модель
        $currentNote = $Note->getById($id);

        // Возвращаем только текст (или рендерим маленький кусочек HTML)
        echo $currentNote->content; 
        return; // Прерываем выполнение, чтобы не рендерить весь шаблон сайта
    }
}

public function notegetAction()
{
    // Проверяем, пришел ли ID через POST
    $id = $_GET['id'] ?? null;

    if ($id) {
        $Note = new Note(); // Ваша модель
        $currentNote = $Note->getById($id);

        // Возвращаем только текст (или рендерим маленький кусочек HTML)
        echo json_encode($currentNote->content); 
        return; // Прерываем выполнение, чтобы не рендерить весь шаблон сайта
    }
}


}





