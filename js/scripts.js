/**
 * Arquivo com as funções js utilizadas
 */
$(document).ready(function() {

  $("#busca").focus();

  $("#frmBusca").submit(function (){

    if( $("#busca").val().length > 0 ){
      $.post("ajax/buscaVideo.php", { nome_video: $("#busca").val() },
      function(data){
        $("#conteudo").html(data);
        $('html, body').animate({
            scrollTop: $("#conteudo").offset().top - 40
        }, 2000);
      });
    }else{
      alert("Digite o nome do vídeo que deseja buscar.");
      $("#busca").focus();
    }

    return false;
  });

  //Mostra um loader para o usuário saber que uma requisição ajax está sendo carregada
  $("#loader").ajaxStart(function() {
    $(this).show();
  }).ajaxStop(function() {
    $(this).hide();
  });

  $(".close").live("click", function(){
    $('.modal').modal('hide');
  });

  $(".ver-video").live("click", function(){
    var id = $(this).attr("href");
    $(id).modal('show');
  });
});