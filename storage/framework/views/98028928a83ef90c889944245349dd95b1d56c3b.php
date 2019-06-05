<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Reportes de Justificaciones, Licencias y Permisos de Personal</h3>
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
                  <label for="vbuFe" class="col-sm-1 control-label">Fecha que cubre la Licencia:*</label>

                    <div class="col-sm-3">
                    <select id="vbuFe" class="form-control"  v-model="cbufecha">
                <option value="0">Hoy: <?php echo e($fecha); ?></option>
                <option value="1">Mes: <?php echo e(nombremes($mesActual)); ?> de <?php echo e($yearActual); ?></option>
                <option value="2">Año: <?php echo e($yearActual); ?></option>
                <option value="3">Siempre</option>
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
                    <option value="0">Reporte General</option>
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
                        <option v-bind:value="personal.id">{{ personal.apellidos }} , {{ personal.apellidos }} - DNI: {{ personal.doc }}</option>
                    </template>
                    
                  </select>
                   </div>


                </div>

    



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
           <div style="width: 21cm; height: 29cm; background-color: white;" id="divImp">
  <div style="padding-top: 1.5cm;padding-left: 1cm; padding-right: 0.7cm;">
    <center><b>Reporte de Justificaciones, Licencias y Permisos</b></center>


    <div>
      <table style="border: 0px solid gray; width: 100%;">
        <tr>
          <td style="font-size: 12px;" v-if="cbufecha==0">
             {{ cabehoy }}
          </td>
          <td style="font-size: 12px;" v-if="cbufecha==1">
             {{ cabemes }}
          </td>
          <td style="font-size: 12px;" v-if="cbufecha==2">
             {{ cabeyear }}
          </td>
          <td style="font-size: 12px;" v-if="cbufecha==3">
             {{cabesiempre }}
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
            Reporte General de la UGEL Huaraz e Instituciones Educativas
          </td>
          <td style="font-size: 12px;" v-if="cbuIE==1">
            {{ nombreIE }} 
          </td>
          <td style="font-size: 12px;" v-if="cbuIE>1">
            Institución Educativa: {{ nombreIE }} 
          </td>
       
        </tr>
        
      </table>


      <table style="border: 0px solid gray; width: 100%;">
        <tr>
          <td>
             <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>
                  <th style="font-size: 12px;padding: 3px; width: 4%;">#</th>
                  <th style="font-size: 12px;padding: 3px; width: 7%;">DNI</th>
                  <th style="font-size: 12px;padding: 3px; width: 15%;">Persona</th>
                  <th style="font-size: 12px;padding: 3px; width: 15%;">Cargo</th>
                  <th style="font-size: 12px;padding: 3px; width: 11%;">Régimen laboral</th>
                  <th style="font-size: 12px;padding: 3px; width: 12%;">Licencia</th>
                  <th style="font-size: 12px;padding: 3px; width: 6%;">Fecha Inicial</th>
                  <th style="font-size: 12px;padding: 3px; width: 6%;">Fecha Final</th>
                  <th style="font-size: 12px;padding: 3px; width: 15%;">Descripción</th>
                  <th style="font-size: 12px;padding: 3px; width: 9%;">Archivo Adjunto</th>
                </tr>
                <tr v-for="reporte, key in report">
                  <td style="font-size: 10px; padding: 3px;">{{key+1}}</td>

                  <td style="font-size: 10px; padding: 3px;">{{ reporte.dni }}</td>
                  <td style="font-size: 10px; padding: 3px;">{{ reporte.nombres }}</td>
                  <td style="font-size: 10px; padding: 3px;">{{ reporte.cargo }}</td>
                  <td style="font-size: 10px; padding: 3px;">{{ reporte.ley }}</td>
                  <td style="font-size: 10px; padding: 3px;">{{ reporte.motivo }}</td>

              

                  <td style="font-size: 10px; padding: 3px;">{{ pasfechaVista(reporte.fechaini) }}</td>

                  <td style="font-size: 10px; padding: 3px;">{{ pasfechaVista(reporte.fechafin) }}</td>

                  <td style="font-size: 10px; padding: 3px;" v-html="reporte.descripcion"></td>  


                  <td style="font-size: 10px; padding: 3px;">
                    <span class="label label-default" v-if="reporte.rutafile==''">None</span>


                     <template v-if="reporte.rutafile.length>0 ">

                    <a  v-if="reporte.namefile.length>0" v-bind:href="'<?php echo e(asset('/img/informacion/files/')); ?>/'+reporte.rutafile" v-bind:download="reporte.namefile">{{ reporte.namefile }}</a>


                      <a  v-if="reporte.namefile.length==0" v-bind:href="'<?php echo e(asset('/img/informacion/files/')); ?>/'+reporte.rutafile" v-bind:download="reporte.namefile">{{ licencia.namefile }}</a>
                      
                    </template>

                    
                    
                  </td>

                </tr>

              </tbody></table>

            </div>
          </td>
        </tr>
      </table>
    </div>




        </div>
  </div>
</center>

      
