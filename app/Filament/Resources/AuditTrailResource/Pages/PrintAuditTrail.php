<?php

namespace App\Filament\Resources\AuditTrailResource\Pages;

use App\Filament\Resources\AuditTrailResource;
use App\Models\AuditTrail;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;

class PrintAuditTrail extends Page
{
    protected static string $resource = AuditTrailResource::class;

    protected static string $view = 'filament.resources.audit-trail-resource.pages.print-audit-trail';
    
    public ?AuditTrail $record = null;
    
    public function mount(AuditTrail $record): void
    {
        $this->record = $record;
    }
    
    protected function getHeaderActions(): array
    {
        return [];
    }
    
    public function getTitle(): string
    {
        return "Print Audit Trail Record #{$this->record->id}";
    }
}
