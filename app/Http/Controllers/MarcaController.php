<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$marcas = Marca::all();
        $marcas = $this->marca->all();
        return response()->json($marcas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $regras = [
            'nome' => 'required|unique:marcas',
            'imagem' => 'required'
        ];

        $callback = [
            'required' => 'O campo :attribute é obrigatório!',
            'nome.unique' => 'O nome da marca já existe!'
        ];

        $request->validate($regras, $callback);

        $store = $this->marca->create($request->all());
        
        return response()->json($store, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marcas = $this->marca->find($id);
        if ($marcas === null)
            return response()->json(['error' => 'Registro não encontrado.'], 404);

        return response()->json($marcas, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);
        if ($marca === null)
            return response()->json(['error' => 'Registro não encontrado/atualizado'], 404);

        $marca->update($request->all());
        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marcas = $this->marca->find($id);
        $nome = $marcas->getAttributes()['nome'];

        if ($marcas === null)
            return response()->json(['error' => 'Não foi possível deletar o registro'], 404);

        $marcas->delete();
        return ['success:' => 'A marca ' . $nome . ' foi deletada com sucesso!'];
    }
}
