<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\AramexAccount;
use App\Models\Aramex;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToModel,WithHeadingRow

{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data=(object)$row;
        if (@$data->currency) {
            $type = 'CODS';
        }else{
            $type = '';
        }

        $acc=AramexAccount::find(1);
        $armx = new Aramex();
            $result = $armx->makeOrder($data, $type, $acc);
            dd($result);
            if (!is_array($result))
            {
                return response()->json(['result'=>$result,'success' =>true]);
            }
            else
            {
                $url = $result['doc'];
                $file_name = basename($url);
                if (file_put_contents(storage_path("app/public/aramex/" . uniqid() . ".pdf") , file_get_contents($url)))
                {
                    return response()->json(['success' =>true]);
                }
                else
                {
                    return response()->json(['success' =>false,'message'=>"File downloading failed."],500);
                }
            }
        }


}
