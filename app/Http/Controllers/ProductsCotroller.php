<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
//llamamos a nuestro modelo de los productos 
use App\Model\Products;
//funcion validator que es propia de laravel
use Validator;
class ProductsCotroller extends Controller
{
    //funcion donde retornamos todos los datos que estan en la tabla productos 
    public function index()
    {
        $products=Products::select("products.*")->get()->toArray();
        return response()->json($products);
    }

    //funcion donde se guardar los productos 
    public function store(Request $request)
    {   //ingreso todos los datos que vienen por el request
         $input=$request->all();
        //hago las validacion del formulario que estoy enviando desde la aplicacion de flutter IOS Y ANDROID
         $validator= Validator::make($input,[
           'name'=>'required|unique:products|max:60',
           'precio'=>'required|numeric',
           'stock'=>'required|numeric',
         ]);

         //hago una condicion que si validatos es igual a falso mande el mensaje de error
         if($validator->fails())
         {
             return response()->json([
                'ok'=>false,
                'error'=>$validator->messages(),
             ]);
         }
         //si el formulario esta correcto y paso todas las validacion entonces se crea un nuevo producto
         try{
            Products::create($input);
            return response()->json([
               "ok"=>true,
               "mensaje"=>"se registro con exito el producto",
            ]);
         }catch(\Exception $ex){
             return response()->json([
                 "ok"=>false,
                 "error"=>$ex->getMessage(),
             ]);

         }         
    }



    //mostrar un producto por el id que se envia por parametro
    public function show($id)
    {
        //hago una consulta y obtengo el producto que coinciden con el id que paso por parametro
        $products= Products::select("products.*")
        ->where("products.id",$id)
        ->first();

        //mando el producto por json
        return response()->json([ 
                 "ok"=>true,
                 "data"=>$products,
        ]);

    }


    //funcion para obtener el id 
    public function update(Request $request, $id)
    {
        $input=$request->all();
         //hago las validacion del formulario que estoy enviando desde la aplicacion de flutter IOS Y ANDROID
         $validator= Validator::make($input,[
            'name'=>'required|max:60',
            'precio'=>'required|numeric',
            'stock'=>'required|numeric',
          ]);
         //hago una condicion que si validatos es igual a falso mande el mensaje de error
         if($validator->fails())
         {
             return response()->json([
                'ok'=>false,
                'error'=>$validator->messages(),
             ]);
         }

         try{
             $products=Products::find($id);
             // si producto es igual a falso mando un mensaje por json, que el producto no se encontro
             if($products==false)
             {
                 return response()->json([
                   "ok"=>false,
                   "error"=>"producto no encontrado",
                 ]);
             }

             $products->update($input);
             return response()->json([
               "ok"=>true,
               "mensaje"=>"producto modificado corrctamente mario",
             ]);
         }catch(\Exception $ex)
         {
             return response()->json([
                "ok"=>false,
                "error"=>$ex->getMessage(),
             ]);
         }

    }


            //funcion para eliminar un producto
            public function destroy($id)
            {
                try{
                    $products=Products::find($id);
                    if($products==false)
                    {
                        return response()->json([
                            "ok"=>false,
                            "error"=>"producto no encontrado",
                        ]);
                    }

                    $products->delete([]);
                    return response()->json([
                        "ok"=>true,
                        "mensaje"=>"producto eliminado correctamente",
                    ]);
                }catch(\Exception $ex)
                {
                    return response()->json([
                        "ok"=>false,
                        "error"=>$ex->getMessage(),
                    ]);
            }



             }

}
