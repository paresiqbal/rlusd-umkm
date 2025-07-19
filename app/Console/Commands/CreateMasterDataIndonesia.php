<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CreateMasterDataIndonesia extends Command
{
    private $filename = "worldcities.csv";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:master-data-indonesia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create SQL statement for insert data indonesia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Disable command");
        return;
        // $this->readCsv();
        $arrFiles = scandir(storage_path('app/private/cities'));
        $arrFiles = array_slice($arrFiles, 2);
        // dd($arrFiles);
        DB::table("cities")->truncate();
        DB::table("provinces")->truncate();
        DB::beginTransaction();
        $province = null;
        foreach ($arrFiles as $key => $filename) {
            $list = File::json(storage_path('app/private/cities/' . $filename));
            // dd($list);
            foreach ($list as $key2 => $item) {
                $city = explode(PHP_EOL, $item['city_name']);
                $city = implode("", $city);
                if ($key2 == 0) {
                    $province = DB::table("provinces")->insertGetId([
                        "province_name" => $item["province_name"] ?? "Aceh",
                        "country_id" => 1,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ]);
                }
                DB::table("cities")->insert([
                    "city_name" => $city,
                    "province_id" => $province,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }
        }
        DB::commit();

    }

    public function readCsv()
    {
        $csvFile = fopen(storage_path("app/private/{$this->filename}"), 'r');
        $i = 0;
        $row = fgetcsv($csvFile, 1000, ',');
        while (($row = fgetcsv($csvFile, 1000, ',')) !== false) {
            $i++;
            $data = [];
            $data['city'] = isset($row[0]) && is_string($row[0]) ? $row[0] : "";
            $data['city_ascii'] = isset($row[1]) && is_string($row[1]) ? $row[1] : "";
            $data['lat'] = isset($row[2]) && is_numeric($row[2]) ? (float) $row[2] : 0.0;
            $data['lng'] = isset($row[3]) && is_numeric($row[3]) ? (float) $row[3] : 0.0;
            $data['country'] = isset($row[4]) && is_string($row[4]) ? $row[4] : "";
            $data['iso2'] = isset($row[5]) && is_string($row[5]) ? $row[5] : "";
            $data['iso3'] = isset($row[6]) && is_string($row[6]) ? $row[6] : "";
            $data['admin_name'] = isset($row[7]) && is_string($row[7]) ? $row[7] : "";
            $data['capital'] = isset($row[8]) && is_string($row[8]) ? $row[8] : "";

            // Check if population is numeric, defaulting to 0 if empty or invalid
            $data['population'] = isset($row[9]) && is_numeric($row[9]) ? (int) $row[9] : 0;

            $data['id'] = $row[10];
            DB::table("master_data_city")->insert($data);
            $this->line("Line $i");
        }

        fclose($csvFile);

        // return $data; // You can return it or do whatever processing you need
    }
}
