<?php

namespace Modules\Superadmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServerType extends Model
{
  use SoftDeletes;
  protected $table = "server_types";

  protected $fillable = [
    'server_name',
    'image_path',
    'icon_path',
    'server_speed',
    'server_cpu',
    'server_ram',
    'server_network',
    'server_pr_limit',
    'server_response_time_range',
    'server_price_perday',
    'interval',
    'interval_count',
    'trial_days',
    'status',
    'available',
  ];
  public function scopeActive($query)
  {
    return $query->where('status', 1);
  }

  public function scopeStatus($query, $status)
  {
    if ($status === null) {
      return $query;
    }

    return $query->where('status', $status);
  }

  public function scopeListServerTypes($query)
  {
    return $query->where('available', true)->orderBy('server_name', 'asc');
  }

  public function scopeScopeAvailable($query)
  {
    return $query->where('available', true);
  }
  public function scopeis_private($query)
  {
    return $query->where('available', 1);
  }
}