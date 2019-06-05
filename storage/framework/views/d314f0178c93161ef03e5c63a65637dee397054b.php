<form method="post" v-on:submit.prevent="updateUgel(institucion.id)">
  <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de Datos de la UGEL Huaraz</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="<?php echo e(URL::to('home')); ?>"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

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
                  <select class="form-control" id="cbudistrito" name="cbudistrito" v-model="institucion.distritos_id">
                    <template v-for="distritos, key in distrito">
                        <option v-bind:value="distritos.id">{{ distritos.nombre }}</option>
                    </template>
                    
                  </select>
                   </div>
                </div>
            
          </div>

            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtugel" class="col-sm-2 control-label">Nombre de la UGEL:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtugel" name="txtugel" placeholder="Nombre" maxlength="2000" autofocus v-model="institucion.nombre">
                  </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtdirec" class="col-sm-2 control-label">Dirección:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtdirec" name="txtdirec" placeholder="Av. Jr. Psj. N°" maxlength="2000" v-model="institucion.direccion">
                  </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtfono" class="col-sm-2 control-label">Teléfono:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtfono" name="txtfono" placeholder="(043) - ## ## ##" maxlength="100" v-model="institucion.telefono">
                  </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px; padding-bottom: 30px;">
              <div class="form-group">
                  <label for="txtcorreo" class="col-sm-2 control-label">Correo:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtcorreo" name="txtcorreo" placeholder="example@mail.com" maxlength="500" v-model="institucion.correo">
                  </div>
                </div>
            </div>



                              <div class="box-footer" >
                <button type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>

                <button type="reset" class="btn btn-warning" id="btnCancel" @click.prevent="cancelFormUgel()">Cancelar</button>

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

          </div>
</form>



