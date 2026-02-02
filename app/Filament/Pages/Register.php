<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\Major;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Auth\Pages\Register as BaseRegister;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            $this->getNisFormComponent(),
            $this->getKelasFormComponent(),
            $this->getMajorFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
        ]);
    }

    protected function getNisFormComponent(): Component
    {
        return TextInput::make('nis')
            ->label('NIS')
            ->required()
            ->unique('users', 'nis')
            ->maxLength(255);
    }

    protected function getKelasFormComponent(): Component
    {
        return Select::make('kelas')
            ->label('Kelas')
            ->required()
            ->options([
                'X' => 'X',
                'XI' => 'XI',
                'XII' => 'XII',
            ]);
    }

    protected function getMajorFormComponent(): Component
    {
        return Select::make('major_id')
            ->label('Jurusan')
            ->options(fn() => Major::pluck('name', 'id'))
            ->required()
            ->placeholder('Pilih Jurusan');
    }

    protected function handleRegistration(array $data): User
    {
        $user = parent::handleRegistration($data);

        $user->assignRole('siswa');

        return $user;
    }
}
