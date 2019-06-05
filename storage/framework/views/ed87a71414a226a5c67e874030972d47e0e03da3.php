<?php if(accesoUser([1,2,3])): ?>
<div class="col-lg-12 col-xs-12">
				<h4>Seleccione una Opción</h4>
			</div>



		<div class="col-lg-3 col-xs-6" >
          <div class="small-box bg-green">
            <div class="inner">
              <h3 style="font-size: 25px; font-size: 15px;">Asistencia de Alumnos</h3>

              <p>Registro de Asistencia</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo e(URL::to('asistAlumnos')); ?>" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 style="font-size: 25px; font-size: 15px;">Asistencia de Personal</h3>
              <p>Registro de Asistencia</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo e(URL::to('asistPersonal')); ?>" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

       

<?php endif; ?>

<?php if(1==2): ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size: 25px;">Usuarios del Sistema</h3>

              <p>Gestión de Usuarios</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-user-secret"></i>
            </div>
            <a href="<?php echo e(URL::to('usuarios')); ?>" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

<?php endif; ?>