<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentLiteracyHourResource\Pages;
use App\Models\Literacy_Hour;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class StudentLiteracyHourResource extends Resource
{
    protected static ?string $model = Literacy_Hour::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Hoja de Alfabetización';
    protected static ?string $pluralModelLabel = 'Horas de Alfabetización';
    protected static ?string $modelLabel = 'Hora de Alfabetización';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('hour_type')
                    ->label('Tipo de Hora')
                    ->options([
                        'school' => 'Colegio',
                        'learning' => 'Aprendizaje',
                    ])
                    ->required()
                    ->default('school')
                    ->helperText('Selecciona si estas horas son de colegio o aprendizaje autónomo'),
                
                Forms\Components\DateTimePicker::make('date_time_start')
                    ->label('Inicio')
                    ->required()
                    ->seconds(false)
                    ->displayFormat('d/m/Y H:i'),
                
                Forms\Components\DateTimePicker::make('date_time_end')
                    ->label('Fin')
                    ->required()
                    ->seconds(false)
                    ->displayFormat('d/m/Y H:i')
                    ->after('date_time_start')
                    ->helperText('La hora de fin debe ser posterior a la hora de inicio'),
                
                Forms\Components\Textarea::make('comments')
                    ->label('Comentarios')
                    ->placeholder('Describe las actividades realizadas durante estas horas...')
                    ->rows(3)
                    ->maxLength(500),
                
                Forms\Components\Select::make('id_teacher')
                    ->label('Profesor')
                    ->relationship('teacher', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                
                Forms\Components\Select::make('id_zone')
                    ->label('Zona')
                    ->relationship('zone', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_time_start')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('date_time_end')
                    ->label('Fin')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duración')
                    ->getStateUsing(function ($record) {
                        $start = \Carbon\Carbon::parse($record->date_time_start);
                        $end = \Carbon\Carbon::parse($record->date_time_end);
                        $hours = $end->diffInMinutes($start) / 60;
                        return number_format($hours, 1) . 'h';
                    })
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('hour_type')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state): string => $state === 'school' ? 'Colegio' : 'Aprendizaje')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'school' => 'primary',
                        'learning' => 'warning',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Profesor')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('zone.name')
                    ->label('Zona')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('comments')
                    ->label('Comentarios')
                    ->limit(50)
                    ->toggleable(),
                
                Tables\Columns\BooleanColumn::make('validated')
                    ->label('Validada')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('hour_type')
                    ->label('Tipo de Hora')
                    ->options([
                        'school' => 'Colegio',
                        'learning' => 'Aprendizaje',
                    ]),
                
                Tables\Filters\Filter::make('validated')
                    ->label('Solo Validadas')
                    ->query(fn ($query) => $query->where('validated', true)),
                
                Tables\Filters\Filter::make('not_validated')
                    ->label('No Validadas')
                    ->query(fn ($query) => $query->where('validated', false)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => !$record->validated),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => !$record->validated),
            ])
            ->headerActions([
                Tables\Actions\Action::make('anadirHora')
                    ->label('Añadir Hora')
                    ->url(fn () => static::getUrl('create'))
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary'),
            ])
            ->defaultSort('date_time_start', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentLiteracyHours::route('/'),
            'create' => Pages\CreateStudentLiteracyHour::route('/create'),
            'edit' => Pages\EditStudentLiteracyHour::route('/{record}/edit'),
        ];
    }
}