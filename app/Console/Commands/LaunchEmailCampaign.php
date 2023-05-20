<?php

namespace App\Console\Commands;

use App\Mail\DynamicTemplateMail;
use App\Mail\TemplateMail;
use App\Models\EmailCampaign;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LaunchEmailCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'launch:campaign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'launch the campaign that has a ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * get the campains that are supposed to launch in the next 80 min
         * loop over them
         * defin their parameters
         * start sending the emails then sleep for the decided amount
         *
         */
        $this->info('launch email campaigns');
        $now = Carbon::now();
        $max_into_the_future = Carbon::now()->addMinutes(80);
        $campaigns = EmailCampaign::where('launch_at', '>', $now)
        ->where('launch_at', '<', $max_into_the_future)
        ->get();
        foreach ($campaigns as $campaign) {
            $campaign->refresh();
            if($campaign->status != INACTIVE_CAMPAIGN){
                continue;
            }
            $this->info('launching campaign ' . $campaign->id);
            $campaign->pushStatus(LAUNCHED_CAMPAIGN);

            $emails = $campaign->emails;
            $template = $campaign->template;
            $time_gap = $campaign->time_gap;
            $campaign->refresh();
            foreach($emails as $email){
                if($campaign->status != LAUNCHED_CAMPAIGN){
                    break;
                }
                $this->info('sending email to ' . $email);
                Mail::to($email)->send(new DynamicTemplateMail($template->subject, $template->template, $template->sender));
                $campaign->progress++;
                $campaign->save();
                sleep($time_gap);
                $campaign->refresh();

            }

            $campaign->pushStatus(FINISHED_CAMPAIGN);
            $this->info('finished campaign ' . $campaign->id);

        }
        return Command::SUCCESS;
    }
}
