@extends('admin')

@section('content')

<!-- extends('admin') -->
<div class="mt-3">
	<!-- blank-page -->
	<h2 class="font-semibold text-gray-800">Страница управления пользователями</h2>
	<div class="col-md-4">
		<a class="btn btn-primary" type="submit" data-toggle="modal" data-target="#myModal_user">+ Добавить пользователя</a>
	</div>

	<!-- Begin: table -->
	<div class="well">
		<table class="table">
			<thead>
				<tr>
					<th class="text-center">ID</th>
					<th class="text-center">Имя</th>
					<th class="text-center">Е-майл</th>
					<th class="text-center">Е-майл подтверждён?</th>
					<th class="text-center">Юзер активен?</th>
					<th class="text-center">Это админ?</th>
					<th class="text-center">Дата создания</th>
					<th class="text-center">Дата обновления</th>
					<th class="text-center">Действия</th>
				</tr>
			</thead>

			<tbody>
			@foreach ($users as $n)
				<tr>
					<td class="text-center"><strong>{!! $n->id !!}</strong></td>
					<td class="text-center">{{ $n->name }}</td>
					<td class="text-center">{{ $n->email }}</td>
					<td class="text-center">{{ $n->email_verified_at ? 'да' : 'нет' }}</td>
					<td class="text-center">{{ $n->active ? 'да' : 'нет' }}</td>
					<td class="text-center">{{ $n->is_admin ? 'да' : 'нет' }}</td>
					<td class="text-center">{{ $n->created_at }}</td>
					<td class="text-center">{{ $n->updated_at }}</td>
					<td class="text-right">
						{{-- Админ не должен иметь возможность дезактивировать или удалить сам себя --}}
						@if ($n->name != Auth::user()->name)
						<div class="row">
							<div class="col-md-6">
								<a class="btn btn-success" type="submit" data-toggle="modal" data-target="#myModal_user_{{ $n->id }}">Обновить</a>
							</div>
							<div class="col-md-6">
								<a class="btn btn-danger" data-toggle="modal" data-target="#delete_user_{{ $n->id }}">Удалить</a>
							</div>
						</div>
						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<!-- End: table -->

	<!-- Begin: modal Add user -->
	<div id="myModal_user" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" >
				<center>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="modal-title">Добавить пользователя</h3><br>
					</div>
				</center>
				<div class="modal-body" >
					<form class="form-horizontal" method="POST" action="admin-users">
					{{ csrf_field() }}

						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Имя</label>
							<div class="col-sm-8">
								<input id="name" type="text" name="name" class="form-control" placeholder="Enter Name" required />
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Е-майл</label>
							<div class="col-sm-8">
								<input id="email" type="email" name="email" class="form-control" placeholder="Enter E-mail" required />
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-sm-3 control-label">Пароль</label>
							<div class="col-sm-8">
								<input id="password" type="text" name="password" class="form-control" placeholder="Enter Password" required />
							</div>
						</div>
						<div class="form-group">
							<label for="active" class="col-sm-3 control-label">Активен</label>
							<div class="col-sm-8">
								<input id="active" type="checkbox" name="active" class="checkbox" checked value="1" />
							</div>
						</div>
						<div class="form-group">
							<label for="admin" class="col-sm-3 control-label">Админ</label>
							<div class="col-sm-8">
								<input id="admin" type="checkbox" name="is_admin" class="checkbox" checked value="1" />
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
	<!-- End: modal Add user -->

	@foreach ($users as $n)
	<!-- Begin: modal Update user -->
	<div id="myModal_user_{{ $n->id }}" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" >
				<center>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="modal-title">Редактировать пользователя</h3><br>
					</div>
				</center>
				<div class="modal-body" >
					<form class="form-horizontal" method="POST" action="admin-users/{{ $n->id }}">
					{{ csrf_field() }}
					{{ method_field('PATCH') }}
					
						<div class="form-group">
							<label for="name2" class="col-sm-3 control-label">Имя</label>
							<div class="col-sm-8">
								<input id="name2" type="text" name="name" class="form-control" value="{{ $n->name }}" required />
							</div>
						</div>
						<div class="form-group">
							<label for="active2" class="col-sm-3 control-label">Активен</label>
							<div class="col-sm-8">
							@if ($n->active)
								<input id="active2" type="checkbox" name="active" class="checkbox" checked value="1" />
							@else
								<input id="active2" type="checkbox" name="active" class="checkbox" value="1" />
							@endif
							</div>
						</div>
						<div class="form-group">
							<label for="admin2" class="col-sm-3 control-label">Админ</label>
							<div class="col-sm-8">
							@if ($n->is_admin)
								<input id="admin2" type="checkbox" name="active" class="checkbox" checked value="1" />
							@else
								<input id="admin2" type="checkbox" name="is_admin" class="checkbox" value="1" />
							@endif
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
	<!-- End: modal Update user -->

	<!-- Begin: modal Delete user -->
	<div id="delete_user_{{ $n->id }}" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" >
				<center>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="modal-title">Delete User Confirmation</h3><br>
					</div>
				</center>
				<div class="modal-body" >
					<p>
						Are you sure want to Delete this user?
					</p>
					<form class="form-horizontal" method="POST" action="admin-users/{{ $n->id }}">
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
	<!-- End: modal Delete user -->
	@endforeach
</div>

@endsection