        <div style="width: 18cm;padding-left: 0px;" class="panel panel-defaultPrint container-fluid spark-screen" id='printarea'>
            <div style="width: 18cm;padding-top: 30px;">
                
                <div style="width: 18cm;">

                

                <div style="width: 18.2cm;">




                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 3.2cm;text-align: center;padding-top: 20px;">
                                
                                </td>

                                <td style="width: 11.5cm;;text-align: center;padding-top: 20px;">
                                   <img src="<?php echo e(asset('/img/unasam.png')); ?>" >

                                </td>
                               <td style="width: 3.52cm; text-align: center;padding-top: 20px;" >
                                
                                </td>                    
                            </tr>
                        </tbody>
                    </table>



                   
                </div>


                <div style="width: 18cm;">
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 3.2cm; text-align: center;padding-top: 17px;">
                                
                                </td>

                                <td style="width: 11.5cm;text-align: center;padding-top: 15px;padding-bottom: 20px;">
                                    
                                    <p style="margin-bottom: 0px;font-size: 19px"><strong>FICHA DE USUARIO DEL SISTEMA</strong></p>
                                  
                                </td>
                               <td style="width: 3.52cm; text-align: center;padding-top: 17px;">
                                
                                </td>                    
                            </tr>
                        </tbody>
                    </table>
                </div>


                


            <div style="width: 18cm;" v-if="fillPersona.tipoinsti==1"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;"> 
                                Institución
                                </strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p  id="impArea" style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                   {{ nombreie}}
                                </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="width: 18cm;" v-if="fillPersona.tipoinsti==2"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;"> 
                                Institución Educativa
                                </strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p  id="impArea" style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                   {{ nombreie }}
                                </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="width: 18cm;" v-if="fillPersona.tipoinsti==2"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;"> 
                                Código Modular
                                </strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p  id="impArea" style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                   {{ codmod }}
                                </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>





                <div style="width: 18cm;"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;"> 
                                DNI
                                </strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p  id="impArea" style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                   {{ fillPersona.doc }}
                                </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="width: 18cm;"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">Nombres y Apellidos</strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                   {{ fillPersona.nombres }}, {{ fillPersona.apellidos }}
                                </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="width: 18cm;"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">Tipo de Usuario</strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                    {{ tipoUser }}   
                                </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>

              

                <div style="width: 18cm;"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">TELÉFONO</strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                    {{ fillPersona.telefono }}
                                   </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="width: 18cm;"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">EMAIL</strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p style="margin-bottom: 0px;font-size: 15px;text-align: left;padding-left: 10px;padding-right: 10px;">  
                                    {{ filluser.email }} 
                                    </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="width: 18cm;"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">DIRECCIÓN</strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p style="margin-bottom: 0px;font-size: 15px;text-align: left;padding-left: 10px;padding-right: 10px;"> 
                                    {{ fillPersona.direccion }}   
                                    </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>


                

                <div style="width: 18cm;"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 8px;">GENERO</strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">

                                    <p v-if="fillPersona.genero==0" style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                        Sin Información
                                    </p>
                                    
                                    <p v-if="fillPersona.genero==1" style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                        Masculino
                                    </p>

                                    <p v-if="fillPersona.genero==2" style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                        Femenino
                                    </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>

              

                <div style="width: 18cm;"> 
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 5.6cm; text-align: center; border: 1px;border-style: solid">
                                <p style="margin-bottom: 0px;font-size: 13px"><strong style="padding-left: 10px;">USERNAME</strong>:</p>
                                </td>

                                <td style="width: 70%;text-align: center;padding-top: 17px;padding-bottom: 17px;border: 1px;border-style: solid;">
                                    
                                    <p style="margin-bottom: 0px;font-size: 14px;text-align: justify;padding-left: 10px;padding-right: 10px;">
                                        {{ filluser.name }}  
                                    </p>
                                  
                                </td>
                                           
                            </tr>
                        </tbody>
                    </table>
                </div>


          

                </div>

            </div>
        </div>