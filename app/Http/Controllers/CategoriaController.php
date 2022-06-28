<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;

use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.registerCat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = new Categoria();
        $categoria->nombreCategoria = $request->input('nombre');
        $categoria->descripcion = $request->input('descripcion');
        $categoria->save();

        $user = Auth::user();
        $info = [
            'IP' => $request->getClientIp(),
            'id usuario' => $user->id,
            'tipo usuario' => $user->tipo,
            'nuevo registro' => $categoria,
        ];
        Log::channel('mydailylogs')->info('Crear Categoria: ', $info);


        return redirect()->route('Allcategoriastable');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function categorias(){
        $categorias = Categoria::all();
        if(auth()->user()){
        if(auth()->user()->tipo == 'Alumno'){
            return view('layouts.categorias',['categorias' => $categorias]);

        }else{
            if(auth()->user()->tipo == 'Admin'){
                return view('backoffice.pages.admin.tablaCategorias',['categorias' => $categorias]);
            }
            return view('backoffice.pages.profesor.categorias',['categorias' => $categorias]);

        }
      }
    return view('layouts.categorias', ['categorias' => $categorias]);
    }

    public function categoriasTable(){
        $categorias = Categoria::all();
        return view('backoffice.pages.admin.tablaCategorias',['categorias'=>$categorias]);
    }
}
