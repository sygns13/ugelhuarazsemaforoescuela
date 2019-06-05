<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <?php if(! Auth::guest()): ?>
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo e(asset('/img/perfil/noPerfil.png')); ?>" class="img-circle imgPerfil" alt="User Image" style="height: 45px;"/>
                </div>
                <div class="pull-left info">
                    <p><?php echo e(Auth::user()->name); ?></p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> <?php echo e(trans('adminlte_lang::message.online')); ?></a>
                </div>
            </div>
        <?php endif; ?>

        <!-- search form (Optional)
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            
            <!-- Optionally, you can add icons to the links -->
            <li v-bind:class="classMenu0"><a href="<?php echo e(url('home')); ?>"><i class='fa fa-home'></i> <span>Inicio</span></a></li>

            <li class="treeview" v-bind:class="classMenu1">
                <a href="#"><i class='fa fa-calendar-check-o'></i> <span>Controlar Asistencia</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(URL::to('asistAlumnos')); ?>">Asistencia Alumnos</a></li>
                    <li><a href="<?php echo e(URL::to('asistPersonal')); ?>">Asistecia de Personal</a></li>
                </ul>
            </li>


            <?php if(accesoUser([1,2])): ?>

            <li class="header">MENÚ ADMINISTRADOR</li>

            <li class="treeview" v-bind:class="classMenu2">
                <a href="#"><i class='fa  fa-building-o'></i> <span>Gestión de Instituciones</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(URL::to('datosugel')); ?>">Datos de la UGEL</a></li>
                    <li><a href="<?php echo e(URL::to('ies')); ?>">Instituciones Educativas</a></li>

                </ul>
            </li>
            <?php endif; ?>

            <?php if(accesoUser([1,2])): ?>

            

            <li v-bind:class="classMenu3"><a href="<?php echo e(URL::to('turnos')); ?>"><i class='fa fa-calendar'></i> <span>Gestión de Turnos</span></a></li>
            
            <li v-bind:class="classMenu4"><a href="<?php echo e(URL::to('usuarios')); ?>"><i class='fa fa-user-secret'></i> <span>Gestión de Usuarios</span></a></li>
            
            <li v-bind:class="classMenu10"><a href="<?php echo e(URL::to('feriados')); ?>"><i class='fa fa-calendar-times-o'></i> <span>Registro de Feriados</span></a></li>

             <?php endif; ?>

             <?php if(accesoUser([1,2,3])): ?>

             <li class="header">MENÚ DIRECTIVO</li>

        <?php if(accesoUser([3])): ?>    

        <li v-bind:class="classMenu5"><a href="<?php echo e(URL::to('ies')); ?>"><i class='fa fa-university'></i> <span>Gestión de Datos de la IE</span></a></li>

         <?php endif; ?>

            <li v-bind:class="classMenu6"><a href="<?php echo e(URL::to('personal')); ?>"><i class='fa fa-users'></i> <span>Gestión de Personal</span></a></li>

            
           
            <?php endif; ?>



            <?php if(accesoUser([1,2,3])): ?>
            <li class="header">MENÚ DE REPORTESS</li>

            <li class="treeview" v-bind:class="classMenu7">
                <a href="#"><i class='fa fa-file-text-o'></i> <span>Asistencia Personal</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                    <li><a href="<?php echo e(URL::to('repAsistenciaPersonalMasiva')); ?>">Reporte Masivo</a></li>
                   
                </ul>
            </li>

            <li class="treeview" v-bind:class="classMenu8">
                <a href="#"><i class='fa fa-print'></i> <span>Asistencia Alumnos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo e(URL::to('repAsistenciaAlumnosMasiva')); ?>">Reporte Masivo</a></li>
                   
                </ul>
            </li>

            <li v-bind:class="classMenu9" ><a href="<?php echo e(URL::to('licencia')); ?>"><i class='fa fa-file-powerpoint-o'></i> <span>Licencias/Permisos</span></a></li>


             <?php endif; ?>


        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
