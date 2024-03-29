@extends('layouts.main')

@section('title', 'Cadrastrar Aulas')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
	<h1>
		Registre sua Aula
	</h1>
	<form action="/events" method="POST" enctype="multipart/form-data">
	@csrf
		<div class="form-group">
			<label for="image ">
				imagem:
			</label>
			<input type="file" id="image" name="image" class="from-control-file">
		</div>
		<div class="form-group">
			<label for="title">
				Aula:
			</label>
			<input type="text" class="form-control" id="title" name="title" placeholder="Titulo da Aula">
		</div>
		<div class="form-group">
			<label for="date">
				Data da Aula:
			</label>
			<input type="date" class="form-control" id="date" name="date">
		</div>
		<div class="form-group">
			<label for="classroom">
				Sala Nº:
			</label>
			<input type="text" class="form-control" id="classroom" name="classroom" placeholder="Local da Aula">
		</div>
		<div class="form-group">
			<label for="private">
				Aula é privada?
			</label>
			<select name="private" id="private" class="form-control">
				<option value="0">
					Não
				</option>
				<option value="1">
					Sim
				</option>
			</select>
		</div>
		<div class="form-group">
			<label for="description">
				Atividades da Aula:
			</label>
			<textarea name="description" id="description" class="form-control" placeholder="Oque vai acontecer na aula?"></textarea>
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
		<input type="submit" class="btn btn-primary" value="Registrar Aula">
	</form>
</div>

@endsection