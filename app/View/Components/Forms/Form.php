<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Form extends Component
{
  public string $action;

  public bool $notPostMethod;

  public ?string $backRouteName;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(string $action, ?string $backRouteName = null)
  {
    $this->action = $action;

    $splitUrl = explode('/', $action);

    $lastUrl = $splitUrl[count($splitUrl) - 1];

    $this->notPostMethod = is_numeric($lastUrl) ? true : false;

    $this->backRouteName = $backRouteName;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.forms.form');
  }
}
