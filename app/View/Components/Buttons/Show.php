<?php

namespace App\View\Components\Buttons;

use Illuminate\View\Component;

class Show extends Component
{
  public string $route;

  public string $text;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(string $id, string $routeName, ?string $text = null)
  {
    $this->route = route("$routeName.show", $id);

    $this->text = $text ?? trans('app.button.show');
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.buttons.show');
  }
}
