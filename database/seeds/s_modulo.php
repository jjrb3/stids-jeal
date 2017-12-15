<?php

use Illuminate\Database\Seeder;

class s_modulo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Back
    	DB::table('s_modulo')->insert(array(
		   'id' => 1,
		   'nombre' => 'Perfil de Usuario',
		   'descripcion' => 'En esa sesión podrá cambiar sus datos de usuario.',
		   'enlace_administrador' => 'perfil/inicio',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-user',
		   'orden' => 2,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
        DB::table('s_modulo')->insert(array(
		   'id' => 2,
		   'id_padre' => 9,
		   'nombre' => 'Usuario',
		   'descripcion' => 'En esa sesión podrá editar los usuarios del sistema.',
		   'enlace_administrador' => 'parametrizacion/usuario',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-users',
		   'orden' => 1,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 3,
		   'id_padre' => 9,
		   'nombre' => 'Permisos',
		   'descripcion' => 'En esa sesión podrá crear, modificar y eliminar los permisos para los modulos.',
		   'enlace_administrador' => 'parametrizacion/permisos',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-key',
		   'orden' => 2,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 4,
		   'id_padre' => 9,
		   'nombre' => 'Tipo de Identificación',
		   'descripcion' => 'En esa sesión podrá crear, modificar y eliminar el tipo de identificación para los usuario.',
		   'enlace_administrador' => 'parametrizacion/identificacion',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-id-card-o',
		   'orden' => 3,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 5,
		   'id_padre' => 9,
		   'nombre' => 'Ciudades y paises',
		   'descripcion' => 'En esa sesión podrá crear y modificar los paises, departamentos y municipios.',
		   'enlace_administrador' => 'parametrizacion/territorio',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-globe',
		   'orden' => 4,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 6,
		   'id_padre' => 9,
		   'nombre' => 'Empresa',
		   'descripcion' => 'En esa sesión encontrara los datos de su empresa.',
		   'enlace_administrador' => 'parametrizacion/empresa',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-building-o',
		   'orden' => 5,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 7,
		   'id_padre' => 9,
		   'nombre' => 'Temas',
		   'descripcion' => 'En esa sesión encontrara los temas de la plataforma.',
		   'enlace_administrador' => 'parametrizacion/temas',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-object-group',
		   'orden' => 6,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 8,
		   'id_padre' => 9,
		   'nombre' => 'Transacciones',
		   'descripcion' => 'En esa sesión podrá consultar las transacciones realizadas en la plataforma.',
		   'enlace_administrador' => 'parametrizacion/transacciones',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-database',
		   'orden' => 9,
		   'es_nuevo' => 1,
		   'estado' => 0,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 9,
		   'id_padre' => NULL,
		   'nombre' => 'Parametrizacion',
		   'descripcion' => 'En esta sesión podrás realizar la configuración y Administración de los datos de la plataforma, usuarios, menú, entre otras características.',
		   'enlace_administrador' => 'parametrizacion/inicio',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-th-large',
		   'orden' => 1,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 10,
		   'id_padre' => 9,
		   'nombre' => 'Roles',
		   'descripcion' => 'En esta sesión podrá crear, modificar y eliminar los roles de la plataforma.',
		   'enlace_administrador' => 'parametrizacion/rol',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-th-large',
		   'orden' => 7,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 11,
		   'id_padre' => 9,
		   'nombre' => 'Generador de modulos',
		   'descripcion' => 'En esta sesión podrá generar automaticamente un modulo y eliminarlo.',
		   'enlace_administrador' => 'parametrizacion/generarModulo',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-file-code-o',
		   'orden' => 8,
		   'es_nuevo' => 1,
		   'estado' => 0,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 12,
		   'id_padre' => 9,
		   'nombre' => 'Sexo',
		   'descripcion' => 'En esta sesión podrá crear, modificar y eliminar los generos de la plataforma.',
		   'enlace_administrador' => 'parametrizacion/sexo',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-venus-mars',
		   'orden' => 10,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 13,
		   'id_padre' => 9,
		   'nombre' => 'Modulos',
		   'descripcion' => 'En esta sesión podrá crear, modificar, actualizar, eliminar y mover los módulos de la plataforma.',
		   'enlace_administrador' => 'parametrizacion/modulos',
		   'enlace_usuario' => NULL,
		   'icono' => 'fa-list-alt',
		   'orden' => 11,
		   'es_nuevo' => 1,
		   'estado' => 1,
		));

		// Front
		DB::table('s_modulo')->insert(array(
		   'id' => 14,
		   'id_padre' => NULL,
		   'nombre' => 'Inicio',
		   'descripcion' => NULL,
		   'enlace_administrador' => NULL,
		   'enlace_usuario' => 'inicio',
		   'icono' => NULL,
		   'orden' => 1,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 15,
		   'id_padre' => NULL,
		   'nombre' => 'Nosotros',
		   'descripcion' => NULL,
		   'enlace_administrador' => NULL,
		   'enlace_usuario' => 'nosotros',
		   'icono' => NULL,
		   'orden' => 2,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 16,
		   'id_padre' => NULL,
		   'nombre' => 'Servicios',
		   'descripcion' => NULL,
		   'enlace_administrador' => NULL,
		   'enlace_usuario' => 'servicios',
		   'icono' => NULL,
		   'orden' => 3,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 17,
		   'id_padre' => NULL,
		   'nombre' => 'Portafolio',
		   'descripcion' => NULL,
		   'enlace_administrador' => NULL,
		   'enlace_usuario' => 'portafolio',
		   'icono' => NULL,
		   'orden' => 4,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 18,
		   'id_padre' => NULL,
		   'nombre' => 'Más de Stids',
		   'descripcion' => NULL,
		   'enlace_administrador' => NULL,
		   'enlace_usuario' => '#',
		   'icono' => NULL,
		   'orden' => 5,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 19,
		   'id_padre' => 18,
		   'nombre' => 'Noticias',
		   'descripcion' => NULL,
		   'enlace_administrador' => NULL,
		   'enlace_usuario' => '#',
		   'icono' => NULL,
		   'orden' => 1,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 20,
		   'id_padre' => 18,
		   'nombre' => 'Ingresar a Stids Jeal',
		   'descripcion' => NULL,
		   'enlace_administrador' => NULL,
		   'enlace_usuario' => 'ingresar',
		   'icono' => NULL,
		   'orden' => 2,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));
		DB::table('s_modulo')->insert(array(
		   'id' => 21,
		   'id_padre' => NULL,
		   'nombre' => 'Contacto',
		   'descripcion' => NULL,
		   'enlace_administrador' => NULL,
		   'enlace_usuario' => 'contacto',
		   'icono' => NULL,
		   'orden' => 6,
		   'es_nuevo' => 0,
		   'estado' => 1,
		));

		// Back
        DB::table('s_modulo')->insert(array(
            'id' => 22,
            'id_padre' => NULL,
            'nombre' => 'Página pública',
            'descripcion' => 'En esta sesión podrá personalizar la pagina publica de la plataforma.',
            'enlace_administrador' => 'pagina_publica/inicio',
            'enlace_usuario' => NULL,
            'icono' => 'fa-object-group',
            'orden' => 3,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 23,
            'id_padre' => 22,
            'nombre' => 'Slider',
            'descripcion' => 'En esta sesión podrá agregar y eliminar los Slider de la pagina principal.',
            'enlace_administrador' => 'pagina_publica/slider',
            'enlace_usuario' => NULL,
            'icono' => 'fa-picture-o',
            'orden' => 1,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 24,
            'id_padre' => 22,
            'nombre' => 'Herramientas',
            'descripcion' => 'En esta sesión podrá agregar y eliminar herramientas usadas en la pagina.',
            'enlace_administrador' => 'pagina_publica/herramientas',
            'enlace_usuario' => NULL,
            'icono' => 'fa-wrench',
            'orden' => 2,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 25,
            'id_padre' => 22,
            'nombre' => 'Servicios',
            'descripcion' => 'En esta sesión podrá agregar y eliminar servicios que ofrece.',
            'enlace_administrador' => 'pagina_publica/servicios',
            'enlace_usuario' => NULL,
            'icono' => 'fa-list-ol',
            'orden' => 3,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 26,
            'id_padre' => 22,
            'nombre' => 'Planes',
            'descripcion' => 'En esta sesión podrá agregar y eliminar planes que ofrece.',
            'enlace_administrador' => 'pagina_publica/planes',
            'enlace_usuario' => NULL,
            'icono' => 'fa-list-alt',
            'orden' => 4,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 27,
            'id_padre' => 22,
            'nombre' => 'Clientes',
            'descripcion' => 'En esta sesión podrá agregar y eliminar sus clientes.',
            'enlace_administrador' => 'pagina_publica/clientes',
            'enlace_usuario' => NULL,
            'icono' => 'fa-address-book-o',
            'orden' => 5,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 28,
            'id_padre' => 22,
            'nombre' => 'Conocimientos',
            'descripcion' => 'En esta sesión podrá agregar y eliminar sus conocimientos.',
            'enlace_administrador' => 'pagina_publica/conocimientos',
            'enlace_usuario' => NULL,
            'icono' => 'fa-tasks',
            'orden' => 6,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 29,
            'id_padre' => 22,
            'nombre' => 'Portafolio',
            'descripcion' => 'En esta sesión podrá agregar y eliminar su portafolio.',
            'enlace_administrador' => 'pagina_publica/portafolio',
            'enlace_usuario' => NULL,
            'icono' => 'fa-briefcase',
            'orden' => 7,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 30,
            'id_padre' => NULL,
            'nombre' => 'Prestamos',
            'descripcion' => 'En este modulo podra realizar prestamos y cobros.',
            'enlace_administrador' => 'prestamo/inicio',
            'enlace_usuario' => NULL,
            'icono' => 'fa-handshake-o',
            'orden' => 4,
            'es_nuevo' => 1,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 31,
            'id_padre' => 30,
            'nombre' => 'Clientes',
            'descripcion' => 'En esta sesión podrá crear, editar y eliminar sus clientes.',
            'enlace_administrador' => 'prestamo/cliente',
            'enlace_usuario' => NULL,
            'icono' => 'fa-users',
            'orden' => 1,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 32,
            'id_padre' => 30,
            'nombre' => 'Prestamos y pagos',
            'descripcion' => 'En esta sesión podrá crear y eliminar prestamos y pagos.',
            'enlace_administrador' => 'prestamo/prestamos_pagos',
            'enlace_usuario' => NULL,
            'icono' => 'fa-money',
            'orden' => 1,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 33,
            'id_padre' => 30,
            'nombre' => 'Contrato',
            'descripcion' => 'En esta sesión podrá crear su contrato de prestamos.',
            'enlace_administrador' => 'prestamo/contrato',
            'enlace_usuario' => NULL,
            'icono' => 'fa-file-text-o',
            'orden' => 1,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
        DB::table('s_modulo')->insert(array(
            'id' => 34,
            'id_padre' => 30,
            'nombre' => 'Reportes',
            'descripcion' => 'En esta sesión podrá generar reportes de prestamos, pagos, moras y muchos mas.',
            'enlace_administrador' => 'prestamo/reportes',
            'enlace_usuario' => NULL,
            'icono' => 'fa-file-pdf-o',
            'orden' => 1,
            'es_nuevo' => 0,
            'estado' => 1,
        ));
    }
}
