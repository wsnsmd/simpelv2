<?php

namespace App\Filament\Resources\Data;

use App\Filament\Resources\Data\FasilitatorResource\Pages;
use App\Filament\Resources\Data\FasilitatorResource\RelationManagers;
use App\Models\Fasilitator;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Pangkat;
use Filament\Tables\Filters\SelectFilter;
use Filament\Resources\Components\Tab;

class FasilitatorResource extends Resource
{
    protected static ?string $model = Fasilitator::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralLabel = 'Fasilitator';
    protected static ?string $navigationGroup = 'Data';
    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->nullable()
                    // ->numeric()
                    ->maxLength(18),

                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('pangkat_id')
                    ->label('Pangkat')
                    ->native(false)
                    ->options(Pangkat::all()->pluck('singkat', 'id'))
                    ->placeholder('-- Pilih Pangkat --'),

                Forms\Components\DatePicker::make('tmt_pangkat')
                    ->label('TMT-Pangkat')
                    ->nullable(),

                Forms\Components\TextInput::make('jabatan')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('tmt_jabatan')
                    ->label('TMT-Jabatan')
                    ->nullable(),

                Forms\Components\TextInput::make('instansi')
                    ->nullable()
                    ->maxLength(255),

                Forms\Components\TextInput::make('satker_nama')
                    ->label('Satuan Kerja (SKPD/OPD)')
                    ->nullable()
                    ->maxLength(255),

                Forms\Components\Select::make('internal')
                    ->label('Internal')
                    ->options([
                        '0' => 'Tidak',
                        '1' => 'Ya'
                    ])
                    ->default(0)
                    ->native(false)
                    ->required()
                    ->selectablePlaceholder(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->placeholder('-')
                    ->width('5%'),
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('pangkat.singkat'),
                Tables\Columns\TextColumn::make('jabatan')
                    ->wrap(),
                Tables\Columns\IconColumn::make('internal')
                    ->boolean()
                    ->alignCenter()
                    ->width('1%'),
                //
            ])
            ->defaultSort('nama', 'asc')
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('Detail'),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Edit'),
                Tables\Actions\DeleteAction::make()->hiddenLabel()->tooltip('Hapus'),
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
            'index' => Pages\ListFasilitators::route('/'),
            // 'create' => Pages\CreateFasilitator::route('/create'),
            // 'edit' => Pages\EditFasilitator::route('/{record}/edit'),
        ];
    }
}
