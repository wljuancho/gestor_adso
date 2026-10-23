<?php
namespace App\Http\Controllers;
use App\Models\Aprendiz;
use Illuminate\Http\Request;
class AprendizController extends Controller
{
 public function index(Request $request)
 {
 $busqueda = $request->query('buscar');
 $consulta = Aprendiz::query();

 if ($busqueda) {
 $consulta->where(function ($query) use ($busqueda) {
 $query->where('nombre', 'like', "%{$busqueda}%")
 ->orWhere('documento', 'like', "%{$busqueda}%")
 ->orWhere('correo', 'like', "%{$busqueda}%");
 });
 }

 $totalAprendices = Aprendiz::count();
 $aprendices = $consulta->latest()->paginate(8)->withQueryString();
 return view('aprendices.index', compact('aprendices', 'busqueda', 'totalAprendices'));
 }
 public function create()
 {
 return view('aprendices.create');
 }
 public function store(Request $request)
 {
 $data = $request->validate([
 'nombre' => ['required','string','max:120'],
 'documento' => ['required','string','max:40','unique:aprendices,documento'],
 'correo' => ['required','email','max:120','unique:aprendices,correo'],
 'ficha_id' => ['nullable','integer'],
 ]);
 Aprendiz::create($data);
 return redirect()->route('aprendices.index')->with('ok','Aprendiz creado');
 }
 public function show(Aprendiz $aprendiz)
 {
 abort(404);
 }
 public function edit(Aprendiz $aprendiz)
 {
 abort(404);
 }
 public function update(Request $r, Aprendiz $aprendiz)
 {
 abort(404);
 }
 public function destroy(Aprendiz $aprendiz)
 {
 abort(404);
 }
}
