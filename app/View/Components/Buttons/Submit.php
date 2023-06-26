<?php

namespace App\View\Components\Buttons;

use Illuminate\View\Component;

class Submit extends Component
{
  public string $text;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(?string $text = null)
  {
    $this->text = $text ?? __('app.button.submit');
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.buttons.submit');
  }
}
