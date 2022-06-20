<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">SUBASTAME!</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                      <a href='../index.php'>Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categorias <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php  

                                $categorias = $bd->select("select * from sub_categorias");

                                if ($categorias->num_rows > 0) {

                                    while ($row = $categorias->fetch_assoc()) {
                                        $cat = $row["categoria"];
                                        $id_cat= $row["id_categoria"];
                                        echo "<li><a href='subastas.php?id=".$id_cat."'>".$cat."</a></li>";
                                    }
                                }else{
                                    echo "<li><a>No existen categorias aun</a></li>";
                                }

                            ?>
                        </ul>
                    </li>
                    <?php

                        if (!isset($_SESSION["id_usuario"])) {
                           echo "";
                            
                            echo "<li>
                                    <a href='../login.php'>Entrar</a>
                                  </li>
                                  ";
                        }else{
                          echo"<li class='dropdown'>
                                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Administracion <b class='caret'></b></a>
                                    <ul class='dropdown-menu'>
                                        <li>
                                            <a href='cuenta.php'>Mi Cuenta</a>
                                        </li>
                                        <li>
                                            <a href='agregar_producto.php'>Agregar Productos</a>
                                        </li>
                                        <li>
                                            <a href='../logout.php'>Salir</a>
                                        </li>
                                    </ul>
                                </li>";
                        }
                    ?>
                   <?php 
                  if(isset($_SESSION["id_usuario"])){
                     $r=$bd->select("SELECT count(*) as total from sub_cesta where id_usuario=".$_SESSION["id_usuario"]);
                     $arr=mysqli_fetch_array($r);
                     $contador = $arr['total'];
                  }
                  ?>
                    <li>
                        <a href="carrito.php">Carrito(<?php if(isset($contador)){ echo $contador; }else{ echo "0"; } ?>)</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>