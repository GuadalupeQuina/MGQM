<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\precios;
use App\producto;


class ctrlPrecios extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            $query=trim($request->get('searchText'));
            
            $precio=precios::join('producto','producto.id', '=', 'precio.idProducto')
            ->select('precio.precio', 
            'precio.fecha',  
            'precio.id', 
            'producto.nombre', 
            'producto.descripcion', 
            'producto.foto',  
            'producto.precio')->where('producto.nombre','LIKE','%'.$query.'%')
            ->paginate(10);
        }
        return view('modules.precios.table',['precios'=>$precio,'searchText'=>$query ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos=producto::all();
        return view('modules.precio.frmCreate',['productos'=>$productos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $precio = new precios();
        $precio->precio = $request->get('precio');
        $precio->fecha = $request->get('fecha');
        $precio->idProducto = $request->get('idProducto');
        $precio->save();

        return redirect('/precios')->with('success','el registro se ha guardado correctamente');
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
        $precio=precios::join('producto','producto.id', '=', 'precio.idProducto')
        ->select('precio.precio',  
        'precio.fecha')->where('precio.id','=',$id)
        ->get();
        $productos=producto::all();
        return view('modules.precios.frmUpdate',['precios'=>$precio, 'producto'=>$productos]);
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
        $precio = precios::findOrFail($id);
        $precio->precio = $request->get('precio');
        $precio->fecha = $request->get('fecha');
        $precio->idProducto = $request->get('idProducto');
        
        $precio->update();
        
        return redirect('/precios')->with('info','el registro se ha guardado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $precios = precios::findOrFail($id);
        $precio->delete();

        return redirect('/precios')->with('danger','el registro se ha guardado correctamente');
    }
}
