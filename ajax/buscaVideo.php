<?php
/**
 * Arquivo retorna a lista de vídeos conforme a busca utilizada
 */
include_once '../funcoes/funcoes.php';

// nome do vídeo a ser buscado
$nome_video = $_POST['nome_video'];

// criação de uma instância do cliente
$SoapClient = new SoapClient(null, array('location' => 'http://localhost/teste-interage/ws/index.php', 'uri' => 'http://localhost/teste-interage/ws/', 'trace' => 1));

// chamada do serviço SOAP
$result = json_decode($SoapClient->buscaVideo($nome_video));

// verifica erros na execução do serviço e exibe o resultado
if (is_soap_fault($result)) {
  trigger_error("Por favor faça a busca de novo tivemos um pequeno problema: (faultcode: {$result->faultcode}, faultstring: {$result->faulstring})", E_ERROR);
} else {
  $total = count($result->feed->entry);
  $cont = 1;
  $cont_modal = 1;
  foreach ($result->feed->entry AS $row) {
    $titulo_variavel      = '$t';
    $desc_var1            = 'media$group';
    $desc_var2            = 'media$description';
    $desc_var3            = 'media$player';

    // ENCURTAR A URL PARA TWITTAR
    $json_migreme         = json_decode(file_get_contents('http://migre.me/api.json?url=' . $row->$desc_var1->$desc_var3->url));

    $titulo               = limita_caracteres($row->title->$titulo_variavel, 50);
    $descricao            = limita_caracteres($row->$desc_var1->$desc_var2->$titulo_variavel, 300, false);
    $player               = $row->content->src;

    // DEVIDO AO LIMITE DE 200 CONSULTAS POR HORA COLOQUEI ESSA VALIDAÇÃO PARA COMPARTILHAR O LINK
    $player_compartilhar  = ( $json_migreme->migre ) ? $json_migreme->migre : $row->$desc_var1->$desc_var3->url;

    if ($cont % 4 == 0 || $cont == 1) {
      echo '<div class="row-fluid">';
    }

    echo '<div class="span4">' .
    '<h2 class="titulo">' . $titulo . ' </h2>' .
    '<p class="descricao">' . $descricao . ' </p>' .
    '<p><a class="btn ver-video" data-toggle="modal" href="#modal' . $cont_modal . '">Ver Vídeo »</a></p>' .
    '</div><!--/span-->';

    if ($cont % 3 == 0 || $total == $cont_modal) {
      echo '</div>';
      $cont = 3;
    }

    $object_player = '<object style="height: 390px; width: 540px">' .
            '<param name="movie" value="' . $player . '">' .
            '<param name="allowFullScreen" value="true">' .
            '<param name="allowScriptAccess" value="always">' .
            '<embed src="' . $player . '" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="540" height="360">' .
            '</object>';

    echo '<div class="modal" id="modal' . $cont_modal . '">' .
    '<div class="modal-header">' .
    '<button class="close" data-dismiss="modal">×</button>' .
    '<h3>' . $row->title->$titulo_variavel . '</h3>' .
    '</div>' .
    '<div class="modal-body">' .
    '<p>' . $object_player . '</p>' .
    '</div>' .
    '<div class="modal-footer">' .
    '<a href="https://twitter.com/share" target="_blank" class="twitter-share-button" data-url="' . $player_compartilhar . '" data-text="Veja esse vídeo que legal!" data-lang="pt">Tweetar</a>' .
    '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>' .
    '<a href="" class="btn close">Close</a>' .
    '</div>' .
    '</div>';

    $cont++;
    $cont_modal++;
  }
}
?>