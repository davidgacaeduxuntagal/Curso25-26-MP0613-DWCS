@extends('plantillas.plantilla2')
@section('titulo')
    {{$titulo}}
@endsection
@section('encabezado')
    {{$encabezado}}
@endsection
@section('contenido')
    @if ( $mensaje != '' )
        <div class="alert alert-success h-100 mt-3">
            <p>{{ $mensaje }}</p>
        </div>
    @endif
    <div class="container mt-3">
        <form class="form-inline" name="vaciar" method="POST" action='{{$action}}'>
            <a href="cesta.php" class="btn btn-success mr-2">Ir a Cesta</a>
            <input type='submit' value='Vaciar Carro' class="btn btn-danger" name="vaciar">
        </form>
        <table class="table table-striped table-dark mt-3">
            <thead>
            <tr class="text-center">
                <th scope="col">Añadir</th>
                <th scope="col">Nombre</th>
                <th scope="col">Añadido</th>
            </tr>
            </thead>
            <tbody>
            @foreach($productos as $item) 
                <tr>
                    <th scope='row' class='text-center'>
                        <form action='{{$action}}' method='POST'>
                            <input type='hidden' name='id' value='{{$item->id}}'>
                            <input type='submit' class='btn btn-primary' name='comprar' value='Añadir'>
                            <a href='tiendas.php?id={{$item->id}}' class='btn btn-info'>Tiendas</a>
                            <input type="button" class='btn btn-warning' value="listarTiendas" onclick="JaxonPrestaciones.listarTiendas({{$item->id}});return false;" />
                        </form>
                    </th>
                    <td>{{$item->nombre}}, Precio: {{$item->pvp}} (€)</td>
                    <td class='text-center'>
                        @if( isset($cesta[$item->id]) ) 
                            <i class='fas fa-check fa-2x'></i>
                        @else
                            <i class='far fa-times-circle fa-2x'></i>
                        @endif
                    <td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection