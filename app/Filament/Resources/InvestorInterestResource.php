<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ProjectInvestorInterestStatus;
use App\Filament\Resources\InvestorInterestResource\Pages;
use App\Models\ProjectInvestorInterest;
use App\Services\ProjectService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InvestorInterestResource extends Resource
{
    protected static ?string $model = ProjectInvestorInterest::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Financement';

    protected static ?string $modelLabel = 'proposition d\'investissement';

    protected static ?string $pluralModelLabel = 'propositions d\'investissement';

    protected static ?string $navigationLabel = 'Propositions d\'investissement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Investisseur')
                    ->schema([
                        Forms\Components\TextInput::make('investorUser.name')
                            ->label('Nom')
                            ->disabled(),
                        Forms\Components\TextInput::make('investorUser.organization_name')
                            ->label('Organisation')
                            ->disabled(),
                        Forms\Components\TextInput::make('investorUser.email')
                            ->label('Email')
                            ->disabled(),
                        Forms\Components\TextInput::make('investorUser.phone')
                            ->label('Téléphone')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Proposition')
                    ->schema([
                        Forms\Components\TextInput::make('project.title')
                            ->label('Projet')
                            ->disabled(),
                        Forms\Components\TextInput::make('intended_amount')
                            ->label('Montant proposé')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('currency')
                            ->label('Devise')
                            ->default('XOF')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->label('Statut')
                            ->options([
                                'new' => 'Nouvelle',
                                'contacted' => 'Contacté',
                                'pledged' => 'Engagé',
                                'paid' => 'Payé',
                                'cancelled' => 'Annulé',
                            ])
                            ->native(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Notes')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->label('Message investisseur')
                            ->rows(4)
                            ->disabled(),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Notes administrateur')
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['investorUser', 'project'])->latest('created_at'))
            ->columns([
                Tables\Columns\TextColumn::make('investorUser.name')
                    ->label('Investisseur')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('investorUser.organization_name')
                    ->label('Organisation')
                    ->sortable(),
                Tables\Columns\TextColumn::make('project.title')
                    ->label('Projet')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('intended_amount')
                    ->label('Montant')
                    ->money('XOF')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut')
                    ->formatStateUsing(fn (ProjectInvestorInterestStatus|string $state): string => match ($state instanceof ProjectInvestorInterestStatus ? $state : ProjectInvestorInterestStatus::from($state)) {
                        ProjectInvestorInterestStatus::New => 'Nouvelle',
                        ProjectInvestorInterestStatus::Contacted => 'Contacté',
                        ProjectInvestorInterestStatus::Pledged => 'Engagé',
                        ProjectInvestorInterestStatus::Paid => 'Payé',
                        ProjectInvestorInterestStatus::Cancelled => 'Annulé',
                    })
                    ->color(fn (ProjectInvestorInterestStatus|string $state): string => match ($state instanceof ProjectInvestorInterestStatus ? $state : ProjectInvestorInterestStatus::from($state)) {
                        ProjectInvestorInterestStatus::New => 'info',
                        ProjectInvestorInterestStatus::Contacted => 'warning',
                        ProjectInvestorInterestStatus::Pledged => 'success',
                        ProjectInvestorInterestStatus::Paid => 'success',
                        ProjectInvestorInterestStatus::Cancelled => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date soumission')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->label('Projet')
                    ->relationship('project', 'title'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'new' => 'Nouvelle',
                        'contacted' => 'Contacté',
                        'pledged' => 'Engagé',
                        'paid' => 'Payé',
                        'cancelled' => 'Annulé',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Modifier'),
                    Tables\Actions\Action::make('confirm')
                        ->label('Confirmer')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (ProjectInvestorInterest $record): void {
                            $record->update(['status' => ProjectInvestorInterestStatus::Pledged]);

                            app(ProjectService::class)->updateFundedAmount($record->project);

                            Notification::make()
                                ->title('Proposition confirmée')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('reject')
                        ->label('Rejeter')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (ProjectInvestorInterest $record): void {
                            $record->update(['status' => ProjectInvestorInterestStatus::Cancelled]);

                            app(ProjectService::class)->updateFundedAmount($record->project);

                            Notification::make()
                                ->title('Proposition rejetée')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Supprimer'),
                ]),
            ]);
    }

    /**
     * @return array<string, array<string, string>>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvestorInterests::route('/'),
            'edit' => Pages\EditInvestorInterest::route('/{record}/edit'),
        ];
    }
}
