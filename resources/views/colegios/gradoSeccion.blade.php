<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de Grados y Secciones de la IE: <b>@{{ colegioIE }}</b> Código Módular: <b>@{{ codmodIE }}</b></h3>
              <a style="float: right;" type="button" class="btn btn-default" href="#" @click.prevent="volverCarreras()"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                <div class="form-group">
              <button type="button" class="btn btn-primary" id="btncrearinformacion" @click.prevent="nuevaInformacion()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Grado</button>
                </div>

          </div>

          </div>

        <div class="box box-success" v-if="divNuevaInformacion">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nuevo Grado Académico</h3>
            </div>

            <form v-on:submit.prevent="createInformacion" >
             <div class="box-body">

             	<div class="col-md-12" >

             	<div class="form-group">
                  <label for="txtgrado" class="col-sm-2 control-label">Grado:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtgrado" name="txtgrado" placeholder="Título" maxlength="200" autofocus v-model="newGrado">
                  </div>
                </div>
              </div>


 <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="estadoGrado">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>

            </div>

               

            </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>

                <button type="reset" class="btn btn-warning" id="btnCancel" @click.prevent="cancelFormInformacion()">Cancelar</button>

                <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormInformacion()">Cerrar</button>

      <div class="sk-circle" v-show="divloaderNuevo">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
      </div>
                
              </div>
              <!-- /.box-footer -->
           
		</form>
          </div>




          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Listado de los Grados y Secciones de la IE: <b>@{{ colegioIE }}</b></h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 300px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
                  </div>


                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>
                  <th style="padding: 5px; width: 4%;">#</th>
                  <th style="padding: 5px; width: 78%;">Grado</th>
                  <th style="padding: 5px; width: 8%;">Estado</th>
                  <th style="padding: 5px; width: 10%;">Gestión</th>
                </tr>
               <tr v-for="grado, key in grados">
                  <td style="font-size: 12px; padding: 5px;">@{{key+1}}</td>

                  <td style="font-size: 12px; padding: 5px;"><b>@{{ grado.nombre }}</b>


                    <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>

                  <th style="padding: 5px; width: 35%;">Sección</th>
                  <th style="padding: 5px; width: 10%;">Alumnos Matriculados</th>
                  <th style="padding: 5px; width: 25%;">Turnos de Asistencia</th>
                  <th style="padding: 5px; width: 10%;">Estado</th>
                  <th style="padding: 5px; width: 15%;">Gestión 
                    <a href="#"  class="btn btn-info" v-on:click.prevent="nuevaSecc(grado)" data-placement="top" data-toggle="tooltip" title="Agregar Nueva Sección"><i class="fa fa-plus-square-o"></i></a>
                  </th>
                </tr>
               <tr v-for="seccion, key2 in secciones" v-if="grado.id==seccion.idgrados">
                  
                  <td style="font-size: 12px; padding: 5px;">@{{ seccion.seccion }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ seccion.cantalumnos }}</td>
                  <td style="font-size: 10px; padding: 5px;">
                  
                    <table>
                      <tr>
                        <td>
                        
                  <table>
                 
                  <template v-for="turno, key3 in turnos" v-if="turno.idSec==seccion.idSec">
                  <template v-if="turno.activo==1">

                   <tr>
                      <td style="font-size: 10px;padding: 2px;">@{{ turno.dia }}: </td><td style="font-size: 10px;padding: 2px;"> <b>Turno @{{ turno.turno }}</b> </td>
                   </tr>
                  </template>

                  </template>

                   </table>

                 </td>
                       
                     
                 <td style="padding-left: 20px;">
                   <a href="#" class="btn btn-success btn-sm" v-on:click.prevent="turnosMethod(seccion)" data-placement="top" data-toggle="tooltip" title="Editar Turnos"><i class="fa fa-edit"></i></a>
                   </td>
                    </tr>
                    </table>

                  </td>

                  <td style="font-size: 12px; padding: 5px;">
                    <span class="label label-success" v-if="seccion.activo=='1'">Activo</span>
                    <span class="label label-warning" v-if="seccion.activo=='0'">Inactivo</span>
                  </td>

                  <td style="font-size: 12px; padding: 5px;">

     

                    <a href="#" v-if="seccion.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaSeccion(seccion)" data-placement="top" data-toggle="tooltip" title="Desactivar Sección"><i class="fa fa-arrow-circle-down"></i></a>

                    <a href="#" v-if="seccion.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaSeccion(seccion)" data-placement="top" data-toggle="tooltip" title="Activar Sección"><i class="fa fa-check-circle"></i></a>


                    <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editSeccion(seccion)" data-placement="top" data-toggle="tooltip" title="Editar Sección"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarSeccion(seccion)" data-placement="top" data-toggle="tooltip" title="Borrar Sección"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              
              <tr v-for="numAl, key3 in numAlumnos" v-if="numAl.idgrado==grado.id">
                  <td colspan="1"><b>Total de Alumnos Matriculados en el Grado</b></td>
                  <td colspan="4"><b>@{{ numAl.cantAl }}</b></td>
                </tr>

              </tbody></table>

            </div>

                  </td>

                  <td style="font-size: 12px; padding: 5px;">
                  	<span class="label label-success" v-if="grado.activo=='1'">Activo</span>
                  	<span class="label label-warning" v-if="grado.activo=='0'">Inactivo</span>
                  </td>

                  <td style="font-size: 12px; padding: 5px;">

     

                  	<a href="#" v-if="grado.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaInformacion(grado)" data-placement="top" data-toggle="tooltip" title="Desactivar el Grado"><i class="fa fa-arrow-circle-down"></i></a>

                  	<a href="#" v-if="grado.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaInformacion(grado)" data-placement="top" data-toggle="tooltip" title="Activar el Grado"><i class="fa fa-check-circle"></i></a>


                  	<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editInformacion(grado)" data-placement="top" data-toggle="tooltip" title="Editar el Grado"><i class="fa fa-edit"></i></a>
                  	<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarInformacion(grado)" data-placement="top" data-toggle="tooltip" title="Borrar el Grado"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>

              </tbody></table>

            </div>

          </div>

<form  v-on:submit.prevent="updateInformacion(fillgrados.id)">
<div class="modal  bs-example-modal-lg" id="modalEditar"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR GRADO</h4>
      </div> 
      <div class="modal-body">
      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Grado:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >

              <div class="col-md-12" >
                <div class="form-group">
                  <label for="txtgradoE" class="col-sm-2 control-label">Grado:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtgradoE" name="txtgradoE" placeholder="Título" maxlength="200" autofocus v-model="fillgrados.nombre">
                  </div>
                </div>
              </div>

 <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="fillgrados.activo">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>
            </div>
          </div>

      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelE" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderEdit">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
      </div>

    
    </div>
  </div>
</div>
</div>
</div>
</form>















<form  v-on:submit.prevent="createSeccion">
<div class="modal  bs-example-modal-lg" id="modalSeccion"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desTituloSeccion" style="font-weight: bold;text-decoration: underline;">NUEVA SECCIÓN</h4>
      </div> 
      <div class="modal-body">
      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulonSec">Grado:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >

              <div class="col-md-12" >
                <div class="form-group">
                  <label for="txtSeccion" class="col-sm-2 control-label">Sección:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtSeccion" name="txtSeccion" placeholder="Nombre de Sección" maxlength="200" autofocus v-model="newSeccion">
                  </div>
                </div>
              </div>




              <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="txnumAlum" class="col-sm-2 control-label">Alumnos Matriculados:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control txtAs" id="txnumAlum" name="txnumAlum" placeholder="0" maxlength="10" v-model="newcantAlum" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>
                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuTurno" class="col-sm-2 control-label">Turno:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuTurno" name="cbuTurno" v-model="turnoOp">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                   </div>
                </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuTurno" class="col-sm-2 control-label">Días Asistencia:*</label>

                  <div class="col-sm-8">
                    <table>
                      <tr>
                        <th style="width: 100px;"><center>Lunes</center></th>
                        <th style="width: 100px;"><center>Martes</center></th>
                        <th style="width: 100px;"><center>Miercoles</center></th>
                        <th style="width: 100px;"><center>Jueves</center></th>
                        <th style="width: 100px;"><center>Viernes</center></th>
                        <th style="width: 100px;"><center>Sábado</center></th>
                        <th style="width: 100px;"><center>Domingo</center></th>
                      </tr>
                      <tr>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check1" v-model="check1"> </center></td>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check2" v-model="check2"></center></td>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check3" v-model="check3"></center></td>
                    <td><center><input type="checkbox" class="checkBoxDia" id="check4" v-model="check4"></center></td>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check5" v-model="check5"> </center></td>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check6" v-model="check6"></center></td>
                    <td><center><input type="checkbox" class="checkBoxDia" id="check7" v-model="check7"></center></td>
                      </tr>
                    </table>


                   </div>
                </div>
            </div>


 <div class="col-md-12" style="padding-top: 25px;">

                <div class="form-group">
                  <label for="cbuestadoSeccion" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestadoSeccion" name="cbuestadoSeccion" v-model="newEstadoSec">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>
            </div>
          </div>

      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveNS"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelNS" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderNS">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
      </div>

    
    </div>
  </div>
</div>
</div>
</div>
</form>


















<form  v-on:submit.prevent="updateSeccion(fillseccions.id)">
<div class="modal  bs-example-modal-lg" id="modalEditSeccion"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTituloSec" style="font-weight: bold;text-decoration: underline;">EDITAR SECCIÓN</h4>
      </div> 
      <div class="modal-body">
      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloGES">Grado:</h3><br><br>
              <h3 class="box-title" id="boxTituloES">Sección:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >


              <div class="col-md-12" >
                <div class="form-group">
                  <label for="txtSeccionE" class="col-sm-2 control-label">Sección:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtSeccionE" name="txtSeccionE" placeholder="Nombre de Sección" maxlength="200" autofocus v-model="fillseccions.nombre">
                  </div>
                </div>
              </div>




              <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="txnumAlumE" class="col-sm-2 control-label">Alumnos Matriculados:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control txtAs" id="txnumAlumE" name="txnumAlumE" placeholder="0" maxlength="10" v-model="fillseccions.cantalumnos" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>
                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;" v-if="2==1">

                <div class="form-group">
                  <label for="cbuTurno" class="col-sm-2 control-label">Turno:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuTurno" name="cbuTurno" v-model="turnoOpE">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                   </div>
                </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;" v-if="2==1">

                <div class="form-group">
                  <label for="cbuTurno" class="col-sm-2 control-label">Días Asistencia:*</label>

                  <div class="col-sm-8">
                    <table>
                      <tr>
                        <th style="width: 100px;"><center>Lunes</center></th>
                        <th style="width: 100px;"><center>Martes</center></th>
                        <th style="width: 100px;"><center>Miercoles</center></th>
                        <th style="width: 100px;"><center>Jueves</center></th>
                        <th style="width: 100px;"><center>Viernes</center></th>
                        <th style="width: 100px;"><center>Sábado</center></th>
                        <th style="width: 100px;"><center>Domingo</center></th>
                      </tr>
                      <tr>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check1E" v-model="check1E"> </center></td>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check2E" v-model="check2E"></center></td>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check3E" v-model="check3E"></center></td>
                    <td><center><input type="checkbox" class="checkBoxDia" id="check4E" v-model="check4E"></center></td>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check5E" v-model="check5E"> </center></td>
                    <td><center> <input type="checkbox" class="checkBoxDia" id="check6E" v-model="check6E"></center></td>
                    <td><center><input type="checkbox" class="checkBoxDia" id="check7E" v-model="check7E"></center></td>
                      </tr>
                    </table>


                   </div>
                </div>
            </div>


 <div class="col-md-12" style="padding-top: 25px;">

                <div class="form-group">
                  <label for="cbuestadoSeccion" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestadoSeccion" name="cbuestadoSeccion" v-model="fillseccions.activo">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>
            </div>


          </div>

      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveESec"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelESec" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderEditSeccion">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
      </div>

    
    </div>
  </div>
</div>
</div>
</div>
</form>















<form  v-on:submit.prevent="updateSeccion2(fillseccions.id)">
<div class="modal  bs-example-modal-lg" id="modalEditSeccion2"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTituloSec2" style="font-weight: bold;text-decoration: underline;">GESTIONAR TURNOS DE LA SECCIÓN</h4>
      </div> 
      <div class="modal-body">
      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloGES2">Grado:</h3><br><br>
              <h3 class="box-title" id="boxTituloES2">Sección:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >

              <div class="col-md-12" style="padding-top: 15px;" v-if="2==1">

                <div class="form-group">
                  <label for="cbuTurno" class="col-sm-2 control-label">Turno:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuTurno" name="cbuTurno" v-model="turnoOpE1">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                   </div>
                </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuTurno" class="col-sm-2 control-label">Días Asistencia:*</label>

                  <div class="col-sm-8">


                    <table>
                      <tr>
                        <th style="border-bottom: 1px solid gray;padding: 5px;">Activo</th>
                        <th style="border-bottom: 1px solid gray;padding: 5px;">Día</th>
                        <th style="border-bottom: 1px solid gray;padding: 5px;">Turno </th>
                      </tr>

                      <tr>
                        <td style="padding: 5px;">
                          <input type="checkbox" class="checkBoxDia" id="check1E" v-model="check1E">
                        </td>
                        <td style="padding: 5px;">
                          Lunes
                        </td>
                        <td style="padding: 5px;">
                          <select class="form-control" id="cbuTurno1E" name="cbuTurno1E" v-model="turnoOpE1">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding: 5px;">
                          <input type="checkbox" class="checkBoxDia" id="check2E" v-model="check2E">
                        </td>
                        <td style="padding: 5px;">
                          Martes
                        </td>
                        <td style="padding: 5px;">
                          <select class="form-control" id="cbuTurno2E" name="cbuTurno2E" v-model="turnoOpE2">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding: 5px;">
                          <input type="checkbox" class="checkBoxDia" id="check3E" v-model="check3E">
                        </td>
                        <td style="padding: 5px;">
                          Miercoles
                        </td>
                        <td style="padding: 5px;">
                          <select class="form-control" id="cbuTurno3E" name="cbuTurno3E" v-model="turnoOpE3">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding: 5px;">
                          <input type="checkbox" class="checkBoxDia" id="check4E" v-model="check4E">
                        </td>
                        <td style="padding: 5px;">
                          Jueves
                        </td>
                        <td style="padding: 5px;">
                          <select class="form-control" id="cbuTurno4E" name="cbuTurno4E" v-model="turnoOpE4">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding: 5px;">
                          <input type="checkbox" class="checkBoxDia" id="check5E" v-model="check5E">
                        </td>
                        <td style="padding: 5px;">
                          Viernes
                        </td>
                        <td style="padding: 5px;">
                          <select class="form-control" id="cbuTurno5E" name="cbuTurno5E" v-model="turnoOpE5">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding: 5px;">
                          <input type="checkbox" class="checkBoxDia" id="check6E" v-model="check6E">
                        </td>
                        <td style="padding: 5px;">
                          Sabado
                        </td>
                        <td style="padding: 5px;">
                          <select class="form-control" id="cbuTurno6E" name="cbuTurno6E" v-model="turnoOpE6">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding: 5px;">
                          <input type="checkbox" class="checkBoxDia" id="check7E" v-model="check7E">
                        </td>
                        <td style="padding: 5px;">
                          Domingo
                        </td>
                        <td style="padding: 5px;">
                          <select class="form-control" id="cbuTurno7E" name="cbuTurno7E" v-model="turnoOpE7">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">@{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>
                      </tr>


                    </table>


                   </div>
                </div>
            </div>

          </div>

      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveESec2"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelESec2" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderEditSeccion2">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
      </div>

    
    </div>
  </div>
</div>
</div>
</div>
</form>