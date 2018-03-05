<?php
namespace App;

use illuminate\Database\Eloquent\Model;
use App\Support\FilterPaginateOrder;
use Spatie\Activitylog\Traits\LogsActivity;

class ArtikelPenulis extends Model {

    use FilterPaginateOrder, LogsActivity;
    
    protected $table = 'artikelPenulis';

    protected static $logFillable = true;
    
    public static $rules = [
        'id_cu' => 'required',
        'name' => 'required',
        'deskripsi' => 'required|min:5'
    ];
    
    protected $fillable = ['id_cu','id_staf','name','deskripsi','gambar'];

    protected $filter = [
        'id','id_cu','name','deskripsi','gambar','utamakan','created_at'
    ];

    public function getNameAttribute($value){
        return !empty($value) ? $value : '-';
    }

    public function artikel(){
        return $this->hasMany('App\Artikel','id_artikel_penulis','id')
                    ->where('status','=','1')
                    ->orderBy('created_at','desc')
                    ->take(3);
    }

    public static function initialize()
    {
        return [
            'id_cu' => '0','id_staf' => '0', 'name' => '', 'deskripsi' => '','gambar' => '',
        ];
    }

    public function hasArtikel()
    {
        return $this->hasMany('App\Artikel','id_artikel_penulis','id');
    }

    public function CU()
    {
        return $this->belongsTo('App\CU','id_cu','id')->select('id','name');
    }
}