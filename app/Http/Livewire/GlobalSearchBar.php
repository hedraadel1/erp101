<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;

class GlobalSearchBar extends Component
{
  public $query ; 
  public $contacts ; 


  


  public function render()
  {
  
      return view('livewire.global-search-bar');
  }
}
