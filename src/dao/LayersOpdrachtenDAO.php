<?php

require_once(__DIR__ . '/DAO.php');

class LayersOpdrachtenDAO extends DAO
{
  public function selectById($id)
  {
    $sql = "SELECT * FROM `opdracht` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectByIdPlusVakKleur($id)
  {
    $sql = "SELECT vak.vak_kleur, opdracht.id, opdracht.username, opdracht.opdracht_vak, opdracht.opdracht_datum, opdracht.opdracht_tijd, opdracht.opdracht_naam, opdracht.opdracht_omschrijving, opdracht.opdracht_herinneringen, opdracht.opdracht_link FROM opdracht INNER JOIN vak ON opdracht.opdracht_vak = vak.vak_naam WHERE opdracht.id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectOpdrachtPlusVak($id){
    $sql = "SELECT vak.vak_kleur, opdracht.id, opdracht.username, opdracht.opdracht_vak, opdracht.opdracht_datum, opdracht.opdracht_tijd, opdracht.opdracht_naam, opdracht.opdracht_omschrijving, opdracht.opdracht_herinneringen, opdracht.opdracht_link FROM opdracht INNER JOIN vak ON opdracht.opdracht_vak = vak.vak_naam WHERE opdracht.id = :id AND vak.username = :username";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':username', $_SESSION['user']['username']);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectOpdrachtenByDate($date){
    $sql = "SELECT * FROM `opdracht` WHERE `opdracht_datum` = :date AND `username` = :user";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':user', $_SESSION['user']['username']);
    $stmt->execute();
    //Expres fetch want maar 1 item per detail
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function delete($id)
  {
    $sql = "DELETE FROM `opdracht` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    return $stmt->execute();
  }

  public function insert($data)
  {
    $errors = $this->validate($data);
    if (empty($errors)) {
      $sql = "INSERT INTO `opdracht` (`username`,`opdracht_vak`, `opdracht_datum`, `opdracht_tijd`, `opdracht_naam`, `opdracht_omschrijving`, `opdracht_herinneringen`,  `opdracht_link`) VALUES (:username, :opdracht_vak, :opdracht_datum, :opdracht_tijd, :opdracht_naam, :opdracht_omschrijving, :opdracht_herinneringen, :opdracht_link)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $data['username']);
      $stmt->bindValue(':opdracht_vak', $data['opdracht_vak']);
      $stmt->bindValue(':opdracht_datum', $data['opdracht_datum']);
      $stmt->bindValue(':opdracht_tijd', $data['opdracht_tijd']);
      $stmt->bindValue(':opdracht_naam', $data['opdracht_naam']);
      $stmt->bindValue(':opdracht_omschrijving', $data['opdracht_omschrijving']);
      $stmt->bindValue(':opdracht_herinneringen', $data['opdracht_herinneringen']);
      $stmt->bindValue(':opdracht_link', $data['opdracht_link']);
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
      $sql = "UPDATE `opdracht` SET `username` = :username, `opdracht_vak` = :opdracht_vak, `opdracht_datum` = :opdracht_datum, `opdracht_tijd` = :opdracht_tijd, `opdracht_naam` = :opdracht_naam, `opdracht_omschrijving` = :opdracht_omschrijving, `opdracht_herinneringen` = :opdracht_herinneringen, `opdracht_link` = :opdracht_link WHERE `id` = :id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $data['username']);
      $stmt->bindValue(':opdracht_vak', $data['opdracht_vak']);
      $stmt->bindValue(':opdracht_datum', $data['opdracht_datum']);
      $stmt->bindValue(':opdracht_tijd', $data['opdracht_tijd']);
      $stmt->bindValue(':opdracht_naam', $data['opdracht_naam']);
      $stmt->bindValue(':opdracht_omschrijving', $data['opdracht_omschrijving']);
      $stmt->bindValue(':opdracht_herinneringen', $data['opdracht_herinneringen']);
      $stmt->bindValue(':opdracht_link', $data['opdracht_link']);
      $stmt->bindValue(':id', $data['id']);
      if ($stmt->execute()) {
        return $this->selectById($data['id']);
      }
    }
    return false;
  }

  public function selectAllOpdrachtenNEWVAK($data)
  {
    $sql = "SELECT * FROM `opdracht` WHERE username = :username ORDER BY `id` ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $data['vak_naam']);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

  public function updateOpdrachtenVakUpdate($data)
  {
    $sql = "UPDATE opdracht SET opdracht_vak = :vak_naam WHERE opdracht_vak = :vak_name_old";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':vak_naam', $data['vak_naam']);
    $stmt->bindValue(':vak_name_old', $data['vak_name_old']);
    if ($stmt->execute()) {
      // return $this->selectAllOpdrachtenNEWVAK($data);
    }
  }

  public function validate($data)
  {
    $errors = [];
    if (!isset($data['opdracht_vak'])) {
      $errors['image_id'] = 'Gelieve vaknaam in te vullen';
    }
    $errors = [];
    if (!isset($data['opdracht_datum'])) {
      $errors['image_id'] = 'Gelieve vaknaam in te vullen';
    }
    $errors = [];
    if (!isset($data['opdracht_tijd'])) {
      $errors['image_id'] = 'Gelieve vaknaam in te vullen';
    }
    $errors = [];
    if (!isset($data['opdracht_naam'])) {
      $errors['image_id'] = 'Gelieve vaknaam in te vullen';
    }
    $errors = [];
    if (!isset($data['opdracht_omschrijving'])) {
      $errors['image_id'] = 'Gelieve vaknaam in te vullen';
    }
    $errors = [];
    if (!isset($data['opdracht_herinneringen'])) {
      $errors['image_id'] = 'Gelieve vaknaam in te vullen';
    }
    $errors = [];
    if (!isset($data['opdracht_link'])) {
      $errors['image_id'] = 'Gelieve vaknaam in te vullen';
    }
    return $errors;
  }
}
