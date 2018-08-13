<?php
namespace App\Http\Controllers;

use DB;
use App\DiklatTempat;
use App\Support\Helper;
use Illuminate\Http\Request;
use File;
use Image;

class DiklatTempatController extends Controller{

	protected $imagepath = 'images/tempat/';
	protected $width = 200;
	protected $height = 200;
	protected $message = "Tempat kegiatan";

	public function index()
	{
		$table_data = DiklatTempat::with('Villages','Districts','Regencies','Provinces')->filterPaginateOrder();

		return response()
		->json([
			'model' => $table_data
		]);
	}

	public function get()
	{
		$table_data = DiklatTempat::select('id','name')->orderby('name','asc')->get();

		return response()
			->json([
				'model' => $table_data
			]);
	}
	
	public function getId($id)
	{
		$table_data = DiklatTempat::where('id_regencies',$id)->select('id','name')->orderby('name','asc')->get();

		return response()
			->json([
				'model' => $table_data
			]);
  }

	public function create()
	{
		return response()
			->json([
					'form' => DiklatTempat::initialize(),
					'rules' => DiklatTempat::$rules,
					'option' => []
			]);
	}

	public function store(Request $request)
	{
		$this->validate($request,DiklatTempat::$rules);

		$name = $request->name;

		// processing single image upload
		if(!empty($request->gambar))
			$fileName = Helper::image_processing($this->imagepath,$this->width,$this->height,$request,'');
		else
			$fileName = '';

		$kelas = DiklatTEmpat::create($request->except('gambar') + [
			'gambar' => $fileName
		]);
		
		return response()
			->json([
				'saved' => true,
				'message' => $this->message . $name . ' berhasil ditambah',
				'id' => $kelas->id
			]);	
	}

	public function edit($id)
	{
		$kelas = DiklatTempat::with('Villages','Districts','Regencies','Provinces')->findOrFail($id);

		return response()
				->json([
						'form' => $kelas,
						'option' => []
				]);
	}

	public function update(Request $request, $id)
	{
		$this->validate($request,DiklatTempat::$rules);

		$name = $request->name;

		$kelas = DiklatTempat::findOrFail($id);

		// processing single image upload
		if(!empty($request->gambar))
			$fileName = Helper::image_processing($this->imagepath,$this->width,$this->height,$request,$kelas);
		else
			$fileName = '';

		$kelas->update($request->except('gambar') + [
			'gambar' => $fileName
		]);	
		
		return response()
			->json([
				'saved' => true,
				'message' => $this->message . $name . ' berhasil diubah',
				'id' => $kelas->id
			]);	
	}

	public function destroy($id)
	{
		$kelas = DiklatTempat::findOrFail($id);
		$name = $kelas->name;

		if(!empty($kelas->gambar)){
			File::delete($path . $kelas->gambar . '.jpg');
			File::delete($path . $kelas->gambar . 'n.jpg');
		}

		$kelas->delete();

		return response()
			->json([
				'deleted' => true,
				'message' => $this->message . $name . 'berhasil dihapus'
			]);
	}
}