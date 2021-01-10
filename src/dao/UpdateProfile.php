<?php

require_once(__DIR__ . '/DAO.php');

class updateProfile extends DAO
{
  public function selectById($id) {
      $sql = "SELECT * FROM `users` WHERE `id` = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectByNameISNOTUser($username){
      $sql = "SELECT * FROM `users` WHERE `username` = :username AND not id = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':id', $_SESSION['user']['id']);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function selectByEmailISNOTUser($email) {
      $sql = "SELECT * FROM `users` WHERE `email` = :email AND not id = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':id', $_SESSION['user']['id']);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
public function selectAllVakkenNEWUSER($username)
  {
    $sql = "SELECT * FROM `vak` WHERE username = :username ORDER BY `id` ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

  public function selectAllOpdrachtenNEWUSER($username)
  {
    $sql = "SELECT * FROM `opdracht` WHERE username = :username ORDER BY `id` ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

  public function selectAllSchoolagendaNEWUSER($username)
  {
    $sql = "SELECT * FROM `schoolagenda` WHERE username = :username ORDER BY `id` ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

  public function selectAllPrikbordNEWUSER($username)
  {
    $sql = "SELECT * FROM `prikbord` WHERE username = :username ORDER BY `id` ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

public function updateOpdrachten($username){
    $sql = "UPDATE opdracht SET username = :username WHERE username = :oldName";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':oldName', $_SESSION['user']['username']);
    if ($stmt->execute()) {
      return $this->selectAllOpdrachtenNEWUSER($username);
    }
  }

  public function updateVakken($username){
    $sql = "UPDATE vak SET username = :username WHERE username = :oldName";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':oldName', $_SESSION['user']['username']);
    if ($stmt->execute()) {
      return $this->selectAllVakkenNEWUSER($username);
    }
  }

  public function updateSchoolagenda($username){
    $sql = "UPDATE schoolagenda SET username = :username WHERE username = :oldName";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':oldName', $_SESSION['user']['username']);
    if ($stmt->execute()) {
      return $this->selectAllSchoolagendaNEWUSER($username);
    }
  }

  public function updatePrikbord($username){
    $sql = "UPDATE prikbord SET username = :username WHERE username = :oldName";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':oldName', $_SESSION['user']['username']);
    if ($stmt->execute()) {
      return $this->selectAllPrikbordNEWUSER($username);
    }
  }

  public function updateProfileUser($data){
    $nameExists = $this->selectByNameISNOTUser($data['newName']);
    $emailExists = $this->selectByEmailISNOTUser($data['newEmail']);
    
      if((!empty($data['oldPassword'])) && (!empty($data['newPassword']))){
        //Update with password
        $checkOldPass = $this->selectById($data['id']);
        $oldPassInput = password_hash($data['oldPassword'], PASSWORD_BCRYPT);
        if(password_verify($data['oldPassword'], $checkOldPass['password'])){
          $sql = "UPDATE `users` SET `username` = :username, `email` = :email, `password` = :password WHERE `id` = :id";
          $stmt = $this->pdo->prepare($sql);
          $stmt->bindValue(':username', $data['newName']);
          $stmt->bindValue(':email', $data['newEmail']);
          $stmt->bindValue(':password',  password_hash($data['newPassword'], PASSWORD_BCRYPT));
          $stmt->bindValue(':id', $data['id']);
          if ($stmt->execute()) {
            return $this->selectById($data['id']);
          }
        }
      }
      else{
        //Update without password
        if($nameExists == false && $emailExists == true){
          //Update name
          $sql = "UPDATE `users` SET `username` = :username WHERE `id` = :id";
          $stmt = $this->pdo->prepare($sql);
          $stmt->bindValue(':username', $data['newName']);
          $stmt->bindValue(':id', $data['id']);
          if ($stmt->execute()) {
            return $this->selectById($data['id']);
          }
        }
        if($emailExists == false && $nameExists == true){
          //Update email
          $sql = "UPDATE `users` SET `email` = :email WHERE `id` = :id";
          $stmt = $this->pdo->prepare($sql);
          $stmt->bindValue(':email', $data['newEmail']);
          $stmt->bindValue(':id', $data['id']);
          if ($stmt->execute()) {
            return $this->selectById($data['id']);
          }
        }
        if($nameExists == false && $nameExists == false){
          //Update both
          $sql = "UPDATE `users` SET `username` = :username, `email` = :email WHERE `id` = :id";
          $stmt = $this->pdo->prepare($sql);
          $stmt->bindValue(':username', $data['newName']);
          $stmt->bindValue(':email', $data['newEmail']);
          $stmt->bindValue(':id', $data['id']);
          if ($stmt->execute()) {
            return $this->selectById($data['id']);
          }
        }
        if($nameExists == true && $emailExists == true){
          //Fail, both already exists
        }
    }
  }
}
