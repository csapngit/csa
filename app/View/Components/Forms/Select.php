<?php

namespace App\View\Components\Forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
  public Collection $items;

  public $model;

  public string $name;

  public bool $readonly;

  public bool $required;

  public string $placeholder;

  public ?string $text = null;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(Collection $items, $model = null, string $name, string $trans, bool $readonly = false, bool $required = false)
  {
    // Foreach looping items
    $this->items = $items;

    //Model to get selected data
    $this->model = $model;

    // Input name
    $this->name = $name;

    // Text label
    $this->text = __("app.$trans.$name");

    // Input placeholder
    $placeholderText = __("app.$trans.placeholder.$name");

    $splitPlaceholder = explode('.', $placeholderText);

    if ($splitPlaceholder[0] == 'app') {
      $placeholderText = '';
    }

    $this->placeholder = $placeholder ?? $placeholderText;

    // Readonly
    $this->readonly = $readonly;

    // Asterisk next to the text label (if true)
    $this->required = $required;
  }

  public function isSelected($itemId)
  {
    return (old($this->name) ?? optional($this->model)->{$this->name}) == $itemId ? 'selected' : '';
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.forms.select');
  }
}
