<?php

namespace App\Http\Controllers;

use App\Models\Barang as Barang;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    private function responseJSON(int $status, array $messages, array $data = [])
    {
        return response()->json([
            'status' => $status,
            'messages' => $messages,
            'data' => $data
        ]);
    }

    public function search(Request $request)
    {
        $q = isset($request['q']) ? "%" .$request['q']. "%" : '%%';
        try {
            $res = Barang::where("nama_barang", "like", $q)
                ->orWhere("kode_barang", "like", $q)
                ->orWhere("expired_date", "like", $q)
                ->get();
            return $this->responseJSON(200, ["message" => "success"], $res->toArray());
        } catch (Exception $ee) {
            return $this->responseJSON(500, ["error" => $ee]);
        }
    }
}
