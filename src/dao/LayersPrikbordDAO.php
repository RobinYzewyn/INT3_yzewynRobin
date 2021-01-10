<?php

require_once(__DIR__ . '/DAO.php');

class LayersPrikbordDAO extends DAO
{

  public function selectById($id)
  {
    $sql = "SELECT * FROM `prikbord` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectAllPrikbordItems()
  {
    $sql = "SELECT * FROM `prikbord` WHERE username = :username";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $_SESSION['user']['username']);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function delete($id)
  {
    $sql = "DELETE FROM `prikbord` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    return $stmt->execute();
  }

  public function insert($data)
  {
    $errors = $this->validate($data);
    if (empty($errors)) {
      $sql = "INSERT INTO `prikbord` (`username`,`prikbord_tekst`) VALUES (:username, :prikbord_tekst)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $data['username']);
      $stmt->bindValue(':prikbord_tekst', $data['prikbord_tekst']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
    }
    return false;
  }

  public function validate($data)
  {
    $errors = [];
    if (empty($data['prikbord_tekst'])) {
      $errors['prikbord_tekst'] = 'Gelieve een text in te vullen';
    }
    return $errors;
  }
}
