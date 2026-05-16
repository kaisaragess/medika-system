<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiObatModel extends Model
{
    protected $table            = 'transaksi_obat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pendaftaran', 'id_obat', 'qty', 'aturan_pakai', 'tagihan_obat'];

    public function getTransaksiLengkap()
    {
        // Kita tambahkan obat.nama_obat dan obat.satuan di bagian select
        return $this->select('transaksi_obat.*, pendaftaran.no_pendaftaran, pasien.nama as nama_pasien, obat.nama_obat, obat.satuan, ')
                    ->join('pendaftaran', 'pendaftaran.id = transaksi_obat.id_pendaftaran')
                    ->join('pasien', 'pasien.id = pendaftaran.id_pasien')
                    ->join('obat', 'obat.id = transaksi_obat.id_obat', 'left') // Tambahkan JOIN ke tabel obat
                    ->orderBy('transaksi_obat.tgl_transaksi', 'DESC')
                    ->findAll();
    }

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
