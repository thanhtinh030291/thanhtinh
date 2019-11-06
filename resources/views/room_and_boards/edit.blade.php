@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Room And Board
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($roomAndBoard, ['route' => ['roomAndBoards.update', $roomAndBoard->id], 'method' => 'patch']) !!}

                        @include('room_and_boards.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection