<?php 

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');


// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Складываем признак ошибок в массив.

$errors=array();
$errors['name'] = !empty($_COOKIE['name_error']);
$errors['email'] = !empty($_COOKIE['email_error']);
$errors['date1'] = !empty($_COOKIE['date_error']); //!!!
$errors['gender'] = !empty($_COOKIE['gender_error']);
$errors['hand'] = !empty($_COOKIE['hand_error']);
$errors['select1'] = !empty($_COOKIE['select1_error']);//!!!
$errors['biogr'] = !empty($_COOKIE['biogr_error']);
$errors['form-ch'] = !empty($_COOKIE['form-ch_error']);

// временное хранение сообщений пользователю

$messages = array();
$messages['name']='';
$messages['email']='';
$messages['date1']='';
$messages['gender']='';
$messages['hand']='';
$messages['select1']='';//!!!
$messages['biogr']='';
$messages['form-ch']='';

// сообщения об ошибке 

if ($errors['name'] == '1') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages['name'] = 'Заполните имя';
  }
  else if ($errors['name'] == '2') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages['name'] = 'Используйте латинский алфавит';
  }
  if ($errors['email'] == '1') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages['email'] = 'Заполните email';
  }
  else if ($errors['email'] == '2') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages['email'] = 'Заполните email в формате example@mail.ru';
  }
  if ($errors['date1']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('limbs_error', '', 100000);
    // Выводим сообщение.
    $messages['date1'] = 'Выбирите дату';
  }
  if ($errors['gender']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    // Выводим сообщение.
    $messages['gender'] = 'Выбирите гендер';
  }
  if ($errors['hand']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    // Выводим сообщение.
    $messages['hand'] = 'Выбирите колво рук';
  }
  if ($errors['select1']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('select1_error', '', 100000);
    // Выводим сообщение.
    $messages['select1'] = 'Выбирите сверхспособность';
  }
  if ($errors['biogr']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('biogr_error', '', 100000);
    // Выводим сообщение.
    $messages['biogr'] = 'Заполните биографию';
  }
  if ($errors['form-ch']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('form-ch_error', '', 100000);
    // Выводим сообщение.
    $messages['form-ch'] = 'Поставьте галочку!';
  }
  //if ($errors['data_saved']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    //setcookie('save_error', '', 100000);
   // $messages['data_saved'] = "Ошибка отправки: " . $_COOKIE['save_error'];
 // }

  // Выдаем сообщение об успешном сохранении.
  //if (array_key_exists('save', $_GET) && $_GET['save']) {
    // Если есть параметр save, то выводим сообщение пользователю.
   // $messages['data_saved'] = 'Спасибо, результаты сохранены.';
 // }


// Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['date1'] = empty($_COOKIE['date1_value']) ? '' : $_COOKIE['date1_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['hand'] = empty($_COOKIE['hand_value']) ? '' : $_COOKIE['hand_value'];
  $values['select1'] = empty($_COOKIE['select1_value']) ? '' : $_COOKIE['select1_value'];//!!!
  $values['bio'] = empty($_COOKIE['biogr_value']) ? '' : $_COOKIE['biogr_value'];
  $values['form-ch'] = empty($_COOKIE['form-ch_value']) ? '' : $_COOKIE['form-ch_value'];

// Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.

  include('form.php');

}

// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле name.
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if (!preg_match("/[\w-]+/i", $_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле name.
    setcookie('name_error', '2', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    // Выдаем куку на день с флажком об ошибке в поле email.
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if (!preg_match("/[a-z0-9]+@[a-z0-9]+\.[a-z]+/i", $_POST['email'])) {
    // Выдаем куку на день с флажком об ошибке в поле email.
    setcookie('email_error', '2', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['gender'])) {
    // Выдаем куку на день с флажком об ошибке в поле gender.
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['hand'])) {
    // Выдаем куку на день с флажком об ошибке в поле gender.
    setcookie('hand_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('hand_value', $_POST['hand'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['biogr'])) {
    // Выдаем куку на день с флажком об ошибке в поле biogr.
    setcookie('biogr_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if(!preg_match("/[\w-]+/i", $_POST['biogr'])){
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('biogr_value', $_POST['biogr'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['form-ch'])) {
    // Выдаем куку на день с флажком об ошибке в поле form-ch.
    setcookie('form-ch_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('form-ch_value', $_POST['form-ch'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['date1'])) {
    // Выдаем куку на день с флажком об ошибке в поле bdate.
    setcookie('date1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('date1_value', $_POST['date1'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['select12']) , implode(",", $_POST['select1']))) {
    // Выдаем куку на день с флажком об ошибке в поле superpowers.
    setcookie('select12_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('select1_value', ($_POST['select12']), time() + 30 * 24 * 60 * 60);
  }

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }

  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('date1_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('hand_error', '', 100000);
    setcookie('select1_error', '', 100000);
    setcookie('biogr_error', '', 100000);
    setcookie('form-ch_error', '', 100000);
  }

  $name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date1'];
$gender = $_POST['gender'];
$hand = $_POST['hand'];
// преобразуем данные в строку 

$select12 = implode(",",$_POST['select1']);
$biogr = $_POST['biogr'];
$formCh = $_POST['form-ch'];
$id = 1;

// Подготовленный запрос. Не именованные метки.
//подключение к базе данных 
//$db = new PDO('mysql:host=localhost; dbname=$dbName, $user, $pass, array(PDO::ATTR_PERSISTENT => true)); 
$db = new PDO('mysql:host=localhost; dbname=u41732', 'u41732', '9367477', array(PDO::ATTR_PERSISTENT => true));
try 
{
 $qu = $db->prepare("INSERT INTO application SET id = ?, name = ?, email = ?,data_1 = ?,gender = ?, hand = ?, biogr = ?,formCh = ?");
 //$query->execute(array ($_POST['name'],$_POST['email'],$_POST['date1'],$_POST['gender'],$_POST['hand'],$_POST['biogr'],$_POST['form-ch']));
 //$query->execute(array($_POST['name'],$_POST['email'],date('d-m-y', strtotime($_POST['date1'])),$_POST['gender'],$_POST['hand'],$_POST['biogr'],$_POST['form-ch']));
 $qu->execute([$id,$name,$email,$date,$gender,$hand,$biogr,$formCh]);
 $id = $db->lastInsertId();
 $qu2 = $db->prepare("INSERT INTO application2 SET id = ?,sel = ?");
 $qu2->execute([$id, $select12]);
 echo "Запрос отправлен!" . $id;

}

catch(PDOException $e)
{
print('Error : ' . $e->getMessage());
exit();
}

?>