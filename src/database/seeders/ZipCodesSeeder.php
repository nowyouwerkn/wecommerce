<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nowyouwerkn\WeCommerce\Models\ZipCode;
use Storage;

class ZipCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '1024M');//allocate memory

        $json = Storage::disk('root')->get("public/assets/data/zip_codes_mexico.json");
        $zips = json_decode(stripslashes($json), true);
        
        /* Useful for debugging */
        /*
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                echo ' - No errors';
            break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                echo ' - Unknown error';
            break;
        }
        */

        foreach ($zips as $zip) {
            if (empty($zip['d_ciudad'])) {
                ZipCode::create([
                    "country_id" => '2',
                    "int_code" => $zip['d_CP'],
                    "zip_code" => $zip['d_codigo'],
                    "suburb" => $zip['d_asenta'],
                    "state" => $zip['d_estado'],
                    "municipality" => $zip['D_mnpio'],
                ]);
            }else{
                ZipCode::create([
                    "country_id" => '2',
                    "int_code" => $zip['d_CP'],
                    "zip_code" => $zip['d_codigo'],
                    "suburb" => $zip['d_asenta'],
                    "state" => $zip['d_estado'],
                    "municipality" => $zip['D_mnpio'],
                    "city" => $zip['d_ciudad'],
                ]); 
            }
        }
    }
}