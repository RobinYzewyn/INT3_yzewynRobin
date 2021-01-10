<?php

require_once(__DIR__ . '/DAO.php');

class LayersSchoolagendaDAO extends DAO
{
  public function selectAgenda()
  {
    $sql = "SELECT * FROM `schoolagenda` WHERE username = :username";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $_SESSION['user']['username']);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert($string)
  {
    $hasAgenda = $this->selectAgenda();
    if(!empty($hasAgenda)){
      $sql = "UPDATE `schoolagenda` SET `csvstring` = :csvstring WHERE username = :username";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $_SESSION['user']['username']);
      $stmt->bindValue(':csvstring', $string);
      if ($stmt->execute()) {
        return $this->selectAgenda();
      }
    }
    else{
      $this->importStandard($string);
    }
  }

  public function importStandard($string){
    $sql = "INSERT INTO `schoolagenda`(`username`,`csvstring`) VALUES (:username, :csvstring)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $_SESSION['user']['username']);
      $stmt->bindValue(':csvstring', $string);
      if ($stmt->execute()) {
        return $this->selectAgenda();
      }
  }
}
