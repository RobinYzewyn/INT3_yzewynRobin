<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/LayersDAO.php';
require_once __DIR__ . '/../dao/LayersVakDAO.php';
require_once __DIR__ . '/../dao/LayersOpdrachtenDAO.php';
require_once __DIR__ . '/../dao/LayersPrikbordDAO.php';
require_once __DIR__ . '/../dao/LayersSchoolagendaDAO.php';
require_once __DIR__ . '/../dao/LayersUserDAO.php';
require_once __DIR__ . '/../dao/UpdateProfile.php';
require "PHPMailer/PHPMailerAutoload.php";
include 'ChromePhp.php';
//ChromePhp::log('Hello console!');

class LayersController extends Controller
{

  private $layersDAO;

  function __construct()
  {
    $this->layersDAO = new LayersDAO();
    $this->layersVakDAO = new LayersVakDAO();
    $this->layersOpdrachtenDAO = new LayersOpdrachtenDAO();
    $this->layersPrikbordDAO = new LayersPrikbordDAO();
    $this->layersSchoolagendaDAO = new LayersSchoolagendaDAO();
    $this->layersUserDAO = new LayersUserDAO();
    $this->updateProfile = new UpdateProfile();
  }



  public function index()
  {
    if (!empty($_SESSION)) {
      header('Location:index.php?page=opdrachten');
    } else {
      if (!empty($_POST)) {
        if ($_POST['action'] == 'login_account') {
          if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $existing = $this->layersUserDAO->selectByName($_POST['username']);
            if (!empty($existing)) {
              if (password_verify($_POST['password'], $existing['password'])) {
                $_SESSION['user'] = $existing;
                header('location:index.php?page=opdrachten');
                exit();
              } else {
                $errors = 'Onbekende gebruikersnaam / wachtwoord';
              }
            } else {
              $errors = 'Onbekende gebruikersnaam / wachtwoord';
            }
          } else {
            $errors = 'Onbekende gebruikersnaam / wachtwoord';
          }
        }
        $this->set('errors', $errors);
      }
    }
  }

  public function registreer()
  {
    if (!empty($_SESSION)) {
      header('Location:index.php?page=opdrachten');
    } else {
      if (!empty($_POST)) {
        if ($_POST['action'] == 'create_account') {
          $errors = array();
          $errors = $this->layersUserDAO->validateRegister();
          if (empty($errors)) {
            $inserteduser = $this->layersUserDAO->insertUser(array(
              'username' => $_POST['username'],
              'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
              'email' => $_POST['email']
            ));
            header('location:index.php');
            exit();
          } else {
            $this->set('errors', $errors);
          }
        }
      }

      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json" || $contentType === "application/x-www-form-urlencoded") {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true); // JSON omzetten naar assoc array

        if ($data['action'] == 'checkName') {
          $nameExists = $this->layersUserDAO->selectByName($data['username']);
          if (!empty($nameExists)) {
            $result = true;
            echo json_encode($result);
            exit();
          } else {
            $result = false;
            echo json_encode($result);
            exit();
          }
        }
        if ($data['action'] == 'checkEmail') {
          $nameExists = $this->layersUserDAO->selectByEmail($data['email']);
          if (!empty($nameExists)) {
            $result = true;
            echo json_encode($result);
            exit();
          } else {
            $result = false;
            echo json_encode($result);
            exit();
          }
        }
      }
    }
  }

  public function nieuwwachtwoord()
  {
    session_destroy();
    if (!empty($_POST)) {
      if ($_POST['action'] == 'new-password') {

        if (!empty($_SESSION['mail'])) {
          unset($_SESSION['mail']);
        }
        $_SESSION['mail'] = $_POST['mail'];
        //Check mail exists
        $mailExists = $this->layersUserDAO->selectMailbyMail();
        if (!empty($mailExists)) {
          $password = $this->generatePassword();
          $this->sendMail($password);
          //Update password in DB
          $password = password_hash($password, PASSWORD_BCRYPT);
          $updateUser = $this->layersUserDAO->updatePasswordByMail($password);
          $_SESSION['send'] = 'Er is een nieuw wachtwoord gestuurd ✔';
        } else {
          $_SESSION['error'] = 'Deze mail heeft geen account';
        }
      }
    }
  }

  public function opdracht()
  {
    if (!empty($_SESSION['user'])) {
      if (!empty($_GET['id'])) {
        $specificOpdracht = $this->layersDAO->selectOpdrachtById($_GET['id']);
        $this->set('specificOpdracht', $specificOpdracht);

        $opdrachtKleur = $this->layersDAO->selectOpdrachtKleur($specificOpdracht['opdracht_vak']);
        $this->set('opdrachtKleur', $opdrachtKleur);

        if (!empty($_POST['action'])) {
          if ($_POST['action'] == 'toevoegenPrikbordItem') {
            $this->toevoegenPrikBordItem();
          }
        }

        if (!empty($_GET['action'])) {
          if ($_GET['action'] == 'deleteItem' && !empty($_GET['prikbord_id'])) {
            $this->verwijderPrikBordItem();
          } 
          else if ($_GET['action'] == 'deleteOpdracht' && !empty($_GET['opdracht_id'])) {
            $this->layersOpdrachtenDAO->delete($_GET['opdracht_id']);
            header('Location: index.php?page=opdrachten');
            exit();
          } 
          else {
            header('Location: index.php?page=opdrachten');
            exit();
          }
        }

        if (!empty($_POST['action'])) {
          if ($_POST['action'] == 'opdrachtUpdate') {
            $data = array(
              'username' => $_SESSION['user']['username'],
              'opdracht_vak' => $_POST['opdracht_vak'],
              'opdracht_datum' => $_POST['opdracht_datum'],
              'opdracht_tijd' => $_POST['opdracht_tijd'],
              'opdracht_naam' => $_POST['opdracht_naam'],
              'opdracht_omschrijving' => $_POST['opdracht_omschrijving'],
              'opdracht_herinneringen' => $_POST['opdracht_herinneringen'],
              'opdracht_link' => $_POST['opdracht_link'],
              'id' => $specificOpdracht['id']
            );
            $updateOpdracht = $this->layersOpdrachtenDAO->update($data);
            if (!$updateOpdracht) {
              $errors = $this->layersOpdrachtenDAO->validate($data);
              $this->set('errors', $errors);
            } else {
              header('Location: index.php?page=opdracht&id=' . $specificOpdracht['id']);
              exit();
            }
          }
        }
      }
      $this->selectOpdrachten();

      $this->selectPrikbord();

      $this->selectVakken();

      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json") {
        $content = trim(file_get_contents("php://input"));
        //$data = json_decode($content, true);

        if (!empty($_GET['id'])) {
          $specificOpdracht = $this->layersOpdrachtenDAO->selectByIdPlusVakKleur($_GET['id']);
          $specificOpdracht = json_encode($specificOpdracht);
          echo $specificOpdracht;
        } else {
          //Errors
        }
        exit();
      } else {
        header('Location: index.php');
      }
    }
  }

  public function opdrachten()
  {
    $this->set('currentPage', 'opdrachten');
    if (!empty($_SESSION['user'])) {
      $notificatieOpdrachten = $this->setNotifications();
      $this->set('notificatieOpdrachten', $notificatieOpdrachten);

      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json" || $contentType === "application/x-www-form-urlencoded") {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true); // JSON omzetten naar assoc array

        
        
        if(!empty($data)){
          if ($data['action'] == 'toevoegenOpdracht') {
            $data['username'] = $_SESSION['user']['username'];
            $data['opdracht_vak'] = trim($data['opdracht_vak']);
            $insertOpdracht = $this->layersOpdrachtenDAO->insert($data);
            if (!$insertOpdracht) {
              $errors = $this->layersOpdrachtenDAO->validate($data);
              $this->set('errors', $errors);
            } else {
              header('Location: index.php?page=opdrachten');
              exit();
            }
          }

          if ($data['action'] == 'removeNotification') {
            $this->checkRemoveNotification($data);
          }

          if ($data['action'] == 'refreshNotification') {
          $_SESSION['notifyTasks'] = array();
          $notificatieOpdrachten = $this->setNotifications();
          echo json_encode($notificatieOpdrachten);
          exit();
        }
        }
        
        
        if (!empty($_GET['date'])) {
          $selectOpdrachtenByDate = $this->layersOpdrachtenDAO->selectOpdrachtenByDate($_GET['date']);
          if (!empty($selectOpdrachtenByDate)) {
            $selectOpdrachtenByDate = json_encode($selectOpdrachtenByDate);
            echo $selectOpdrachtenByDate;
          } else {
            header('Location: index.php?page=opdrachten');
            exit();
          }
          exit();
        }
      }

      if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'toevoegenOpdracht') {
          $data = array(
            'username' => $_SESSION['user']['username'],
            'opdracht_vak' => $_POST['opdracht_vak'],
            'opdracht_datum' => $_POST['opdracht_datum'],
            'opdracht_tijd' => $_POST['opdracht_tijd'],
            'opdracht_naam' => $_POST['opdracht_naam'],
            'opdracht_omschrijving' => $_POST['opdracht_omschrijving'],
            'opdracht_herinneringen' => $_POST['opdracht_herinneringen'],
            'opdracht_link' => $_POST['opdracht_link']
          );
          $insertOpdracht = $this->layersOpdrachtenDAO->insert($data);
          if (!$insertOpdracht) {
            $errors = $this->layersOpdrachtenDAO->validate($data);
            $this->set('errors', $errors);
          } else {
            header('Location: index.php?page=opdrachten');
            exit();
          }
        }
        if ($_POST['action'] == 'toevoegenPrikbordItem') {
          $this->toevoegenPrikBordItem();
        }
      }

      if (!empty($_GET['action'])) {
        if ($_GET['action'] == 'deleteItem' && !empty($_GET['prikbord_id'])) {
          $this->verwijderPrikBordItem();
        } 
        else {
          header('Location: index.php?page=opdrachten');
          exit();
        }
      }

      $this->selectOpdrachten();
      $this->selectPrikbord();
      $this->selectVakken();

    } else {
      header('Location: index.php');
    }
  }

  public function opdrachttoevoegen()
  {
    if (!empty($_SESSION['user'])) {
      $notificatieOpdrachten = $this->setNotifications();
      $this->set('notificatieOpdrachten', $notificatieOpdrachten);
      // Js
      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json") {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        //add comments
        if ($data['action'] == 'toevoegenVak') {
          $data = array(
            'username' => $data['username'],
            'vak_naam' => $data['naamvak'],
            'vak_docent' => $data['naamdocent'],
            'vak_kleur' => $data['kleur']
          );
          $vakInsert = $this->layersVakDAO->insert($data);
          if (!$vakInsert) {
            $errors = $this->layersVakDAO->validate($data);
            $errors['error'] = "Er zijn fouten opgetreden";
            echo json_encode($errors);
          } else {
            $vakken = $this->layersDAO->selectAllVakken($data);
            echo json_encode($vakken);
          }

          exit();
        }
        if ($data['action'] == 'removeNotification') {
          $this->checkRemoveNotification($data);
        }
        if ($data['action'] == 'refreshNotification') {
          $_SESSION['notifyTasks'] = array();
          $notificatieOpdrachten = $this->setNotifications();
          echo json_encode($notificatieOpdrachten);
          exit();
        }
      }

      // Php
      $this->set('currentPage', 'opdrachttoevoegen');
      $this->selectOpdrachten();

      if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'toevoegenVakOpdracht') {
          $data = array(
            'username' => $_SESSION['user']['username'],
            'vak_naam' => $_POST['naamvak'],
            'vak_docent' => $_POST['naamdocent'],
            'vak_kleur' => $_POST['kleur']
          );
          $checkExists = $this->layersVakDAO->checkExists($_POST['naamvak']);
          if (empty($checkExists)) {
            $insertVak = $this->layersVakDAO->insert($data);
            // if (!$insertVak) {
            //   $errors = $this->layersVakDAO->validate($data);
            //   $this->set('errors', $errors);
            // } else {
            //   header('Location: index.php?page=opdrachten');
            //   exit();
            // }
            //TODO: gelukt boodschap
            if (!empty($insertVak)) {
              $vakToegevoegd = true;
              $this->set('vakToegevoegd', $vakToegevoegd);
            }
          } else {
            $errors = 'Vak bestaat al';
            $this->set('errors', $errors);
          }
        }
        if ($_POST['action'] == 'toevoegenPrikbordItem') {
          $this->toevoegenPrikBordItem();
        }
      }
      if (!empty($_GET['action'])) {
        if ($_GET['action'] == 'deleteItem' && !empty($_GET['prikbord_id'])) {
          $this->verwijderPrikBordItem();
        } 
        else {
          // naar id
          header('Location: index.php?page=opdrachttoevoegen');
          exit();
        }
      }

      $this->selectVakken();
      $this->selectPrikbord();

    } 
    else {
      header('Location: index.php');
    }
  }

  public function profiel()
  {
    if (!empty($_SESSION['user'])) {
      $notificatieOpdrachten = $this->setNotifications();
      $this->set('notificatieOpdrachten', $notificatieOpdrachten);

      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json" || $contentType === "application/x-www-form-urlencoded") {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true); // JSON omzetten naar assoc array

        if ($data['action'] == 'removeNotification') {
          $this->checkRemoveNotification($data);
        }
        if ($data['action'] == 'refreshNotification') {
          $_SESSION['notifyTasks'] = array();
          $notificatieOpdrachten = $this->setNotifications();
          echo json_encode($notificatieOpdrachten);
          exit();
        }
        if ($data['action'] == 'updateProfile') {
          $data['id'] = $_SESSION['user']['id'];

          $updateProfile = $this->updateProfile->updateProfileUser($data);
          $this->updateProfile->updateOpdrachten($data['newName']);
          $this->updateProfile->updateVakken($data['newName']);
          $this->updateProfile->updateSchoolagenda($data['newName']);
          $this->updateProfile->updatePrikbord($data['newName']);
          if (!empty($updateProfile)) {
            $existing = $this->layersUserDAO->selectById($_SESSION['user']['id']);
            $_SESSION['user'] = $existing;
            $newUser = $_SESSION['user'];
            echo json_encode($existing);
            $_SESSION['succes'] = 'Profiel gewijzigd!';
            exit();
          } else {
            header('Location: index.php?page=profiel');
            exit();
          }
          exit();
        }
        if ($data['action'] == 'updateProfileAll') {
          $data['id'] = $_SESSION['user']['id'];
          $updateProfile = $this->updateProfile->updateProfileUser($data);
          
          if (!empty($updateProfile)) {
            $this->updateProfile->updateOpdrachten($data['newName']);
            $this->updateProfile->updateVakken($data['newName']);
            $this->updateProfile->updateSchoolagenda($data['newName']);
            $this->updateProfile->updatePrikbord($data['newName']);
            $existing = $this->layersUserDAO->selectById($_SESSION['user']['id']);
            $_SESSION['user'] = $existing;
            $newUser = $_SESSION['user'];
            echo json_encode($existing);
            $_SESSION['succes'] = 'Profiel gewijzigd!';
            exit();
          } else {
            header('Location: index.php?page=profiel');
            exit();
          }
          exit();
        }
        if($data['action'] == 'checkUsername'){
          $nameExists = $this->layersUserDAO->selectByName($data['newName']);
          if ($nameExists == false || $nameExists['username'] == $_SESSION['user']['username']) {
            $result = true; 
            echo json_encode($result);
            exit();
          } else {
            $result = false;
            echo json_encode($result);
            exit();
          }
        }
        if($data['action'] == 'checkEmail'){
          $emailExists = $this->layersUserDAO->selectByEmail($data['newEmail']);
          if ($emailExists == false || $emailExists['email'] == $_SESSION['user']['email']) {
            $result = true; 
            echo json_encode($result);
            exit();
          } else {
            $result = false;
            echo json_encode($result);
            exit();
          }
        }
      }
      $this->set('currentPage', 'profiel');
      if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'toevoegenPrikbordItem') {
          $this->toevoegenPrikBordItem();
        }
      }

      if (!empty($_GET['action'])) {
        if ($_GET['action'] == 'deleteItem' && !empty($_GET['prikbord_id'])) {
          $this->verwijderPrikBordItem();
        } else {
          // naar id
          header('Location: index.php?page=profiel');
          exit();
        }
      }
      $this->selectOpdrachten();
      $this->selectPrikbord();
    } else {
      header('Location: index.php');
    }
  }

  public function schoolagenda()
  {
    if (!empty($_SESSION['user'])) {
      $notificatieOpdrachten = $this->setNotifications();
      $this->set('notificatieOpdrachten', $notificatieOpdrachten);
      $this->set('currentPage', 'schoolagenda');
      $this->selectOpdrachten();

      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json" || $contentType === "application/x-www-form-urlencoded") {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true); // JSON omzetten naar assoc array

        if(!empty($data)){
          if ($data['action'] == 'removeNotification') {
            $this->checkRemoveNotification($data);
          }
          if ($data['action'] == 'refreshNotification') {
            $_SESSION['notifyTasks'] = array();
            $notificatieOpdrachten = $this->setNotifications();
            echo json_encode($notificatieOpdrachten);
            exit();
          }
        }
        
        if(!empty($_GET)){
          if (!empty($_GET['id'])) {
          $data = array();

          $csvString = $this->layersSchoolagendaDAO->selectAgenda();
          //var_dump($csvString[0]['csvstring']);

          $lines = explode(PHP_EOL, $csvString[0]['csvstring']);
          $array = array();
          foreach ($lines as $line) {
            $array[] = str_getcsv($line);
          }

          //var_dump($array[0]);
          $longArray = $array[0];
          //var_dump($longArray);

          $aantalBlokken = (count($longArray) / 15.2);
          $dagArray = array();
          $fullArray = array();
          for ($i = 1; $i < $aantalBlokken; $i++) {
            $number = 15 * $i;
            $blok = array();
            $blok['Datum'] = $longArray[$number + 4];
            $blok['Weekdag'] = $longArray[$number + 3];
            $blok['Les'] = $longArray[$number];
            $blok['Begintijd'] = $longArray[$number + 5];
            $blok['Eindtijd'] = $longArray[$number + 8];
            $blok['Duur'] = $longArray[$number + 9];
            $blok['Type'] = $longArray[$number + 10];
            $blok['Leerkracht'] = $longArray[$number + 11];
            $blok['Lokaal'] = $longArray[$number + 12];
            $blok['id'] = $i;

            //array_push($dagArray, $longArray[$number+4]);
            array_push($dagArray, $blok);
          }
          $les = $dagArray[$_GET['id'] - 1];
          $opdrachten = $this->layersDAO->selectAllOpdrachten();

          array_push($data, $les, $opdrachten);

          // $selectOpdrachtById = $this->layersOpdrachtenDAO->selectOpdrachtPlusVak($_GET['opdracht_id']);
          if (!empty($data)) {
            $encoded = json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);
            echo json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);
            exit();
          }
        }
        }
      }

      if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'toevoegenPrikbordItem') {
          $this->toevoegenPrikBordItem();
        }
      }

      if (!empty($_GET['action'])) {
        if ($_GET['action'] == 'deleteItem' && !empty($_GET['prikbord_id'])) {
          $this->verwijderPrikBordItem();
        } else {
          // naar id
          header('Location: index.php?page=schoolagenda');
          exit();
        }
      }

      $this->selectPrikbord();

      $csvString = $this->layersSchoolagendaDAO->selectAgenda();
      //var_dump($csvString[0]['csvstring']);

      if (!empty($csvString)) {
        $lines = explode(PHP_EOL, $csvString[0]['csvstring']);
        $array = array();
        foreach ($lines as $line) {
          $array[] = str_getcsv($line);
        }

        //var_dump($array[0]);
        $longArray = $array[0];
        //var_dump($longArray);

        $aantalBlokken = (count($longArray) / 15.2);
        $dagArray = array();
        $fullArray = array();
        for ($i = 1; $i < $aantalBlokken; $i++) {
          $number = 15 * $i;
          $blok = array();
          $blok['Datum'] = $longArray[$number + 4];
          $blok['Weekdag'] = $longArray[$number + 3];
          $blok['Les'] = $longArray[$number];
          $blok['Begintijd'] = $longArray[$number + 5];
          $blok['Eindtijd'] = $longArray[$number + 8];
          $blok['Duur'] = $longArray[$number + 9];
          $blok['Type'] = $longArray[$number + 10];
          $blok['Leerkracht'] = $longArray[$number + 11];
          $blok['Lokaal'] = $longArray[$number + 12];
          $blok['id'] = $i;

          //array_push($dagArray, $longArray[$number+4]);
          array_push($dagArray, $blok);
        }
        $this->set('agendaArray', $dagArray);
      }





      //$blok1 = array();
      //$blok1['Les'] = $longArray[15];
      //$blok1['Begintijd'] = $longArray[20];
      //$blok1['Eindtijd'] = $longArray[23];
      //$blok1['Duur'] = $longArray[24];
      //$blok1['Type'] = $longArray[25];
      //$blok1['Leerkracht'] = $longArray[26];
      //$blok1['Lokaal'] = $longArray[27];

      //$fullArray['dag1'] = $blok1;
      //var_dump($fullArray);
    } else {
      header('Location: index.php');
    }
  }

  public function schoolagendaToevoegen()
  {
    if (!empty($_SESSION['user'])) {
      $notificatieOpdrachten = $this->setNotifications();
      $this->set('notificatieOpdrachten', $notificatieOpdrachten);
      $this->set('currentPage', 'schoolagendatoevoegen');
      $this->selectOpdrachten();

      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json" || $contentType === "application/x-www-form-urlencoded") {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true); // JSON omzetten naar assoc array

        if ($data['action'] == 'removeNotification') {
          $this->checkRemoveNotification($data);
        }
        if ($data['action'] == 'refreshNotification') {
          $_SESSION['notifyTasks'] = array();
          $notificatieOpdrachten = $this->setNotifications();
          echo json_encode($notificatieOpdrachten);
          exit();
        }
      }

      if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'importAgenda' && $_FILES['file']['name'] !== '') {
          ChromePhp::log('import agenda');
          ChromePhp::log($_FILES['file']);
          $fh = fopen($_FILES['file']['tmp_name'], 'r+');

          $lines = array();
          while (($row = fgetcsv($fh, 8192)) !== FALSE) {
            $lines[] = $row;
          }

          //Om stukje array van csv te tonen
          //var_dump($lines[1]);

          function str_putcsv($input, $delimiter = ',', $enclosure = '"')
          {
            $fp = fopen('php://temp', 'r+'); //File openen voor lezen (Read) en schrijven (Write)
            fputcsv($fp, $input, $delimiter, $enclosure); //De input (array) in de fp (file) steken door fputcsv...
            rewind($fp); //Terug leesbaar maken
            $data = fread($fp, 1048576); //Lijn in variabele steken
            fclose($fp); //Sluit file
            return rtrim($data, "\n"); //Return en de nieuwe lijntjes/enters wegdoen
          }

          $csvString = '';
          foreach ($lines as $line) {
            $csvString .= str_putcsv($line);
          }

          //String csv
          //var_dump($csvString);

          //Import csv (word een blob file in phpmyadmin)
          $importAgendaString = $this->layersSchoolagendaDAO->insert($csvString);
          $selectAgenda = $this->layersSchoolagendaDAO->selectAgenda();
          //TODO: gelukt boodschap
          if (!empty($selectAgenda)) {
            $agendaUploaded = true;
            $this->set('agendaUploaded', $agendaUploaded);
          } else {
            header('Location: index.php?page=schoolagendaToevoegen');
            exit();
          }
        }
        if ($_POST['action'] == 'toevoegenPrikbordItem') {
          $this->toevoegenPrikBordItem();
        }
      }

      if (!empty($_GET['action'])) {
        if ($_GET['action'] == 'deleteItem' && !empty($_GET['prikbord_id'])) {
          $this->verwijderPrikBordItem();
        } else {
          // naar id
          header('Location: index.php?page=schoolagendaToevoegen');
          exit();
        }
      }

      $this->selectPrikbord();
    } else {
      header('Location: index.php');
    }
  }

  public function vaktoevoegen()
  {
    if (!empty($_SESSION['user'])) {
      $notificatieOpdrachten = $this->setNotifications();
      $this->set('notificatieOpdrachten', $notificatieOpdrachten);
      // // Js
      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json") {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);

        if ($data['action'] == 'updateVak') {
          $data = array(
            'username' => $_SESSION['user']['username'],
            'vak_naam' => $data['vaknaam2'],
            'vak_docent' => $data['naamdocent2'],
            'vak_kleur' => $data['kleur2'],
            'id' => $data['vakId'],
            'vak_name_old' => $data['vakOldName']
          );
          // update vakken in opdrachten db
          $vakInsert = $this->layersVakDAO->update($data);
          $this->layersOpdrachtenDAO->updateOpdrachtenVakUpdate($data);
          if (!$vakInsert) {
            $errors = $this->layersVakDAO->validate($data);
            $errors['error'] = "Er zijn fouten opgetreden";
            echo json_encode($errors);
          } else {
            $vakken = $this->layersDAO->selectAllVakken($data);
            echo json_encode($vakken);
          }

          exit();
        }
        if ($data['action'] == 'removeNotification') {
          $this->checkRemoveNotification($data);
        }
        if ($data['action'] == 'refreshNotification') {
          $_SESSION['notifyTasks'] = array();
          $notificatieOpdrachten = $this->setNotifications();
          echo json_encode($notificatieOpdrachten);
          exit();
        }
        if ($data['action'] == 'removeVak') {
          $data = array(
            'id' => $data['vakId']
          );
          $vakDelete = $this->layersVakDAO->delete($data);
          if (!$vakDelete) {
            $errors = $this->layersVakDAO->validate($data);
            $errors['error'] = "Er zijn fouten opgetreden";
            echo json_encode($errors);
          } else {
            echo json_encode($vakDelete);
          }

          exit();
        }
      }

      if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'toevoegenVak') {
          $data = array(
            'username' => $_SESSION['user']['username'],
            'vak_naam' => $_POST['naamvak'],
            'vak_docent' => $_POST['naamdocent'],
            'vak_kleur' => $_POST['kleur']
          );
          $checkExists = $this->layersVakDAO->checkExists($_POST['naamvak']);
          if (empty($checkExists)) {
            $insertVak = $this->layersVakDAO->insert($data);
            if (!empty($insertVak)) {
              $vakToegevoegd = true;
              $this->set('vakToegevoegd', $vakToegevoegd);
            }
          } else {
            $errors = 'Vak bestaat al';
            $this->set('errors', $errors);
          }
        }
        if ($_POST['action'] == 'toevoegenPrikbordItem') {
          $data = array(
            'username' => $_SESSION['user']['username'],
            'prikbord_tekst' => $_POST['prikbord_tekst']
          );
          $toevoegenPrikbordItem = $this->layersPrikbordDAO->insert($data);
          // controleren of alles foutloos is verlopen
          if (!$toevoegenPrikbordItem) {
            $errors = $this->layersPrikbordDAO->validate($data);
            $this->set('errors', $errors);
          } else {
            // naar id
            header('Location: index.php?page=vaktoevoegen');
            exit();
          }
        }
        if(!empty($_GET['action'])){
          if ($_GET['action'] == 'deleteItem' && !empty($_GET['prikbord_id'])) {
            $this->verwijderPrikBordItem();
          } 
        }
        
        else {
          // naar id
          header('Location: index.php?page=vaktoevoegen');
          exit();
        }
      }

      $this->selectVakken();
      $this->set('currentPage', 'vaktoevoegen');
      $this->selectOpdrachten();

      $this->selectPrikbord();
    } else {
      header('Location: index.php');
    }
  }

  public function logout()
  {
    session_destroy();
    header('Location: index.php');
  }

  function generatePassword()
  {
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function sendMail($password)
  {


    function smtpmailer($to, $from, $from_name, $subject, $body)
    {
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true;

      $mail->SMTPSecure = 'ssl';
      $mail->Host = 'smtp-auth.mailprotect.be';
      $mail->Port = 465;
      $mail->Username = 'planner@robiny.be';
      $mail->Password = 'verdicktyzewyn123';

      //   $path = 'reseller.pdf';
      //   $mail->AddAttachment($path);

      $mail->IsHTML(true);
      $mail->From = "planner@robiny.be";
      $mail->FromName = $from_name;
      $mail->Sender = $from;
      $mail->AddReplyTo($from, $from_name);
      $mail->Subject = $subject;
      $mail->Body = $body;
      $mail->AddAddress($to);
      if (!$mail->Send()) {
        $error = "Please try Later, Error occured while Processing...";
        return $error;
      } else {
        $error = "Thanks You !! Your email is sent.";
        return $error;
      }
    }
    $sendmailto = $_SESSION['mail'];
    $to   = $sendmailto;
    $from = 'planner@robiny.be';
    $name = 'planner';
    $subj = 'Schoolplanner - Nieuw wachtwoord';
    $msg = "Hey! <br><br>  Dit is jouw nieuw wachtwoord: " . $password . "<br> <br> Groetjes, <br> Planner <br><br><br><a href='www.google.com'>Klik hier om naar de planner te gaan</a>";

    $error = smtpmailer($to, $from, $name, $subj, $msg);
    //header('Location:index.php?page=nieuwwachtwoord');
  }

  public function setNotifications()
  {
    if (empty($_SESSION['notifyTasks'])) {


      $opdrachten = $this->layersDAO->selectAllOpdrachten();
      $toNotify = array();
      $datesTasks = array();
      for ($i = 0; $i < count($opdrachten); $i++) {
        $taskDate = array();
        array_push($taskDate, $opdrachten[$i]['id']);
        array_push($taskDate, $opdrachten[$i]['opdracht_datum']);
        array_push($taskDate, $opdrachten[$i]['opdracht_herinneringen']);


        if ($taskDate[2] == 'Dag tevoren' || $taskDate[2] == 'Elke dag') {
          array_push($taskDate, date_format((date_sub(date_create($taskDate[1]), date_interval_create_from_date_string('1 days'))), 'Y-m-d'));
        } else if ($taskDate[2] == 'Week tevoren' || $taskDate[2] == 'Elke week') {
          array_push($taskDate, date_format((date_sub(date_create($taskDate[1]), date_interval_create_from_date_string('7 days'))), 'Y-m-d'));
        }
        array_push($datesTasks, $taskDate);
      }
      $today = date('Y-m-d');
      for ($j = 0; $j < count($datesTasks); $j++) {
        //0 is id van opdracht
        //1 is dag van opdracht
        //2 is elke dag, dag tevoren, week tevoren, elke week
        //3 is dag afgetrokken
        //If today  == dag afgetrokken --> in notify
        if ($today == $datesTasks[$j][3] || $datesTasks[$j][2] == 'Elke dag') {
          array_push($toNotify, $datesTasks[$j]);
        }
      }

      $_SESSION['notifyTasks'] = array();

      for ($z = 0; $z < count($toNotify); $z++) {
        array_push($_SESSION['notifyTasks'], $this->layersOpdrachtenDAO->selectById($toNotify[$z][0]));
      }
      $months = ["", "Jan", "Feb", "Maa", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"];
      for ($x = 0; $x < count($_SESSION['notifyTasks']); $x++) {
        $dayNumber = substr(($_SESSION['notifyTasks'][$x]['opdracht_datum']), -2);
        $cutday = substr($dayNumber, 0, 1);
        if ($cutday == "-") {
          $dayNumber = substr($dayNumber, 1);
          $monthNumber = (substr(substr(($_SESSION['notifyTasks'][$x]['opdracht_datum']), -4), 0, 2));
        } else {
          $monthNumber = (substr(substr(($_SESSION['notifyTasks'][$x]['opdracht_datum']), -5), 0, 2));
        }

        $dayMonth =  $months[intval($monthNumber)];
        $_SESSION['notifyTasks'][$x]['Dag'] = $dayNumber;
        $_SESSION['notifyTasks'][$x]['Maand'] = $dayMonth;
      }
      return $_SESSION['notifyTasks'];
    } else {
      return $_SESSION['notifyTasks'];
    }
  }

  public function checkRemoveNotification($data)
  { 
    if ($data['action'] == 'removeNotification') {
      for ($i = 0; $i < count($_SESSION['notifyTasks']); $i++) {
        if ($_SESSION['notifyTasks'][$i]['id'] == $data['notificationId']) {
          unset($_SESSION['notifyTasks'][$i]);
          $session = $_SESSION['notifyTasks'];
          $_SESSION['notifyTasks'] = array_values($session);
          echo json_encode($_SESSION['notifyTasks']);
          exit();
        }
      }
    }
  }

  public function toevoegenPrikBordItem(){
    if(!empty($_GET['id'])){
      $specificOpdracht = $this->layersDAO->selectOpdrachtById($_GET['id']);
    }
    
    $data = array(
      'username' => $_SESSION['user']['username'],
      'prikbord_tekst' => $_POST['prikbord_tekst']
    );
    $toevoegenPrikbordItem = $this->layersPrikbordDAO->insert($data);
    // controleren of alles foutloos is verlopen
    if (!$toevoegenPrikbordItem) {
      $errors = $this->layersPrikbordDAO->validate($data);
      $this->set('errors', $errors);
    } else {
      // naar id
      if(!empty($_GET['id'])){
        header('Location: index.php?page=opdracht&id=' . $specificOpdracht['id']);
      }
      else{
        header('Location: index.php?page=' . $_GET['page']);
      }
      exit();
    }
  }

  public function verwijderPrikBordItem(){
    if(!empty($_GET['id'])){
      $specificOpdracht = $this->layersDAO->selectOpdrachtById($_GET['id']);
    }
    $this->layersPrikbordDAO->delete($_GET['prikbord_id']);
    if(!empty($_GET['id'])){
      header('Location: index.php?page=opdracht&id=' . $specificOpdracht['id']);
    }
    else{
      header('Location: index.php?page=' . $_GET['page']);
    }
    exit();
  }

  public function selectOpdrachten(){
    $opdrachten = $this->layersDAO->selectAllOpdrachten();
    $this->set('opdrachten', $opdrachten);
  }

  public function selectPrikbord(){
    $prikbordItems = $this->layersPrikbordDAO->selectAllPrikbordItems();
    $this->set('prikbordItems', $prikbordItems);
  }

  public function selectVakken(){
    $vakken = $this->layersDAO->selectAllVakken();
    $this->set('vakken', $vakken);
  }
}
