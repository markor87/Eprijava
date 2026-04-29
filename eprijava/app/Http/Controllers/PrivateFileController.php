<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrivateFileController extends Controller
{
    public function serve(Request $request, string $path)
    {
        $user = $request->user();

        if (str_contains($path, '..')) {
            abort(403);
        }

        $attachment = Attachment::where('path', $path)->first();

        if (!$attachment) {
            abort(404);
        }

        $isSuperAdmin = $user->hasRole('super_admin');
        $isOwner      = $attachment->user_id === $user->id;

        if (!$isSuperAdmin && !$isOwner) {
            abort(403);
        }

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->response($path);
    }
}
