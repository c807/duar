<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
<!-- Modal Crear Producto -->
<div class="container">
    <div class="modal fade" id="myModal" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header alert-success ">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title border-bottom pb-3 mb-4"><strong>CREAR PRODUCTO </strong></h4>

                </div>
                <div class="modal-body">
                     <form enctype="multipart/form-data" class="add_producto" id="add_producto">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-sm-6">
                                    <!--Inicio primera Columna -->

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Importador</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="importador" id="importador"
                                                placeholder="Introduzca Importador" require />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Código</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="codproducto" id="codproducto"
                                                 placeholder="Introduzca código de producto"
                                                require />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Descripción F.</label>
                                        <div class="col-sm-8">

                                            <textarea class="form-control" rows="3" id="descripcion" name="descripcion"
                                                 placeholder="Introduzca descripción según factura"
                                                require></textarea>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Descripción G.</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="descripcion_generica" name="descripcion_generica"
                                                placeholder="Introduzca descripción genérica"
                                                require></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Función</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="3" id="funcion" name="funcion"
                                                placeholder="Introduzca función"
                                                require></textarea>
                                        </div>
                                    </div>


                                </div>
                                <!--fin primera Columna -->
                                <div class="col-sm-6">
                                    <!--Inicio segunda Columna -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  ">Partida</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="partida" id="partida"
                                                placeholder="Introduzca partida Arancelelaria" require />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label col-sm-offset-0" ">Observaciones</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="observaciones"" id="observaciones"
                                                placeholder="Introduzca observaciones" require />
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  "></label>
                                        <div class=" checkbox col-sm-8 ">
                                        <label><input type="checkbox" value=""  name="permiso" id="permiso">PERMISO</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label  "></label>
                                        <div class=" checkbox col-sm-8 ">
                                        <label><input type="checkbox" value="" name="tlc" id="tlc">TLC</label>
                                        </div>
                                    </div>
     
                                </div>
                                <!--fin segunda Columna -->


                            </div>
                        </div>
                    </form>


                </div>


                
                <p id="demo"></p>
<!--
<p>Click the button get the HTML content of the p element.</p>

<button onclick="myFunction()">Try it</button>


<script>
function myFunction() {
  var x = document.getElementById("myP").innerHTML;
  document.getElementById("demo").innerHTML = x;
}
</script>
-->
                <div class="message" id="message">hola</div><br /><br />
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <!-- <input type="button" value="Guardar" id="borrar" class="btn btn-success"
                        onclick="gestion_cliente('b')" data-dismiss="modal" /> -->


                    <input type="button" value="Guardar" id="enviar" class="btn btn-success"
                        onclick="msg('1')" />

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>


<script>
    $('#myModal').modal('show')
    </script>
