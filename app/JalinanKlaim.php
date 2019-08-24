<?php
namespace App;

use illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use App\Support\FilterPaginateOrder;
use Spatie\Activitylog\Traits\LogsActivity;

class JalinanKlaim extends Model {

    use Dataviewer, FilterPaginateOrder, LogsActivity;

    protected $table = 'jalinan_klaim';

    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    public static $rules = [
        'anggota_cu_id' => 'required',
        'tipe' => 'required',
        'kategori_penyakit' => 'required',
        'tanggal_mati' => 'required',
        'status_klaim' => 'required'
    ];

    protected $fillable = [
        'anggota_cu_id','tipe','kategori_penyakit', 'tanggal_mati','keterangan_mati','keterangan','status_klaim'
    ];

    protected $allowedFilters = [
        'id','anggota_cu_id','tipe','kategori_penyakit', 'tanggal_mati','keterangan_mati','keterangan','status_klaim','created_at','updated_at',
        
        'anggota_cu.nik','anggota_cu.name','anggota_cu.tanggal_lahir','anggota_cu_cu.no_ba','anggota_cu_cu.tanggal_masuk'
    ];

    protected $orderable = [
        'id','anggota_cu_id','tipe','kategori_penyakit', 'tanggal_mati','keterangan_mati','keterangan','status_klaim','created_at','updated_at',

        'anggota_cu.nik','anggota_cu.name','anggota_cu.tanggal_lahir','anggota_cu_cu.no_ba','anggota_cu_cu.tanggal_masuk'
    ];

    public static function initialize()
    {
        return [
            'anggota_cu_id' => '','tipe' => '','kategori_penyakit' => '','tanggal_mati' => '', 'keterangan_mati' => '', 'keterangan' => '', 'status_klaim' => ''
        ];
    }

    public function anggota_cu()
    {
        return $this->belongsTo('App\AnggotaCu','anggota_cu_id','id');
    }

    public function anggota_cu_cu()
    {
        return $this->hasMany('App\AnggotaCuCu','anggota_cu_id');
    }

}