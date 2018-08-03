<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pacientes;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
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
        //
    }
    
      protected function validator(array $data)
    {   
        $messages = [
            'required' => '*Campo obrigatório',
            'email' => 'Insira um email válido'
        ];
        

        return Validator::make($data, [
            'nome' => 'required',
            'telefone' => 'required',
            'data-nascimento' => 'required',
            'cpf' => 'required',
            'rg' => 'required',
            'email' => 'required|email|max:255',
            'celular' => 'required',
            'observacao' => 'required',
            'sexo' => 'required'
        ], $messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validator($request->all())->validate();

        $input = $request->all();
        $input['user_id'] = Auth::id();
        
        Pacientes::create($input);
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
}
