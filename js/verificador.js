$(document).ready(function(){
  
  function total_mensajes(){
    $.post("verificador.php",{revisar:"revisar"},function(mensaje){
      
    });
  }
   setInterval(total_mensajes, 10000);
});