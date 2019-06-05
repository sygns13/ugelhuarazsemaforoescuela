<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Reportes de Asistencia de Personal</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="<?php echo e(URL::to('home')); ?>"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                <div class="form-group">


                  <div class="col-md-12">
                    <h5>Filtros de Búsqueda</h5>
                  </div>


                  <div class="col-md-12">
                    
                                        <div class="form-group">
                  <label for="vbuFe" class="col-sm-1 control-label">Fecha:*</label>

                    <div class="col-sm-3">
                    <select id="vbuFe" class="form-control"  v-model="cbufecha">
                <option value="0">Hoy: <?php echo e($fecha); ?></option>
                <option value="1">Mes: <?php echo e(nombremes($mesActual)); ?> de <?php echo e($yearActual); ?></option>
                
                
                <option value="4">Rango de Fecha</option>
                
                </select>

                <div id="divfec" v-if="cbufecha==4">
                    
                   <br>
                <div style="display: inline-block">
                
                Desde:
                 <input type="date" class="form-control" id="txtfecha" name="txtfecha" placeholder="dd/mm/aaaa" maxlength="10"  v-model="fechaini">

                Hasta:
                 <input type="date" class="form-control" id="txtfecha" name="txtfecha" placeholder="dd/mm/aaaa" maxlength="10"  v-model="fechafin">
                    
                </div>
            </div>
                </div>


            

    
                <div class="form-group">
                  <label for="cbuIE" class="col-sm-1 control-label">Institución:*</label>

                  <div class="col-sm-7">
                  <select class="form-control" id="cbuIE" name="cbuIE" >
                    <option value="0">Reporte General por Instituciones</option>
                    <option value="-1">Reporte General de Personal</option>
                    <template v-for="institucion, key in institucions">
                        <option v-bind:value="institucion.id" v-if="institucion.tipo==1">{{ institucion.nombre }} </option>
                        <option v-bind:value="institucion.id" v-if="institucion.tipo==2">{{ institucion.nombre }} - Código Modular: {{ institucion.codigomod }}</option>
                    </template>
                    
                  </select>
                   </div>
                </div>
     
           
                 

                  </div>
                  </div>


<div class="col-md-12" style="padding-top: 30px;" v-if="selectInsti">
  


                <div class="form-group">
                  <label for="cbuPersonal" class="col-sm-1 control-label">Personal:*</label>

                  <div class="col-sm-5">
                  <select class="form-control" id="cbuPersonal" name="cbuPersonal" >
                    <option value="0">Reporte General</option>
                    <template v-for="personal, key in personals">
                        <option v-bind:value="personal.idpersonal">{{ personal.apellidos }} , {{ personal.apellidos }} - DNI: {{ personal.doc }}</option>
                       
                    </template>
                    
                  </select>
                   </div>


                </div>
<template v-for="personal, key in personals">
     <input type="hidden" name="txtcargo" v-bind:id="'txtcargo'+personal.idpersonal" v-bind:value="personal.cargo">
</template>


</div>



<div  class="col-md-12" style="padding-top: 30px;">
  
   <div class="form-group" >

    <button type="button" class="btn btn-info" id="btnImprimirPlantilla" @click.prevent="buscarInfo()"><i class="fa fa-search" aria-hidden="true" ></i> Buscar Datos</button>

              <button type="button" class="btn btn-success" id="btnImprimirPlantilla" @click.prevent="imprimirPlantilla()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir</button>

                    <div class="sk-three-bounce" v-show="divloaderNuevo">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
      </div>

              
                </div>

</div>


                </div>
          </div>

          </div>













<center>
           <div style="width: 23cm; height: auto; background-color: white;" id="divImp">
  <div style="padding-top: 1.5cm;padding-left: 1cm; padding-right: 0.7cm;">
    <center><b>Reporte de Asistencia de Personal</b></center>


    <div>
      <table style="border: 0px solid gray; width: 100%;">
        <tr>
          <td style="font-size: 12px;" v-if="cbufecha==0">
            Fecha: {{ cabehoy }}
          </td>
          <td style="font-size: 12px;" v-if="cbufecha==1">
            Fecha: {{ cabemes }}
          </td>
          <td style="font-size: 12px;" v-if="cbufecha==2">
            Fecha: {{ cabeyear }}
          </td>
          <td style="font-size: 12px;" v-if="cbufecha==3">
            Fecha: {{cabesiempre }}
          </td>
          <td style="font-size: 12px;" v-if="cbufecha==4">
            Rango de Fecha Desde el: {{ pasfechaVista(fechaini) }} Hasta el: {{ pasfechaVista(fechafin) }}
          </td>
        </tr>
        
      </table>
    </div>

    <div>
      <table style="border: 0px solid gray; width: 100%;">
        <tr>
          <td style="font-size: 12px;" v-if="cbuIE==0">
            Reporte General de Instituciones Educativas
          </td>
          <td style="font-size: 12px;" v-if="cbuIE==-1">
            Reporte General de Personal
          </td>
          <td style="font-size: 12px;" v-if="cbuIE==1">
            Institución {{ nombreIE }} 
          </td>
          <td style="font-size: 12px;" v-if="cbuIE>1">
            Institución Educativa: {{ nombreIE }} <br>
            Nivel: {{ nivel }}
          </td>
       
        </tr>
        
      </table>
    </div>

        <div>
      <table style="border: 0px solid gray; width: 100%;">
        <tr>
          <td style="font-size: 12px;" v-if="cbuPersonal>1">
            Trabajador: {{ trabajador }} 
          </td>
        </tr>
        <tr>
          <td style="font-size: 12px;" v-if="cbuPersonal>1">
            Cargo: {{ cargo }}
          </td>
        </tr>
        
      </table>
    </div>


         <div style="padding-top: 20px;" v-if="cbuIE==0" class="box-body table-responsive">
      <table style=" width: 100%;" class="table table-hover table-bordered">
        <tr>
          <th style=" font-size: 12px; width: 4%;">N°</th>
          <th style=" font-size: 12px; width: 26%;">Institución</th>
          <th style=" font-size: 12px; width: 10%;">Código Modular</th>
          <th style=" font-size: 12px; width: 20%;">Nivel</th>
          <th style=" font-size: 12px; width: 10%;">Asistencias programadas</th>
          <th style=" font-size: 12px; width: 10%;">Asistencias Realizadas</th>
          <th style=" font-size: 12px; width: 10%;">Faltas de Personal</th>
          <th style=" font-size: 12px; width: 10%;">% de Asistencia</th>
        </tr>


         <tr v-for="rep, key in reporte" >
                  <td style="font-size: 12px; padding: 5px;">{{key+1}}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.nombre }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.codigomod }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.nivel }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.asistProgramadas }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.asistRealizadas }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.Faltas }}</td>

                  <template v-if="parseFloat(rep.Porcentaje)>=98">
                  <td style="font-size: 12px; padding: 5px; background: green!important;;">{{ rep.Porcentaje }}</td>
                </template>

                <template v-if="parseFloat(rep.Porcentaje)>=90 && parseFloat(rep.Porcentaje)<98">
                  <td style="font-size: 12px; padding: 5px; background: orange!important;;">{{ rep.Porcentaje }}</td>
                </template>

                <template v-if="parseFloat(rep.Porcentaje)>=0 && parseFloat(rep.Porcentaje)<90">
                  <td style="font-size: 12px; padding: 5px; background: red!important;;">{{ rep.Porcentaje }}</td>
                </template>


                </tr>
        
      </table>
      </div>



             <div style="padding-top: 20px;" v-if="cbuIE==-1" class="box-body table-responsive">
      <table style=" width: 100%;" class="table table-hover table-bordered">
        <tr>
          <th style=" font-size: 10px; width: 4%;">N°</th>
          <th style=" font-size: 10px; width: 14%;">Institución</th>
          <th style=" font-size: 10px; width: 14%;">Persona</th>
          <th style=" font-size: 10px; width: 10%;">DNI</th>
          <th style=" font-size: 10px; width: 14%;">Cargo</th>
          <th style=" font-size: 10px; width: 14%;">Tipo</th>
          <th style=" font-size: 10px; width: 7%;">Asistencias programadas</th>
          <th style=" font-size: 10px; width: 7%;">Asistencias Realizadas</th>
          <th style=" font-size: 10px; width: 8%;">Faltas de Personal</th>
          <th style=" font-size: 10px; width: 8%;">% de Asistencia</th>
        </tr>


         <tr v-for="rep, key in reporte4" >
                  <td style="font-size: 10px; padding: 5px;">{{parseInt(key)+1}}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.ie }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.nombre }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.dni }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.cargo }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.tipo }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.asistProgramadas }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.asistRealizadas }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.Faltas }}</td>

                  <template v-if="parseFloat(rep.Porcentaje)>=98">
                  <td style="font-size: 10px; padding: 5px; background: green!important;;">{{ rep.Porcentaje }}</td>
                </template>

                <template v-if="parseFloat(rep.Porcentaje)>=90 && parseFloat(rep.Porcentaje)<98">
                  <td style="font-size: 10px; padding: 5px; background: orange!important;;">{{ rep.Porcentaje }}</td>
                </template>

                <template v-if="parseFloat(rep.Porcentaje)>=0 && parseFloat(rep.Porcentaje)<90">
                  <td style="font-size: 10px; padding: 5px; background: red!important;;">{{ rep.Porcentaje }}</td>
                </template>


                </tr>
        

      </table>
      </div>





       <div style="padding-top: 20px;" v-if="cbuIE>0 && cbuPersonal==0" class="box-body table-responsive">
      <table style=" width: 100%;" class="table table-hover table-bordered">
        <tr>
          <th style=" font-size: 10px; width: 4%;">N°</th>
          <th style=" font-size: 10px; width: 18%;">Persona</th>
          <th style=" font-size: 10px; width: 10%;">DNI</th>
          <th style=" font-size: 10px; width: 18%;">Cargo</th>
          <th style=" font-size: 10px; width: 18%;">Tipo</th>
          <th style=" font-size: 10px; width: 8%;">Asistencias programadas</th>
          <th style=" font-size: 10px; width: 8%;">Asistencias Realizadas</th>
          <th style=" font-size: 10px; width: 8%;">Faltas de Personal</th>
          <th style=" font-size: 10px; width: 8%;">% de Asistencia</th>
        </tr>


         <tr v-for="rep, key in reporte2" >
                  <td style="font-size: 10px; padding: 5px;">{{key+1}}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.nombre }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.dni }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.cargo }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.tipo }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.asistProgramadas }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.asistRealizadas }}</td>
                  <td style="font-size: 10px; padding: 5px;">{{ rep.Faltas }}</td>

                  <template v-if="parseFloat(rep.Porcentaje)>=98">
                  <td style="font-size: 10px; padding: 5px; background: green!important;;">{{ rep.Porcentaje }}</td>
                </template>

                <template v-if="parseFloat(rep.Porcentaje)>=90 && parseFloat(rep.Porcentaje)<98">
                  <td style="font-size: 10px; padding: 5px; background: orange!important;;">{{ rep.Porcentaje }}</td>
                </template>

                <template v-if="parseFloat(rep.Porcentaje)>=0 && parseFloat(rep.Porcentaje)<90">
                  <td style="font-size: 10px; padding: 5px; background: red!important;;">{{ rep.Porcentaje }}</td>
                </template>


                </tr>
        

      </table>
      </div>




      <div style="padding-top: 20px;" v-if="cbuIE>0 && cbuPersonal>0" class="box-body table-responsive">
      <table style=" width: 100%;" class="table table-hover table-bordered">
        <tr>
          <th style=" font-size: 12px; width: 5%;">N°</th>
          <th style=" font-size: 12px; width: 19%;">Fecha</th>
          <th style=" font-size: 12px; width: 19%;">Feriado</th>
          <th style=" font-size: 12px; width: 19%;">Asistencias programadas</th>
          <th style=" font-size: 12px; width: 19%;">Asistencias Realizadas</th>
          <th style=" font-size: 12px; width: 19%;">Faltas</th>
        </tr>


         <tr v-for="rep, key in reporte3" >
                  <td style="font-size: 12px; padding: 5px;">{{key+1}}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.fecha }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.feriado }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.asistProgramadas }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.asistRealizadas }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ rep.Faltas }}</td>

                </tr>

                        <tr>
          <td colspan="3" style="font-size: 12px; padding: 5px;"><b>Total</b></td>
          <td style="font-size: 12px; padding: 5px;"><b>{{ t1 }}</b></td>
          <td  style="font-size: 12px; padding: 5px;"><b>{{ t2 }}</b></td>
          <td  style="font-size: 12px; padding: 5px;"><b>{{ t3 }}</b></td>
        </tr>
        
      </table>
      </div>







        </div>
  </div>
</center>

      
