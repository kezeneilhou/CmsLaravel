<?php

namespace Kezeneilhou\CmsLaravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class QuillUploadController extends BaseController
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $url = Storage::url($path);

            return response()->json(['url' => $url]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalExtension = $file->getClientOriginalExtension();  // Example: 'pdf'
            $mimeType = $file->getMimeType(); // Example: 'application/pdf'

            // Determine if the file extension matches the MIME type
            if ($this->isValidExtension($mimeType, $originalExtension)) {
                // Rename the file to ensure it has the correct extension
                $newFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $originalExtension;
            } else {
                // Fallback: Force correct extension based on MIME type (for safety)
                $newFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . $this->getExtensionForMimeType($mimeType);
            }
            $path = $request->file('file')->storeAs('files', $newFileName, 'public');
            $url = Storage::url($path);

            return response()->json(['url' => $url]);
        }
        return response()->json(['error' => 'File not found.'], 400);
    }

    // Check if the file extension matches the MIME type
    private function isValidExtension($mimeType, $extension) {
        $mimeTypeMap = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'text/plain' => 'txt'
        ];

        return isset($mimeTypeMap[$mimeType]) && $mimeTypeMap[$mimeType] === strtolower($extension);
    }

    // Get the correct extension based on MIME type
    private function getExtensionForMimeType($mimeType) {
        $mimeTypeMap = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'text/plain' => 'txt'
        ];

        return $mimeTypeMap[$mimeType] ?? '';
    }


}
