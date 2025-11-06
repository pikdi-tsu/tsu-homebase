<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required(),
                TextInput::make('slug')
                    ->unique(ignoreRecord: true)
                    ->required(),
//                RichEditor::make('content')
//                    ->columnSpanFull()
//                    ->required()
//                    ->toolbarButtons([ // <-- Ini cara konfigurasinya
//                        'attachFiles',
//                        'blockquote',
//                        'bold',
//                        'bulletList',
//                        'codeBlock',
//                        'h2',
//                        'h3',
//                        'italic',
//                        'link',
//                        'orderedList',
//                        'redo',
//                        'strike',
//                        'table',
//                        'undo',
//                        'grid', // <-- INI DIA LAYOUT BUILDER-MU
//                    ])
//                    ->columnSpan(2),
                Builder::make('content')
                    ->blocks([
                        // Ini "widget" Elementor-mu
                        Builder\Block::make('hero_section')
                            ->schema([
                                TextInput::make('title')->required(),
                                TextInput::make('subtitle'),
                                FileUpload::make('background_image'),
                            ]),

                        Builder\Block::make('simple_text')
                            ->schema([
                                RichEditor::make('text_content') // Tiptap di dalam Builder!
                            ]),

                        Builder\Block::make('call_to_action')
                            ->schema([
                                TextInput::make('text'),
                                TextInput::make('button_label'),
                                TextInput::make('button_url'),
                            ])
                    ])
                    ->required()
                    ->columnSpanFull(),
                Group::make()
                    ->schema([
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->default(now()),

                        Select::make('id')
                            ->label('Author')
                            ->relationship('user', 'name')
                            ->default(auth()->id()) // Otomat   is pilih user yg login
                            ->required(),

                        Textarea::make('excerpt')
                            ->rows(3),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
