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
                Forms\Components\DateTimePicker::make('date_time_start')
                    ->label('Inicio')
                    ->required(),
                Forms\Components\DateTimePicker::make('date_time_end')
                    ->label('Fin')
                    ->required(),
                Forms\Components\Textarea::make('comments')
                    ->label('Comentarios'),
                Forms\Components\Select::make('id_teacher')
                    ->label('Profesor')
                    ->relationship('teacher', 'name') // Usar el accesor getFilamentNameAttribute
                    ->required(),
                Forms\Components\Select::make('id_zone')
                    ->label('Zona')
                    ->relationship('zone', 'name')
                    ->required(),
                
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_time_start')->label('Inicio'),
                Tables\Columns\TextColumn::make('date_time_end')->label('Fin'),
                Tables\Columns\TextColumn::make('comments')->label('Comentarios'),
                Tables\Columns\BooleanColumn::make('validated')->label('Validada'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('anadirHora')
                    ->label('Añadir Hora')
                    ->url(fn () => static::getUrl('create'))
                    ->icon('heroicon-o-plus-circle'),
            ]);
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