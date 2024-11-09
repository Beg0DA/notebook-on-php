<?php
session_start();
$_SESSION['id'] = 0;
class notebook
{
    private $notebook = [];
    function __construct()
    {
        if (isset($_SESSION['notebook'])) {
            $this->notebook = $_SESSION['notebook'];
        }
    }
    function getAll()
    {
        for ($j = 0; $j < count($this->notebook); $j++) {
            $l = $j + 1;
            echo "<ul><li>Запись №" . $l . "</li> <li>ФИО: " . $this->notebook[$j]['fio'] . "</li>" . "<li>Компания: " . $this->notebook[$j]['company'] . "</li>" . "<li>Телефон: " . $this->notebook[$j]['telephone'] . "</li>" . "<li>Почта: " . $this->notebook[$j]['email'] . "</li>" . "<li>Дата рождения: " . $this->notebook[$j]['birthday'] . "</li>" . "<li>Фото: <br> <img src='" . $this->notebook[$j]['photo'] . "' height=100px></li></ul>";
        }
    }
    function addNew($fio, $company, $telephone, $email, $birthday, $photo)
    {
        $this->notebook[] = [
            'fio' => $fio,
            'company' => $company,
            'telephone' => $telephone,
            'email' => $email,
            'birthday' => $birthday,
            'photo' => $photo
        ];
    }
    function getById($id)
    {
        $l = $id + 1;
        return "<ul><li>Запись №" . $l . "</li> <li>ФИО: " . $this->notebook[$id]['fio'] . "</li>" . "<li>Компания: " . $this->notebook[$id]['company'] . "</li>" . "<li>Телефон: " . $this->notebook[$id]['telephone'] . "</li>" . "<li>Почта: " . $this->notebook[$id]['email'] . "</li>" . "<li>Дата рождения: " . $this->notebook[$id]['birthday'] . "</li>" . "<li>Фото:<br>  <img src='" . $this->notebook[$id]['photo'] . "' height=100px></li></ul>";
    }
    function updateById($id, $fio, $company, $telephone, $email, $birthday, $photo)
    {
        $this->notebook[$id] = [
            'fio' => $fio,
            'company' => $company,
            'telephone' => $telephone,
            'email' => $email,
            'birthday' => $birthday,
            'photo' => $photo
        ];
    }
    function deleteById($id)
    {
        unset($this->notebook[$id]);
        $this->notebook = array_values($this->notebook);
        $this->saveData();
        if ($id >= $this->getCount() && $id > 0) {
            $id--;
        } else if ($this->getCount() == 0) {
            $id = 0;
        }
        $_SESSION['id'] = $id;
    }
    function getCount()
    {
        return count($this->notebook);
    }
    function saveData()
    {
        $_SESSION['notebook'] = $this->notebook;
    }
}
$note = new notebook;
$id = 0;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
if (isset($_POST['sub'])) {
    move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . '/images/' . $_FILES['photo']['name']);
    $note->addNew($_POST['fio'], $_POST['company'], $_POST['telephone'], $_POST['mail'], $_POST['birthday'], 'images/' . $_FILES['photo']['name']);
    $note->saveData();
}
if (isset($_GET['update'])) {
    $id = $_GET['id'];
    echo '<form method="post" enctype="multipart/form-data">
            <p><label for="fio">ФИО: </label>
                <input type="text" name="fio" id="fio" require>*
            </p>
            <p><label for="company">Компания: </label>
                <input type="text" name="company" id="company">
            </p>
            <p><label for="telephone">Телефон: </label>
                <input type="tel" name="telephone" id="telephone" require>*
            </p>
            <p> <label for="mail">Email: </label>
                <input type="email" name="mail" id="mail" require>*
            </p>
            <p> <label for="birthday">Дата рождения: </label>
                <input type="date" name="birthday" id="birthday">
            </p>
            <p> <label for="photo">Фото: </label>
                <input type="file" name="photo" id="photo">
            </p>
            <input type="submit" name="up" id="up" value="Добавить в записную книжку">
        </form>
        <a href="?back">Назад</a>';
    if (isset($_POST['up'])) {
        move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . '/images/' . $_FILES['photo']['name']);
        $note->updateById($_GET['id'], $_POST['fio'], $_POST['company'], $_POST['telephone'], $_POST['mail'], $_POST['birthday'], 'images/' . $_FILES['photo']['name']);
        $note->saveData();
    }
}
if (isset($_GET['delete'])) {
    $note->deleteById($_GET['id']);
    unset($_GET);
}
if (isset($_GET['find'])) {
    $_SESSION['id'] = $_GET['id'];
}
if (isset($_GET['next'])) {
    if ($_GET['id'] < $note->getCount() - 1) {
        $id = $_GET['id'] + 1;
    }
}
if (isset($_GET['previous'])) {
    if ($_GET['id'] > 0) {
        $id = $_GET['id'] - 1;
    }
}
if (isset($_GET['add'])) {
    echo '<form method="post" action="" enctype="multipart/form-data">
            <p><label for="fio">ФИО: </label>
                <input type="text" name="fio" id="fio" require>*
            </p>
            <p><label for="company">Компания: </label>
                <input type="text" name="company" id="company">
            </p>
            <p><label for="telephone">Телефон: </label>
                <input type="tel" name="telephone" id="telephone" require>*
            </p>
            <p> <label for="mail">Email: </label>
                <input type="email" name="mail" id="mail" require>*
            </p>
            <p> <label for="birthday">Дата рождения: </label>
                <input type="date" name="birthday" id="birthday">
            </p>
            <p> <label for="photo">Фото: </label>
                <input type="file" name="photo" id="photo">
            </p>
            <input type="submit" name="ad" id="ad" value="Добавить в записную книжку">
        </form>
        <a href="?back">Назад</a>';
    if (isset($_POST['ad'])) {
        move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . '/images/' . $_FILES['photo']['name']);
        $note->addNew($_POST['fio'], $_POST['company'], $_POST['telephone'], $_POST['mail'], $_POST['birthday'], 'images/' . $_FILES['photo']['name']);
        $note->saveData();
    }
}
if (isset($_GET['back'])) {
    unset($_GET);
}
if (isset($_GET['seeall'])) {
    $note->getAll();
    echo "<br><br><a href='?back'>Назад</a>";
}
$_SESSION['id'] = $id;
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notebook</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php if ($note->getCount() == 0) { ?>
        <h2>Добавьте первую запись</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <p><label for="fio">ФИО: </label>
                <input type="text" name="fio" id="fio" require>*
            </p>
            <p><label for="company">Компания: </label>
                <input type="text" name="company" id="company">
            </p>
            <p><label for="telephone">Телефон: </label>
                <input type="tel" name="telephone" id="telephone" require>*
            </p>
            <p> <label for="mail">Email: </label>
                <input type="email" name="mail" id="mail" require>*
            </p>
            <p> <label for="birthday">Дата рождения: </label>
                <input type="date" name="birthday" id="birthday">
            </p>
            <p> <label for="photo">Фото: </label>
                <input type="file" name="photo" id="photo">
            </p>
            <p>* - Обязательно к заполнению</p>
            <input type="submit" name="sub" id="sub" value="Добавить в записную книжку">
        </form>
    <?php } else if (!isset($_GET['update']) && !isset($_GET['add']) && !isset($_GET['seeall'])) {
        echo $note->getById($id); ?>
        <div class="nextprev"><? if ($id != 0) echo "<a href='?previous&id=" . $id . "'>Предыдущий</a>" ?><? if ($note->getCount() !== $id + 1) echo "<a href='?next&id=" . $id . "'>Следующий</a   >" ?></div><br><br>
        <div class="first">
            <a href='?update&id=<? echo $id; ?>'>Обновить</a>
            <a href='?delete&id=<? echo $id; ?>'>Удалить</a><br>
        </div>
        <div class="new"><a href='?add'>Добавить новую запись</a></div><br>
        <div class="all"><a href='?seeall'>Показать все записи</a></div>
    <?php } ?>
</body>

</html>