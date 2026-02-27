@extends('plantillas.plantilla1')
@section('titulo')
    {{$titulo}}
@endsection
@section('encabezado')
    {{$encabezado}}
@endsection
@section('contenido')
    <div class="container mt-3">
        <div class="card text-white bg-success mb-3 m-auto" style="width:40rem">
            <div class="card-body">
                <h5 class="card-title"><i class="fa fa-shopping-cart mr-2"></i>Tiendas con producto</h5>
                @if ( count($tiendas) == 0 )
                    <p class='card-text'>Ninguna tienda tiene el producto</p>
                @else  
                    <p class='card-text'>
                    <ul>
                    @foreach($tiendas as $tienda) 
                        <li>{{$tienda->nombre}} (telefono: {{$tienda->tlf}}): {{$tienda->unidades}} unidades</li>
                    @endforeach  
                    </ul></p>
                @endif
                <a href="listado.php" class="btn btn-primary mr-2">Volver</a>
            </div>
        </div>
    </div>
@endsection