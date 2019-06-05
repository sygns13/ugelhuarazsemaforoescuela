<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de Instituciones Educativas</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="<?php echo e(URL::to('home')); ?>"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">

          <?php if(accesoUser([1,2])): ?>
                <div class="form-group">
              <button type="button" class="btn btn-primary" id="btncrearCarrera" @click.prevent="nuevaCarrera()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo</button>
                </div>
          <?php endif; ?>


    	
    	

          </div>

          </div>

        <div class="box box-success" v-if="divNuevaCarrera">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nueva Institución Educativa</h3>
            </div>

            <form v-on:submit.prevent="createCarrera">
             <div class="box-body">

          <div class="col-md-12" >
                <div class="form-group">
                  <label for="cbudepartamento" class="col-sm-2 control-label">Departamento:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbudepartamento" name="cbudepartamento" v-model="departamento.id">
                    <option v-bind:value="departamento.id">{{ departamento.nombre }}</option>
                  </select>
                   </div>
                </div>
            
          </div>

          <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuprovincia" class="col-sm-2 control-label">Provincia:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbuprovincia" name="cbuprovincia" v-model="provincia.id">
                    <option v-bind:value="provincia.id">{{ provincia.nombre }}</option>
                  </select>
                   </div>
                </div>
            
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbudistrito" class="col-sm-2 control-label">Distrito (Ubicación):*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbudistrito" name="cbudistrito" >
                    <option disabled value="">Seleccione un Distrito</option>
                    <template v-for="distritos, key in distrito">
                        <option v-bind:value="distritos.id">{{ distritos.nombre }}</option>
                    </template>
                    
                  </select>
                   </div>
                </div>
            
          </div>
          <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuNivel" class="col-sm-2 control-label">Nivel:*</label>
                  <div class="col-sm-8">
                  <select class="form-control" id="cbuNivel" name="cbuNivel">
                    <option disabled value="">Seleccione un Nivel</option>
                   <option v-for="niv in nivel" v-bind:value="niv.id">{{ niv.descripcion }} </option>
                  </select>
                  </div>
                </div>
            </div>


             <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuTipo" class="col-sm-2 control-label">Tipo de IE:*</label>
                    <div class="col-sm-8">
                  <select class="form-control" id="cbuTipo" name="cbuTipo">
                    <option disabled value="">Seleccione un Tipo</option>
                    <option v-for="tipo, key in tipoie" v-bind:value="tipo.id">{{ tipo.descripcion }} </option>
                  </select>
                   </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuGestion" class="col-sm-2 control-label">Gestión de la IE:*</label>
                    <div class="col-sm-8">
                  <select class="form-control" id="cbuGestion" name="cbuGestion">
                    <option disabled value="">Seleccione un Tipo de Gestión</option>
                    <option v-for="gestion, key in tipogestion" v-bind:value="gestion.id">{{ gestion.descripcion }} </option>
                  </select>
                   </div>
                </div>
            </div>

             	<div class="col-md-12"  style="padding-top: 15px;">
             	<div class="form-group">
                  <label for="txtIE" class="col-sm-2 control-label">Nombre de la IE:*</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtIE" name="txtIE" placeholder="Nombre" maxlength="2000" autofocus v-model="newIE">
                  </div>
                </div>
              </div>


              <div class="col-md-12"  style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtcodmod" class="col-sm-2 control-label">Código Modular:*</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtcodmod" name="txtcodmod" placeholder="Código Modular" maxlength="50"  v-model="newcodigomod">
                  </div>
                </div>
              </div>


              <div class="col-md-12"  style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtmodalidad" class="col-sm-2 control-label">Modalidad:*</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtmodalidad" name="txtmodalidad" placeholder="Modalidad" maxlength="200"  v-model="newModalidad">
                  </div>
                </div>
              </div>


              <div class="col-md-12"  style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtdir" class="col-sm-2 control-label">Dirección:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtdir" name="txtdir" placeholder="Av. Jr. Psj. N°" maxlength="2000"  v-model="newdirec">
                  </div>
                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtfono" class="col-sm-2 control-label">Teléfono:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtfono" name="txtfono" placeholder="(043) - ## ## ##" maxlength="100" v-model="newtelf">
                  </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px; ">
              <div class="form-group">
                  <label for="txtcorreo" class="col-sm-2 control-label">Correo:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtcorreo" name="txtcorreo" placeholder="example@mail.com" maxlength="500" v-model="newmail">
                  </div>
                </div>
            </div>




 <div class="col-md-12" style="padding-top: 15px;padding-bottom: 30px;">
                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>
                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="estadoie">
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

                <button type="reset" class="btn btn-warning" id="btnCancel" @click.prevent="cancelFormCarrera()">Cancelar</button>

                <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormCarrera()">Cerrar</button>

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
              <h3 class="box-title">Listado de instituciones Educativas</h3>

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
                  <th style="padding: 5px; width: 16%;">Institución Educativa</th>
                  <th style="padding: 5px; width: 8%;">Código Modular</th>
                  <th style="padding: 5px; width: 11%;">Nivel</th>
                  <th style="padding: 5px; width: 10%;">Gestión</th>
                  <th style="padding: 5px; width: 10%;">Tipo</th>
                  <th style="padding: 5px; width: 10%;">Modalidad</th>
                  <th style="padding: 5px; width: 9%;">Distrito</th>
                  <th style="padding: 5px; width: 9%;">Estado</th>
                  <th style="padding: 5px; width: 18%;">Gestión</th>
                </tr>
                 <tr v-for="colegio, key in institucion">
                  <td style="font-size: 12px; padding: 5px;">{{key+pagination.from}}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ colegio.nombre }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ colegio.codigomod }}</td>                
                  <td style="font-size: 12px; padding: 5px;">{{ colegio.nivel }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ colegio.tipogestion }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ colegio.tipoie }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ colegio.modalidad }}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ colegio.distrito }}</td>

                  <td style="font-size: 12px; padding: 5px;">
                  	<span class="label label-success" v-if="colegio.activo=='1'">Activo</span>
                  	<span class="label label-warning" v-if="colegio.activo=='0'">Inactivo</span>
                  </td>

                  <td style="font-size: 12px; padding: 5px;">

                    <a href="#" class="btn bg-teal btn-sm" v-on:click.prevent="detalle(colegio)" data-placement="top" data-toggle="tooltip" title="Gestionar Grados y Secciones de Colegios"><i class="fa fa-cogs"></i></a>
<?php if(accesoUser([1,2])): ?>

                  	<a href="#" v-if="colegio.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaCarrera(colegio)" data-placement="top" data-toggle="tooltip" title="Desactivar Institución Educativa"><i class="fa fa-arrow-circle-down"></i></a>

                  	<a href="#" v-if="colegio.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaCarrera(colegio)" data-placement="top" data-toggle="tooltip" title="Activar Institución Educativa"><i class="fa fa-check-circle"></i></a>


                  	<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editCarrera(colegio)" data-placement="top" data-toggle="tooltip" title="Editar Institución Educativa"><i class="fa fa-edit"></i></a>
                  	<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarCarrera(colegio)" data-placement="top" data-toggle="tooltip" title="Borrar Institución Educativa"><i class="fa fa-trash"></i></a>
 <?php endif; ?>
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

<form method="post" v-on:submit.prevent="updateCarrera(fillColegio.id)">
<div class="modal fade bs-example-modal-lg" id="modalEditar"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR INSTITUCIÓN EDUCATIVA</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Institución Educativa:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >


                        <div class="col-md-12" >
                <div class="form-group">
                  <label for="cbudepartamentoE" class="col-sm-2 control-label">Departamento:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbudepartamentoE" name="cbudepartamentoE" v-model="departamento.id">
                    <option v-bind:value="departamento.id">{{ departamento.nombre }}</option>
                  </select>
                   </div>
                </div>
            
          </div>

          <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuprovinciaE" class="col-sm-2 control-label">Provincia:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbuprovinciaE" name="cbuprovinciaE" v-model="provincia.id">
                    <option v-bind:value="provincia.id">{{ provincia.nombre }}</option>
                  </select>
                   </div>
                </div>
            
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbudistritoE" class="col-sm-2 control-label">Distrito (Ubicación):*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbudistritoE" name="cbudistritoE" >
                    <option disabled value="">Seleccione un Distrito</option>
                    <template v-for="distritos, key in distrito">
                        <option v-bind:value="distritos.id">{{ distritos.nombre }}</option>
                    </template>
                    
                  </select>
                   </div>
                </div>
            
          </div>
          <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuNivelE" class="col-sm-2 control-label">Nivel:*</label>
                  <div class="col-sm-8">
                  <select class="form-control" id="cbuNivelE" name="cbuNivelE">
                    <option disabled value="">Seleccione un Nivel</option>
                   <option v-for="niv in nivel" v-bind:value="niv.id">{{ niv.descripcion }} </option>
                  </select>
                  </div>
                </div>
            </div>


             <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuTipoE" class="col-sm-2 control-label">Tipo de IE:*</label>
                    <div class="col-sm-8">
                  <select class="form-control" id="cbuTipoE" name="cbuTipoE">
                    <option disabled value="">Seleccione un Tipo</option>
                    <option v-for="tipo, key in tipoie" v-bind:value="tipo.id">{{ tipo.descripcion }} </option>
                  </select>
                   </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuGestionE" class="col-sm-2 control-label">Gestión de la IE:*</label>
                    <div class="col-sm-8">
                  <select class="form-control" id="cbuGestionE" name="cbuGestionE">
                    <option disabled value="">Seleccione un Tipo de Gestión</option>
                    <option v-for="gestion, key in tipogestion" v-bind:value="gestion.id">{{ gestion.descripcion }} </option>
                  </select>
                   </div>
                </div>
            </div>

              <div class="col-md-12"  style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtIEE" class="col-sm-2 control-label">Nombre de la IE:*</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtIEE" name="txtIEE" placeholder="Nombre" maxlength="2000" autofocus v-model="fillColegio.nombre">
                  </div>
                </div>
              </div>


              <div class="col-md-12"  style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtcodmodE" class="col-sm-2 control-label">Código Modular:*</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtcodmodE" name="txtcodmodE" placeholder="Código Modular" maxlength="50"  v-model="fillColegio.codigomod">
                  </div>
                </div>
              </div>


              <div class="col-md-12"  style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtmodalidadE" class="col-sm-2 control-label">Modalidad:*</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtmodalidadE" name="txtmodalidadE" placeholder="Modalidad" maxlength="200"  v-model="fillColegio.modalidad">
                  </div>
                </div>
              </div>


              <div class="col-md-12"  style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtdirE" class="col-sm-2 control-label">Dirección:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtdirE" name="txtdirE" placeholder="Av. Jr. Psj. N°" maxlength="2000"  v-model="fillColegio.direccion">
                  </div>
                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtfonoE" class="col-sm-2 control-label">Teléfono:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtfonoE" name="txtfonoE" placeholder="(043) - ## ## ##" maxlength="100" v-model="fillColegio.telefono">
                  </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px; ">
              <div class="form-group">
                  <label for="txtcorreoE" class="col-sm-2 control-label">Correo:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtcorreoE" name="txtcorreoE" placeholder="example@mail.com" maxlength="500" v-model="fillColegio.correo">
                  </div>
                </div>
            </div>




 <div class="col-md-12" style="padding-top: 15px;padding-bottom: 30px;">
                <div class="form-group">
                  <label for="cbuestadoE" class="col-sm-2 control-label">Estado:*</label>
                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillColegio.activo">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
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
