<?php

use Illuminate\Database\Seeder;

class s_sucursal extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_sucursal')->insert(array(
		   'id' => 1,
		   'id_empresa' => 1,
		   'id_municipio' => 1,
		   'codigo' => 1,
		   'nombre' => 'Stids',
		   'telefono' => NULL,
		   'direccion' => NULL,
		   'quienes_somos' => 'Somos un grupo de desarrolladores y diseñadores de aplicaciones web en Barranquilla. Responsables, minuciosos, rápidos, destacados y eficientes. Realizamos aplicaciones de gran calidad y totalmente profesionales para satisfacer las necesidades de nuestros clientes haciendo realidad sus sueños. Llevamos nuestros servicios con responsabilidad para que el cliente encuentre en nosotros total satisfacción ya sea en proyectos básicos o muy complejos.',
		   'que_hacemos' => 'En Stids S.A.S diseñamos y desarrollamos plataformas digitales, acorde a los objetivos y metas de cada cliente. Nos destacamos por ser innovadores y prolijos en términos de códigos, administración y gestión de proyectos digitales. Desarrollamos aplicaciones, sistemas informáticos y software a medida para gestión interna de empresas y procesos de negocio (Intranet/Extranet) que cubran sus necesidades.',
		   'mision' => 'Desarrollar a nuestros clientes sus sueños tecnológicos e innovadores para su empresa con una alta calidad de trabajo aplicando de manera óptima los más altos estándares tecnológicos y satisfaciendo siempre la necesidad de todos nuestros clientes.',
		   'vision' => 'En un futuro ser la empresa tecnológica numero 1 con reconocimiento por nuestra gran labor en los proyectos innovadores y los servicios que se le brinda a las empresas y a los clientes que acuden a nosotros.',
		   'servicios' => 'Contamos con una cantidad de servicios que nos caracterizan por sobresalir eficientemente en el mercado y que nosotros nos encargamos de brindarles a nuestros clientes.',
		   'herramientas' => 'Contamos con variedades de herramientas para desarrollar su sitio de una forma eficaz y segura.',
		   'porque_escogernos' => 'Basicamente contamos con personal calificado en los distintos lenguajes y en dintintas áreas para realizar los proyectos asignados.',
		   'planes' => 'Contamos con distintos planes para brindarle a nuestros clientes alternativas que se acomoden a sus necesidades y presupuesto.',
		   'clientes' => 'Contamos con clientes que han depositado su confianza en nosotros.',
		   'estado' => 1
		));
    }
}
