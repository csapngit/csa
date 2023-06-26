<?php

namespace App\View\Components\Buttons;

use Illuminate\View\Component;

class Edit extends Component
{
  public string $route;

  public string $text;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(string $routeName, string $id, ?string $text = null)
  {
    $this->route = route("$routeName.edit", $id);

    $this->text = $text ?? __('app.button.edit');
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.buttons.edit');
  }
}
