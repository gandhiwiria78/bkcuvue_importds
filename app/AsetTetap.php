<?php
namespace App;

use DB;
use illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AsetTetap extends Model {
    
    use \Venturecraft\Revisionable\RevisionableTrait;
    use Dataviewer, LogsActivity;

    protected $table = 'aset_tetap';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    
    public static $rules = [
        'name' => 'required',
        'kode'=> 'sometimes|required|unique:aset_tetap',
        'aset_tetap_jenis_id' => 'required',
        'aset_tetap_lokasi_id' => 'required',
        'aktivis_id' => 'required',
        'aktivis_id_pembeli' => 'required',
        'merk' => 'required',
        'tipe' => 'required',
        'kondisi' => 'required',
        'tanggal' => 'required',
        'harga' => 'required',
    ];

    public static function boot()
    {
        parent::boot();
    }
    
    protected $fillable = [
        'aset_id','aktivis_id','kode','name','aset_tetap_jenis_id','merk','tipe','aset_tetap_lokasi_id','kondisi','gambar','aktivis_id_pembeli','tanggal','harga','keterangan'
    ];

    protected $allowedFilters = [
        'aset_id','aktivis_id','kode','name','aset_tetap_jenis_id','merk','tipe','aset_tetap_lokasi_id','kondisi','gambar','created_at','updated_at','aktivis_id_pembeli','tanggal','harga','keterangan',
        
        'aktivs.name','jenis.name','lokasi.name','pembeli.name'
    ];

    protected $orderable = [
        'aset_id','aktivis_id','kode','name','aset_tetap_jenis_id','merk','tipe','aset_tetap_lokasi_id','kondisi','gambar','created_at','updated_at','aktivis_id_pembeli','tanggal','harga','keterangan',
    ];

    public static function initialize()
    {
        return [
            'aset_id' =>'', 'aktivis_id' => '','kode' => '','name' => '','aset_tetap_jenis_id' => '','merk' => '','tipe' => '','aset_tetap_lokasi_id' => '','kondisi' => '','gambar' => '','aktivis_id_pembeli' => '','tanggal' => '','harga' => '','keterangan' => '',
        ];
    }

    public function aset()
    {
        return $this->belongsTo('App\AsetTetap','aset_id','id');
    }

    public function hasAset()
    {
        return $this->hasMany('App\AsetTetap','aset_id','id');
    }

    public function aktivis()
    {
        return $this->belongsTo('App\Aktivis','aktivis_id','id');
    }

    public function pembeli()
    {
        return $this->belongsTo('App\Aktivis','aktivis_id_pembeli','id');
    }

    public function jenis()
    {
        return $this->belongsTo('App\AsetTetapJenis','aset_tetap_jenis_id','id');
    }

    public function lokasi()
    {
        return $this->belongsTo('App\AsetTetapLokasi','aset_tetap_lokasi_id','id');
    }
}