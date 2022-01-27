<table class="table table-dashboard mg-b-0 mt-2">
    <thead>
        <tr>
        	<th>Tipo</th>
        	<th>Usuario</th>
            <th>Acción</th>
            <th>Fecha y Hora</th>
            
        </tr>
    </thead>

    <tbody>
        @foreach($logs as $log)
        <tr>
            <td>
            	@switch($log->model_action)
                    @case('destroy')
                        <i class="fas fa-minus-circle"></i> Registro eliminado
                        @break
         
                    @case('update')
                        <i class="far fa-edit"></i> Actualización de información
                        @break

                    @case('create')
                        <i class="far fa-check-circle"></i> Creación de registro
                        @break
         
                    @default
                        <i class="far fa-bell"></i> General
                @endswitch
            </td>
            <td>
                @if($log->user == NULL)
                <span class="badge badge-danger">USUARIO ELIMINADO POR ADMINISTRACIÓN</span>
                @else
                {{ $log->user->name }}
                @endif
            </td>
            <td>{{ $log->data }}</td>

            <td class="text-muted"><i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($log->created_at)->format('d-m-Y g:i a') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>