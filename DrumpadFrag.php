<?php
require "Models/ModelDrum.php";

$dir = "/home/pi/Dev/sites/lahoucine-hamsek/uploads";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}
rsort($files);
array_pop($files);
array_pop($files);

function setEtoile()
{
  if(isset($_POST['etoile']) and !preg_match("#^\s*$#",$_POST['etoile']) and isset($_POST['musique']) and !preg_match("#^\s*$#",$_POST['musique']))
  {
    $m = ModelDrum::getModel();
    $etoile=str_replace(' ','',$_POST['etoile']);
    $data = $m->updateEtoile($etoile,$_POST['musique']);
    print_r($data);
    echo $data;
        }
}

function artiste()
{
  if(isset($_POST['musique']) and !preg_match("#^\s*$#",$_POST['musique']))
  {
    $m = ModelDrum::getModel();
    $data = $m->getArtiste($_POST['musique']);
    echo $data['createur'];
      }
}

if (isset($_POST['fonction'])){

  switch ($_POST['fonction']){
    case 'getNbMax':
      echo count($files);
      break;
    case 'musique':
      echo $files[$_POST['id']];
      break;
    case 'etoile':
      setEtoile();
      break;
    case 'artiste':
        artiste();
        break;
    default:
      break;
  }
}

?>
