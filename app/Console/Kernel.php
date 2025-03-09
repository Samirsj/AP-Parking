<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $reservationsExpirees = HistoriqueAttribution::where('expiration_at', '<', now())->get();
    
            foreach ($reservationsExpirees as $reservation) {
                // Libère la place de parking
                $parking = $reservation->parking;
                if ($parking) {
                    $parking->update(['est_occupe' => false]);
                }
    
                // Supprime la réservation expirée
                $reservation->delete();
            }
        })->hourly(); // Vérifie toutes les heures
    }
    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
