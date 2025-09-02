<?php

namespace App\Imports;

use App\Models\Code;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;

class CodeActivate implements ToArray , WithHeadingRow
{
    use Importable;

    public $errors = [];

    public function  __construct($data)
    {
        $this->user_id = $data['user_id'];
    }

    public function array(array $array)
    {
        if(count($array)>0){
            foreach ($array as $key => $row) {
                $code = Code::where('code_data',$row['code_data'])->where('user_id',$this->user_id)->first();
                if ($code) {
                    $code->status = '1';
                    $code->save();   
                }
            }
        }
    }

    public function headingRow(): int
    {
        return 2;
    }
}
