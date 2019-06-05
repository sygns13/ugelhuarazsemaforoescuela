<div class="box box-primary" v-if="mostrarPalenIni">
            <div class="box-header with-border"> 
              <h3 class="box-title">Gestión de Personal</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="<?php echo e(URL::to('home')); ?>"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">



                       <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
              <button type="button" class="btn btn-primary btn-sm" id="btncrearusuario" @click.prevent="nuevoUsuario()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Personal</button>
                </div>
                </div>





                
              </div>

          </div>

        <div class="box box-success" v-if="divNuevoUsuario">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nuevo Personal


              </h3>
            </div>
       
        <?php echo $__env->make('personals.formulario', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  

         </div>

         <div class="box box-warning" v-if="divEditUsuario">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Editar Personal: {{ fillPersona.apellidos }} {{ fillPersona.nombres }}


              </h3>
            </div>
       
        <?php echo $__env->make('personals.editar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  

         </div>
          <div class="box box-info" >
            <div class="box-header">
              <h3 class="box-title">Listado de Personales
              </h3>

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
                  <th style="padding: 5px; width: 3%;">#</th>
                  <th style="padding: 5px; width: 15%;">Institución Educativa</th>
                  <th style="padding: 5px; width: 7%;">Código Modular</th>
                  <th style="padding: 5px; width: 14%;">Apellidos y Nombres</th>
                  <th style="padding: 5px; width: 6%;">DNI</th>
                  
                  <th style="padding: 5px; width: 16%;">Cargo</th>
                  <th style="padding: 5px; width: 18%;">Turno</th>
                  <th style="padding: 5px; width: 5%;">Estado</th>
                  <th style="padding: 5px; width: 16%;">Gestión</th>
                </tr>
                <tr v-for="personal, key in personals">
                  <td style="font-size: 11px; padding: 5px;">{{key+pagination.from}}</td>
                  <td style="font-size: 11px; padding: 5px;">{{ personal.nombreie }}</td>
                  <td style="font-size: 11px; padding: 5px;">{{ personal.codigomod }}</td>
                  <td style="font-size: 11px; padding: 5px;">{{ personal.apePer }}, {{ personal.nombresPer }}</td>
                  <td style="font-size: 11px; padding: 5px;">{{ personal.doc }}</td>
                 
                  <td style="font-size: 11px; padding: 5px;">{{ personal.cargo }}</td>
                  <td style="font-size: 11px; padding: 5px;">
                     <table>
                      <tr>
                        <td>
                        
                  <table>
                 
                  <template v-for="turno, key3 in turnos[key]" v-if="turno.idPer==personal.idpersonal">
                  <template v-if="turno.activo==1">

                   <tr>
                      <td style="font-size: 10px;padding: 2px;">{{ turno.dia }}: </td><td style="font-size: 10px;padding: 2px;"> <b>Turno {{ turno.turno }}</b> </td>
                   </tr>
                  </template>
                  </template>


                   <template v-for="turno, key3 in turnos2[key]" v-if="turno.idPer==personal.idpersonal">
                  <template v-if="turno.activo==2">

                   <tr>
                      <td style="font-size: 10px;padding: 2px;">{{ turno.dia }}: </td><td style="font-size: 10px;padding: 2px;"> <b>Turno {{ turno.turno }}</b> </td>
                   </tr>
                  </template>
                  </template>



                   <template v-for="turno, key3 in turnos3[key]" v-if="turno.idPer==personal.idpersonal">
                  <template v-if="turno.activo==3">

                   <tr>
                      <td style="font-size: 10px;padding: 2px;">{{ turno.dia }}: </td><td style="font-size: 10px;padding: 2px;"> <b>Turno {{ turno.turno }}</b> </td>
                   </tr>
                  </template>
                  </template>








                   </table>

                 </td>
                       
                     
                 <td style="padding-left: 20px;">
                   <a href="#" class="btn btn-success btn-sm" v-on:click.prevent="turnosMethod(personal)" data-placement="top" data-toggle="tooltip" title="Editar Turnos"><i class="fa fa-edit"></i></a>
                   </td>
                    </tr>
                    </table>
                  </td>
                  <td style="font-size: 11px; padding: 5px;">
                    <span class="label label-success" v-if="personal.activo=='1'">Activo</span>
                    <span class="label label-warning" v-if="personal.activo=='0'">Inactivo</span>
                  </td>
                  <td style="font-size: 11px; padding: 5px;">

                   <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="impFicha(personal)" data-placement="top" data-toggle="tooltip" title="Imprimir Ficha de Usuario"><i class="fa fa-print"></i></a>

                   <a href="#" class="btn bg-teal btn-sm" v-on:click.prevent="detalle(personal)" data-placement="top" data-toggle="tooltip" title="Gestionar Licencias, Permisos"><i class="fa fa-wheelchair"></i></a>


                    <a href="#" v-if="personal.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaUsuario(personal)" data-placement="top" data-toggle="tooltip" title="Desactivar Usuario"><i class="fa fa-arrow-circle-down"></i></a>

                    <a href="#" v-if="personal.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaUsuario(personal)" data-placement="top" data-toggle="tooltip" title="Activar Usuario"><i class="fa fa-check-circle"></i></a>


                    <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editUsuario(personal)" data-placement="top" data-toggle="tooltip" title="Editar personal"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarUsuario(personal)" data-placement="top" data-toggle="tooltip" title="Borrar personal"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>

              </tbody></table>

            </div>
            <!-- /.box-body -->
            <div style="padding: 15px;">
              <div><h5>Registros por Página: {{ pagination.per_page }}</h5></div>
            <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" v-if="pagination.current_page>1">
          <a class="page-link" href="#" @click.prevent="changePage(1)">
            <span><b>Inicio</b></span>
          </a>
        </li>

        <li class="page-item" v-if="pagination.current_page>1">
          <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1)">
            <span>Atras</span>
          </a>
        </li>
        <li class="page-item" v-for="page in pagesNumber" v-bind:class="[page=== isActived ? 'active' : '']">
          <a class="page-link" href="#" @click.prevent="changePage(page)">
            <span>{{ page }}</span>
          </a>
        </li>
        <li class="page-item" v-if="pagination.current_page< pagination.last_page">
          <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1)">
            <span>Siguiente</span>
          </a>
        </li>
        <li class="page-item" v-if="pagination.current_page< pagination.last_page">
          <a class="page-link" href="#" @click.prevent="changePage(pagination.last_page)">
            <span><b>Ultima</b></span>
          </a>
        </li>
      </ul>
    </nav>
    <div><h5>Registros Totales: {{ pagination.total }}</h5></div>
    </div>
          </div>


<form  v-on:submit.prevent="Imprimir()">
<div class="modal fade bs-example-modal-lg" id="modalFicha" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document"  id="modaltamanio1">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">IMPRIMIR FICHA DE PERSONAL</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloAgre"></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div id="FichaUsuario"> 
       <?php echo $__env->make('personals.ficha', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
                
            </div>
          </div>



      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnImprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Ficha</button>

      <button type="button" id="btnCancelFoto" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>



      </div>
    </div>
  </div>
</div>
</div>
</form>












<form  v-on:submit.prevent="updateSeccion2(fillPersonal.id)">
<div class="modal  bs-example-modal-lg" id="modalEditSeccion2"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTituloSec2" style="font-weight: bold;text-decoration: underline;">GESTIONAR TURNOS DEL PERSONAL</h4>
      </div> 
      <div class="modal-body">
      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloGES2">Personal:</h3><br><br>
              <h3 class="box-title" id="boxTituloES2">Cargo:</h3>
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
                      <option :value="turno.id">{{ turno.descripcion }}</option>
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
                        <th style="border-bottom: 1px solid gray;padding: 5px;">Turno Principal </th>
                        <th style="border-bottom: 1px solid gray;padding: 5px;">Turno 2 </th>
                        <th style="border-bottom: 1px solid gray;padding: 5px;">Turno 3 </th>
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
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>


                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu2Turno1E" name="cbu2Turno1E" v-model="turno2OpE1">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>

                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu3Turno1E" name="cbu3Turno1E" v-model="turno3OpE1">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
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
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>


                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu2Turno2E" name="cbu2Turno2E" v-model="turno2OpE2">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>

                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu3Turno2E" name="cbu3Turno2E" v-model="turno3OpE2">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
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
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>



                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu2Turno3E" name="cbu2Turno3E" v-model="turno2OpE3">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>

                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu3Turno3E" name="cbu3Turno3E" v-model="turno3OpE3">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
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
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>



                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu2Turno4E" name="cbu2Turno4E" v-model="turno2OpE4">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>

                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu3Turno4E" name="cbu3Turno4E" v-model="turno3OpE4">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
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
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>


                         <td style="padding: 5px;">
                          <select class="form-control" id="cbu2Turno5E" name="cbu2Turno5E" v-model="turno2OpE5">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>

                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu3Turno5E" name="cbu3Turno5E" v-model="turno3OpE5">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
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
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>


                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu2Turno6E" name="cbu2Turno6E" v-model="turno2OpE6">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>

                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu3Turno6E" name="cbu3Turno6E" v-model="turno3OpE6">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
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
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>



                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu2Turno7E" name="cbu2Turno7E" v-model="turno2OpE7">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                        </td>

                        <td style="padding: 5px;">
                          <select class="form-control" id="cbu3Turno7E" name="cbu3Turno7E" v-model="turno3OpE7">
                            <option value="0">Ninguno</option>
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
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