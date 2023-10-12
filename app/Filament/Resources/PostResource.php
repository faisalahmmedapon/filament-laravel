<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->live()
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->label('Title')->required(),
                TextInput::make('slug')->required(),
                FileUpload::make('image')->required(),
                RichEditor::make('description')->label('Description')->placeholder('Enter a description')->rules('required'),
                // Select::make('category_id')->label('Category')->options(Category::all()->pluck('name', 'id'))->searchable()->multiple()->required(),
                Select::make('category_id')->relationship('categories', 'name')->multiple()->required(),
                                Toggle::make('status')->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('id')->label('Id')->sortable(),
                TextColumn::make('title')->searchable()->separator(),
                // TextColumn::make('category.name')->badge(),
                TextColumn::make('categories.name')->badge(),
                TextColumn::make('description')->html()->limit(50),
                ImageColumn::make('image')->label('Photo')->square()->width(150)->height(150),
                IconColumn::make('status')->sortable()->boolean()->label('Publish'),
            ])
            ->defaultSort('id','desc')
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\ViewAction::make()
                ->form([
                    TextInput::make('title'),
                    TextInput::make('slug'),
                    FileUpload::make('image'),
                    TextArea::make('description')->rows(10),
                    Select::make('category_id')->relationship('categories', 'name')->multiple(),
                    Toggle::make('status'),
                ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
