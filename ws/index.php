<?php
include_once '../classes/Youtube.class.php';

/**
 * Busco o vídeo do youtube
 * @param String $video
 * @return JSON
 */
function buscaVideo($video = null){
  $Youtube = new Youtube();
  return $Youtube->buscaVideo($video);
}

//criação de uma instância do servidor
$server = new SoapServer(null, array('uri' => "http://localhost/teste-interage/ws/"));
$server->addFunction('buscaVideo');
$server->handle();
?>