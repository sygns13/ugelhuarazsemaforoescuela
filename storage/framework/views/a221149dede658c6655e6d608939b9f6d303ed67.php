<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Rectificar o Completar el Registro de Asistencia de Personal</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="<?php echo e(URL::to('home')); ?>"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">

               <div class="form-group" style="font-weight: bold;">
                 <div class="col-md-12">
                   
                   <div class="form-group">
                    <label for="txtfecha" class="col-sm-1 control-label">Fecha:*</label>
                    <div class="col-sm-3">
                   <input type="date" name="txtfecha" id="txtfecha" v-model="fecnow" class="form-control" placeholder="dd/mm/aaaa" ></div>

                   </div>
                   </div>


               </div>

               <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
              <button type="button" class="btn btn-primary btn-sm" id="btncrearusuario" @click.prevent="buscarFecha()"><i class="fa fa-calendar" aria-hidden="true" ></i> Buscar Fecha</button>
                </div>
                </div>


          </div>

          </div>



      
          <div class="box box-info">
            <div class="box-header">
             <h3 class="box-title">Listado de Instituciones - Asistencia de Personal</h3>

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
                  <th style="padding: 5px; width: 10%;">Asistencias</th>
                  <th style="padding: 5px; width: 10%;">Faltas</th>
                </tr>
               <tr v-for="insti, key in institucion" v-on:dblclick="Asistencia(insti)" style="cursor: pointer;">
                  <td style="font-size: 12px; padding: 5px;">{{key+pagination.from}}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ insti.nombre }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ insti.codigomod }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ fecha }}</td>
                  <td style="font-size: 12px; padding: 5px;">
                    <template v-for="nTurno, key2 in numTurnos">
                    <template v-if="insti.id==nTurno.idInstituto">
                      {{nTurno.turnos}} -
                    </template>
                   </template>
                  </td>

                  <template v-for="nPersonal, key2 in numPersonal">
                    <template v-if="insti.id==nPersonal.idInstituto">
                  <td style="font-size: 12px; padding: 5px;">{{nPersonal.asistentes}}</td>
                  <td style="font-size: 12px; padding: 5px;">{{nPersonal.cantidad-nPersonal.asistentes}}</td>
                    </template>
                   </template>

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
              <h3 class="box-title" id="boxTitulo">personales:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">
               
               <div class="col-md-12" >

           


          <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>
                  <th style="padding: 5px; width: 4%;">#</th>
                  <th style="padding: 5px; width: 35%;">Personal</th>
                  <th style="padding: 5px; width: 10%;">DNI</th>
                  <th style="padding: 5px; width: 35%;">Cargo</th>

                  <th style="padding: 5px; width: 18%;">Turno</th>
                  <th style="padding: 5px; width: 8%;">Asistencia</th>
                
                </tr>
               <tr v-for="personal, key in personals" >
                  <td style="font-size: 12px; padding: 5px;">{{key+1}}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ personal.apellidos }}, {{ personal.nombres }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ personal.doc }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ personal.cargo }}</td>


                  <template v-if="personal.activoDia==0">
                    <td style="font-size: 12px; padding: 5px;" colspan="2">
                      Día no Programado Para Controlar Asistencia
                    </td>
                  </template>


                   <template v-if="personal.activoDia==1"> 

                    <td style="font-size: 12px; padding: 5px;">{{ personal.turno }}</td>




                   

                   <template v-if="String(personal.asistencia)=='null'|| personal.asistencia==false">
                    <td style="font-size: 12px; padding: 5px; background: red;">
                     <center> <input type="checkbox" id="checkbox" v-model="personal.asistencia"></center> 
                    </td>
                  </template>

                  <template v-if="String(personal.asistencia)==1 || personal.asistencia==true">
                    <td style="font-size: 12px; padding: 5px; background: green;">
                      <center> <input type="checkbox" id="checkbox" v-model="personal.asistencia"></center> 
                    </td>
                  </template> 

                 


                  </template>





                  <template v-if="personal.activoDia==2"> 

                    <td style="font-size: 12px; padding: 5px;">{{ personal.turno }}</td>

                    

                   
     
                   

                   <template v-if="String(personal.asistencia)=='null'|| personal.asistencia==false">
                    <td style="font-size: 12px; padding: 5px; background: red;">
                     <center> <input type="checkbox" id="checkbox" v-model="personal.asistencia"></center> 
                    </td>
                  </template>

                  <template v-if="String(personal.asistencia)==1 || personal.asistencia==true">
                    <td style="font-size: 12px; padding: 5px; background: green;">
                      <center> <input type="checkbox" id="checkbox" v-model="personal.asistencia"></center> 
                    </td>
                  </template> 

   


                  </template>



                  <template v-if="personal.activoDia==3"> 

                    <td style="font-size: 12px; padding: 5px;">{{ personal.turno }}</td>

                   
                   <template v-if="String(personal.asistencia)=='null'|| personal.asistencia==false">
                    <td style="font-size: 12px; padding: 5px; background: red;">
                     <center> <input type="checkbox" id="checkbox" v-model="personal.asistencia"></center> 
                    </td>
                  </template>

                  <template v-if="String(personal.asistencia)==1 || personal.asistencia==true">
                    <td style="font-size: 12px; padding: 5px; background: green;">
                      <center> <input type="checkbox" id="checkbox" v-model="personal.asistencia"></center> 
                    </td>
                  </template> 



                  </template>


              

                </tr>

              </tbody></table>

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
