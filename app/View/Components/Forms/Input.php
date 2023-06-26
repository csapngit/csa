<?php

namespace App\View\Components\Forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Input extends Component
{
	public string $form_id;

  public string $name;

  public string $placeholder;

  public bool $readonly;

  public bool $required;

  public ?string $text = null;

  public string $type;

  // public mixed $value = null;

  /**
   * @var mixed $value
   */
  public $value = null;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(?Model $model = null, string $form_id = '',  string $name, ?string $placeholder = null, string $trans, bool $readonly = false, bool $required = false, string $type = 'text')
  {
		$this->form_id = $form_id;

    // Input name
    $this->name = $name;

    // Input placeholder
    $placeholderText = __("app.$trans.placeholder.$name");

    $splitPlaceholder = explode('.', $placeholderText);

    if ($splitPlaceholder[0] == 'app') {
      $placeholderText = '';
    }

    $this->placeholder = $placeholder ?? $placeholderText;

    // Input type
    $this->type = $type;

    // Text label
    $this->text = __("app.$trans.$name");

    // Readonly
    $this->readonly = $readonly;

    // Asterisk next to the text label (if true)
    $this->required = $required;

    // Input Value
    $this->value = old($name) ?? optional($model)->$name;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.forms.input');
  }
}
