<?php
/**
 * Classe Youtube
 *
 * @author tiagofinger
 */
class Youtube{
  function __construct() {}

  /**
   * Busca os vídeos e retorna um JSON com dados
   * @param String $video
   * @return String
   */
  function buscaVideo($video=null) {
    $url       = 'http://gdata.youtube.com/feeds/api/videos?q=' . urlencode($video) . '&orderby=published&v=2&alt=json';
    return file_get_contents($url);
  }
}

?>
