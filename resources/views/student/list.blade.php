@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-11">
                <h2>Laravel 9 Ajax CRUD</h2>
        </div>
        <div class="col-lg-1">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addModal">Agregar</a>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered" id="studentTable">
		<thead>
			<tr>
				<th>id</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>direccion</th>
				<th width="280px">Acción</th>
			</tr>
		</thead>	
		<tbody>
        @foreach ($students as $student)
            <tr id="{{ $student->id }}">
                <td>{{ $student->id }}</td>
                <td>{{ $student->nombre }}</td>
                <td>{{ $student->apellido }}</td>
                <td>{{ $student->direccion }}</td>
                <td>
		     <a data-id="{{ $student->id }}" class="btn btn-primary btnEdit">Editar</a>
		     <a data-id="{{ $student->id }}" class="btn btn-danger btnDelete">Borrar</button>
                </td>
            </tr>
        @endforeach
		</tbody>
    </table>
	

<!-- Add Student Modal -->
<div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Nuevo Estudiante</h4>
      </div>
	  <div class="modal-body">
		<form id="addStudent" name="addStudent" action="{{ route('student.store') }}" method="post">
			@csrf
			<div class="form-group">
				<label for="txtNombre">Nombre:</label>
				<input type="text" class="form-control" id="txtNombre" placeholder="Nombre" name="txtNombre">
			</div>
			<div class="form-group">
				<label for="txtApellido">Apellido:</label>
				<input type="text" class="form-control" id="txtApellido" placeholder="Apellido" name="txtApellido">
			</div>
			<div class="form-group">
				<label for="txtDireccion">Direccion:</label>
				<textarea class="form-control" id="txtDireccion" name="txtDireccion" rows="10" placeholder="Direccion"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Enviar</button>
		</form>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>	
<!-- Update Student Modal -->
<div id="updateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Student</h4>
      </div>
	  <div class="modal-body">
		<form id="updateStudent" name="updateStudent" action="{{ route('student.update') }}" method="post">
			<input type="hidden" name="hdnEstudianteId" id="hdnEstudianteId"/>
			@csrf
			<div class="form-group">
				<label for="txtNombre">Nombre:</label>
				<input type="text" class="form-control" id="txtNombre" placeholder="Enter Nombre" name="txtNombre">
			</div>
			<div class="form-group">
				<label for="txtApellido">Apellido:</label>
				<input type="text" class="form-control" id="txtApellido" placeholder="Enter Apellido" name="txtApellido">
			</div>
			<div class="form-group">
				<label for="txtDireccion">direccion:</label>
				<textarea class="form-control" id="txtDireccion" name="txtDireccion" rows="10" placeholder="Enter direccion"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	

<script>
  $(document).ready(function () {
	//Add the Student  
	$("#addStudent").validate({
		 rules: {
				txtNombre: "required",
				txtApellido: "required",
				txtDireccion: "required"
			},
			messages: {
			},
 
		 submitHandler: function(form) {
		  var form_action = $("#addStudent").attr("action");
		  $.ajax({
			  data: $('#addStudent').serialize(),
			  url: form_action,
			  type: "POST",
			  dataType: 'json',
			  success: function (data) {
				  var student = '<tr id="'+data.id+'">';
				  student += '<td>' + data.id + '</td>';
				  student += '<td>' + data.nombre + '</td>';
				  student += '<td>' + data.apellido + '</td>';
				  student += '<td>' + data.direccion + '</td>';
				  student += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Editar</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Borrar</a></td>';
				  student += '</tr>';            
				  $('#studentTable tbody').prepend(student);
				  $('#addStudent')[0].reset();
				  $('#addModal').modal('hide');
			  },
			  error: function (data) {
			  }
		  });
		}
	});
  
 
    //When click edit student
    $('body').on('click', '.btnEdit', function () {
      var student_id = $(this).attr('data-id');
      $.get('student/' + student_id +'/edit', function (data) {
          $('#updateModal').modal('show');
          $('#updateStudent #hdnEstudianteId').val(data.id); 
          $('#updateStudent #txtNombre').val(data.nombre);
          $('#updateStudent #txtApellido').val(data.apellido);
          $('#updateStudent #txtDireccion').val(data.direccion);
      })
   });
    // Update the student
	$("#updateStudent").validate({
		 rules: {
				txtNombre: "required",
				txtApellido: "required",
				txtDireccion: "required"
				
			},
			messages: {
			},
 
		 submitHandler: function(form) {
		  var form_action = $("#updateStudent").attr("action");
		  $.ajax({
			  data: $('#updateStudent').serialize(),
			  url: form_action,
			  type: "POST",
			  dataType: 'json',
			  success: function (data) {
				  var student = '<td>' + data.id + '</td>';
				  student += '<td>' + data.nombre + '</td>';
				  student += '<td>' + data.apellido + '</td>';
				  student += '<td>' + data.direccion + '</td>';
				  student += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Editar</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Borrar</a></td>';
				  $('#studentTable tbody #'+ data.id).html(student);
				  $('#updateStudent')[0].reset();
				  $('#updateModal').modal('hide');
			  },
			  error: function (data) {
			  }
		  });
		}
	});		
		
   //delete student
	$('body').on('click', '.btnDelete', function () {
      var student_id = $(this).attr('data-id');
      $.get('student/' + student_id +'/delete', function (data) {
          $('#studentTable tbody #'+ student_id).remove();
      })
   });	
	
});	  
</script>
@endsection