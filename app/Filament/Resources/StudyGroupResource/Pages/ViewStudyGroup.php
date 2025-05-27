<?php

namespace App\Filament\Resources\StudyGroupResource\Pages;

use App\Filament\Resources\StudyGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewStudyGroup extends ViewRecord
{
    protected static string $resource = StudyGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('view_frontend')
                ->label('View on Frontend')
                ->icon('heroicon-o-eye')
                ->url(fn () => route('study-groups.show', $this->record))
                ->openUrlInNewTab(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Group Information')
                    ->schema([
                        Infolists\Components\Split::make([
                            Infolists\Components\Grid::make(2)
                                ->schema([
                                    Infolists\Components\TextEntry::make('name')
                                        ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                        ->weight('bold'),
                                    Infolists\Components\TextEntry::make('creator.name')
                                        ->label('Created by'),
                                    Infolists\Components\TextEntry::make('description')
                                        ->columnSpanFull(),
                                ]),
                            Infolists\Components\ImageEntry::make('image')
                                ->hiddenLabel()
                                ->grow(false),
                        ])->from('lg'),
                    ]),

                Infolists\Components\Section::make('Settings')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\IconEntry::make('is_private')
                                    ->label('Privacy')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-lock-closed')
                                    ->falseIcon('heroicon-o-globe-alt')
                                    ->trueColor('warning')
                                    ->falseColor('success'),
                                Infolists\Components\TextEntry::make('max_members')
                                    ->label('Maximum Members')
                                    ->badge()
                                    ->color('primary'),
                                Infolists\Components\TextEntry::make('join_code')
                                    ->label('Join Code')
                                    ->copyable()
                                    ->copyMessage('Join code copied!')
                                    ->placeholder('—')
                                    ->visible(fn () => $this->record->is_private),
                            ]),
                    ]),

                Infolists\Components\Section::make('Statistics')
                    ->schema([
                        Infolists\Components\Grid::make(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('members_count')
                                    ->label('Total Members')
                                    ->state(fn () => $this->record->members()->count())
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('discussions_count')
                                    ->label('Discussions')
                                    ->state(fn () => $this->record->discussions()->count())
                                    ->badge()
                                    ->color('info'),
                                Infolists\Components\TextEntry::make('challenges_count')
                                    ->label('Challenges')
                                    ->state(fn () => $this->record->groupChallenges()->count())
                                    ->badge()
                                    ->color('warning'),
                                Infolists\Components\TextEntry::make('active_challenges_count')
                                    ->label('Active Challenges')
                                    ->state(fn () => $this->record->groupChallenges()->where('is_active', true)->count())
                                    ->badge()
                                    ->color('danger'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Focus Areas')
                    ->schema([
                        Infolists\Components\TextEntry::make('focus_areas')
                            ->label('')
                            ->state(function () {
                                if (!$this->record->focus_areas) {
                                    return [];
                                }
                                $categories = \App\Models\Category::whereIn('id', $this->record->focus_areas)->pluck('name')->toArray();
                                return $categories;
                            })
                            ->badge()
                            ->color('gray')
                            ->separator(','),
                    ])
                    ->visible(fn () => $this->record->focus_areas && count($this->record->focus_areas) > 0),

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime(),
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime(),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }
}
