<?php

namespace App\Filament\Resources\SupportTicketResource\Pages;

use App\Filament\Resources\SupportTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewSupportTicket extends ViewRecord
{
    protected static string $resource = SupportTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Ticket Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('ticket_number')
                            ->label('Ticket Number')
                            ->copyable(),
                        
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('User'),
                        
                        Infolists\Components\TextEntry::make('subject')
                            ->columnSpanFull(),
                        
                        Infolists\Components\TextEntry::make('description')
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->columns(2),
                
                Infolists\Components\Section::make('Classification')
                    ->schema([
                        Infolists\Components\TextEntry::make('category')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'technical_issue' => 'primary',
                                'account_problem' => 'secondary',
                                'billing_question' => 'warning',
                                'course_access' => 'info',
                                'feature_request' => 'success',
                                'other' => 'gray',
                                default => 'gray',
                            }),
                        
                        Infolists\Components\TextEntry::make('priority')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'low' => 'success',
                                'medium' => 'warning',
                                'high' => 'danger',
                                default => 'gray',
                            }),
                        
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'open' => 'primary',
                                'in_progress' => 'warning',
                                'resolved' => 'success',
                                'closed' => 'gray',
                                default => 'gray',
                            }),
                        
                        Infolists\Components\TextEntry::make('assignedAdmin.name')
                            ->label('Assigned To')
                            ->placeholder('Unassigned'),
                    ])
                    ->columns(2),
                
                Infolists\Components\Section::make('Resolution')
                    ->schema([
                        Infolists\Components\TextEntry::make('resolved_at')
                            ->dateTime()
                            ->placeholder('Not resolved'),
                        
                        Infolists\Components\TextEntry::make('resolution_notes')
                            ->columnSpanFull()
                            ->prose()
                            ->placeholder('No resolution notes'),
                        
                        Infolists\Components\TextEntry::make('admin_notes')
                            ->columnSpanFull()
                            ->prose()
                            ->placeholder('No admin notes'),
                    ])
                    ->columns(2),
                
                Infolists\Components\Section::make('Attachments')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('attachments')
                            ->schema([
                                Infolists\Components\TextEntry::make('original_name')
                                    ->label('File Name'),
                                Infolists\Components\TextEntry::make('size')
                                    ->label('Size')
                                    ->formatStateUsing(fn ($state) => number_format($state / 1024, 2) . ' KB'),
                                Infolists\Components\TextEntry::make('mime_type')
                                    ->label('Type'),
                            ])
                            ->columns(3)
                            ->placeholder('No attachments'),
                    ]),
                
                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                        
                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
