<!-- Indicadores -->
<h2>Reporte de Movimientos de Inventario</h2>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Color</th>
            <th>Talla / Variante</th>
            <th>Movimiento</th>
            <th>Fecha del Movimiento</th>
            <th>Disponibilidad de Talla</th>
            <th>Disponibilidad Modelo</th>
            <th>Modificado por</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movements as $movement)
        @if($movement->variant->product != null && $movement->created_at != null)
        <tr>
            <td>{{ $movement->variant->product->name ?? $movement->variant->product }}</td>
            <td>{{ $movement->variant->product->color ?? $movement->variant->product }}</td>
            <td>{{ $movement->variant->variants->value ?? $movement->variant->variants }}</td>
            <td>{{ $movement->initial_value + $movement->final_value }}</td>
            <td>{{ $movement->created_at ?? 'Sin Fecha' }}</td>
            <td>{{ $movement->variant->stock ?? $movement->variant }}</td>
            <td>{{ $movement->variant->product->stock ?? $movement->variant->product }}</td>
            <td>{{ $movement->user->name ?? $movement->user }}</td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>