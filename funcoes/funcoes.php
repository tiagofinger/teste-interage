<?php
/**
 * Função quebra o texto de acordo com o tamanho solicitado
 * @param String $texto
 * @param int $limite
 * @param boolean $quebra
 * @return string
 */
function limita_caracteres($texto, $limite, $quebra = true) {
  $tamanho = strlen($texto);
  if ($tamanho <= $limite) { //Verifica se o tamanho do texto é menor ou igual ao limite
    $novo_texto = $texto;
  } else { // Se o tamanho do texto for maior que o limite
    if ($quebra == true) { // Verifica a opção de quebrar o texto
      $novo_texto = trim(substr($texto, 0, $limite)) . "...";
    } else { // Se não, corta $texto na última palavra antes do limite
      $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
      $novo_texto = trim(substr($texto, 0, $ultimo_espaco)) . "..."; // Corta o $texto até a posição localizada
    }
  }
  return $novo_texto; // Retorna o valor formatado
}
?>