<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/LayersDAO.php';
require_once __DIR__ . '/../dao/LayersVakDAO.php';


class LayersController extends Controller
{

  private $layersDAO;

  function __construct()
  {
    $this->layersDAO = new LayersDAO();
    $this->layersVakDAO = new LayersVakDAO();
  }



  public function index()
  {
  }

}
