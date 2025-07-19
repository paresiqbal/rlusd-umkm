<?php
namespace Database\Seeders;

use App\Models\BusinessClass;
use App\Models\Country;
use App\Models\Education;
use App\Models\EmploymentType;
use App\Models\JobType;
use App\Models\Organization;
use App\Models\Sector;
use App\Models\ServiceType;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    private static $pathMasterDataCity = "database/master_data/master-data-city-old.sql";

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businessClasses = [
            ["business_class_name" => "Usaha Mikro"],
            ["business_class_name" => "Usaha Kecil"],
            ["business_class_name" => "Usaha Menengah"],
            ["business_class_name" => "Usaha Besar"],
        ];

        $educations = [
            ["education_name" => "SD"],
            ["education_name" => "SMP"],
            ["education_name" => "SMA"],
            ["education_name" => "D1"],
            ["education_name" => "D2"],
            ["education_name" => "D3"],
            ["education_name" => "D4"],
            ["education_name" => "S1"],
            ["education_name" => "S2"],
            ["education_name" => "S3"],
        ];

        $employmentTypes = [
            ["employment_type_name" => "Full-time"],
            ["employment_type_name" => "Part-time"],
            ["employment_type_name" => "Proyek"],
            ["employment_type_name" => "Internship"],
            // ["employment_type_name" => "Magang"],
            // ["employment_type_name" => "Konsultan / Tenaga Ahli"],
        ];

        $jobTypes = [
            ["job_type_name" => "Work From Office"],
            ["job_type_name" => "Work From Home"],
            ["job_type_name" => "Hybrid"],
        ];

        $sectors = [
            "Minyak & Gas",
            "Batu Bara",
            "Dukungan Minyak, Gas & Batu Bara",
            "Peralatan Energi Alternatif",
            "Bahan Bakar Alternatif",
            "Kimia",
            "Bahan Konstruksi",
            "Kontainer & Kemasan",
            "Logam & Mineral",
            "Kehutanan & Kertas",
            "Dirgantara & Pertahanan",
            "Produk & Fasilitas Bangunan",
            "Listrik",
            "Mesin",
            "Perdagangan Industri Terdiversifikasi",
            "Jasa Komersial",
            "Jasa Profesional",
            "Kepemilikan Multi-sektor",
            "Ritel Makanan & Pokok",
            "Minuman",
            "Makanan Olahan",
            "Produk Pertanian",
            "Tembakau",
            "Produk Rumah Tangga",
            "Produk Perawatan Pribadi",
            "Komponen Otomotif",
            "Otomotif",
            "Barang Rumah Tangga",
            "Elektronik Konsumen",
            "Peralatan Olahraga & Hobi",
            "Pakaian & Barang Mewah",
            "Pariwisata & Rekreasi",
            "Pendidikan & Layanan Pendukung",
            "Media",
            "Hiburan & Produksi Film",
            "Distributor Konsumen",
            "Ritel Internet & Rumah",
            "Toko Serba Ada",
            "Ritel Khusus",
            "Peralatan & Persediaan Kesehatan",
            "Penyedia Layanan Kesehatan",
            "Farmasi",
            "Riset Kesehatan",
            "Bank",
            "Pembiayaan Konsumen",
            "Pembiayaan Bisnis",
            "Layanan Investasi",
            "Asuransi",
            "Perusahaan Kepemilikan & Investasi",
            "Manajemen & Pengembangan Real Estat",
            "Aplikasi & Layanan Online",
            "Layanan & Konsultasi TI",
            "Perangkat Lunak",
            "Peralatan Jaringan",
            "Perangkat Keras Komputer",
            "Peralatan Elektronik, Instrumen & Komponen",
            "Operator Infrastruktur Transportasi",
            "Konstruksi Berat & Teknik Sipil",
            "Layanan Telekomunikasi",
            "Layanan Telekomunikasi Nirkabel",
            "Utilitas Listrik",
            "Utilitas Gas",
            "Utilitas Air",
            "Maskapai Penerbangan",
            "Transportasi Laut Penumpang",
            "Transportasi Darat Penumpang",
            "Logistik & Pengiriman",
            "Dana Investasi",
            "Obligasi",
        ];

        $serviceTypes = [
            "Pelatihan",
            "Pendampingan",
            "Fasilitasi",
            "Advokasi",
            "Sosialisasi",
            "Konseling",
        ];

        $organizations = [
            "Pemerintah",
            "Perusahaan",
            "BUMN",
            "LSM/NGO",
            "Kampus",
        ];

        BusinessClass::insert($businessClasses);

        JobType::insert($jobTypes);

        Education::insert($educations);

        EmploymentType::insert($employmentTypes);

        ServiceType::insert(array_map(function ($serviceType) {
            return ["service_type_name" => $serviceType];
        }, $serviceTypes));

        Organization::insert(array_map(function ($organization) {
            return ["organization_name" => $organization];
        }, $organizations));

        foreach ($sectors as $sector) {
            Sector::create([
                "sector_name" => $sector,
            ]);
        }

        Country::create([
            "country_name" => "Indonesia",
        ]);

        try {
            DB::unprepared(file_get_contents(static::$pathMasterDataCity));
        } catch (\Throwable $th) {
            throw new Exception("There is no master data city on the path.");
        }

    }
}
