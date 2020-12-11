<?php
require "Models/ModelDrum.php";

function addClient()
{
  if(isset($_POST['pseudo']) and !preg_match("#^\s*$#",$_POST['pseudo']) and isset($_POST['mdp']) and !preg_match("#^\s*$#",$_POST['mdp']) and isset($_POST['mail']) and !preg_match("#^\s*$#",$_POST['mail']))
  {
          $m = ModelDrum::getModel();
          $hash = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
          $info = ['pseudo'=>$_POST['pseudo'],'mdp'=>$hash,'mail'=>$_POST['mail']];
          $data = $m->addNewClient($info);
          echo 'OK';
        }
}

function login()
{
  if(isset($_POST['pseudo']) and !preg_match("#^\s*$#",$_POST['pseudo']) and isset($_POST['mdp']) and !preg_match("#^\s*$#",$_POST['mdp']))
  {
          $m = ModelDrum::getModel();
          $data = $m->getClient($_POST['pseudo']);
          if (password_verify($_POST['mdp'], $data["mdp"])) {
            echo "OK";
          }else {
            echo "PAS OK";
          }
        }
}


function arrayList()
{
  $dir = "/home/pi/Dev/sites/lahoucine-hamsek/uploads";
  $dh  = opendir($dir);
  while (false !== ($filename = readdir($dh))) {
      $files[] = $filename;
  }
  rsort($files);

  echo $files;
}

function insertMusique()
{
  if(isset($_POST['musique']) and !preg_match("#^\s*$#",$_POST['musique']) and isset($_POST['createur']) and !preg_match("#^\s*$#",$_POST['createur']))
  {
    $m = ModelDrum::getModel();
    $info = ['musique'=>$_POST['musique'],'createur'=>$_POST['createur']];
    $data = $m->addNewMuique($info);
    echo 'OK';
        }
}

function NbMusique()
{
  if(isset($_POST['id']) and !preg_match("#^\s*$#",$_POST['id']))
  {
    $m = ModelDrum::getModel();
    $data = $m->getNbMusique($_POST['id']);
    echo $data['count(*)'];
        }
}


function etoile()
{
  if(isset($_POST['id']) and !preg_match("#^\s*$#",$_POST['id']))
  {
    $m = ModelDrum::getModel();
    $data = $m->getEtoile($_POST['fonction'],$_POST['id']);
    echo $data['sum('.$_POST['fonction'].')'];
    }
}

function isInDBMusique()
{
  $m = ModelDrum::getModel();
  $data = $m->getMusiqueArray();
  if(in_array($_POST['musique'], $data)){
    echo 'true';
  }else {
    echo 'false';
  }
}

function isInDBClient()
{
  $m = ModelDrum::getModel();
  $data = $m->getClientArray();
  if(in_array($_POST['pseudo'], $data)){
    echo 'false';
  }else {
    echo 'true';
  }
}

if (isset($_POST['fonction'])){

  switch ($_POST['fonction']){
    case 'singup':
      addClient();
      break;
    case 'login':
      login();
      break;
    case 'array':
      arrayList();
      break;
    case 'insertMusique':
      insertMusique();
      break;
    case 'NbMusique':
      NbMusique();
      break;
    case 'isInDBMusique':
      isInDBMusique();
      break;
    case 'isInDBClient':
      isInDBClient();
      break;
    case '1etoile':
      etoile();
      break;
    case '2etoile':
      etoile();
      break;
    case '3etoile':
      etoile();
      break;
    case '4etoile':
      etoile();
      break;
    case '5etoile':
      etoile();
      break;
    default:
      break;
  }
}

 ?>
