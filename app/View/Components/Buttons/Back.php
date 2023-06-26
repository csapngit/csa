<?php

namespace App\View\Components\Buttons;

use Illuminate\View\Component;

class Back extends Component
{
  public string $route;

  public string $text;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(string $routeName, ?string $text = null)
  {
    $this->route = route($routeName);

    $this->text = $text ?? __('app.button.back');
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.buttons.back');
  }
}
