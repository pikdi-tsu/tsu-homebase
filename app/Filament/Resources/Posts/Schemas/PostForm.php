<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true),
//                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
//                        TextInput::make('slug')
//                            ->required()
//                            ->unique(ignoreRecord: true),
                        // Pakai RichEditor (Tiptap)
                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'attachFiles', 'blockquote', 'bold', 'bulletList',
                                'codeBlock', 'h2', 'h3', 'italic', 'link',
                                'orderedList', 'strike', 'table', 'grid',
                            ]),
                        Textarea::make('excerpt')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(), // Ambil 2/3 lebar

                // Kolom Sidebar (Meta Data)
                Section::make('Meta')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->default(now()),

                        // Field Kategori
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->required(),

                        Select::make('user_id')
                            ->label('Author')
                            ->relationship('user', 'name')
                            ->default(auth()->id())
                            ->required(),
                    ]),

                    Section::make('Featured Image')
                        ->schema([
                            FileUpload::make('featured_image')
                                ->image()
                                ->disk('public'),
                        ]),
            ]);
    }
}
