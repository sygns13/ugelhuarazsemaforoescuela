<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de Licencias, Permisos y vacaciones: <br><br> 
                Personal: <b>{{ personaL }}</b>  DNI: <b>{{ dniL }}</b><br> <br> 
                Cargo: <b>{{ cargoL }}</b> </h3>
              <a style="float: right;" type="button" class="btn btn-default" href="#" @click.prevent="volverPrincipal()"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                <div class="form-group">
              <button type="button" class="btn btn-primary" id="btncrearinformacion" @click.prevent="nuevaInformacion()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nueva Licencia, Permiso o Vacaciones</button>
                </div>


    	
    	

          </div>

          </div>

        <div class="box box-success" v-if="divNuevaInformacion">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nueva Licencia, Permiso o Vacaciones</h3>
            </div>

            <form v-on:submit.prevent="createInformacion" enctype="multipart/form-data" id="formulario">
             <div class="box-body">


               <div class="col-md-12" >

              <div class="form-group">
                  <label for="txttitulo" class="col-sm-2 control-label">Motivo:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txttitulo" name="txttitulo" placeholder="Motivo, Título" maxlength="200" autofocus v-model="newTitulo">
                  </div>
                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtfecIni" class="col-sm-2 control-label">Fecha de Inicio:*</label>

                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="txtfecIni" name="txtfecIni" placeholder="dd/mm/aaaa" maxlength="10"  v-model="newFecIni">
                  </div>

                  <label for="txtFecFin" class="col-sm-2 control-label">Fecha Final:*</label>

                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="txtFecFin" name="txtFecFin" placeholder="dd/mm/aaaa" maxlength="10"  v-model="newFecFin">
                  </div>
                </div>
                </div>


                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtdescripcion" class="col-sm-2 control-label">Sustentación u Observación:*</label>

                  <div class="col-sm-8">
                   
                    <ckeditora v-model="content"></ckeditora>
                  </div>
                </div>

            </div>

            <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtArchivoAdjunto" class="col-sm-2 control-label">Archivo Adjunto: (Opcional: pdf, docx, xlsx, pptx) Peso Máximo 2 MB</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtArchivoAdjunto" name="txtArchivoAdjunto" placeholder="Nombre del Archivo" maxlength="500" autofocus v-model="newNombreArchivo">
                  </div>

                  <div class="col-sm-8">
                     <input v-if="uploadReady" name="archivo2" type="file" id="archivo2" class="archivo form-control" @change="getArchivo" 
          accept=".pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX"/>

         

      
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
              <h3 class="box-title">Listado de Licencias, Permiso y Vacaciones de : <b>{{ personaL }}</b></h3>

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
                  <th style="padding: 5px; width: 15%;">Motivo</th>
                  <th style="padding: 5px; width: 32%;">Sustentación u Observación</th>
                  <th style="padding: 5px; width: 10%;">Fecha de Inicio</th>
                  <th style="padding: 5px; width: 10%;">Fecha Final</th>
                  <th style="padding: 5px; width: 10%;">Archivo Adjunto</th>
                  <th style="padding: 5px; width: 8%;">Gestión</th>
                </tr>
                <tr v-for="licencia, key in licencias">
                  <td style="font-size: 12px; padding: 5px;">{{key+pagination.from}}</td>

                  <td style="font-size: 12px; padding: 5px;">{{ licencia.nombre }}</td>

                  <td style="font-size: 12px; padding: 5px;" v-html="licencia.descripcion"></td>                

                  <td style="font-size: 12px; padding: 5px;">{{ pasfechaVista(licencia.fechaini) }}</td>

                  <td style="font-size: 12px; padding: 5px;">{{ pasfechaVista(licencia.fechafin) }}</td>


                  <td style="font-size: 12px; padding: 5px;">
                    <span class="label label-default" v-if="licencia.rutafile==''">None</span>

                    <a v-if="licencia.rutafile.length>0" v-bind:href="'<?php echo e(asset('/img/informacion/files/')); ?>/'+licencia.rutafile" v-bind:download="licencia.namefile">{{ licencia.namefile }}</a>
                    
                  </td>


                  <td style="font-size: 12px; padding: 5px;">


                  	<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editInformacion(licencia)" data-placement="top" data-toggle="tooltip" title="Editar Contenido"><i class="fa fa-edit"></i></a>
                  	<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarInformacion(licencia)" data-placement="top" data-toggle="tooltip" title="Borrar Contenido"><i class="fa fa-trash"></i></a>
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



<form  v-on:submit.prevent="updateInformacion(fillinformacion.id)" enctype="multipart/form-data" id="formulario2">
<div class="modal fade bs-example-modal-lg" id="modalEditar"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR LICENCIA, PERMISO O VACACIONES</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Motivo:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >


              
                            <div class="col-md-12" >

              <div class="form-group">
                  <label for="txttituloE" class="col-sm-2 control-label">Título:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txttituloE" name="txttituloE" placeholder="Título" maxlength="500" autofocus v-model="fillinformacion.titulo">
                  </div>
                </div>
              </div>




                            <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtfecIniE" class="col-sm-2 control-label">Fecha de Inicio:*</label>

                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="txtfecIniE" name="txtfecIniE" placeholder="dd/mm/aaaa" maxlength="10"  v-model="fillinformacion.fechaini">
                  </div>

                  <label for="txtFecFinE" class="col-sm-2 control-label">Fecha Final:*</label>

                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="txtFecFinE" name="txtFecFinE" placeholder="dd/mm/aaaa" maxlength="10"  v-model="fillinformacion.fechafin">
                  </div>
                </div>
                </div>





<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtdescripcion" class="col-sm-2 control-label">Descripción:*</label>

                  <div class="col-sm-8">
                   
                    <ckeditore v-model="contentE"></ckeditore>
                  </div>
                </div>

</div>





<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtArchivoAdjuntoE" class="col-sm-2 control-label">Archivo Adjunto: (Opcional: pdf, docx, xlsx, pptx) Peso Máximo 2MB</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtArchivoAdjuntoE" name="txtArchivoAdjuntoE" placeholder="Nombre del Archivo" maxlength="500" autofocus v-model="fillinformacion.archivonombre">
                  </div>

                  <div class="col-sm-8" v-if="uploadReadyE">
                     <input  name="archivo2E" type="file" id="archivo2E" class="archivo form-control" @change="getArchivoE" 
          accept=".pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX"/>

         

      
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




<form  v-on:submit.prevent="deleteFoto(fillinformacion.id)">
<div class="modal fade bs-example-modal-lg" id="modalFoto"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document"  id="modaltamanio2">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">IMAGEN DEL CONTENIDO INFORMATIVO</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloImg">Imagen:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >


              
                            <div class="col-md-12" >

              <div class="form-group">

                  <div class="col-sm-12">
                    <center>
                    <img src="" style="max-height: 600px;max-width: 600px;" class="img-responsive" alt="Imagen del Contenido Informativo" id="imgInformacion">
                    </center>
                  </div>
                </div>
              </div>


            
          </div>



      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnDeleteImg"><i class="fa fa-floppy-o" aria-hidden="true"></i> Eliminar Foto</button>

      <button type="button" id="btnCancelFoto" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

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





<form  v-on:submit.prevent="deleteAdjunto(fillinformacion.id)">
<div class="modal fade bs-example-modal-lg" id="modalArchivo"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document"  id="modaltamanio3">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">ARCHIVO ADJUNTO DEL CONTENIDO INFORMATIVO</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloFile">Archivo Adjunto de:</h3>
            </div>

           
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >


              
                            <div class="col-md-12" >

              <div class="form-group">
                <label for="adjunto" class="col-sm-2 control-label">Archivo (Click para acceder):</label>
                  <div class="col-sm-8">
                    <p>
                    <a v-if="iflink" v-bind:href="urlAdjunto" v-bind:download="nameAdjunto">{{ nameAdjunto }}</a>
                    </p>
                  </div>
                </div>
              </div>

<div class="col-md-12" >
               <hr style="padding-top: 10px;padding-bottom: 10px;">
</div>
              <div class="col-md-12" >

              <div class="form-group">
                  <label for="txtnameAdjuntoE" class="col-sm-2 control-label">Nombre del Archivo Adjunto:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtnameAdjuntoE" name="txtnameAdjuntoE" placeholder="Nombre del Archivo" maxlength="500"  v-model="nameAdjuntoE" @keyup.enter="pressBtnEdit()"  @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                  </div>

                  <div class="col-sm-2">
                    <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="editNombreAdjunto(fillinformacion.id)" id="btnEditarNA">Cambiar</a>
                  </div>

                </div>
              </div>


            
          </div>



      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnDeleteImg"><i class="fa fa-floppy-o" aria-hidden="true"></i> Eliminar Archivo</button>

      <button type="button" id="btnCancelFoto" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

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