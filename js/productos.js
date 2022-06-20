$(document).ready(function(){
  
  //esperando un submit del formulario de subastas
  $("#form-subasta").on("submit",function(e){
    //prevenimos que se refresque la pagina
    e.preventDefault();
    //realizamos algunas validaciones previas
    if($("#of_ini").val() === ''){
      $("#error").html("infrese una oferta inicial");
    }else if($("#of_fin").val() === ''){
      $("#error").html("infrese una oferta final");
    }else if($("#date_ini").val() === ''){
      $("#error").html("infrese una fecha final");
    }else if($("#date_fin").val() === ''){
      $("#error").html("infrese una hora final");
    }else{
      $.post("subasta/ajaxSubastas.php",
             {accion:"insertar",of_ini:$("#of_ini").val(),of_fin:$("#of_fin").val(),
              date_fin:$("#date_fin").val(),time_fin:$("#time_fin").val(),id_p:$("#id_p").val()},
             function(mensaje){
                $("#of_ini").val("");
                $("#of_fin").val("");
                $("#time_fin").val("");
                $("#date_fin").val("");
                $("#aviso").html(mensaje);
                $("#aviso").fadeIn("fast");
                $("#aviso").fadeOut(5000);
              }
            );
    }
  });
  
  //esperando un submit del formulario de productos
  $("#form-producto").on("submit",function(e){
    //prevenimos que se refresque la pagina
     e.preventDefault();
    //realizamos algunas validaciones previas
    if($("#foto").val() === ''){
      $("#aviso").html("¡Seleccione una foto!");
    }else{
      var f = $(this);
      var formData = new FormData(document.getElementById("form-producto"));

      $.ajax({
          url: "producto/ajaxAgregar.php",
          type: "post",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false
      })
      .done(function(res){
        alert(res);
        location.reload();
      });
    }
  });
  
});

//funcion que elimina un producto
function eliminar(id,nombre,foto){
  if(confirm("Esta seguro de eliminar "+nombre)){
    //metodo ajax tipo post para mandar datos al archvio y ejecutar el delete
    $.post("producto/ajaxAgregar.php",{accion: "eliminar",id_producto:id,foto:foto},function(mensaje){
      alert(mensaje);
      location.reload();
    })
  }else{
    alert("no se elimino");
  }
}