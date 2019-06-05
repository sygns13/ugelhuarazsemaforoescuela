<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registro de Asistencia de Alumnos</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">

               <div class="form-group" style="font-weight: bold;">
                 <div class="col-md-12">
                   <span class="col-sm-4">
                     Fecha: @{{ fecha }}
                   </span>
                   <span class="col-sm-4">
                     Hora: @{{ hora }}
                   </span>
                   </div>

                   <div class="col-md-12" style="padding-top: 15px;">
                   <span class="col-sm-4">
                     Turno Activo: @{{ turno }}
                   </span>

                   <span class="col-sm-4" v-if="keyturno.length>0">
                     Hora Inicio Turno: @{{ horaini }}
                   </span>

                   <span class="col-sm-4"  v-if="keyturno.length>0">
                     Hora Final Turno: @{{ horafin }}
                   </span>
                 </div>

               </div>


          </div>

          </div>



<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Leyenda de Turnos</h3>
</div>

              <div class="box-body">


               <div class="form-group">
                 <div class="col-md-12" v-for="turn, key in turns" style="font-size: 12px; ">
                  
                   <span class="col-sm-2" style="font-size: 12px; border: 1px solid gray;">
                     Turno: @{{ turn.descripcion }}
                   </span>

                   <span class="col-sm-2" style="font-size: 12px; border: 1px solid gray;">
                     Hora Inicio: @{{ turn.horaIni }}
                   </span>

                   <span class="col-sm-2" style="font-size: 12px; border: 1px solid gray;">
                     Hora Final: @{{ turn.horaFin }}
                   </span>
                 </div>

               </div>


          </div>

          </div>

          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Listado de Instituciones Educativas - Asistencia de Alumnos</h3>

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
                  <th style="padding: 5px; width: 5%;">#</th>
                  <th style="padding: 5px; width: 40%;">Institución Educativa</th>
                  <th style="padding: 5px; width: 10%;">Código Modular</th>
                  <th style="padding: 5px; width: 10%;">Fecha</th>
                  <th style="padding: 5px; width: 15%;">Turno</th>
                  <th style="padding: 5px; width: 10%;">Asistieron</th>
                  <th style="padding: 5px; width: 10%;">Faltaron</th>
                </tr>
               <tr v-for="insti, key in institucion" v-on:dblclick="Asistencia(insti)" style="cursor: pointer;">
                  <td style="font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ insti.nombre }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ insti.codigomod }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ fecha }}</td>
                  <td style="font-size: 12px; padding: 5px;">
                    <template v-for="nTurno, key2 in numTurnos">
                    <template v-if="insti.id==nTurno.idInstituto">
                      @{{nTurno.turnos}} -
                    </template>
                   </template>
                  </td>

                  <template v-for="nAlumnos, key2 in numAlumnos">
                    <template v-if="insti.id==nAlumnos.idInstituto">
                  <td style="font-size: 12px; padding: 5px;">@{{nAlumnos.asistentes}}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{nAlumnos.cantidad-nAlumnos.asistentes}}</td>
                    </template>
                   </template>

                </tr>

              </tbody></table>

            </div>
            <!-- /.box-body -->
            <div style="padding: 15px;">
            	<div><h5>Registros por Página: @{{ pagination.per_page }}</h5></div>
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
						<span>@{{ page }}</span>
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
    <div><h5>Registros Totales: @{{ pagination.total }}</h5></div>
		</div>
          </div>




<form method="post" v-on:submit.prevent="createAsistencias()">
<div class="modal bs-example-modal-lg" id="modalAsistencia" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">Realizar el Registro de Asistencia</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Área de Interéss:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">
               
               <div class="col-md-12" >



          <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>
                  <th style="padding: 5px; width: 3%;">#</th>
                  <th style="padding: 5px; width: 15%;">Grado</th>
                  <th style="padding: 5px; width: 15%;">Sección</th>
                  <th style="padding: 5px; width: 20%;">Nivel</th>

                  <th style="padding: 5px; width: 10%;">Total de Matriculados</th>
                  <th style="padding: 5px; width: 8%;">Turno</th>
                  <th style="padding: 5px; width: 10%;">Asistieron</th>
                  <th style="padding: 5px; width: 10%;">Faltaron</th>
                  <th style="padding: 5px; width: 10%;">% Asistencia</th>
                </tr>
               <tr v-for="seccion, key in secciones" >
                  <td style="font-size: 12px; padding: 5px;">@{{key+1}}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ seccion.grado }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ seccion.seccion }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ seccion.nivel }}</td>
    
                  <td style="font-size: 12px; padding: 5px;">@{{ seccion.cantalumnos }}</td>


                  <template v-if="seccion.activoDia==0">
                    <td style="font-size: 12px; padding: 5px;" colspan="4">
                      Día no Programado Para Controlar Asistencia en la Sección
                    </td>
                  </template>

                  <template v-if="seccion.activoDia==1"> 
                  


                  <td style="font-size: 12px; padding: 5px;">@{{ seccion.turno }}</td>
                  <td style="font-size: 12px; padding: 5px;">
                    
                    <template v-if="keyturno.length==0 || String(keyturno)!=String(seccion.idturno)">
                      @{{ seccion.cantasist }}
                      <template v-if="String(seccion.cantasist)=='null'">0</template>
                    </template>

                    <template v-if="keyturno.length!=0 && String(keyturno)==String(seccion.idturno)">



                      <input type="text" class="form-control txtAs" :id="'txtAsist'+seccion.idSec" name="txtAsist" placeholder="0" maxlength="10" v-model="seccion.cantasist" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">


                    </template>
                    
                  
                  </td>
                  <td style="font-size: 12px; padding: 5px;">@{{ seccion.cantalumnos-seccion.cantasist }}</td>

                  <template v-if="((100*seccion.cantasist)/seccion.cantalumnos).toFixed(2)<90">
                    <td style="font-size: 12px; padding: 5px; background: red;">@{{ ((100*seccion.cantasist)/seccion.cantalumnos).toFixed(2) }}</td>
                  </template>

                  <template v-if="((100*seccion.cantasist)/seccion.cantalumnos).toFixed(2)>=90">

                    <template v-if="((100*seccion.cantasist)/seccion.cantalumnos).toFixed(2)<95">
<td style="font-size: 12px; padding: 5px; background: orange;">@{{ ((100*seccion.cantasist)/seccion.cantalumnos).toFixed(2) }}</td>
                    </template>

                    <template v-if="((100*seccion.cantasist)/seccion.cantalumnos).toFixed(2)>=95 && ((100*seccion.cantasist)/seccion.cantalumnos).toFixed(2)<=100">
<td style="font-size: 12px; padding: 5px; background: green;">@{{ ((100*seccion.cantasist)/seccion.cantalumnos).toFixed(2) }}</td>
                    </template>

                    <template v-if="((100*seccion.cantasist)/seccion.cantalumnos).toFixed(2)>100">
<td style="font-size: 12px; padding: 5px; background: green;">100.00</td>
                  </template>
                  
</template>



</template>
                </tr>

              </tbody></table>

            </div>
            



                



      </div>
      </div>
      <div class="modal-footer">

        <template v-if="keyturno.length!=0">
      <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
        </template>
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
