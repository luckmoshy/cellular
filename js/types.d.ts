export interface Snapshot {
  name: string;
  fingerprint: string;
  data: CellProperty[];
  meta?: any[];
}

export interface CellProperty {
  key: string;
  value: any;
}

/**
 * A modifier to a directive, like `delay` or `sync`.
 */
export interface DirectiveModifier {
  // the name of the modifier, like `delay`
  name: string;
  // the value of the modifier, like `500`
  value?: string;
}

/**
 * A `directive` is a representation of an action
 * that can be performed on a cell, like `click` or `submit`,
 * along with any modifiers to that action, like `delay`, `sync`, or `prevent`.
 */
export interface Directive {
  // The name of the cell,
  cell: string;
  // The name of the directive, like `click`, `submit`, or `model`.
  action: string;
  // An array of arguments, like `addTodo`, or `["foo", "bar"]`.
  args: string[];
  // An array of modifiers, like `{ delay: 500 }`
  modifiers: DirectiveModifier[];
}
