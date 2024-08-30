<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\ApiLog;
use Carbon\Carbon;

class ScheduleAssign extends Command {
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'schedule:hospitalcron';
    /**
     * The console command description.
     * @var string
     */
    protected $description = 'assign api cron job ';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return int
     */
    public function handle() {
        $schedule = Schedule::all();
        $is_allow = 0;
        foreach ( $schedule as $key ) {

            if ( $key->schedule == 'AfterMinute' ) {

                if ( Carbon::parse( $key->updated_at )->addMinutes( $key->day )->timezone( $key->timezone )->timestamp <= Carbon::now()->timezone( $key->timezone )->timestamp ) {
                    $this->info( '[TYPE]['.$key->type_of.'] [category]['.$key->patient_category.'] AfterMinute:' . Carbon::parse( $key->updated_at )->addMinutes( $key->day )->timezone( $key->timezone )->timestamp . '<=' . Carbon::now()->timezone( $key->timezone )->timestamp );
                    $is_allow = 1;
                }
            } else if ( $key->schedule == 'Afterhourly' ) {

                if ( Carbon::parse( $key->updated_at )->addHour( $key->day )->timezone( $key->timezone )->format( 'H' ) == Carbon::now()->timezone( $key->timezone )->format( 'H' ) ) {

                    $this->info( '[TYPE]['.$key->type_of.'] [category]['.$key->patient_category.']  Afterhourly:' . Carbon::parse( $key->updated_at )->addHour( $key->day )->timezone( $key->timezone )->format( 'H' ) . '==' . Carbon::now()->timezone( $key->timezone )->format( 'H' ) );
                    $is_allow = 1;
                }
            } else if ( $key->schedule == 'dailyAt' ) {
                if ( $key->time == Carbon::now()->timezone( $key->timezone )->format( 'H:i' ) ) {
                    $this->info( '[TYPE]['.$key->type_of.'] [category]['.$key->patient_category.']  dailyAt:' . $key->time . '==' . Carbon::now()->timezone( $key->timezone )->format( 'H:i' ) );
                    $is_allow = 1;
                }
            } else if ( $key->schedule == 'weeklyOn' ) {
                if ( $key->day == Carbon::now()->timezone( $key->timezone )->dayOfWeekIso && $key->time == Carbon::now()->timezone( $key->timezone )->format( 'H:i' ) ) {
                    $this->info( '[TYPE]['.$key->type_of.'] [category]['.$key->patient_category.']  weeklyOn:' . $key->day . '==' . Carbon::now()->timezone( $key->timezone )->dayOfWeekIso . '&&' . $key->time . '==' . Carbon::now()->timezone( $key->timezone )->format( 'H:i' ) );
                    $is_allow = 1;
                }
            } else if ( $key->schedule == 'monthlyOn' ) {
                if ( $key->day == Carbon::now()->timezone( $key->timezone )->format( 'd' ) && $key->time == Carbon::now()->timezone( $key->timezone )->format( 'H:i' ) ) {
                    $this->info( '[TYPE]['.$key->type_of.'] [category]['.$key->patient_category.']  weeklyOn:' . $key->day . '==' . Carbon::now()->timezone( $key->timezone )->format( 'd' ) . '&&' . $key->time . '==' . Carbon::now()->timezone( $key->timezone )->format( 'H:i' ) );
                    $is_allow = 1;
                }
            }
            if ( $is_allow == 1 ) {
                $check_job_is_process = ApiLog::where( 'type_of', $key->type_of )->where( 'patient_category', $key->patient_category )->where( 'is_active', 0 )->first();
                if ( empty( $check_job_is_process ) ) {
                    $ApiLog_save                   = new ApiLog();
                    $ApiLog_save->type_of          = $key->type_of;
                    $ApiLog_save->patient_category = $key->patient_category;
                    $ApiLog_save->offset           = 0;
                    $ApiLog_save->status           = 'start';
                    $ApiLog_save->save();
                }
                $update_date_schedule = Schedule::find( $key->id );
                $update_date_schedule->touch();
            }
        }
        $this->info( 'Successfully run.' );
    }
}
