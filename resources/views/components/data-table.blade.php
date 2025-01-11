@props([
    'records',
    'columns' => [],
    'actions' => true,
    'sortField' => null,
    'sortDirection' => 'asc'
])

<div x-data="tableFeatures" class="bg-white shadow-sm rounded-lg">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach($columns as $key => $column)
                        <th scope="col" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('{{ $key }}')"
                        >
                            <div class="flex items-center space-x-1">
                                <span>{{ $column }}</span>
                                <span class="text-gray-400">
                                    @if($sortField === $key)
                                        @if($sortDirection === 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @else
                                        ↕
                                    @endif
                                </span>
                            </div>
                        </th>
                    @endforeach
                    @if($actions)
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    
    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
        {{ $records->links() }}
    </div>
</div> 