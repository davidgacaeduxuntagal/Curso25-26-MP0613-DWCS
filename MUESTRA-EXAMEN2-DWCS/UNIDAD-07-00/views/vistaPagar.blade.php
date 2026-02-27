@extends('plantillas.plantilla1')
@section('titulo')
    {{$titulo}}
@endsection
@section('encabezado')
    {{$encabezado}}
@endsection
@section('contenido')
    <div class="container">
        <p class="font-weight-bold">Pedido realizado Correctamente</p>
        <a href="listado.php" class="btn btn-info mt-3">Hacer otra Compra</a>
    </div>
@endsection