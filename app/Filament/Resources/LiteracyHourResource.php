<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LiteracyHourResource\Pages;
use App\Models\Literacy_Hour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LiteracyHourResource extends Resource
{
    protected static ?string $model = Literacy_Hour::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Horas de Alfabetización';
    protected static ?string $pluralModelLabel = 'Horas de Alfabetización';
    protected static ?string $modelLabel = 'Hora de Alfabetización';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_zone')
                    ->label('Zona')
                    ->options(function () {
                        // Solo mostrar zonas con profesor asignado
                        return \App\Models\Zone::whereNotNull('id_teacher')->pluck('name', 'id');
                    })
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $zone = \App\Models\Zone::find($state);
                        if ($zone && $zone->teacher) {
                            $set('id_teacher', $zone->teacher->id);
                        } else {
                            $set('id_teacher', null);
                        }
                    }),
                Forms\Components\Select::make('id_student')
                    ->label('Estudiante')
                    ->relationship('student', 'name')
                    ->required(),
                Forms\Components\Select::make('id_teacher')
                    ->label('Profesor')
                    ->relationship('teacher', 'name')
                    ->required()
                    ->readOnly(),
                Forms\Components\DateTimePicker::make('date_time_start')
                    ->label('Fecha y hora de inicio')
                    ->required(),
                Forms\Components\DateTimePicker::make('date_time_end')
                    ->label('Fecha y hora de fin')
                    ->required(),
                Forms\Components\Toggle::make('validated')
                    ->label('Validado')
                    ->default(false),
                Forms\Components\Textarea::make('comments')
                    ->label('Descripción')
                    ->rows(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('zone.name')
                    ->label('Zona') 
                    ->toggleable(),    
                Tables\Columns\TextColumn::make('student.name')->label('Estudiante')                     ->toggleable(),                    Tables\Columns\TextColumn::make('teacher.name')->label('Profesor'),
                Tables\Columns\TextColumn::make('date_time_start')->label('Inicio')                     ->toggleable(),    
                Tables\Columns\TextColumn::make('date_time_end')->label('Fin')                     ->toggleable(),
                                Tables\Columns\TextColumn::make('duration')
                    ->label('Duración')
                    ->getStateUsing(function ($record) {
                        $start = \Carbon\Carbon::parse($record->date_time_start);
                        $end = \Carbon\Carbon::parse($record->date_time_end);
                        $hours = $end->diffInMinutes($start) / 60;
                        return number_format($hours, 1) . 'h';
                    })
                    ->badge()
                    ->color('success')
                    ->toggleable(),    
                // Usa ToggleColumn sin iconos personalizados para evitar el error
                Tables\Columns\ToggleColumn::make('validated')
                    ->label('Validado')
                    ->disabled(fn ($record) => !\Filament\Facades\Filament::auth()?->user() instanceof \App\Models\Teacher),
                Tables\Columns\TextColumn::make('comments')->label('Descripción')->limit(30)                    ->toggleable(),    
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sort_by')
                    ->label('Ordenar por')
                    ->options([
                        'recent' => 'Más Recientes',
                        'oldest' => 'Más Antiguas',
                        'validated_first' => 'Validadas Primero',
                        'not_validated_first' => 'No Validadas Primero',
                    ])
                    ->default('recent')
                    ->query(function ($query, array $data) {
                        if (! $data['value']) {
                            return $query;
                        }
                        
                        return match ($data['value']) {
                            'recent' => $query->orderBy('created_at', 'desc'),
                            'oldest' => $query->orderBy('created_at', 'asc'),
                            'validated_first' => $query->orderBy('validated', 'desc')->orderBy('created_at', 'desc'),
                            'not_validated_first' => $query->orderBy('validated', 'asc')->orderBy('created_at', 'desc'),
                            default => $query,
                        };
                    }),

                Tables\Filters\SelectFilter::make('hour_type')
                    ->label('Tipo de Hora')
                    ->options([
                        'school' => 'Colegio',
                        'learning' => 'Aprendizaje',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->extraAttributes([
                         'class' => 'btn-primary', // ⬅ Tu clase personalizada
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLiteracyHours::route('/'),
            'create' => Pages\CreateLiteracyHour::route('/create'),
            'edit' => Pages\EditLiteracyHour::route('/{record}/edit'),
            'student-sheet' => Pages\StudentSheet::route('/student-sheet/{record}'),
            'group-student-list' => Pages\GroupStudentList::route('/grupos'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = \Filament\Facades\Filament::auth()?->user();
        
        // Admin ve todo
        if ($user && $user instanceof \App\Models\Admin) {
            return parent::getEloquentQuery();
        }
        
        // Maestro: solo ve horas donde él está asignado como profesor en el formulario
        if ($user && $user instanceof \App\Models\Teacher) {
            return parent::getEloquentQuery()->where('id_teacher', $user->id);
        }
        
        // Estudiante: solo ve sus propias horas
        if ($user && $user instanceof \App\Models\Student) {
            return parent::getEloquentQuery()->where('id_student', $user->id);
        }
        
        // Por defecto, no mostrar nada
        return parent::getEloquentQuery()->whereRaw('1=0');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = \Filament\Facades\Filament::auth()?->user();
        
        if ($user instanceof \App\Models\Student) {
            return false;
        }
        return true;
    }

    public static function registerNavigationForStudents()
    {
        return [
            'label' => 'Registrar Alfabetización',
            'icon' => 'heroicon-o-pencil',
            'url'  => route('literacy_hours.student.create'),
        ];
    }
}