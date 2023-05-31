<?php

namespace App\Console\Commands;

use App\Mail\DynamicTemplateMail;
use App\Mail\TemplateMail;
use App\Models\EmailCampaign;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
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
        $campaigns = EmailCampaign::where(function ($query) {
                $now = Carbon::now();
                $max_into_the_future = Carbon::now()->addMinutes(80);
                $query->where('launch_at', '>', $now)
                    ->where('launch_at', '<', $max_into_the_future);
            })
            ->orWhere('status', RESUMEABLE_CAMPAIGN)
            ->get();
        foreach ($campaigns as $campaign) {
            try {
                
                $campaign->refresh();
                if (!in_array($campaign->status,  [INACTIVE_CAMPAIGN, RESUMEABLE_CAMPAIGN])) {
                    continue;
                }
                $this->info('launching campaign ' . $campaign->id);
                $campaign->update_hitory_log('launching campaign ');
                $campaign->pushStatus(LAUNCHED_CAMPAIGN);
                $all_emails = $campaign->emails ?? [];
                $sent = $campaign->was_sent_to ?? [];
                $emails = array_diff($all_emails, $sent);

                $template = $campaign->template;
                $time_gap = $campaign->time_gap;
                // $campaign->refresh();
                foreach ($emails as $email) {
                    if ($campaign->status != LAUNCHED_CAMPAIGN) {
                        break;
                    }
                    $this->info('sending email to ' . $email);
                    try {
                        Mail::to($email)->send(new DynamicTemplateMail($template->subject, $template->template, $template->sender));
                        $campaign->progress++;
                        $campaign->save();
                        $campaign->pushToSent($email);
                        sleep($time_gap);
                        $campaign->refresh();
                    } catch (Exception $ex) {
                        $this->info('error happened emails');
                        $campaign->update_hitory_log($ex->getMessage() . ' stopped at email :' . $email , $email);
                        continue;
                    }
                }

                $campaign->pushStatus(FINISHED_CAMPAIGN);
                $this->info('finished campaign ' . $campaign->id);
                $campaign->update_hitory_log('finished campaign');
            } catch (Exception $Ex) {
                $this->info('error happened campain');
                $campaign->update_hitory_log('error : '. $Ex->getMessage() . ' code :' . $Ex->getCode() );

                $campaign->pushStatus(FAILED_CAMPAIGN);
                Log::channel('campaign_errors')->error($Ex->getMessage() . '- with campaign :' . $campaign->id);
                continue;
            }
        }
        return Command::SUCCESS;
    }
}
