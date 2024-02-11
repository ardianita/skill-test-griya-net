<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\ResponseFormatter;

class CustomerController extends Controller
{
    public function index(ResponseFormatter $responseFormatter)
    {
        $customers = Customer::query()->get();

        try {
            return $responseFormatter->success($customers, 'Berhasil!', 200);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal!', 400);
        }
    }

    public function store(Request $request, ResponseFormatter $responseFormatter)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'telp' => ['required', 'string'],
            'package_id' => ['required', 'exists:packages,id'],
            'ktp' => ['required', 'image', 'mimes:jpeg,png,jpg'],
        ]);

        $file = $request->file('ktp');
        $fileName = Str::of($file->getClientOriginalName());
        $fileUrl = $file->storeAs('images/ktp', $fileName);

        $sales = Sales::query()->where('user_id', Auth::user()->id)->first();
        $sales_id = $sales->id;

        $customers = Customer::create([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'package_id' => $request->package_id,
            'sales_id' => $sales_id,
            'ktp' => $fileUrl,
        ]);

        try {
            return $responseFormatter->success($customers, 'Berhasil Ditambahkan!', 201);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal Ditambahkan!', 400);
        }
    }

    public function update(Customer $idCustomer, Request $request, ResponseFormatter $responseFormatter)
    {
        $request->validate([
            'name' => ['sometimes', 'string'],
            'alamat' => ['sometimes', 'string'],
            'telp' => ['sometimes', 'string'],
            'package_id' => ['sometimes', 'exists:packages,id'],
            'ktp' => ['sometimes', 'image', 'mimes:jpeg,png,jpg'],
        ]);

        if ($request->hasFile('ktp')) {
            $file = $request->file('ktp');
            $fileName = Str::of($file->getClientOriginalName());
            Storage::delete($idCustomer->ktp);
            $fileUrl = $file->storeAs('images/ktp', $fileName);
        } else {
            $fileUrl = $idCustomer->ktp;
        }

        $sales = Sales::query()->where('user_id', Auth::user()->id)->first();
        $sales_id = $sales->id;

        $idCustomer->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'package_id' => $request->package_id,
            'sales_id' => $sales_id,
            'ktp' => $fileUrl,
        ]);

        try {
            return $responseFormatter->success($idCustomer, 'Berhasil Diubah!', 200);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal Diubah!', 400);
        }
    }

    public function destroy(Customer $idCustomer, ResponseFormatter $responseFormatter)
    {
        $idCustomer->delete();
        Storage::delete($idCustomer->ktp);

        try {
            return $responseFormatter->success('Berhasil Dihapus!', 202);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal Dihapus!', 400);
        }
    }
}
