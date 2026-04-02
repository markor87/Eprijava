<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrivateFileController extends Controller
{
    public function serve(Request $request, string $path)
    {
        $user = $request->user();

        // Extract user ID from path (second segment: e.g. certificate-attachments/3/file.pdf)
        $segments = explode('/', $path);
        $ownerIdFromPath = isset($segments[1]) ? (int) $segments[1] : null;

        $isSuperAdmin = $user->hasRole('super_admin');
        $isOwner = $ownerIdFromPath && $ownerIdFromPath === $user->id;

        if (!$isSuperAdmin && !$isOwner) {
            abort(403);
        }

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->response($path);
    }
}
