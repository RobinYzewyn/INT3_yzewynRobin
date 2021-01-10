<?php

require_once(__DIR__ . '/DAO.php');

class LayersUserDAO extends DAO
{
    public function selectAll(){
      $sql = "SELECT * FROM `users`";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectMailbyMail(){
      $sql = "SELECT email FROM `users` WHERE email = :email";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':email', $_SESSION['mail']);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePasswordByMail($password){
      $sql = "UPDATE users SET users.password = :password WHERE email = :email";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':email', $_SESSION['mail']);
      $stmt->bindValue(':password', $password);
      if($stmt->execute()) {
        $this->selectAll();
      }
    }

    public function insertUser($data) {
      $sql = "INSERT INTO `users` (`username`, `password`, `email`) VALUES (:username, :password, :email)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $data['username']);
      $stmt->bindValue(':password', $data['password']);
      $stmt->bindValue(':email', $data['email']);
      if($stmt->execute()) {
        $insertedId = $this->pdo->lastInsertId();
        return $this->selectById($insertedId);
      }
    }

    public function selectById($id) {
      $sql = "SELECT * FROM `users` WHERE `id` = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function selectByName($username) {
      $sql = "SELECT * FROM `users` WHERE `username` = :username";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $username);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function selectByEmail($email) {
      $sql = "SELECT * FROM `users` WHERE `email` = :email";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':email', $email);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

  public function update($data)
  {
    $errors = $this->validate($data);
    if (empty($errors)) {
      $sql = "UPDATE `users` SET `username` = :username, `email` = :email, `password` = :password WHERE `id` = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $data['username']);
      $stmt->bindValue(':email', $data['email']);
      $stmt->bindValue(':password', $data['password']);
      $stmt->bindValue(':id', $data['id']);
      if ($stmt->execute()) {
        return $this->selectById($data['id']);
      }
    }
    return false;
  }


    public function validateRegister(){
      $errors = array();
      if(empty($_POST['username'])){
          $errors = 'Graag een gebruikersnaam invullen';
      }
      if(!empty($_POST['username'])){
          $existing = $this->selectByName($_POST['username']);
          if (!empty($existing)) {
          $errors = 'Deze gebruikersnaam is al in gebruik';
          }
      }
      if(empty($_POST['password'])){
          $errors = 'Graag een wachtwoord invullen';
      }
      if($_POST['password'] !== $_POST['repeat_password']){
        $errors = 'Wachtwoorden zijn niet hetzelfde';
      }
      if(empty($_POST['email'])){
          $errors = 'Graag een mail invullen';
      }
      if(!empty($_POST['email'])){
          $existing = $this->selectByEmail($_POST['email']);
          if (!empty($existing)) {
          $errors = 'Deze mail is al in gebruik';
          }
      }
      return $errors;
    }

  public function validate($data)
  {
    $errors = [];
    if (!isset($data['username'])) {
      $errors['username'] = 'Gelieve created in te vullen';
    }
    if (!isset($data['password'])) {
      $errors['password'] = 'Gelieve modified in te vullen';
    }
    if (!isset($data['email'])) {
      $errors['email'] = 'Gelieve checked in te vullen';
    }
    return $errors;
  }
}
