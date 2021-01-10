<?php

require_once(__DIR__ . '/DAO.php');

class LayersDAO extends DAO
{

  public function selectAllVakken()
  {
    $sql = "SELECT * FROM `vak` WHERE username = :username ORDER BY `id` ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $_SESSION['user']['username']);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

  

  public function selectOpdrachtById($id)
  {
    $sql = "SELECT * FROM `opdracht` WHERE `id` = :id ORDER BY `opdracht_datum`";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectOpdrachtKleur($opdracht_naam)
  {
    $sql = "SELECT vak.vak_kleur FROM opdracht INNER JOIN vak ON opdracht.opdracht_vak = vak.vak_naam WHERE vak_naam = :opdracht_naam";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':opdracht_naam', $opdracht_naam);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectAllOpdrachten()
  {
    $sql = "SELECT opdracht.username, vak.vak_kleur, opdracht.id, opdracht_vak, opdracht_datum, opdracht_tijd, opdracht_naam, opdracht_omschrijving, opdracht_link, opdracht_herinneringen FROM opdracht INNER JOIN vak ON opdracht.opdracht_vak = vak.vak_naam WHERE opdracht.username = :usernameOpdracht AND vak.username = :usernameVak ORDER BY opdracht.opdracht_datum";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':usernameOpdracht', $_SESSION['user']['username']);
    $stmt->bindValue(':usernameVak', $_SESSION['user']['username']);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }
}
