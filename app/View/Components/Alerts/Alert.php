<?php

namespace App\View\Components\Alerts;

use Illuminate\View\Component;

class Alert extends Component
{
  public string $condition;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(string $condition)
  {
    /**
     * condition = success | warning | danger
     */
    $this->condition = $condition;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.alerts.alert');
  }
}
