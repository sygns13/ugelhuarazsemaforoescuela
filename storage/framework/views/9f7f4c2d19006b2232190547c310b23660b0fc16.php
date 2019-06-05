<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de Turnos</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="<?php echo e(URL::to('home')); ?>"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">

<div class="col-md-8"> 
                <h3>Turnos Configurados Para la Asistencia del Personal Administrativo</h3>
                <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>

                  <th style="padding: 5px; width: 40%;">Turno</th>
                  <th style="padding: 5px; width: 15%;">Código</th>
                  <th style="padding: 5px; width: 15%;">Hora de Inicio(Control Asistencia)</th>
                  <th style="padding: 5px; width: 15%;">Hora Final (Control Asistencia)</th>
                  <th style="padding: 5px; width: 15%;">Gestión</th>

                </tr>
                 <tr v-for="turno, key in turnos1">

                  <td style="font-size: 12px; padding: 5px;">{{ turno.descripcion }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ turno.codigo }}</td>                
                  <td style="font-size: 12px; padding: 5px;">{{ turno.horaIni }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ turno.horaFin }}</td>



                  <td style="font-size: 12px; padding: 5px;">

                    <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editTurno(turno,'1')" data-placement="top" data-toggle="tooltip" title="Editar Turno"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>

              </tbody></table>

            </div>

</div>



<div class="col-md-8" style="padding-top: 20px;"> 
                <h3>Turnos Configurados Para la Asistencia de Alumnos</h3>
                <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>

                  <th style="padding: 5px; width: 40%;">Turno</th>
                  <th style="padding: 5px; width: 15%;">Código</th>
                  <th style="padding: 5px; width: 15%;">Hora de Inicio(Control Asistencia)</th>
                  <th style="padding: 5px; width: 15%;">Hora Final (Control Asistencia)</th>
                  <th style="padding: 5px; width: 15%;">Gestión</th>

                </tr>
                 <tr v-for="turno, key in turnos2">

                  <td style="font-size: 12px; padding: 5px;">{{ turno.descripcion }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ turno.codigo }}</td>                
                  <td style="font-size: 12px; padding: 5px;">{{ turno.horaIni }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ turno.horaFin }}</td>



                  <td style="font-size: 12px; padding: 5px;">

                    <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editTurno(turno,'2')" data-placement="top" data-toggle="tooltip" title="Editar Turno"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>

              </tbody></table>

            </div>

</div>


          </div>

          </div>












<form method="post" v-on:submit.prevent="updateTurno(fillTurno.id)">
<div class="modal  bs-example-modal-lg" id="modalEditar"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR TURNO</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Turno:</h3><br><br>
              <h3 class="box-title" id="boxTituloAplic">Aplicado A:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >


              <div class="col-md-12"  style="padding-top: 15px;">
              <div class="form-group">
                  <label for="hraIni" class="col-sm-2 control-label">Hora de Inicio:*</label>
                  <div class="col-sm-8">
                    <input type="time" class="form-control" id="hraIni" name="hraIni" placeholder="00:00:00" maxlength="8" autofocus v-model="fillTurno.horaIni">
                  </div>
                </div>
              </div>


              <div class="col-md-12"  style="padding-top: 15px;">
              <div class="form-group">
                  <label for="hraFin" class="col-sm-2 control-label">Hora Final:*</label>
                  <div class="col-sm-8">
                    <input type="time" class="form-control" id="hraFin" name="hraFin" placeholder="00:00:00" maxlength="8"  v-model="fillTurno.horaFin">
                  </div>
                </div>
              </div>



              <!-- /.box-body -->
             

            
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
</div>
</form>
