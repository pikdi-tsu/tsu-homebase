<?php

namespace App\Filament\Resources\UserDosenTendikResource\Pages;

use App\Models\BackupUsersDosenTendik;
use App\Services\DefaultPasswordService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use App\Filament\Resources\UserDosenTendikResource;
use Filament\Schemas\Components\Form;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ListUserDosenTendik extends ListRecords
{
    protected static string $resource = UserDosenTendikResource::class;

//    protected $listeners = ['openCreateModalForDosenTendik' => 'openCreateModal'];
//
//    public function openCreateModal(): void
//    {
//        $this->mountAction('create');
//    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah User Dosen/Tendik')
                ->modalHeading('Tambah User Dosen/Tendik')
                ->schema(CreateUserDosenTendik::getCreateFormSchema())
                ->modalSubmitActionLabel('Simpan')
                ->modalCancelActionLabel('Batal')
                ->createAnotherAction(fn (Action $action) => $action->label('Simpan & Tambah Lagi'))
                ->using(function (array $data, Form $form): Model {
                    $nik = $data['nik'];
                    $backupUser = BackupUsersDosenTendik::where('nip', $nik)->first();

                    if ($backupUser) {
                        $namaLengkapDariBackup = $backupUser->nama;

                        // Memisahkan nama dari gelar
                        $posisiKomaPertama = strpos($namaLengkapDariBackup, ',');

                        if ($posisiKomaPertama !== false) {
                            $bagianNama = substr($namaLengkapDariBackup, 0, $posisiKomaPertama);
                            $bagianGelar = substr($namaLengkapDariBackup, $posisiKomaPertama); // Ini sudah termasuk koma dan semua setelahnya

                            $namaFormatted = Str::title(strtolower(trim($bagianNama)));

                            $data['name'] = $namaFormatted . $bagianGelar;
                        } else {
                            // Jika tidak ada koma, anggap semuanya adalah nama dan format seperti biasa
                            $data['name'] = Str::title(strtolower($namaLengkapDariBackup));
                        }
                    }


                    $data['password'] = (new DefaultPasswordService())->getDefaultHashedPassword();
                    $data['created_by'] = Auth::user()->nik;

                    return static::getModel()::create($data);
                })
                ->successNotificationTitle('User Dosen/Tendikberhasil ditambahkan'),
        ];
    }
}
