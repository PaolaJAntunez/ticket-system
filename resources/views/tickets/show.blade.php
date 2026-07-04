<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ticket #{{ $ticket->id }}: {{ $ticket->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Estado</p>
                        <p class="font-medium text-gray-900">{{ $ticket->status }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Prioridad</p>
                        <p class="font-medium text-gray-900">{{ $ticket->priority }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Categoría</p>
                        <p class="font-medium text-gray-900">{{ $ticket->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Reportado por</p>
                        <p class="font-medium text-gray-900">{{ $ticket->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Asignado a</p>
                        <p class="font-medium text-gray-900">{{ $ticket->agent?->name ?? 'Sin asignar' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Fecha de creación</p>
                        <p class="font-medium text-gray-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-1">Descripción</p>
                    <p class="text-gray-900">{{ $ticket->description }}</p>
                </div>

                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'agent')
                    <div class="border-t pt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Actualizar Ticket</h3>
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Estado</label>
                                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Abierto</option>
                                        <option value="assigned" {{ $ticket->status == 'assigned' ? 'selected' : '' }}>Asignado</option>
                                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resuelto</option>
                                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Cerrado</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Prioridad</label>
                                    <select name="priority" class="w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Baja</option>
                                        <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Media</option>
                                        <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>Alta</option>
                                        <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>Urgente</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit"
                                    style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer;">
                                Actualizar
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Sección de comentarios -->
            <div class="bg-white shadow rounded-lg p-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Comentarios</h3>

                @forelse($ticket->comments as $comment)
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-gray-700 text-sm">{{ $comment->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No hay comentarios aún.</p>
                @endforelse

                <form action="{{ route('tickets.comments.store', $ticket) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Agregar comentario</label>
                        <textarea name="comment" rows="3"
                                  class="w-full border-gray-300 rounded-md shadow-sm"
                                  placeholder="Escribe tu comentario aquí..."></textarea>
                    </div>
                    <button type="submit"
                            style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer;">
                        Enviar comentario
                    </button>
                </form>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('tickets.index') }}"
                   style="background-color: #e5e7eb; color: #374151; padding: 8px 16px; border-radius: 6px; text-decoration: none;">
                    Volver a la lista
                </a>
            </div>

        </div>
    </div>
</x-app-layout>