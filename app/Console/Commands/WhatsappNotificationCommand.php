<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use SebastianBergmann\Environment\Console;
use App\Business;
use App\BusinessLocation;
use App\SettingGoFast;
use App\StaticsMsg;
use App\User;
use App\Utils\TransactionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Modules\Superadmin\Entities\SuperadminAutomsg;
use Yajra\DataTables\Facades\DataTables;

class WhatsappNotificationCommand extends Command
{
  protected $signature = 'pos:WhatsappNotificationCommand';

  public function handle()
  {
    // Get the WhatsApp notification controller.
    $controller = app('Modules\Superadmin\Http\Controllers\WhatsappNotificationController');

    // Call the checkWhatsappMessage method.
    $controller->checkWhatsappMessage();
    info("schedule is run");
  }
}