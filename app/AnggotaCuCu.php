<?php
namespace App;

use illuminate\Database\Eloquent\Model;
use App\Support\FilterPaginateOrder;
use Spatie\Activitylog\Traits\LogsActivity;

class AnggotaCuCu extends Model {

    use FilterPaginateOrder, LogsActivity;

    protected $table = 'anggota_cu_cu';

    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'anggota_cu_id','cu_id','no_ba', 'tanggal_masuk'
    ];

    protected $filter = [
        'anggota_cu_id','cu_id','no_ba','tanggal_masuk','created_at','updated_at'
    ];

    public static function initialize()
    {
        return [
            'anggota_cu_id' => '','cu_id' => '','no_ba' => '','tanggal_masuk' => ''
        ];
    }

    public function cu()
    {
        return $this->belongsTo('App\Cu','cu_id','id');
    }

    public function jalinanKlaim()
    {
        return $this->belongsTo('App\JalinanKlaim','id','anggota_cu_cu_id');
    }

}