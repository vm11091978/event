@extends('admin')

@section('content')

<!-- extends('admin') -->
<div class="mt-3">
	<!-- blank-page -->
	<h2 class="font-semibold text-gray-800">Страница управления мероприятиями</h2>
	<div class="col-md-4">
		<a class="btn btn-primary" type="submit" data-toggle="modal" data-target="#myModal_event">+ Добавить мероприятие</a>
	</div>

	<!-- Begin: table -->
	<div class="well">
		<table class="table">
			<thead>
				<tr>
					<th class="text-center">ID</th>
					<th class="text-center">Название</th>
					<th class="text-center">Дата проведения</th>
					<th class="text-center">Описание</th>
					<th class="text-center">Опубл.</th>
					<th class="text-center">Категория</th>
					<th class="text-center">Дата &nbsp;&nbsp;создания&nbsp;&nbsp;</th>
					<th class="text-center">Дата обновления</th>
					<th class="text-center">Действия</th>
				</tr>
			</thead>

			<tbody>
			@foreach ($events as $n)
				<tr>
					<td class="text-center"><strong>{!! $n->id !!}</strong></td>
					<td class="text-center">{{ $n->name }}</td>
					<td class="text-center">{{ date('j F, H:i', strtotime($n->date)) }}</td>
					<td class="text-left">
					@if (mb_strlen( $n->description ) > 100)
						{{ mb_substr($n->description, 0, 97, 'utf-8') }}...
					@else
						{{ $n->description }}
					@endif
					</td>
					<td class="text-center">{{ $n->active ? 'да' : 'нет' }}</td>
					<td class="text-center">{{ $n->categories->pluck('name')->implode(', ') }}</td>
					<td class="text-center">{{ $n->created_at }}</td>
					<td class="text-center">{{ $n->updated_at }}</td>
					<td class="text-center">
						<div class="row">
							<div class="col-md-6">
								<a class="btn btn-success" type="submit" data-toggle="modal" data-target="#myModal_event_{{ $n->id }}">Обновить</a>
							</div>
							<div class="col-md-6">
								<a class="btn btn-danger" data-toggle="modal" data-target="#delete_event_{{ $n->id }}">Удалить</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<!-- End: table -->

	<!-- Begin: modal Add event -->
	<div id="myModal_event" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" >
				<center>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="modal-title">Добавить мероприятие</h3><br>
					</div>
				</center>
				<div class="modal-body" >
					<form class="form-horizontal" method="POST" action="admin-events">
					{{ csrf_field() }}

						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Название</label>
							<div class="col-sm-8">
								<input id="name" type="text" name="name" class="form-control" placeholder="Enter Name" required />
							</div>
						</div>
						<div class="form-group">
							<label for="date" class="col-sm-3 control-label">Дата&nbsp;проведения</label>
							<div class="col-sm-8">
								<input id="date" type="datetime-local" name="date" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-sm-3 control-label">Описание</label>
							<div class="col-sm-8">
								<textarea id="description" name="description" rows="4" style="resize: vertical" class="form-control" placeholder="Enter Description" ></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="active" class="col-sm-3 control-label">Опубликовано</label>
							<div class="col-sm-8">
								<input id="active" type="checkbox" name="active" class="checkbox" checked value="1" />
							</div>
						</div>
						<div class="form-group">
							<label for="categories" class="col-sm-3 control-label">Категория(и)</label>
							<div class="col-sm-8">
								<select id="categories" multiple="multiple" size="4" name="categories[]">
									<option disabled>Выберите категорию(и) мероприятия:</option>
									@foreach ($categories as $category)
										<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<br>
						<input class="btn btn-primary" type="submit" value="Submit">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-hover btn-primary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End: modal Add event -->

	@foreach ($events as $n)
	<!-- Begin: modal Update event -->
	<div id="myModal_event_{{ $n->id }}" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" >
				<center>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="modal-title">Редактировать мероприятие</h3><br>
					</div>
				</center>
				<div class="modal-body" >
					<form class="form-horizontal" method="POST" action="admin-events/{{ $n->id }}">
					{{ csrf_field() }}
					{{ method_field('PATCH') }}
					
						<div class="form-group">
							<label for="name2" class="col-sm-3 control-label">Название</label>
							<div class="col-sm-8">
								<input id="name2" type="text" name="name" class="form-control" value="{{ $n->name }}" required />
							</div>
						</div>
						<div class="form-group">
							<label for="date2" class="col-sm-3 control-label">Дата&nbsp;проведения</label>
							<div class="col-sm-8">
								<input id="date2" type="datetime-local" name="date" class="form-control" value="{{ $n->date }}" required />
							</div>
						</div>
						<div class="form-group">
							<label for="description2" class="col-sm-3 control-label">Описание</label>
							<div class="col-sm-8">
								<textarea id="description2" name="description" rows="4" style="resize: vertical" class="form-control">{{ $n->description }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="active2" class="col-sm-3 control-label">Опубликовано</label>
							<div class="col-sm-8">
							@if ($n->active)
								<input id="active2" type="checkbox" name="active" class="checkbox" checked value="1" />
							@else
								<input id="active2" type="checkbox" name="active" class="checkbox" value="1" />
							@endif
							</div>
						</div>
						<div class="form-group">
							<label for="categories" class="col-sm-3 control-label">Категория(и)</label>
							<div class="col-sm-8">
								<select id="categories" multiple="multiple" size="4" name="categories[]">
									<option disabled>Выберите категорию(и) мероприятия:</option>
									@foreach ($categories as $category)
										@if (in_array($category->id, $n->categories->pluck('id')->toArray()))
											<option selected value="{{ $category->id }}">{{ $category->name }}</option>
										@else
											<option value="{{ $category->id }}">{{ $category->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<br>
						<input class="btn btn-primary" type="submit" value="Submit">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-hover btn-primary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End: modal Update event -->

	<!-- Begin: modal Delete event -->
	<div id="delete_event_{{ $n->id }}" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" >
				<center>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="modal-title">Delete Event Confirmation</h3><br>
					</div>
				</center>
				<div class="modal-body" >
					<p>
						Are you sure want to Delete this event?
					</p>
					<form class="form-horizontal" method="POST" action="admin-events/{{ $n->id }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<br>
						<div class="row">
							<div class="col-md-9">
								<button type="button" class="btn btn-hover btn-primary btn-sm" data-dismiss="modal">Cancel</button>
							</div>
							<div class="col-md-3">
								<input class="btn btn-hover btn-danger btn-sm" type="submit" value="Yes, Delete">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- End: modal Delete event -->
	@endforeach
</div>

@endsection