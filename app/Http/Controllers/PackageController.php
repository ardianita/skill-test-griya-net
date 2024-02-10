<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\ResponseFormatter;
use App\Http\Requests\PackageRequest;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(ResponseFormatter $responseFormatter)
    {
        $packages = Package::query()->get();

        try {
            return $responseFormatter->success($packages, 'Berhasil!', 202);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal!', 400);
        }
    }

    public function store(PackageRequest $packageRequest, ResponseFormatter $responseFormatter)
    {
        $data = $packageRequest->validated();
        $packages = Package::create($data);

        try {
            return $responseFormatter->success($packages, 'Berhasil Ditambahkan!', 202);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal Ditambahkan!', 400);
        }
    }

    public function update(Package $idPackage, PackageRequest $packageRequest, ResponseFormatter $responseFormatter)
    {
        $data = $packageRequest->validated();
        $idPackage->update($data);

        try {
            return $responseFormatter->success($idPackage, 'Berhasil Diubah!', 202);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, $idPackage->package . 'Gagal Diubah!', 400);
        }
    }

    public function destroy(Package $idPackage, ResponseFormatter $responseFormatter)
    {
        $idPackage->delete();

        try {
            return $responseFormatter->success('Berhasil Dihapus!', 202);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Gagal Dihapus!', 400);
        }
    }
}
