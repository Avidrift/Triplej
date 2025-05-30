<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Filament\Resources\CertificateResource\RelationManagers;
use App\Models\Certificate;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_estudiante')
               ->label('Estudiante')
             ->options(
                 Student::all()->pluck('name', 'id')->toArray()
             )
          ->required(),
                Forms\Components\TextInput::make('id_usuario_admin')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('fecha_expedicion')
                    ->required(),
                Forms\Components\TextInput::make('horas_totales')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('entregado')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_estudiante')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_usuario_admin')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_expedicion')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('horas_totales')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('entregado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
