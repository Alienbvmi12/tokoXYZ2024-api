<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class TransaksiController extends Controller
{

    private function responseJSON(int $status, array $messages, array $data = [])
    {
        return response()->json([
            'status' => $status,
            'messages' => $messages,
            'data' => $data
        ]);
    }
    
    public function storeTransaksi(Request $request)
    {

        $cum = $request->all();
        $user = $request->user();
        $no_transaksi = date("YmdHis");
        $tgl = date("Y-m-d");

        $vald = FacadesValidator::make($request->all(), [
            'items' => 'required'
        ]);

        if ($vald->fails()) {
            return $this->responseJSON(422, $vald->messages()->toArray());
        } else {
            $item = $cum["items"];
            foreach ($item as $value) {
                $val = $value;
                $vald = FacadesValidator::make($val, [
                    "id_barang" => "required",
                    "harga" => "required",
                    "qty" => "required"
                ]);

                if ($vald->fails()) {
                    return $this->responseJSON(422, $vald->messages()->toArray());
                }

                $val["id_user"] = $user["id"];
                $val["no_transaksi"] = $no_transaksi;
                $val["tgl_transaksi"] = $tgl;
                Transaksi::create($val);
            }
        }

        $trans = Transaksi::where("no_transaksi", $no_transaksi)->get();
        return $this->responseJSON(200, ["message" => "success"], $trans->toArray());
    }
}
