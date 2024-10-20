<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('siglas')->nullable();
            $table->char('country', 2)->nullable();
            $table->boolean('private')->default(false);
            $table->char('department_id', 2)->nullable();
            $table->char('province_id', 4)->nullable();
            $table->char('district_id', 6)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('country')->references('id')->on('countries');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('district_id')->references('id')->on('districts');
        });


        DB::table('universities')->insert([
            ///desde aca nacionales

            ['siglas' => 'UNMSM', 'name' => 'Universidad Nacional Mayor de San Marcos', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNSCH', 'name' => 'Universidad Nacional de San Cristóbal de Huamanga', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNSAAC', 'name' => 'Universidad Nacional San Antonio Abad del Cusco', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNE', 'name' => 'Universidad Nacional de Educación Enrique Guzmán y Valle', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNT', 'name' => 'Universidad Nacional de Trujillo', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNSA', 'name' => 'Universidad Nacional de San Agustín', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAP', 'name' => 'Universidad Nacional del Altiplano de Puno', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNI', 'name' => 'Universidad Nacional de Ingeniería', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNALM', 'name' => 'Universidad Nacional Agraria La Molina', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNICA', 'name' => 'Universidad Nacional San Luis Gonzaga', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNCP', 'name' => 'Universidad Nacional del Centro del Perú', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNDAC', 'name' => 'Universidad Nacional Daniel Alcides Carrión', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNHEVAL', 'name' => 'Universidad Nacional Hermilio Valdizán', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAP', 'name' => 'Universidad Nacional de la Amazonía Peruana', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNP', 'name' => 'Universidad Nacional de Piura', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNC', 'name' => 'Universidad Nacional de Cajamarca', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNFV', 'name' => 'Universidad Nacional Federico Villarreal', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAS', 'name' => 'Universidad Nacional Agraria de la Selva', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAC', 'name' => 'Universidad Nacional del Callao', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNJFSC', 'name' => 'Universidad Nacional José Faustino Sánchez Carrión', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNJBG', 'name' => 'Universidad Nacional Jorge Basadre Grohmann', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNASAM', 'name' => 'Universidad Nacional Santiago Antúnez de Mayolo', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNU', 'name' => 'Universidad Nacional de Ucayali', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNSM', 'name' => 'Universidad Nacional de San Martín', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNS', 'name' => 'Universidad Nacional del Santa', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNT', 'name' => 'Universidad Nacional de Tumbes', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNH', 'name' => 'Universidad Nacional de Huancavelica', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAMAD', 'name' => 'Universidad Nacional Amazónica de Madre de Dios', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNIA', 'name' => 'Universidad Nacional Intercultural de la Amazonía', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAMBA', 'name' => 'Universidad Nacional Micaela Bastidas de Apurímac', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNTRMA', 'name' => 'Universidad Nacional Toribio Rodríguez de Mendoza de Amazonas', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNTECS', 'name' => 'Universidad Nacional Tecnológica de Lima Sur', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAJMA', 'name' => 'Universidad Nacional José María Arguedas', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNM', 'name' => 'Universidad Nacional de Moquegua', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAJ', 'name' => 'Universidad Nacional de Juliaca', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAAT', 'name' => 'Universidad Nacional Autónoma Altoandina de Tarma', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNACh', 'name' => 'Universidad Nacional Autónoma de Chota', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNFS', 'name' => 'Universidad Nacional de Frontera', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNISCJSA', 'name' => 'Universidad Nacional Intercultural de la Selva Central Juan Santos Atahualpa', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNIBAGUA', 'name' => 'Universidad Nacional Intercultural Fabiola Salazar Leguía de Bagua', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAB', 'name' => 'Universidad Nacional de Barranca', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAH', 'name' => 'Universidad Nacional Autónoma de Huanta', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNJ', 'name' => 'Universidad Nacional de Jaén', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAAA', 'name' => 'Universidad Nacional Autónoma de Alto Amazonas', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNAT', 'name' => 'Universidad Nacional Autónoma de Tayacaja Daniel Hernández Morillo', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNDC', 'name' => 'Universidad Nacional de Cañete', 'country' => 'PE', 'private' => false],
            ['siglas' => 'UNIQ', 'name' => 'Universidad Nacional Intercultural de Quillabamba', 'country' => 'PE', 'private' => false],
            ['siglas'=>'UNPRG', 'name'=> 'Universidad Nacional Pedro Ruiz Gallo','country'=>'PE','private'=>false],
            ['siglas'=>'UNCA', 'name'=> 'Universidad Nacional Ciro Alegría','country'=>'PE','private'=>false],


            ///desde aca privadas
            ['siglas'=>'PUCP', 'name'=> 'Pontificia Universidad Católica del Perú','country'=>'PE','private'=>true],
['siglas'=>'UPCH', 'name'=> 'Universidad Peruana Cayetano Heredia','country'=>'PE','private'=>true],
['siglas'=>'UCSM', 'name'=> 'Universidad Católica de Santa María','country'=>'PE','private'=>true],
['siglas'=>'UP', 'name'=> 'Universidad del Pacífico','country'=>'PE','private'=>true],
['siglas'=>'ULIMA', 'name'=> 'Universidad de Lima','country'=>'PE','private'=>true],
['siglas'=>'USMP', 'name'=> 'Universidad de San Martín de Porres','country'=>'PE','private'=>true],
['siglas'=>'UNIFÉ', 'name'=> 'Universidad Femenina del Sagrado Corazón','country'=>'PE','private'=>true],
['siglas'=>'UMCH', 'name'=> 'Universidad Marcelino Champagnat','country'=>'PE','private'=>true],
['siglas'=>'UDEP', 'name'=> 'Universidad de Piura','country'=>'PE','private'=>true],
['siglas'=>'URP', 'name'=> 'Universidad Ricardo Palma','country'=>'PE','private'=>true],
['siglas'=>'UAC', 'name'=> 'Universidad Andina del Cusco','country'=>'PE','private'=>true],
['siglas'=>'UPLA', 'name'=> 'Universidad Peruana Los Andes','country'=>'PE','private'=>true],
['siglas'=>'UPeU', 'name'=> 'Universidad Peruana Unión','country'=>'PE','private'=>true],
['siglas'=>'UTEA', 'name'=> 'Universidad Tecnológica de los Andes','country'=>'PE','private'=>true],
['siglas'=>'UDH', 'name'=> 'Universidad de Huánuco','country'=>'PE','private'=>true],
['siglas'=>'UPT', 'name'=> 'Universidad Privada de Tacna','country'=>'PE','private'=>true],
['siglas'=>'UPAO', 'name'=> 'Universidad Privada Antenor Orrego','country'=>'PE','private'=>true],
['siglas'=>'UPI', 'name'=> 'Universidad Particular de Iquitos','country'=>'PE','private'=>true],
['siglas'=>'UCV', 'name'=> 'Universidad César Vallejo','country'=>'PE','private'=>true],
['siglas'=>'UPN', 'name'=> 'Universidad Privada del Norte','country'=>'PE','private'=>true],
['siglas'=>'FTPCL', 'name'=> 'Facultad de Teología Pontificia y Civil de Lima','country'=>'PE','private'=>true],
['siglas'=>'UPC', 'name'=> 'Universidad Peruana de Ciencias Aplicadas','country'=>'PE','private'=>true],
['siglas'=>'USIL', 'name'=> 'Universidad San Ignacio de Loyola','country'=>'PE','private'=>true],
['siglas'=>'USAT', 'name'=> 'Universidad Católica Santo Toribio de Mogrovejo','country'=>'PE','private'=>true],
['siglas'=>'UW', 'name'=> 'Universidad Norbert Wiener','country'=>'PE','private'=>true],
['siglas'=>'UCSP', 'name'=> 'Universidad Católica San Pablo','country'=>'PE','private'=>true],
['siglas'=>'UPSJB', 'name'=> 'Universidad Privada San Juan Bautista','country'=>'PE','private'=>true],
['siglas'=>'UTP', 'name'=> 'Universidad Tecnológica del Perú','country'=>'PE','private'=>true],
['siglas'=>'UCSS', 'name'=> 'Universidad Católica Sedes Sapientiae','country'=>'PE','private'=>true],
['siglas'=>'UCSur', 'name'=> 'Universidad Científica del Sur','country'=>'PE','private'=>true],
['siglas'=>'UC', 'name'=> 'Universidad Continental','country'=>'PE','private'=>true],
['siglas'=>'–', 'name'=> 'Escuela de Postgrado Gerens','country'=>'PE','private'=>true],
['siglas'=>'USS', 'name'=> 'Universidad Señor de Sipán','country'=>'PE','private'=>true],
['siglas'=>'UCT', 'name'=> 'Universidad Cátólica de Trujillo Benedicto XVI','country'=>'PE','private'=>true],
['siglas'=>'UDeA', 'name'=> 'Universidad para el Desarrollo Andino','country'=>'PE','private'=>true],
['siglas'=>'UARM', 'name'=> 'Universidad Antonio Ruiz de Montoya','country'=>'PE','private'=>true],
['siglas'=>'UE', 'name'=> 'Universidad ESAN','country'=>'PE','private'=>true],
['siglas'=>'UJBM', 'name'=> 'Universidad Jaime Bausate y Meza','country'=>'PE','private'=>true],
['siglas'=>'UCH', 'name'=> 'Universidad de Ciencias y Humanidades','country'=>'PE','private'=>true],
['siglas'=>'UAI', 'name'=> 'Universidad Autónoma de Ica','country'=>'PE','private'=>true],
['siglas'=>'UA', 'name'=> 'Universidad Autónoma del Perú','country'=>'PE','private'=>true],
['siglas'=>'UCAL', 'name'=> 'Universidad de Ciencias y Artes de América Latina','country'=>'PE','private'=>true],
['siglas'=>'Ulasalle', 'name'=> 'Universidad La Salle','country'=>'PE','private'=>true],
['siglas'=>'UPHFR', 'name'=> 'Universidad Privada de Huancayo Franklin Roosevelt','country'=>'PE','private'=>true],
['siglas'=>'UTEC', 'name'=> 'Universidad de Ingeniería y Tecnología','country'=>'PE','private'=>true],
['siglas'=>'UMA', 'name'=> 'Universidad María Auxiliadora','country'=>'PE','private'=>true],
['siglas'=>'UPAL', 'name'=> 'Universidad Privada Peruano Alemana','country'=>'PE','private'=>true],
['siglas'=>'–', 'name'=> 'Escuela de Postgrado Neumann Business School','country'=>'PE','private'=>true],
['siglas'=>'UIGV', 'name'=> 'Universidad Inca Garcilaso de la Vega','country'=>'PE','private'=>true],
['siglas'=>'UANCV', 'name'=> 'Universidad Andina Néstor Cáceres Velásquez','country'=>'PE','private'=>true],
['siglas'=>'UDCH', 'name'=> 'Universidad Particular de Chiclayo','country'=>'PE','private'=>true],
['siglas'=>'USP', 'name'=> 'Universidad San Pedro','country'=>'PE','private'=>true],
['siglas'=>'UJCM', 'name'=> 'Universidad José Carlos Mariátegui','country'=>'PE','private'=>true],
['siglas'=>'UCP', 'name'=> 'Universidad Científica del Perú','country'=>'PE','private'=>true],
['siglas'=>'UPAGU', 'name'=> 'Universidad Privada Antonio Guillermo Urrelo','country'=>'PE','private'=>true],
['siglas'=>'ORVAL', 'name'=> 'Universidad Peruana de Arte Orval','country'=>'PE','private'=>true],
['siglas'=>'UAP', 'name'=> 'Universidad Alas Peruanas','country'=>'PE','private'=>true],
['siglas'=>'UPICA', 'name'=> 'Universidad Privada de Ica','country'=>'PE','private'=>true],
['siglas'=>'UDL', 'name'=> 'Universidad de Lambayeque','country'=>'PE','private'=>true],
['siglas'=>'UPSB', 'name'=> 'Universidad Privada Sergio Bernales','country'=>'PE','private'=>true],
['siglas'=>'UPCI', 'name'=> 'Universidad Peruana de Ciencias e Informática','country'=>'PE','private'=>true],
['siglas'=>'Ulasamericas', 'name'=> 'Universidad Peruana de Las Américas','country'=>'PE','private'=>true],
['siglas'=>'UPSC', 'name'=> 'Universidad Privada San Carlos','country'=>'PE','private'=>true],
['siglas'=>'Utelesup', 'name'=> 'Universidad Privada Telesup','country'=>'PE','private'=>true],
['siglas'=>'UPP', 'name'=> 'Universidad Privada de Pucallpa','country'=>'PE','private'=>true],
['siglas'=>'UPRIT', 'name'=> 'Universidad Privada de Trujillo','country'=>'PE','private'=>true],
['siglas'=>'UPO', 'name'=> 'Universidad Peruana de Oriente','country'=>'PE','private'=>true],
['siglas'=>'USB', 'name'=> 'Universidad Peruana Simón Bolívar','country'=>'PE','private'=>true],
['siglas'=>'UPeCEN', 'name'=> 'Universidad Peruana del Centro','country'=>'PE','private'=>true],
['siglas'=>'UMB', 'name'=> 'Universidad Privada de Juan Mejía Baca','country'=>'PE','private'=>true],
['siglas'=>'UPIG', 'name'=> 'Universidad Peruana de Integración Global','country'=>'PE','private'=>true],
['siglas'=>'UAL', 'name'=> 'Universidad Privada Arzobispo Loayza','country'=>'PE','private'=>true],
['siglas'=>'UAFS', 'name'=> 'Universidad Autónoma San Francisco','country'=>'PE','private'=>true],
['siglas'=>'UNID', 'name'=> 'Universidad Interamericana para el Desarrollo','country'=>'PE','private'=>true],
['siglas'=>'UPAC', 'name'=> 'Universidad Peruana Austral del Cusco','country'=>'PE','private'=>true],
['siglas'=>'USEL', 'name'=> 'Universidad Seminario Evangélico de Lima','country'=>'PE','private'=>true],
['siglas'=>'UPD', 'name'=> 'Universidad Privada Leonardo Da Vinci','country'=>'PE','private'=>true],
['siglas'=>'UCS', 'name'=> 'Universidad Ciencias de la Salud','country'=>'PE','private'=>true],
['siglas'=>'UPS', 'name'=> 'Universidad Privada de la Selva Peruana','country'=>'PE','private'=>true],
['siglas'=>'UDAFF', 'name'=> 'Universidad de Ayacucho Federico Froebel','country'=>'PE','private'=>true],
['siglas'=>'USAN', 'name'=> 'Universidad San Andrés','country'=>'PE','private'=>true],
['siglas'=>'UPADS', 'name'=> 'Universidad Privada Autónoma del Sur','country'=>'PE','private'=>true],
['siglas'=>'UPEIN', 'name'=> 'Universidad Peruana de Investigación y Negocios','country'=>'PE','private'=>true],
['siglas'=>'ULC', 'name'=> 'Universidad Latinoamericana CIMA','country'=>'PE','private'=>true],
['siglas'=>'USISE', 'name'=> 'Universidad Privada SISE','country'=>'PE','private'=>true],
['siglas'=>'UPA', 'name'=> 'Universidad Politécnica Amazónica','country'=>'PE','private'=>true],
['siglas'=>'ULP', 'name'=> 'Universidad Privada Líder Peruana','country'=>'PE','private'=>true],
['siglas'=>'USDG', 'name'=> 'Universidad Santo Domingo de Guzmán','country'=>'PE','private'=>true],
['siglas'=>'UST', 'name'=> 'Universidad Peruana Santo Tomás de Aquino de Ciencia e Integración','country'=>'PE','private'=>true],
['siglas'=>'Uglobal', 'name'=> 'Universidad Global del Cusco','country'=>'PE','private'=>true],
['siglas'=>'UMP', 'name'=> 'Universidad Marítima del Perú','country'=>'PE','private'=>true],
['siglas'=>'UNIJP', 'name'=> 'Universidad Juan Pablo II','country'=>'PE','private'=>true],
['siglas'=>'ULADECH', 'name'=> 'Universidad Católica Los Ángeles de Chimbote','country'=>'PE','private'=>true]

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('universities');
    }
}
