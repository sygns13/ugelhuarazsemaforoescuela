 <form v-on:submit.prevent="createUsuario">
             <div class="box-body" style="font-size: 12px;">

              <div class="col-md-12" >

              <div class="form-group">
                  <label for="txtDNI" class="col-sm-1 control-label">DNI:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtDNI" name="txtDNI" placeholder="N° de DNI" maxlength="8" autofocus v-model="newDNI" @keyup.enter="pressNuevoDNI(newDNI)" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" :disabled="validated == 1" onkeypress="return soloNumeros(event);">
                  </div>
                  <div  class="col-sm-8">
                    <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="pressNuevoDNI(newDNI)">Validar</a>
                  </div>
                </div>



                </div>

                <template v-if="formularioCrear">


                  <div class="col-md-12">
                    <hr style="border-top: 3px solid #1b5f43;">
                  </div>

                  <center><h4>Datos Personales del Personal</h4></center>

              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                  <label for="txtnombres" class="col-sm-1 control-label">Nombres:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtnombres" name="txtnombres" placeholder="Nombres" maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newNombres">
                  </div>

                  <label for="txtapellidos" class="col-sm-1 control-label">Apellidos:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtapellidos" name="txtapellidos" placeholder="Apellidos" maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newApellidos">
                  </div>
                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuGenero" class="col-sm-1 control-label">Género:*</label>

                  <div class="col-sm-2">
                  <select class="form-control" id="cbuGenero" name="cbuGenero" v-model="newGenero">
                    <option value="0">Sin Información</option>
                    <option value="1">Masculino</option>
                    <option value="2">Femenino</option>
                  </select>
                   </div>

                     <label for="txtfono" class="col-sm-1 control-label">Teléfono/Cell:</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfono" name="txtfono" placeholder="N°" maxlength="25" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newTelefono">
                  </div>

                  <label for="txtDir" class="col-sm-1 control-label">Dirección:</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtDir" name="txtDir" placeholder="Av. Jr. Psje." maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newDireccion">
                  </div>

                </div>

            </div>


             <div class="col-md-12">
                    <hr>
                  </div>

                  <center><h4>Datos de Personal</h4></center>



            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuIE" class="col-sm-1 control-label">Institución:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbuIE" name="cbuIE" >
                    <option disabled value="">Seleccione una Institución</option>
                    <template v-for="institucion, key in institucions">
                        <option v-bind:value="institucion.idInsti" v-if="institucion.tipo==1">{{ institucion.nombre }} </option>
                        <option v-bind:value="institucion.idInsti" v-if="institucion.tipo==2">{{ institucion.nombre }} - Código Modular: {{ institucion.codigomod }}</option>
                    </template>
                    
                  </select>
                   </div>
                </div>
            
            </div>



            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuLey" class="col-sm-1 control-label">Régimen Laboral:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbuLey" name="cbuLey" >
                    <option disabled value="">Seleccione un Régimen Laboral</option>

                        <option value="D. LEG. Nº 1057">D. LEG. Nº 1057</option>
                        <option value="D.L. 276">D.L. 276</option>
                        <option value="LEY 24029">LEY 24029</option>
                        <option value="LEY 29944">LEY 29944</option>
                        <option value="LEY 30493">LEY 30493</option>
                        <option value="SIN REGIMEN">SIN REGIMEN</option>

                    
                  </select>
                   </div>
                </div>
            
            </div>



            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuCargos" class="col-sm-1 control-label">Cargo:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbuCargos" name="cbuCargos" >
                    <option disabled value="">Seleccione un Cargo</option>
<option value="DIRECTOR DE UNIDAD DE GESTIÓN EDUCATIVA LOCAL">DIRECTOR DE UNIDAD DE GESTIÓN EDUCATIVA LOCAL</option>
<option value="DIRECTOR I.E.">DIRECTOR I.E.</option>
<option value="SUB-DIRECTOR I.E.">SUB-DIRECTOR I.E.</option>
<option value="DOCENTE COORDINADOR ODEC">DOCENTE COORDINADOR ODEC</option>
<option value="PROFESOR">PROFESOR</option>
<option value="PROFESOR - AIP">PROFESOR - AIP</option>
<option value="PROFESOR - EDUCACION FISICA">PROFESOR - EDUCACION FISICA</option>
<option value="PROFESOR (FUNCIONES DE DIRECTOR)">PROFESOR (FUNCIONES DE DIRECTOR)</option>
<option value="PROFESOR CON FUNCIONES DE COORDINADOR DE TUTORIA JEC">PROFESOR CON FUNCIONES DE COORDINADOR DE TUTORIA JEC</option>
<option value="PROFESOR CON FUNCIONES DE COORDINADOR PEDAGOGICO JEC">PROFESOR CON FUNCIONES DE COORDINADOR PEDAGOGICO JEC</option>
<option value="PROFESOR COORDINADOR">PROFESOR COORDINADOR</option>
<option value="APOYO EDUCATIVO">APOYO EDUCATIVO</option>
<option value="ASESOR">ASESOR</option>
<option value="AUXILIAR DE BIBLIOTECA">AUXILIAR DE BIBLIOTECA</option>
<option value="AUXILIAR DE BIBLIOTECA II">AUXILIAR DE BIBLIOTECA II</option>
<option value="AUXILIAR DE CONTABILIDAD">AUXILIAR DE CONTABILIDAD</option>
<option value="AUXILIAR DE EDUCACION">AUXILIAR DE EDUCACION</option>
<option value="AUXILIAR DE LABORATORIO">AUXILIAR DE LABORATORIO</option>
<option value="AUXILIAR DE LABORATORIO I">AUXILIAR DE LABORATORIO I</option>
<option value="AUXILIAR DE SISTEMA ADMINISTRATIVO">AUXILIAR DE SISTEMA ADMINISTRATIVO</option>
<option value="AUXILIAR DE VIDEOTECA">AUXILIAR DE VIDEOTECA</option>
<option value="CAJERO I">CAJERO I</option>
<option value="CHOFER I">CHOFER I</option>
<option value="CONTADOR I">CONTADOR I</option>
<option value="COORDINADOR">COORDINADOR</option>
<option value="COORDINADOR ACADEMICO">COORDINADOR ACADEMICO</option>
<option value="COORDINADOR ADMINISTRATIVO Y DE RECURSOS EDUCATIVOS PARA ZONAS RURALES">COORDINADOR ADMINISTRATIVO Y DE RECURSOS EDUCATIVOS PARA ZONAS RURALES</option>
<option value="COORDINADOR ADMINISTRATIVO Y DE RECURSOS EDUCATIVOS PARA ZONAS URBANAS">COORDINADOR ADMINISTRATIVO Y DE RECURSOS EDUCATIVOS PARA ZONAS URBANAS</option>
<option value="COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO">COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO</option>
<option value="COORDINADOR DE TUTORIA Y ORIENTACION EDUCATIVA">COORDINADOR DE TUTORIA Y ORIENTACION EDUCATIVA</option>
<option value="DIRECTOR DE SISTEMA ADMINISTRATIVO II">DIRECTOR DE SISTEMA ADMINISTRATIVO II</option>
<option value="DOCENTE RESPONSABLE DE NUCLEO DISTRITAL">DOCENTE RESPONSABLE DE NUCLEO DISTRITAL</option>
<option value="ESPECIALISTA ADMINISTRATIVO I">ESPECIALISTA ADMINISTRATIVO I</option>
<option value="ESPECIALISTA EN ABASTECIMIENTO">ESPECIALISTA EN ABASTECIMIENTO</option>
<option value="ESPECIALISTA EN EDUCACION">ESPECIALISTA EN EDUCACION</option>
<option value="ESPECIALISTA EN FINANZAS I">ESPECIALISTA EN FINANZAS I</option>
<option value="ESPECIALISTA EN INSPECTORIA I">ESPECIALISTA EN INSPECTORIA I</option>
<option value="ESPECIALISTA EN MONITOREO DE EVALUACIONES DE ESTUDIANTES Y DOCENTES">ESPECIALISTA EN MONITOREO DE EVALUACIONES DE ESTUDIANTES Y DOCENTES</option>
<option value="ESPECIALISTA EN PROCESOS ADMINISTRATIVOS DISCIPLINARIOS">ESPECIALISTA EN PROCESOS ADMINISTRATIVOS DISCIPLINARIOS</option>
<option value="ESPECIALISTA EN RACIONALIZACION I">ESPECIALISTA EN RACIONALIZACION I</option>
<option value="ESPECIALISTA EN SUPERVISION DE IIEE PRIVADAS">ESPECIALISTA EN SUPERVISION DE IIEE PRIVADAS</option>
<option value="ESTADISTICO I">ESTADISTICO I</option>
<option value="GESTOR LOCAL INTERVENCIONES PP090">GESTOR LOCAL INTERVENCIONES PP090</option>
<option value="INGENIERO I">INGENIERO I</option>
<option value="JEFE DE AREA">JEFE DE AREA</option>
<option value="JEFE DE DPTO. GUIA OFICIAL DE TURISMO">JEFE DE DPTO. GUIA OFICIAL DE TURISMO</option>
<option value="JEFE DE GESTIÓN PEDAGÓGICA">JEFE DE GESTIÓN PEDAGÓGICA</option>
<option value="JEFE DE LABORATORIO">JEFE DE LABORATORIO</option>
<option value="JEFE DE PRODUCCION">JEFE DE PRODUCCION</option>
<option value="JEFE DE TALLER">JEFE DE TALLER</option>
<option value="JEFE DE TALLER DE COMPUTACION E INFORMATICA">JEFE DE TALLER DE COMPUTACION E INFORMATICA</option>
<option value="JEFE DE TALLER DE ELECTRICIDAD">JEFE DE TALLER DE ELECTRICIDAD</option>
<option value="OFICINISTA">OFICINISTA</option>
<option value="OFICINISTA I">OFICINISTA I</option>
<option value="OFICINISTA II">OFICINISTA II</option>
<option value="OFICINISTA III">OFICINISTA III</option>
<option value="PERSONAL DE MANTENIMIENTO">PERSONAL DE MANTENIMIENTO</option>
<option value="PERSONAL DE SECRETARIA">PERSONAL DE SECRETARIA</option>
<option value="PERSONAL DE VIGILANCIA">PERSONAL DE VIGILANCIA</option>
<option value="PLANIFICADOR I">PLANIFICADOR I</option>
<option value="PROMOTORA EDUCATIVA COMUNAL">PROMOTORA EDUCATIVA COMUNAL</option>
<option value="PSICOLOGO">PSICOLOGO</option>
<option value="RESPONSABLE LOCAL DE CALIDAD DE LA INFORMACION">RESPONSABLE LOCAL DE CALIDAD DE LA INFORMACION</option>
<option value="SECRETARIA">SECRETARIA</option>
<option value="SECRETARIA I">SECRETARIA I</option>
<option value="SECRETARIA II">SECRETARIA II</option>
<option value="TECNICO ADMINISTRATIVO">TECNICO ADMINISTRATIVO</option>
<option value="TECNICO ADMINISTRATIVO I">TECNICO ADMINISTRATIVO I</option>
<option value="TESORERO I">TESORERO I</option>
<option value="TRABAJADOR DE SERVICIO">TRABAJADOR DE SERVICIO</option>
<option value="TRABAJADOR DE SERVICIO I">TRABAJADOR DE SERVICIO I</option>
<option value="TRABAJADOR DE SERVICIO II">TRABAJADOR DE SERVICIO II</option>
<option value="TRABAJADOR DE SERVICIO III">TRABAJADOR DE SERVICIO III</option>


                    
                  </select>
                   </div>
                </div>
            
            </div>


                            <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestado" class="col-sm-1 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="newEstado">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>

            </div>


             <div class="col-md-12">
                    <hr>
                  </div>
 <center><h4>Configuración de Turnos del Personal</h4></center>

                          <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuTurno" class="col-sm-1 control-label">Turno:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuTurno" name="cbuTurno" v-model="turnoOp">
                    <template v-for="turno, key in turns">
                      <option :value="turno.id">{{ turno.descripcion }}</option>
                    </template>
                  </select>
                   </div>
                </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuTurno" class="col-sm-1 control-label">Días Asistencia:*</label>

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








            </template>

            </div>

              <!-- /.box-body -->
              <div class="box-footer" >
                <button v-if="formularioCrear" type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>

                <button v-if="formularioCrear" type="reset" class="btn btn-warning" id="btnCancel" @click="cancelFormUsuario()">Cancelar</button>

                <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormUsuario()">Cerrar</button>

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