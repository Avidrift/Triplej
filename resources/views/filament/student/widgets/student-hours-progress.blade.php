<x-filament::widget>
    <x-filament::card>
        <div class="p-4">
            <h2 class="text-lg font-bold mb-6 text-gray-900 dark:text-gray-100">Progreso de Horas</h2>

            {{-- Progreso total --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Total: {{ number_format($totalHours, 1) }} / {{ $totalRequired }} horas
                    </p>
                    <span class="text-sm font-bold text-blue-600">{{ number_format($progressPercentage, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-4 rounded-full transition-all duration-500 ease-out"
                         style="width: {{ max(2, min(100, $progressPercentage)) }}%; min-width: {{ $progressPercentage > 0 ? '8px' : '0px' }};">
                    </div>
                </div>
            </div>

            {{-- Horas de colegio --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Colegio: {{ number_format($schoolHours, 1) }} / {{ $schoolRequired }} horas
                    </p>
                    <span class="text-sm font-bold text-green-600">{{ number_format($schoolProgressPercentage, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-4 rounded-full transition-all duration-500 ease-out"
                         style="width: {{ max(2, min(100, $schoolProgressPercentage)) }}%; min-width: {{ $schoolProgressPercentage > 0 ? '8px' : '0px' }};">
                    </div>
                </div>
            </div>

            {{-- Horas de aprendizaje --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Aprendizaje: {{ number_format($learningHours, 1) }} / {{ $learningRequired }} horas
                    </p>
                    <span class="text-sm font-bold text-yellow-600">{{ number_format($learningProgressPercentage, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 h-4 rounded-full transition-all duration-500 ease-out"
                         style="width: {{ max(2, min(100, $learningProgressPercentage)) }}%; min-width: {{ $learningProgressPercentage > 0 ? '8px' : '0px' }};">
                    </div>
                </div>
            </div>

            {{-- Debug info (quitar en producción) --}}
            @if(config('app.debug'))
                <div class="mt-4 p-3 bg-gray-100 dark:bg-gray-800 rounded-lg text-xs text-gray-600 dark:text-gray-400">
                    <strong>Debug:</strong> 
                    Total: {{ $totalHours }}h | 
                    Progress: {{ $progressPercentage }}% | 
                    School: {{ $schoolProgressPercentage }}% |
                    Width: {{ max(2, min(100, $progressPercentage)) }}%
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>