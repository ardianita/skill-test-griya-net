<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\API\ResponseFormatter;

class SalesController extends Controller
{
    public function index(ResponseFormatter $responseFormatter)
    {
        $sales = Sales::query()->get();

        try {
            return $responseFormatter->success($sales, 'Berhasil!', 200);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal!', 400);
        }
    }

    public function store(Request $request, ResponseFormatter $responseFormatter)
    {

        $request->validate([
            'name' => ['required', 'string'],
            'nip' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'username' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 2,
        ]);
        $user_id = User::query()->where('email', $request->email)->latest()->first();

        $sales = Sales::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'user_id' => $user_id->id,
        ]);

        try {
            return $responseFormatter->success($sales, 'Berhasil Ditambahkan!', 201);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal Ditambahkan!', 400);
        }
    }
    public function update(Sales $idSales, Request $request, ResponseFormatter $responseFormatter)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'nip' => ['required', 'string'],
            'gender' => ['required', 'string'],
        ]);

        $idSales->update($data);

        try {
            return $responseFormatter->success($idSales, 'Berhasil Diubah!', 202);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal Diubah!', 400);
        }
    }

    public function destroy(Sales $idSales, ResponseFormatter $responseFormatter)
    {
        $idSales->delete();

        try {
            return $responseFormatter->success('Berhasil Dihapus!', 200);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal Dihapus!', 400);
        }
    }
}
