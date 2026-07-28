<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Stamp extends BaseController {
    
    public string $uploadFolder = ROOTPATH . 'public/uploads/';

    public function upload(): ResponseInterface {

        // Models
        $MyModel = new \App\Models\StampModel();

        try {

            $file = request()->getFile('file');
            $number = request()->getPost('number');
            $journalId = request()->getPost('journal_id');

            if (!$file || !$file->isValid()) { throw new \Exception('No se recibió un archivo válido'); }
            if (!in_array($file->getMimeType(), STAMP_ALLOWED_FORMATS)) { throw new \Exception('Formato de imagen no permitido: ' . $file->getMimeType()); }

            $number = (int) $number;
            if ($number < 1) { throw new \Exception('Número de celda inválido.'); }

            $journal = (new \App\Models\JournalModel())->where('id', $journalId)->first();
            if (!$journal || $journal->status !== 'STARTED') { throw new \Exception('Journal no encontrado o no activo'); }

            // Si ya existe un stamp para esa celda, se bloquea (no se sobreescribe)
            $existing = $MyModel->where('id_journal', $journalId)->where('number', $number)->first();
            if ($existing && $existing->image) { throw new \Exception('Esta celda ya tiene una imagen asignada'); }

            $uploadDir = $this->uploadFolder . $journalId;
            $thumbDir  = $uploadDir . '/thumbs';

            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }
            if (!is_dir($thumbDir)) { mkdir($thumbDir, 0755, true); }

            $filename = $number . '.webp';
            $uploadPath = $uploadDir . '/' . $filename;
            $thumbPath  = $thumbDir . '/' . $filename;

            // Crear imagen GD desde el archivo subido
            $gdImage = $this->createImageFromFile($file->getTempName(), $file->getMimeType());
            if (!$gdImage) { throw new \Exception('Error al procesar la imagen'); }

            // Guardar original (redimensionado a 420×500 máximo, manteniendo ratio)
            $origW = imagesx($gdImage);
            $origH = imagesy($gdImage);
            $targetFullW = 420;
            $targetFullH = 500;
            $fullScale = min($targetFullW / $origW, $targetFullH / $origH, 1);
            $fullW = (int) round($origW * $fullScale);
            $fullH = (int) round($origH * $fullScale);

            $fullCanvas = imagecreatetruecolor($fullW, $fullH);
            imagealphablending($fullCanvas, false);
            imagesavealpha($fullCanvas, true);
            imagecopyresampled($fullCanvas, $gdImage, 0, 0, 0, 0, $fullW, $fullH, $origW, $origH);
            imagewebp($fullCanvas, $uploadPath, 85);
            imagedestroy($fullCanvas);

            // Guardar thumbnail (redimensionar toda la imagen a 210×250)
            $thumbW = 210;
            $thumbH = 250;

            $thumbCanvas = imagecreatetruecolor($thumbW, $thumbH);
            imagealphablending($thumbCanvas, false);
            imagesavealpha($thumbCanvas, true);
            imagecopyresampled($thumbCanvas, $gdImage, 0, 0, 0, 0, $thumbW, $thumbH, $origW, $origH);
            imagewebp($thumbCanvas, $thumbPath, 85);
            imagedestroy($thumbCanvas);
            imagedestroy($gdImage);

            // Guardar/actualizar registro en DB
            $data = [
                'id_journal' => $journalId,
                'number'     => $number,
                'image'      => $filename,
                'ip'         => request()->getIPAddress(),
                'user_agent' => request()->getUserAgent()->getAgentString(),
                'status'     => 1,
            ];

            if ($existing) {
                $MyModel->update($existing->id, $data);
                $stampId = $existing->id;
            } else {
                $stampId = $MyModel->insert($data);
            }

            $thumbUrl = base_url('public/uploads/' . $journalId . '/thumbs/' . $filename);
            $fullUrl  = base_url('public/uploads/' . $journalId . '/' . $filename);

            return response()->setJSON([
                'success'   => true,
                'stamp_id'  => $stampId,
                'thumb_url' => $thumbUrl,
                'full_url'  => $fullUrl,
            ]);

        } catch (\Exception $e) {
            return response()->setJSON([ 'success' => false, 'message' => $e->getMessage() ]);
        }

    }

    private function createImageFromFile(string $filePath, string $mimeType)/*: \GdImage|false*/ {
        return match ($mimeType) {
            'image/jpeg' => @imagecreatefromjpeg($filePath),
            'image/png'  => @imagecreatefrompng($filePath),
            'image/gif'  => @imagecreatefromgif($filePath),
            'image/webp' => @imagecreatefromwebp($filePath),
            'image/bmp'  => @imagecreatefrombmp($filePath),
            default      => false,
        };
    }

}
