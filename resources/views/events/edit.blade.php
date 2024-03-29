@extends('layouts.main')

@section('title', 'Editando: ' . $event->title)

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
	<h1>
		Editando: {{ $event->title }}
	</h1>
	<form action="/events/update/{{ $event->id }}" method="POST" enctype="multipart/form-data">
	@csrf
    @method('PUT')
		<div class="form-group">
			<label for="image ">
				imagem:
			</label>
			<input type="file" id="image" name="image" class="from-control-file">
            <img src="/assets/imgEvents/{{ $event->image }}" alt="{{ $event->title }}" class="img-preview">
		</div>
		<div class="form-group">
			<label for="title">
				Aula:
			</label>
			<input type="text" class="form-control" id="title" name="title" placeholder="Titulo da Aula" value="{{ $event->title }}">
		</div>
		<div class="form-group">
			<label for="date">
				Data da Aula:
			</label>
			<input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d', strtotime($event->date));}}">
		</div>
		<div class="form-group">
			<label for="classroom">
				Sala Nº:
			</label>
			<input type="text" class="form-control" id="classroom" name="classroom" placeholder="Local da Aula" value="{{ $event->classroom}}">
		</div>
		<div class="form-group">
			<label for="private">
				Aula é privada?
			</label>
			<select name="private" id="private" class="form-control">
				<option value="0">
					Não
				</option>
				<option value="1" {{ $event->private == 1 ? "selected='selected'" : ""}}>
					Sim
				</option>
			</select>
		</div>
		<div class="form-group">
			<label for="description">
				Atividades da Aula:
			</label>
			<textarea name="description" id="description" class="form-control" placeholder="Oque vai acontecer na aula?">
                {{ $event->description }}
            </textarea>
		</div>
		<div class="form-group">
			<label for="items">
				Recursos de infraestrutura:
			</label>
			<div class="form-group">
				<input type="checkbox" name="items[]" value="Data Show"> Data Show				
			</div>
			<div class="form-group">
				<input type="checkbox" name="items[]" value="Computadores"> Computadores
			</div>
			<div class="form-group">
				<input type="checkbox" name="items[]" value="Caixas de Som"> Caixas de Som
			</div>
		</div>
		<input type="submit" class="btn btn-primary" value="Editar Aula">
	</form>
</div>

@endsection