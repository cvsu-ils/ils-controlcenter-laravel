<?php

namespace App\Services;

class AccessionNumberService {

    public function generate($prefix, $id) {
        $accession_number = $prefix . '-' .str_pad($id, 8, '0', STR_PAD_LEFT);
        return $accession_number;
    }
}