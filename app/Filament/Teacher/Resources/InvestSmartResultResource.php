<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\InvestSmartResultResource\Pages;
use App\Models\InvestSmartResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InvestSmartResultResource extends Resource
{
    protected static ?string $model = InvestSmartResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'SHS Specialized Subjects';

    protected static ?string $navigationLabel = 'InvestSmart Results';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Result Information')
                    ->schema([
                        Forms\Components\TextInput::make('user.name')
                            ->label('Student')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Date')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_value')
                            ->label('Total Value (₱)')
                            ->disabled(),
                        Forms\Components\TextInput::make('cash_balance')
                            ->label('Cash Balance (₱)')
                            ->disabled(),
                        Forms\Components\TextInput::make('portfolio_value')
                            ->label('Portfolio Value (₱)')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_return')
                            ->label('Total Return (₱)')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_return_percent')
                            ->label('Return (%)')
                            ->suffix('%')
                            ->disabled(),
                        Forms\Components\TextInput::make('stock_count')
                            ->label('Number of Stocks')
                            ->disabled(),
                        Forms\Components\TextInput::make('transaction_count')
                            ->label('Number of Transactions')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Student Notes')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Portfolio Snapshot')
                    ->schema([
                        Forms\Components\Placeholder::make('snapshot_info')
                            ->label('Portfolio Snapshot')
                            ->content(function (InvestSmartResult $record) {
                                $html = '<div class="space-y-4">';
                                
                                if (isset($record->snapshot_data['stocks']) && is_array($record->snapshot_data['stocks'])) {
                                    $html .= '<table class="w-full border-collapse border border-gray-300">';
                                    $html .= '<thead class="bg-gray-100"><tr>';
                                    $html .= '<th class="border border-gray-300 p-2 text-left">Symbol</th>';
                                    $html .= '<th class="border border-gray-300 p-2 text-left">Name</th>';
                                    $html .= '<th class="border border-gray-300 p-2 text-right">Quantity</th>';
                                    $html .= '<th class="border border-gray-300 p-2 text-right">Avg. Price</th>';
                                    $html .= '<th class="border border-gray-300 p-2 text-right">Current Price</th>';
                                    $html .= '<th class="border border-gray-300 p-2 text-right">Value</th>';
                                    $html .= '</tr></thead>';
                                    $html .= '<tbody>';
                                    
                                    foreach ($record->snapshot_data['stocks'] as $stock) {
                                        $value = $stock['quantity'] * $stock['current_price'];
                                        $html .= '<tr>';
                                        $html .= '<td class="border border-gray-300 p-2">' . $stock['symbol'] . '</td>';
                                        $html .= '<td class="border border-gray-300 p-2">' . $stock['name'] . '</td>';
                                        $html .= '<td class="border border-gray-300 p-2 text-right">' . number_format($stock['quantity']) . '</td>';
                                        $html .= '<td class="border border-gray-300 p-2 text-right">₱' . number_format($stock['average_price'], 2) . '</td>';
                                        $html .= '<td class="border border-gray-300 p-2 text-right">₱' . number_format($stock['current_price'], 2) . '</td>';
                                        $html .= '<td class="border border-gray-300 p-2 text-right">₱' . number_format($value, 2) . '</td>';
                                        $html .= '</tr>';
                                    }
                                    
                                    $html .= '</tbody></table>';
                                }
                                
                                $html .= '</div>';
                                return new \Illuminate\Support\HtmlString($html);
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_value')
                    ->label('Total Value')
                    ->money('PHP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_return')
                    ->label('Return')
                    ->money('PHP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_return_percent')
                    ->label('Return %')
                    ->numeric(2)
                    ->suffix('%')
                    ->sortable()
                    ->color(fn (string $state): string => $state >= 0 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('stock_count')
                    ->label('Stocks')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('high_performers')
                    ->label('High Performers')
                    ->query(fn (Builder $query): Builder => $query->where('total_return_percent', '>=', 10)),
                Tables\Filters\Filter::make('negative_performers')
                    ->label('Negative Performers')
                    ->query(fn (Builder $query): Builder => $query->where('total_return_percent', '<', 0)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListInvestSmartResults::route('/'),
            'view' => Pages\ViewInvestSmartResult::route('/{record}'),
        ];
    }
}
