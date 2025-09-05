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
                <div style="width: 100%; height: 20px; background-color: #e5e7eb; border-radius: 10px; overflow: hidden;">
                    <div style="width: {{ max(1, min(100, $progressPercentage)) }}%; height: 20px; background: linear-gradient(90deg, #3b82f6, #1d4ed8); border-radius: 10px; transition: width 0.5s ease;"></div>
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
                <div style="width: 100%; height: 20px; background-color: #e5e7eb; border-radius: 10px; overflow: hidden;">
                    <div style="width: {{ max(1, min(100, $schoolProgressPercentage)) }}%; height: 20px; background: linear-gradient(90deg, #10b981, #047857); border-radius: 10px; transition: width 0.5s ease;"></div>
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
                <div style="width: 100%; height: 20px; background-color: #e5e7eb; border-radius: 10px; overflow: hidden;">
                    <div style="width: {{ max(1, min(100, $learningProgressPercentage)) }}%; height: 20px; background: linear-gradient(90deg, #f59e0b, #d97706); border-radius: 10px; transition: width 0.5s ease;"></div>
                </div>
            </div>

            {{-- Debug info (opcional) --}}
            @if(config('app.debug'))
                <div class="mt-4 p-3 bg-gray-100 dark:bg-gray-800 rounded-lg text-xs text-gray-600 dark:text-gray-400">
                    <strong>Debug Info:</strong><br>
                    Total Hours: {{ $totalHours }} ({{ number_format($progressPercentage, 1) }}%)<br>
                    School Hours: {{ $schoolHours }} ({{ number_format($schoolProgressPercentage, 1) }}%)<br>
                    Learning Hours: {{ $learningHours }} ({{ number_format($learningProgressPercentage, 1) }}%)<br>
                    User ID: {{ Auth::id() ?? 'No auth' }}
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>