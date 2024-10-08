<?php

namespace App\Http\Controllers\API\Checklist;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistRequest;
use App\Models\Checklist;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $data = Checklist::where('user_id', $user['id'])->get();
            if ($data->isNotEmpty()) {
                return $this->success($data);
            } else {
                return $this->error(
                    '',
                    'Not found',
                    404
                );
            }
        } catch (\Throwable $th) {
            return $this->internalServerError();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChecklistRequest $request)
    {
        $request->validated();
        $user = $request->user();

        $data = [
            "user_id" => $user['id'],
            "name" => $request->name
        ];

        $data = Checklist::create($data);
        if ($data) {
            return $this->success(
                '',
                'Berhasil Upload Qr Dropbox'
            );
        } else {
            return $this->error(
                '',
                'something went wrong try again',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $user = $request->user();
        $data = Checklist::where('user_id', $user->id)->find($id);
        if ($data) {
            $data->delete();
            return $this->success(
                "",
                'berhasil delete data'
            );
        } else {
            return $this->error(
                '',
                "Not found",
                404

            );
        }
    }
}
