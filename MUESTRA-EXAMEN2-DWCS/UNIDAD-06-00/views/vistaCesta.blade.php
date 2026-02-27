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
                <h5 class="card-title"><i class="fa fa-shopping-cart mr-2"></i>Carrito</h5>

                @if ( count($listado) == 0 )
                    <p class='card-text'>Carrito Vacio</p>
                @else  
                    <p class='card-text'>
                    <ul>
                    @foreach($listado as $k => $v) 
                        <li>{{$v[0]}}, PVP ({{$v[1]}}) €.</li>
                    @endforeach  
                    </ul></p>
                    <hr style='border:none; height:2px; background-color: white'>
                    <p class='card-text'><b>Total:</b><span class='ml-3'>{{$total}} (€)</span></p>
                @endif
                <a href="listado.php" class="btn btn-primary mr-2">Volver</a>
                <a href="pagar.php" class="btn btn-danger">Pagar</a>
            </div>
        </div>
    </div>
@endsection