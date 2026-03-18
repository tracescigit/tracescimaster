<?php

namespace App\Imports;

use App\Models\Code;
use App\Models\Product;
use App\Models\UploadProgress;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Events\AfterImport;
use Throwable;
use Str;

class CodeImport implements
    ToArray,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure,
    WithChunkReading,
    ShouldQueue,
    WithEvents
{
    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;

    public function  __construct($data)
    {
        $this->product_id   = $data['product_id'];
        $this->batch        = $data['batch'];
        $this->batch_id     = $data['batch_id'];
        $this->user_id      = $data['user_id'];
        $this->total_rows   = $data['total_rows'];
        $this->progress_id  = uniqid();
    }

    public function generateQR()
    {
        $code = Str::random(15);

        if (Code::where('qr_code', $code)->exists()) {
            return $this->generateQR();
        }

        return $code;
    }


    public function progress()
    {
        $progress = UploadProgress::where('user_id', $this->user_id)->where('progress_id', $this->progress_id)->first();

        if (!$progress) {
            $progress = new UploadProgress;
        }

        $progress->user_id     = $this->user_id;
        $progress->progress_id = $this->progress_id;
        $progress->total_rows  = $this->total_rows;
        $progress->status      = '1';
        $progress->save();

        return $progress;
    }


    public function array(array $array)
    {
        if (count($array) > 0) {
            $progress = $this->progress();
            foreach ($array as $key => $row) {

                if (getAvailableCredits($this->user_id) && !Code::where('code_data', $row['code_data'])->exists()) {
                    $secret        = $this->generateQR();
                    $collect = [
                        'product_id'          => $this->product_id,
                        'batch'               => $this->batch,
                        'batch_id'            => $this->batch_id,
                        'user_id'             => $this->user_id,
                        'code_data'           => $row['code_data'],
                        'status'              => '0',
                        'qr_code'             => $secret,
                        'url'                 => env('APP_URL', 'https://tracesci.in') . '/api/p/' . $secret,
                        'exported'            => '1'
                    ];
                    if (Product::where('id', $this->product_id)->value('pin_required') == 1) {
                        $secret_code =  Str::random(8);
                        $collect['secret_code'] = $secret_code;
                    }
                    Code::create($collect);
                    $progress->uploaded_rows = $progress->uploaded_rows + 1;
                }
                $progress->processed_rows = $progress->processed_rows + 1;
                $progress->save();
            }
        }
    }


    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'code_data' => 'required|unique:codes',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public static function afterImport(AfterImport $event)
    {
        $thisobj  = $event->getConcernable();
        $progress = $thisobj->progress();
        $progress->status = '2';
        $progress->save();
    }

    public function onFailure(Failure ...$failure)
    {
        if (!empty($failure)) {
            $progress = $this->progress();
            $errors = [];

            if ($progress->error_logs != '') {
                $errors = json_decode($progress->error_logs, true);
            }

            foreach ($failure as $key => $fail) {
                $item = 'On row ' . $fail->row() . ': ' . implode(',', $fail->errors());
                array_push($errors, $item);
            }

            $progress->error_logs = json_encode($errors);
            $progress->save();
        }
    }
}
