<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\Designation;
use App\Models\District;
use App\Models\Municipality;
use App\Models\Organization;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create(
            [
                'name' => 'KIM MAGAT MANOGUID',
                'email' => 'manoguid@gmail.com',
                'role' => 'Super Admin'
            ]
        );


        // Districts
        $districts = [
            ['name' => '1st District'],
            ['name' => '2nd District'],
            ['name' => '3rd District'],
            ['name' => '4th District'],
            ['name' => '5th District'],
            ['name' => '6th District'],
        ];

        foreach ($districts as $district) {
            District::create($district);
        }


        // Municipalitites
        $municipalities = [
            // 1st District
            // ['name' => 'Agno', 'district_id' => 1],
            // ['name' => 'Alaminos City', 'district_id' => 1],
            // ['name' => 'Anda', 'district_id' => 1],
            // ['name' => 'Bani', 'district_id' => 1],
            // ['name' => 'Bolinao', 'district_id' => 1],
            // ['name' => 'Burgos', 'district_id' => 1],
            // ['name' => 'Dasol', 'district_id' => 1],
            // ['name' => 'Infanta', 'district_id' => 1],
            // ['name' => 'Mabini', 'district_id' => 1],
            // ['name' => 'Sual', 'district_id' => 1],

            // 2nd District
            // ['name' => 'Aguilar', 'district_id' => 2],
            // ['name' => 'Basista', 'district_id' => 2],
            // ['name' => 'Binmaley', 'district_id' => 2],
            // ['name' => 'Bugallon', 'district_id' => 2],
            // ['name' => 'Labrador', 'district_id' => 2],
            // ['name' => 'Lingayen', 'district_id' => 2],
            // ['name' => 'Mangatarem', 'district_id' => 2],
            // ['name' => 'Urbiztondo', 'district_id' => 2],

            // 3rd District
            ['name' => 'Bayambang', 'district_id' => 3],  // 1
            ['name' => 'Calasiao', 'district_id' => 3], // 2
            ['name' => 'Malasiqui', 'district_id' => 3], // 3
            ['name' => 'Mapandan', 'district_id' => 3], // 4
            ['name' => 'San Carlos City', 'district_id' => 3], // 5
            ['name' => 'Santa Barbara', 'district_id' => 3], // 6

            // 4th District
            // ['name' => 'Dagupan City', 'district_id' => 4],
            // ['name' => 'Manaoag', 'district_id' => 4],
            // ['name' => 'Mangaldan', 'district_id' => 4],
            // ['name' => 'San Fabian', 'district_id' => 4],
            // ['name' => 'San Jacinto', 'district_id' => 4],

            // 5th District
            // ['name' => 'Alcala', 'district_id' => 5],
            // ['name' => 'Bautista', 'district_id' => 5],
            // ['name' => 'Binalonan', 'district_id' => 5],
            // ['name' => 'Laoac', 'district_id' => 5],
            // ['name' => 'Pozorrubio', 'district_id' => 5],
            // ['name' => 'Santo Tomas', 'district_id' => 5],
            // ['name' => 'Sison', 'district_id' => 5],
            // ['name' => 'Urdaneta City', 'district_id' => 5],
            // ['name' => 'Villasis', 'district_id' => 5],

            // 6th District
            // ['name' => 'Asingan', 'district_id' => 6],
            // ['name' => 'Balungao', 'district_id' => 6],
            // ['name' => 'Natividad', 'district_id' => 6],
            // ['name' => 'Rosales', 'district_id' => 6],
            // ['name' => 'San Manuel', 'district_id' => 6],
            // ['name' => 'San Nicolas', 'district_id' => 6],
            // ['name' => 'San Quintin', 'district_id' => 6],
            // ['name' => 'Santa Maria', 'district_id' => 6],
            // ['name' => 'Tayug', 'district_id' => 6],
            // ['name' => 'Umingan', 'district_id' => 6],
        ];


        foreach ($municipalities as $municipality) {
            Municipality::create($municipality);
        }

        $this->populateBarangay();
    }

    public function populateBarangay()
    {
        $barangays = [
            ['name' => 'Alinggan', 'municipality_id' => 1],
            ['name' => 'Amanperez', 'municipality_id' => 1],
            ['name' => 'Amancosiling Norte', 'municipality_id' => 1],
            ['name' => 'Amancosiling Sur', 'municipality_id' => 1],
            ['name' => 'Ambayat I', 'municipality_id' => 1],
            ['name' => 'Ambayat II', 'municipality_id' => 1],
            ['name' => 'Apalen', 'municipality_id' => 1],
            ['name' => 'Asin', 'municipality_id' => 1],
            ['name' => 'Ataynan', 'municipality_id' => 1],
            ['name' => 'Bacnono', 'municipality_id' => 1],
            ['name' => 'Balaybuaya', 'municipality_id' => 1],
            ['name' => 'Banaban', 'municipality_id' => 1],
            ['name' => 'Bani', 'municipality_id' => 1],
            ['name' => 'Batangcaoa', 'municipality_id' => 1],
            ['name' => 'Beleng', 'municipality_id' => 1],
            ['name' => 'Bical Norte', 'municipality_id' => 1],
            ['name' => 'Bical Sur', 'municipality_id' => 1],
            ['name' => 'Bongato East', 'municipality_id' => 1],
            ['name' => 'Bongato West', 'municipality_id' => 1],
            ['name' => 'Buayaen', 'municipality_id' => 1],
            ['name' => 'Buenlag 1st', 'municipality_id' => 1],
            ['name' => 'Buenlag 2nd', 'municipality_id' => 1],
            ['name' => 'Cadre Site', 'municipality_id' => 1],
            ['name' => 'Carungay', 'municipality_id' => 1],
            ['name' => 'Caturay', 'municipality_id' => 1],
            ['name' => 'Darawey', 'municipality_id' => 1],
            ['name' => 'Duera', 'municipality_id' => 1],
            ['name' => 'Dusoc', 'municipality_id' => 1],
            ['name' => 'Hermoza', 'municipality_id' => 1],
            ['name' => 'Idong', 'municipality_id' => 1],
            ['name' => 'Inanlorenza', 'municipality_id' => 1],
            ['name' => 'Inirangan', 'municipality_id' => 1],
            ['name' => 'Iton', 'municipality_id' => 1],
            ['name' => 'Langiran', 'municipality_id' => 1],
            ['name' => 'Ligue', 'municipality_id' => 1],
            ['name' => 'M.H. Del Pilar', 'municipality_id' => 1],
            ['name' => 'Macayocayo', 'municipality_id' => 1],
            ['name' => 'Magsaysay', 'municipality_id' => 1],
            ['name' => 'Maigpa', 'municipality_id' => 1],
            ['name' => 'Malimpec', 'municipality_id' => 1],
            ['name' => 'Malioer', 'municipality_id' => 1],
            ['name' => 'Managos', 'municipality_id' => 1],
            ['name' => 'Manambong Norte', 'municipality_id' => 1],
            ['name' => 'Manambong Parte', 'municipality_id' => 1],
            ['name' => 'Manambong Sur', 'municipality_id' => 1],
            ['name' => 'Mangayao', 'municipality_id' => 1],
            ['name' => 'Nalsian Norte', 'municipality_id' => 1],
            ['name' => 'Nalsian Sur', 'municipality_id' => 1],
            ['name' => 'Pangdel', 'municipality_id' => 1],
            ['name' => 'Pantol', 'municipality_id' => 1],
            ['name' => 'Paragos', 'municipality_id' => 1],
            ['name' => 'Poblacion Sur', 'municipality_id' => 1],
            ['name' => 'Pugo', 'municipality_id' => 1],
            ['name' => 'Reynado', 'municipality_id' => 1],
            ['name' => 'San Gabriel 1st', 'municipality_id' => 1],
            ['name' => 'San Gabriel 2nd', 'municipality_id' => 1],
            ['name' => 'San Vicente', 'municipality_id' => 1],
            ['name' => 'Sangcagulis', 'municipality_id' => 1],
            ['name' => 'Sanlibo', 'municipality_id' => 1],
            ['name' => 'Sapang', 'municipality_id' => 1],
            ['name' => 'Tamaro', 'municipality_id' => 1],
            ['name' => 'Tambac', 'municipality_id' => 1],
            ['name' => 'Tampog', 'municipality_id' => 1],
            ['name' => 'Tanolong', 'municipality_id' => 1],
            ['name' => 'Tatarac', 'municipality_id' => 1],
            ['name' => 'Telbang', 'municipality_id' => 1],
            ['name' => 'Tococ East', 'municipality_id' => 1],
            ['name' => 'Tococ West', 'municipality_id' => 1],
            ['name' => 'Warding', 'municipality_id' => 1],
            ['name' => 'Wawa', 'municipality_id' => 1],
            ['name' => 'Zone I', 'municipality_id' => 1],
            ['name' => 'Zone II', 'municipality_id' => 1],
            ['name' => 'Zone III', 'municipality_id' => 1],
            ['name' => 'Zone IV', 'municipality_id' => 1],
            ['name' => 'Zone V', 'municipality_id' => 1],
            ['name' => 'Zone VI', 'municipality_id' => 1],
            ['name' => 'Zone VII', 'municipality_id' => 1],

            // Calasiao (Municipality ID: 2)
            ['name' => 'Ambonao', 'municipality_id' => 2],
            ['name' => 'Ambuetel', 'municipality_id' => 2],
            ['name' => 'Banaoang', 'municipality_id' => 2],
            ['name' => 'Bued', 'municipality_id' => 2],
            ['name' => 'Buenlag', 'municipality_id' => 2],
            ['name' => 'Cabilocaan', 'municipality_id' => 2],
            ['name' => 'Dinalaoan', 'municipality_id' => 2],
            ['name' => 'Doyong', 'municipality_id' => 2],
            ['name' => 'Gabon', 'municipality_id' => 2],
            ['name' => 'Lasip', 'municipality_id' => 2],
            ['name' => 'Longos', 'municipality_id' => 2],
            ['name' => 'Lumbang', 'municipality_id' => 2],
            ['name' => 'Macabito', 'municipality_id' => 2],
            ['name' => 'Malabago', 'municipality_id' => 2],
            ['name' => 'Mancup', 'municipality_id' => 2],
            ['name' => 'Nagsaing', 'municipality_id' => 2],
            ['name' => 'Nalsian', 'municipality_id' => 2],
            ['name' => 'Poblacion East', 'municipality_id' => 2],
            ['name' => 'Poblacion West', 'municipality_id' => 2],
            ['name' => 'Quesban', 'municipality_id' => 2],
            ['name' => 'San Miguel', 'municipality_id' => 2],
            ['name' => 'San Vicente', 'municipality_id' => 2],
            ['name' => 'Songkoy', 'municipality_id' => 2],
            ['name' => 'Talibaew', 'municipality_id' => 2],


            // Malasiqui (Municipality ID: 3)
            ['name' => 'Abonagan', 'municipality_id' => 3],
            ['name' => 'Agdao', 'municipality_id' => 3],
            ['name' => 'Alacan', 'municipality_id' => 3],
            ['name' => 'Aliaga', 'municipality_id' => 3],
            ['name' => 'Amacalan', 'municipality_id' => 3],
            ['name' => 'Anolid', 'municipality_id' => 3],
            ['name' => 'Apaya', 'municipality_id' => 3],
            ['name' => 'Asin Este', 'municipality_id' => 3],
            ['name' => 'Asin Weste', 'municipality_id' => 3],
            ['name' => 'Bacundao Este', 'municipality_id' => 3],
            ['name' => 'Bacundao Weste', 'municipality_id' => 3],
            ['name' => 'Bakitiw', 'municipality_id' => 3],
            ['name' => 'Balite', 'municipality_id' => 3],
            ['name' => 'Banawang', 'municipality_id' => 3],
            ['name' => 'Barang', 'municipality_id' => 3],
            ['name' => 'Bawer', 'municipality_id' => 3],
            ['name' => 'Binalay', 'municipality_id' => 3],
            ['name' => 'Bobon', 'municipality_id' => 3],
            ['name' => 'Bolaoit', 'municipality_id' => 3],
            ['name' => 'Bongar', 'municipality_id' => 3],
            ['name' => 'Butao', 'municipality_id' => 3],
            ['name' => 'Cabatling', 'municipality_id' => 3],
            ['name' => 'Cabueldatan', 'municipality_id' => 3],
            ['name' => 'Calbueg', 'municipality_id' => 3],
            ['name' => 'Canan Norte', 'municipality_id' => 3],
            ['name' => 'Canan Sur', 'municipality_id' => 3],
            ['name' => 'Cawayan Bogtong', 'municipality_id' => 3],
            ['name' => 'Don Pedro', 'municipality_id' => 3],
            ['name' => 'Gatang', 'municipality_id' => 3],
            ['name' => 'Goliman', 'municipality_id' => 3],
            ['name' => 'Gomez', 'municipality_id' => 3],
            ['name' => 'Guilig', 'municipality_id' => 3],
            ['name' => 'Ican', 'municipality_id' => 3],
            ['name' => 'Ingalagala', 'municipality_id' => 3],
            ['name' => 'Lareg-lareg', 'municipality_id' => 3],
            ['name' => 'Lasip', 'municipality_id' => 3],
            ['name' => 'Lepa', 'municipality_id' => 3],
            ['name' => 'Loqueb Este', 'municipality_id' => 3],
            ['name' => 'Loqueb Norte', 'municipality_id' => 3],
            ['name' => 'Loqueb Sur', 'municipality_id' => 3],
            ['name' => 'Lunec', 'municipality_id' => 3],
            ['name' => 'Mabulitec', 'municipality_id' => 3],
            ['name' => 'Malimpec', 'municipality_id' => 3],
            ['name' => 'Manggan-Dampay', 'municipality_id' => 3],
            ['name' => 'Nalsian Norte', 'municipality_id' => 3],
            ['name' => 'Nalsian Sur', 'municipality_id' => 3],
            ['name' => 'Nancapian', 'municipality_id' => 3],
            ['name' => 'Nansangaan', 'municipality_id' => 3],
            ['name' => 'Olea', 'municipality_id' => 3],
            ['name' => 'Palapar Norte', 'municipality_id' => 3],
            ['name' => 'Palapar Sur', 'municipality_id' => 3],
            ['name' => 'Palong', 'municipality_id' => 3],
            ['name' => 'Pamaranum', 'municipality_id' => 3],
            ['name' => 'Pasima', 'municipality_id' => 3],
            ['name' => 'Payar', 'municipality_id' => 3],
            ['name' => 'Poblacion', 'municipality_id' => 3],
            ['name' => 'Polong Norte', 'municipality_id' => 3],
            ['name' => 'Polong Sur', 'municipality_id' => 3],
            ['name' => 'Potiocan', 'municipality_id' => 3],
            ['name' => 'San Julian', 'municipality_id' => 3],
            ['name' => 'Tabo-Sili', 'municipality_id' => 3],
            ['name' => 'Talospatang', 'municipality_id' => 3],
            ['name' => 'Taloy', 'municipality_id' => 3],
            ['name' => 'Taloyan', 'municipality_id' => 3],
            ['name' => 'Tambac', 'municipality_id' => 3],
            ['name' => 'Tobor', 'municipality_id' => 3],
            ['name' => 'Tolonguat', 'municipality_id' => 3],
            ['name' => 'Tomling', 'municipality_id' => 3],
            ['name' => 'Umando', 'municipality_id' => 3],
            ['name' => 'Viado', 'municipality_id' => 3],
            ['name' => 'Waig', 'municipality_id' => 3],
            ['name' => 'Warey', 'municipality_id' => 3],

            // Mapandan (Municipality ID: 4)
            ['name' => 'Amanoaoac', 'municipality_id' => 4],
            ['name' => 'Apaya', 'municipality_id' => 4],
            ['name' => 'Aserda', 'municipality_id' => 4],
            ['name' => 'Baloling', 'municipality_id' => 4],
            ['name' => 'Coral', 'municipality_id' => 4],
            ['name' => 'Golden', 'municipality_id' => 4],
            ['name' => 'Lambayan', 'municipality_id' => 4],
            ['name' => 'Luyan', 'municipality_id' => 4],
            ['name' => 'Nilombot', 'municipality_id' => 4],
            ['name' => 'Pias', 'municipality_id' => 4],
            ['name' => 'Poblacion', 'municipality_id' => 4],
            ['name' => 'Primicias', 'municipality_id' => 4],
            ['name' => 'Santa Maria', 'municipality_id' => 4],
            ['name' => 'Torres', 'municipality_id' => 4],
            // Add the remaining barangays for Mapandan...

            // San Carlos City (Municipality ID: 5)
            ['name' => 'Abanon', 'municipality_id' => 5],
            ['name' => 'Agdao', 'municipality_id' => 5],
            ['name' => 'Alacan', 'municipality_id' => 5],
            ['name' => 'Alinaay', 'municipality_id' => 5],
            ['name' => 'Anando', 'municipality_id' => 5],
            ['name' => 'Antipangol', 'municipality_id' => 5],
            ['name' => 'Bacnar', 'municipality_id' => 5],
            ['name' => 'Bactad East', 'municipality_id' => 5],
            ['name' => 'Bactad Proper', 'municipality_id' => 5],
            ['name' => 'Balaya', 'municipality_id' => 5],
            ['name' => 'Balungao', 'municipality_id' => 5],
            ['name' => 'Banaoang', 'municipality_id' => 5],
            ['name' => 'Bega', 'municipality_id' => 5],
            ['name' => 'Bocacliw', 'municipality_id' => 5],
            ['name' => 'Bogtong', 'municipality_id' => 5],
            ['name' => 'Bonifacio', 'municipality_id' => 5],
            ['name' => 'Bugallon-Posadas', 'municipality_id' => 5],
            ['name' => 'Bued', 'municipality_id' => 5],
            ['name' => 'Bulong Norte', 'municipality_id' => 5],
            ['name' => 'Bulong Sur', 'municipality_id' => 5],
            ['name' => 'Cacaritan', 'municipality_id' => 5],
            ['name' => 'Cabayaoasan', 'municipality_id' => 5],
            ['name' => 'Caisipan', 'municipality_id' => 5],
            ['name' => 'Calobaoan', 'municipality_id' => 5],
            ['name' => 'Camanang', 'municipality_id' => 5],
            ['name' => 'Caroan', 'municipality_id' => 5],
            ['name' => 'Caseres', 'municipality_id' => 5],
            ['name' => 'Casilagan', 'municipality_id' => 5],
            ['name' => 'Don Maximo Aguilar', 'municipality_id' => 5],
            ['name' => 'Guelew', 'municipality_id' => 5],
            ['name' => 'Ilang', 'municipality_id' => 5],
            ['name' => 'Inerangan', 'municipality_id' => 5],
            ['name' => 'Labney', 'municipality_id' => 5],
            ['name' => 'Lambayan', 'municipality_id' => 5],
            ['name' => 'Laoac', 'municipality_id' => 5],
            ['name' => 'Licsi', 'municipality_id' => 5],
            ['name' => 'Libas East', 'municipality_id' => 5],
            ['name' => 'Libas West', 'municipality_id' => 5],
            ['name' => 'Lomboy', 'municipality_id' => 5],
            ['name' => 'Lucban', 'municipality_id' => 5],
            ['name' => 'Mabini', 'municipality_id' => 5],
            ['name' => 'Macabito', 'municipality_id' => 5],
            ['name' => 'Magtaking', 'municipality_id' => 5],
            ['name' => 'Manaoag', 'municipality_id' => 5],
            ['name' => 'Mangayao', 'municipality_id' => 5],
            ['name' => 'Maoac', 'municipality_id' => 5],
            ['name' => 'Matic-matic', 'municipality_id' => 5],
            ['name' => 'Nagsaing', 'municipality_id' => 5],
            ['name' => 'Pagal', 'municipality_id' => 5],
            ['name' => 'Palospos', 'municipality_id' => 5],
            ['name' => 'Pangalangan', 'municipality_id' => 5],
            ['name' => 'Pangpang', 'municipality_id' => 5],
            ['name' => 'Poblacion', 'municipality_id' => 5],
            ['name' => 'Pogomboa', 'municipality_id' => 5],
            ['name' => 'Pogon-Berno', 'municipality_id' => 5],
            ['name' => 'Pogon-Cruz', 'municipality_id' => 5],
            ['name' => 'Pogon-Lomboy', 'municipality_id' => 5],
            ['name' => 'Pogon-Serafin', 'municipality_id' => 5],
            ['name' => 'Quimlat', 'municipality_id' => 5],
            ['name' => 'Rabon', 'municipality_id' => 5],
            ['name' => 'Rangayan', 'municipality_id' => 5],
            ['name' => 'Roxas Boulevard', 'municipality_id' => 5],
            ['name' => 'San Pedro Apartado', 'municipality_id' => 5],
            ['name' => 'San Pedro Ili', 'municipality_id' => 5],
            ['name' => 'Sapang', 'municipality_id' => 5],
            ['name' => 'Taloy', 'municipality_id' => 5],
            ['name' => 'Tambac', 'municipality_id' => 5],
            ['name' => 'Tarece', 'municipality_id' => 5],
            ['name' => 'Tayambani', 'municipality_id' => 5],
            ['name' => 'Telbang', 'municipality_id' => 5],
            ['name' => 'Tobuan', 'municipality_id' => 5],
            ['name' => 'Tomling', 'municipality_id' => 5],
            ['name' => 'Torres', 'municipality_id' => 5],
            ['name' => 'Tulong', 'municipality_id' => 5],
            ['name' => 'Tuy', 'municipality_id' => 5],
            ['name' => 'Zone I', 'municipality_id' => 5],
            ['name' => 'Zone II', 'municipality_id' => 5],
            ['name' => 'Zone III', 'municipality_id' => 5],
            ['name' => 'Zone IV', 'municipality_id' => 5],
            // Add the remaining barangays for San Carlos City...

            ['name' => 'Alibago', 'municipality_id' => 6],
            ['name' => 'Balingueo', 'municipality_id' => 6],
            ['name' => 'Banaoang', 'municipality_id' => 6],
            ['name' => 'Banzal', 'municipality_id' => 6],
            ['name' => 'Botao', 'municipality_id' => 6],
            ['name' => 'Cablong', 'municipality_id' => 6],
            ['name' => 'Carusocan', 'municipality_id' => 6],
            ['name' => 'Dalongue', 'municipality_id' => 6],
            ['name' => 'Erfe', 'municipality_id' => 6],
            ['name' => 'Gueguesangen', 'municipality_id' => 6],
            ['name' => 'Leet', 'municipality_id' => 6],
            ['name' => 'Malanay', 'municipality_id' => 6],
            ['name' => 'Maningding', 'municipality_id' => 6],
            ['name' => 'Maronong', 'municipality_id' => 6],
            ['name' => 'Maticmatic', 'municipality_id' => 6],
            ['name' => 'Minien East', 'municipality_id' => 6],
            ['name' => 'Minien West', 'municipality_id' => 6],
            ['name' => 'Nilombot', 'municipality_id' => 6],
            ['name' => 'Patayac', 'municipality_id' => 6],
            ['name' => 'Payas', 'municipality_id' => 6],
            ['name' => 'Poblacion Norte', 'municipality_id' => 6],
            ['name' => 'Poblacion Sur', 'municipality_id' => 6],
            ['name' => 'Primicias', 'municipality_id' => 6],
            ['name' => 'Sapang', 'municipality_id' => 6],
            ['name' => 'Sonquil', 'municipality_id' => 6],
            ['name' => 'Tebag East', 'municipality_id' => 6],
            ['name' => 'Tebag West', 'municipality_id' => 6],
            ['name' => 'Tuliao', 'municipality_id' => 6],
            ['name' => 'Ventinilla', 'municipality_id' => 6],
        ];

        foreach ($barangays as $barangay) {
            Barangay::create($barangay);
        }
    }
}
