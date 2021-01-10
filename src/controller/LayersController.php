<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/LayersDAO.php';

class LayersController extends Controller
{

  private $layersDAO;

  function __construct()
  {
    $this->layersDAO = new LayersDAO();
  }

  public function index()
  {
  }

}
