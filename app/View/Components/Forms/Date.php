<?php

namespace App\View\Components\Forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Date extends Component
{
  public string $name;

  public string $type;

  public ?string $text = null;

  public bool $required;

  // public ?mixed $value = null;

  /**
   * @var mixed $value
   */
  public $value = null;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(?Model $model = null, string $name, string $trans, bool $required = false, string $type = 'date')
  {
    // Input name
    $this->name = $name;

    // Input type
    $this->type = $type;

    // Text label
    $this->text = __("app.$trans.$name");

    // Asterisk next to the text label (if true)
    $this->required = $required;

    // Input Value
    $this->value = old($name) ?? optional(optional($model)->$name)->format('Y-m-d');
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.forms.date');
  }
}
