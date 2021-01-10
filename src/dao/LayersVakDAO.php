<?php

require_once(__DIR__ . '/DAO.php');

class LayersVakDAO extends DAO
{
  public function selectById($id)
  {
    $sql = "SELECT * FROM `vak` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectAll()
  {
    $sql = "SELECT * FROM `vak`";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert($data)
  {
    $errors = $this->validate($data);
    if (empty($errors)) {
      $sql = "INSERT INTO `vak` (`username`,`vak_naam`, `vak_docent`, `vak_kleur`) VALUES (:username, :vak_naam, :vak_docent, :vak_kleur)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $_SESSION['user']['username']);
      $stmt->bindValue(':vak_naam', $data['vak_naam']);
      $stmt->bindValue(':vak_docent', $data['vak_docent']);
      $stmt->bindValue(':vak_kleur', $data['vak_kleur']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
    }
    return false;
  }

  public function update($data)
  {
    $errors = $this->validate($data);
    if (empty($errors)) {
      $sql = "UPDATE `vak` SET `username` = :username, `vak_naam` = :vak_naam, `vak_docent` = :vak_docent, `vak_kleur` = :vak_kleur WHERE `id` = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $_SESSION['user']['username']);
      $stmt->bindValue(':vak_naam', $data['vak_naam']);
      $stmt->bindValue(':vak_docent', $data['vak_docent']);
      $stmt->bindValue(':vak_kleur', $data['vak_kleur']);
      $stmt->bindValue(':id', $data['id']);
      if ($stmt->execute()) {
        return $this->selectById($data['id']);
      }
    }
    return false;
  }

  public function delete($data){
    $sql = "DELETE FROM `vak` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $data['id']);
    if ($stmt->execute()) {
      return $this->selectAll();
    }
  }

  public function checkExists($vak){
    $sql = "SELECT * FROM `vak` WHERE `vak_naam` = :vak AND username = :username";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':vak', $vak);
    $stmt->bindValue(':username', $_SESSION['user']['username']);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function validate($data)
  {
    $errors = [];
    if (!isset($data['vak_naam'])) {
      $errors['image_id'] = 'Gelieve vaknaam in te vullen';
    }
    if (empty($data['vak_docent'])) {
      $errors['comment'] = 'Gelieve een docentnaam in te vullen';
    }
    if (empty($data['vak_kleur'])) {
      $errors['comment'] = 'Gelieve een kleur te kiezen';
    }
    return $errors;
  }
}
