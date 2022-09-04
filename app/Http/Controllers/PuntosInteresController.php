<?php

namespace App\Http\Controllers;

use App\Models\PuntosInteres;
use App\Models\ServiciosEsenciales;
use App\Models\Telefonos;
use App\Models\Espectaculos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class PuntosInteresController extends Controller
{
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'Nombre'       => 'required',
            'Departamento' => 'required',
            'Ciudad'       => 'required',
            'Direccion'    => 'required',
        ], [
            'Nombre.required'       => 'El nombre es obligatorio',
            'Departamento.required' => 'El Departamento es obligatorio',
            'Ciudad.required'       => 'La Ciudad es obligatorio',
            'Direccion.required'    => 'La direccion es obligatorio',
        ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $puntosInteres               = new PuntosInteres();
        $puntosInteres->Nombre       = $request->Nombre;
        $puntosInteres->Departamento = $request->Departamento;
        $puntosInteres->Ciudad       = $request->Ciudad;
        $puntosInteres->Direccion    = $request->Direccion;
        $puntosInteres->HoraDeApertura = $request->HoraDeApertura;
        $puntosInteres->HoraDeCierre = $request->HoraDeCierre;
        $puntosInteres->Facebook     = $request->Facebook;
        $puntosInteres->Instagram    = $request->Instagram;
        $puntosInteres->Descripcion  = $request->Descripcion;
        $puntosInteres->Imagen       = $request->Imagen;
        $puntosInteres->save();
        $PuntosDeInteresDetallado  = json_decode($request->InformacionDetalladaPuntoDeInteres);
        $id = PuntosInteres::latest('id')->first();
        $this->AltaDeTelefono($id->id,$request->Telefono);
        if ($PuntosDeInteresDetallado->Op === 'ServicioEsencial') {
            return $this->AltaDeServicio($id->id, $PuntosDeInteresDetallado->Tipo);
        }
        if ($PuntosDeInteresDetallado->Op === 'Espectaculos') {
            return $this->AltaDeEspectaculos($id->id,$PuntosDeInteresDetallado->Artista,$PuntosDeInteresDetallado->PrecioEntrada,$PuntosDeInteresDetallado->Tipo);
        }
        return response()->json([
            "codigo"    => "200",
            "respuesta" => "Se ingreso con exito",
        ]);

    }
    public function AltaDeServicio($IdPuntoDeInteres, $TipoDetallado)
    {
        $servicio                   = new ServiciosEsenciales();
        $servicio->puntosinteres_id = $IdPuntoDeInteres;
        $servicio->Tipo             = $TipoDetallado;
        $servicio->save();
        return response()->json([
            "codigo"    => "200",
            "respuesta" => "Se ingreso con exito",
        ]);
    }
    public function AltaDeEspectaculos($IdPuntoDeInteres,$Artista,$PrecioEntrada,$tipoDeServicio)
    {
        $Espectaculo                   = new Espectaculos();
        $Espectaculo->puntosinteres_id = $IdPuntoDeInteres;
        $Espectaculo->Artista          = $Artista;
        $Espectaculo->PrecioEntrada    = $PrecioEntrada;
        $Espectaculo->Tipo             = $tipoDeServicio;
        $Espectaculo->save();
        return response()->json([
            "codigo"    => "200",
            "respuesta" => "Se ingreso con exito",
        ]);
    }
    public function AltaDeTelefono($id,$Telefonos){
        $Telefono=new Telefonos();
        $Telefono->puntosinteres_id=$id;
        $Telefono->Telefono=$Telefonos;
        $Telefono->save();
    }

    public function ListarPuntosDeInteres(Request $request, $Categoria)
    {
        if($Categoria==='PuntosDeInteres'){
            $PuntosDeInteres=PuntosInteres::paginate(10);
            return response() ->json($PuntosDeInteres);
        }
        $puntosInteres = DB::table('puntosinteres')
        ->Join($Categoria,'puntosinteres.id','=','puntosinteres_id')
        ->paginate(10);
        
        return response() ->json($puntosInteres);

    }

    private function buscarServicioEscencial($Tipo){
            $categoria = 'servicios_esenciales';
            $puntosInteres = DB::table('puntosinteres')
                ->Join($categoria, 'puntosinteres.id', '=', 'puntosinteres_id')
                ->where($categoria . '.tipo', '=', $Tipo)
                ->paginate(10);

            return response()->json($puntosInteres);

    }

    public function update(Request $request, $IdPuntoDeInteres)
    {
        $puntosInteres               = PuntosInteres::findOrFail($IdPuntoDeInteres);
        $puntosInteres->Nombre       = $request->Nombre;
        $puntosInteres->Departamento = $request->Departamento;
        $puntosInteres->Ciudad       = $request->Ciudad;
        $puntosInteres->Direccion    = $request->Direccion;
        $puntosInteres->HoraDeApertura = $request->HoraDeApertura;
        $puntosInteres->HoraDeCierre = $request->HoraDeCierre;
        $puntosInteres->Facebook     = $request->Facebook;
        $puntosInteres->Instagram    = $request->Instagram;
        $puntosInteres->Descripcion  = $request->Descripcion;
        $puntosInteres->Imagen       = $request->Imagen;
        $puntosInteres->save();

        return response()->json([
            "codigo"    => "200",
            "respuesta" => "Se modifico con exito",
        ]);
    }
    public function ModificarTelefonos($id,$Telefono){
        
    }
    public function destroy(Request $request,$IdPuntoDeInteres,$Categoria)
    {
        if($Categoria==='PuntosDeInteres'){
            $p = PuntosInteres::findOrFail($IdPuntoDeInteres);
            $p->delete();
        return response()->json([
            "codigo"    => "200",
            "respuesta" => "Se elimino con exito",
        ]);
        }
        if($Categoria==='servicios_esenciales'){
            $p = ServiciosEsenciales::findOrFail($IdPuntoDeInteres);
            $p->delete();
        return response()->json([
            "codigo"    => "200",
            "respuesta" => "Se elimino con exito",
        ]);
        }
    }
}
